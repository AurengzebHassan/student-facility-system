<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    //   for logout 
    public function logout(Request $request): RedirectResponse
    {
        //     auth()->logout();
        //    session()->forget('id');
        //    return redirect()->route('login');
        {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('login');
        }
    }
    public function userlogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    public function adminDashboard()
    {
        $today = Carbon::today();
    
        $acceptedOrdersToday = Order::where('archive', 1)
                                    ->whereDate('created_at', $today)
                                    ->count();
    
        $cancelledOrdersToday = Order::where('archive', 2)
                                    ->whereDate('created_at', $today)
                                    ->count();
    
        $orders = Order::orderBy('created_at', 'desc')->paginate(50);
        $admin = Auth::guard('admin')->user();
        $userCount = User::count(); // Get the total user count
    
        if ($admin !== null) {
            return view('layout.adminpanel.dashboard', [
                'adminName' => $admin->name,
                'orders' => $orders,
                'userCount' => $userCount,
                'acceptedOrdersToday' => $acceptedOrdersToday,  
                'cancelledOrdersToday' => $cancelledOrdersToday 
            ]);
        } else {
            return view('layout.adminpanel.dashboard', [
                'adminName' => 'Guest',
                'userCount' => $userCount,
                'acceptedOrdersToday' => $acceptedOrdersToday, 
                'cancelledOrdersToday' => $cancelledOrdersToday  
            ]);
        }
    }
    
}
