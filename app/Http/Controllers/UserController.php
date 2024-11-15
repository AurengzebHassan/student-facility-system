<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use RealRashid\SweetAlert\Facades\Alert;
use function Laravel\Prompts\confirm;
use Carbon\Carbon;
use App\Models\PaymentMethod;
// use Illuminate\Http\Request;

class UserController extends Controller
{
    public function resetPassword()
    {
        return view('layout.adminpanel.reset');
    }

    public function change_Password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Invalid email format.',
            'password.required' => 'The password field is required.',
            'confirm_password.required' => 'The confirm password field is required.',
            'confirm_password.same' => 'The confirm password field must match the password field.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->only('email', 'password', 'confirm_password'));
        }

        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            $admin->password = Hash::make($request->password);
            $admin->save();

            // Redirect to the appropriate route
            return redirect()->route('reset')->with('success', 'Password has been changed successfully.');;
        } else {
            return redirect()->back()->withInput($request->only('email'));
        }
    }

    public function userorder(Request $request)
    {
        Order::query()->update(['is_read' => 1]);
        $searchQuery = $request->query('search');
        $filter = $request->query('filter');

        $query = Order::with(['product' => function ($query) {
            $query->withTrashed(); // Include soft deleted products
        }, 'user', 'paymentMethod'])
            ->orderBy('created_at', 'desc')
            ->where('archive', '=', 0);

        if ($searchQuery && $filter) {
            $query->whereHas('user', function ($q) use ($filter, $searchQuery) {
                $q->where($filter, 'like', '%' . $searchQuery . '%');
            });
        }

        $orders = $query->paginate(50);

        return view('layout.adminpanel.order', compact('orders', 'searchQuery'));
    }


    public function resePasscode()
    {
        return view('layout.adminpanel.resetpassword');
    }

    public function userprofile(Request $request)
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Check if the user is authenticated
        if ($user) {
            // If authenticated, load the user's data
            $userData = User::where('id', $user->id)->get();

            // Pass the user's data to the view
            return view('frontend.userdashboard', ['users' => $userData]);
        } else {
            // If not authenticated, redirect to login
            return redirect()->route('login');
        }
    }

    public function confirmationorder($uuid)
    {
        // Retrieve the product associated with the given UUID
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $payment_methods = PaymentMethod::all();

        // Retrieve the authenticated user
        $user = Auth::user();

        // Pass both the $product and $user variables to the view
        return view('frontend.buynow', ['product' => $product, 'user' => $user, 'payment_methods' => $payment_methods]);
    }

    public function confirmorder(Request $request)
    {
        // Check if the user is authenticated and email is verified
        if (!Auth::check() || !Auth::user()->email_verified_at || !Auth::user()->id) {
            return redirect()->route('login');
        }

        $user_id = Auth::id();
        $product_id = $request->input('product_id');
        $product = Product::findOrFail($product_id);
        $quantity = $request->input('quantity');
        $totalPrice = $product->price * $quantity;

        // $paymentMethodId = $request->input('payment_method_id'); // Assuming the payment method ID is sent in the request
        // $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);

        // Determine whether to subtract from remaining quantity or total quantity
        if ($product->remaining_quantity !== null) {
            $quantityToSubtract = 'remaining_quantity';
        } else {
            $quantityToSubtract = 'total_quantity';
        }

        // Check if the ordered quantity is greater than the available quantity
        if ($quantity > $product->$quantityToSubtract) {
            Alert::warning('Warning', 'Ordered quantity exceeds available quantity');
            return redirect()->back();
        }

        $order = new Order();
        $order->product_id = $product->id;
        // $order->payment_method_id = $paymentMethod->id;
        $order->user_id = $user_id;
        $order->quantity = $quantity;
        $order->order_price = $totalPrice;
        $order->order_id = mt_rand(100000, 999999); // Random 6-digit order ID


        // Handle payment method ID
        $paymentMethodId = $request->input('payment_method_id');
        if ($paymentMethodId !== 'cash_on_delivery') {
            // Validate payment method ID
            $paymentMethod = PaymentMethod::find($paymentMethodId);
            if (!$paymentMethod) {
                return redirect()->back()->with('error', 'Invalid payment method selected');
            }
            $order->payment_method_id = $paymentMethodId;
        } else {
            $order->payment_method_id = null; // Set payment method ID to null for cash on delivery
        }




        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('payment/images/', $filename);
            $order->image = $filename;
        } else {
            // Set image to null if no file is uploaded
            $order->image = null;
        }

        // Save the order
        if ($order->save()) {
            // Calculate the remaining quantity
            if ($product->remaining_quantity !== null) {
                // Subtract from remaining quantity
                $remainingQuantity = $product->remaining_quantity - $quantity;
            } else {
                // If remaining quantity is null, subtract from total quantity and set remaining quantity
                $remainingQuantity = $product->total_quantity - $quantity;
            }

            // Update the product's remaining quantity
            $product->remaining_quantity = $remainingQuantity;
            // dd( $order);
            $product->save();


            Alert::success('Success', 'Order Submitted Successfully');
            return redirect()->route('orderhistory')->with('success', 'Refresh your History page after 5 minutes to check your order status');
        } else {
            // If something went wrong during the order confirmation process
            Alert::error('Error', 'Something went wrong. Please try again.');
            return redirect()->back();
        }
    }

    public function completedOrder(Request $request)
    {
        $searchQuery = $request->query('search');
        $filter = $request->query('filter');

        $query = Order::with('product', 'user', 'paymentMethod')
            ->with(['product' => function ($query) {
                $query->withTrashed(); // Include soft deleted products
            }])
            ->orderBy('created_at', 'desc')
            ->where('archive', '=', 1);

        if ($searchQuery && $filter) {
            $query->whereHas('user', function ($q) use ($filter, $searchQuery) {
                $q->where($filter, 'like', '%' . $searchQuery . '%');
            });
        }

        $orders = $query->paginate(50);

        if ($orders->isEmpty()) {
            return redirect()->back();
        } else {
            return view('layout.adminpanel.completedorder', compact('orders', 'searchQuery'));
        }
    }


    public function updateOrder(Request $request, $id)
    {
        // Find the order by its ID
        $order = Order::find($id);
        //    dd( $order);
        if ($order) {
            // Update the 'archive' field to 1
            $order->update(['archive' => 1]);

            // Alert::Success('Success', 'Order Completed Successfully');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Order not found!');
            return redirect()->back();
        }
    }

    public function CancelOrder(Request $request)
    {
        $searchQuery = $request->query('search');
        $filter = $request->query('filter');

        $query = Order::with('product', 'user', 'paymentMethod')
            ->with(['product' => function ($query) {
                $query->withTrashed(); // Include soft deleted products
            }])
            ->orderBy('created_at', 'desc')
            ->where('archive', '=', 2);

        if ($searchQuery && $filter) {
            $query->whereHas('user', function ($q) use ($filter, $searchQuery) {
                $q->where($filter, 'like', '%' . $searchQuery . '%');
            });
        }

        $orders = $query->paginate(50);

        if ($orders->isEmpty()) {
            return redirect()->back();
        } else {
            return view('layout.adminpanel.cancelorder', compact('orders', 'searchQuery'));
        }
    }

    public function user_order_cancel($id)
    {

        $order = Order::find($id);
        //    dd( $order);
        if ($order) {
            // Update the 'archive' field to 1
            $order->update(['archive' => 2]);

            // Alert::Success('Success', 'Order Cancel Successfully');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Order not found!');
            return redirect()->back();
        }
    }


    public function orderhistory()
    {
        $user = auth()->user();
        $query = Order::with(['product' => function ($query) {
            $query->withTrashed(); // Include products with trashed records
        }, 'paymentMethod']) // Include both product and payment method relationships
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');
        $orders = $query->paginate(10);
        return view('frontend.userorderhistory', compact('orders'));
    }


    public function user_profile(Request $request)
    {
        // Retrieve the search query and filter type from the request
        $searchQuery = $request->input('search');
        $filter = $request->input('filter');

        $usersQuery = User::query()->where('is_enabled', 0);

        if ($searchQuery) {
            if ($filter === 'rollno') {
                $usersQuery->where('rollno', $searchQuery);
            } elseif ($filter === 'email') {
                $usersQuery->where('email', $searchQuery);
            }
             elseif ($filter === 'name') {
                $usersQuery->where('name', 'LIKE', "%$searchQuery%");
            }
        }

        // Retrieve paginated results
        $users = $usersQuery->paginate(10); // Adjust pagination as needed

        // Pass the filtered users and search query to the view
        return view('layout.adminpanel.user', compact('users', 'searchQuery'));
    }


    public function edit_user_profile(Request $request, $user_id)
    {
        // $id = $request->id; // Remove this line

        // dd($uuid);

        // $user = User::where('id', $id)->first(); // Remove this line
        $user_id = auth()->user();

        // Check if the user is authenticated
        if ($user_id) {
            // If authenticated, load the user's data
            $userData = User::where('user_id', $user_id->user_id)->get();

            // Pass the user's data to the view
            return view('frontend.editprofile', ['users' => $userData]);
        } else {
            // If not authenticated, redirect to login
            return redirect()->route('login');
        }
    }

    public function update_user_Profile(Request $request)
    {
        $id = $request->input('id');

        // Find the user by ID
        $user = User::find($id);

        // Validate the request data
        $request->validate([
            'name' => 'sometimes|required|max:20',
            // 'email' => 'sometimes|required|email|unique:users,email,' . $user->id . '|max:40|regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/',
            'class' => 'sometimes|required|max:10',
            'number' => 'sometimes|required|digits:11|unique:users,number,' . $user->id . '|regex:/^0[0-9]{10}$/',
            // 'rollno' => 'sometimes|required|unique:users,rollno,' . $user->id . '|max:20',
            'oldpassword' => 'nullable|required_with:newpassword|string',
            'newpassword' => 'nullable|string|min:8|max:15|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'confirmpassword' => 'nullable|required_with:newpassword|same:newpassword',
        ], [
            'name.max' => 'Name must not exceed 20 characters.',
            // 'email.email' => 'Please enter a valid email address.',
            // 'email.unique' => 'Email is already in use.',
            // 'email.max' => 'Email must not exceed 40 characters.',
            // 'email.regex' => 'Email must be in lowercase format.',
            'number.digits' => 'Number must be exactly 11 digits.',
            'number.unique' => 'Number is already in use.',
            'number.regex' => 'Number must start with 0 and contain only numeric characters.',
            // 'rollno.unique' => 'Roll number is already in use.',
            // 'rollno.max' => 'Roll number must not exceed 20 characters.',
            'oldpassword.required_with' => 'Please enter your old password.',
            'confirmpassword.same' => 'The new password and confirmation do not match.',
        ]);


        // Check if the old password is provided and valid
        if ($request->filled('oldpassword')) {
            if (!Hash::check($request->input('oldpassword'), $user->password)) {
                return redirect()->back()->withErrors(['oldpassword' => 'The old password is incorrect.'])->withInput();
            }
        }

        // Update user attributes
        $user->name = $request->input('name');
        // $user->email = $request->input('email');
        $user->number = $request->input('number');
        // $user->rollno = $request->input('rollno');
        // If a new password is provided, update the password
        if ($request->filled('newpassword')) {
            $user->password = Hash::make($request->input('newpassword'));
        }

        // Save the updated user
        $user->save();

        // Show success alert
        // Alert::success('Success', 'Profile updated successfully.');

        // Redirect to the user profile page
        return redirect()->route('userprofile');
    }
}
