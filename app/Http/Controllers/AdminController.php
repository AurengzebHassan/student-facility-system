<?php

namespace App\Http\Controllers;

use App\Http\Middleware\User as MiddlewareUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function admin_detail()
    {
        $admins = Admin::all();
        return view('layout.adminpanel.admin', compact('admins'));
    }

    public function disableUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_enabled' => false]);
        Alert::Success('Success', 'User Disabled Successfully');
        return redirect()->back();
    }
    public function enableUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_enabled' => true]);
        Alert::Success('Success', 'User Enable Successfully');
        return redirect()->back();
    }
    
    public function calculateMonthlyEarnings()
    {
        $monthlyEarnings = Order::where('archive', 1)
            ->select(DB::raw('SUM(order_price) as total_earnings'), DB::raw('MONTH(created_at) as month'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        return response()->json($monthlyEarnings);
    }



    public function getDailyOrdersAndEarnings()
    {
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $dailyData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(CASE WHEN archive = 1 THEN order_price ELSE 0 END) as total_earnings')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->get();

        return response()->json($dailyData);
    }

    public function privacyPolicy()
    {
        return view('frontend.privacypolicy');
    }

    public function Show_Authenticated_User(Request $request)
    {
        $searchQuery = $request->input('search');
        $filter = $request->input('filter');

        // Base query to fetch authenticated users
        $query = User::where('is_enabled', 1);

        // Apply search query if it exists
        if ($searchQuery) {
            if ($filter === 'rollno') {
                $query->where('rollno', $searchQuery);
            } elseif ($filter === 'email') {
                $query->where('email', $searchQuery);
            }
             elseif ($filter === 'name') {
                $query->where('name', 'LIKE', "%$searchQuery%");
            }
        }

        // Paginate the results
        $users = $query->paginate(200); 

        // Pass the user data and search query back to the view
        return view('layout.adminpanel.authuser', compact('users', 'searchQuery'));
    }

    public function edit_Authenticated_User($id)
    {
        $users = User::findOrFail($id);
        return view('layout.adminpanel.editauthUser', compact('users'));
    }
    public function update_Authenticated_User(Request $request)
    { {
            $id = $request->input('id');

            // Find the user by ID
            $users = User::find($id);

            // Validate the request data
            $request->validate([
                'name' => 'sometimes|required|max:20',
                'class' => 'sometimes|required|max:10',
                'number' => 'sometimes|required|digits:11|unique:users,number,' . $users->id . '|regex:/^0[0-9]{10}$/',
                'rollno' => 'sometimes|required|unique:users,rollno,' . $users->id . '|max:20',
            ], [
                'name.max' => 'Name must not exceed 20 characters.',
                'number.digits' => 'Number must be exactly 11 digits.',
                'number.unique' => 'Number is already in use.',
                'number.regex' => 'Number must start with 0 and contain only numeric characters.',
                'rollno.unique' => 'Roll number is already in use.',
                'rollno.max' => 'Roll number must not exceed 20 characters.',
            ]);


            // Update user attributes
            $users->name = $request->input('name');
            $users->number = $request->input('number');
            $users->rollno = $request->input('rollno');
            $users->class = $request->input('class');


            // Save the updated user
            $users->save();
            return redirect()->route('Authenticated.user');
        }
    }
}
