<?php

namespace App\Http\Controllers;
use App\Models\CustomerReview;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class CustomerReviewController extends Controller
{
   public function homepage() {
    return view('frontend.index');
   }
   public function submit(Request $request)
   {
       // Validate incoming request
       $validator = Validator::make($request->all(), [
        'name' => 'required|min:3|regex:/^[a-zA-Z ]+$/',
        'email' => 'required|email', 
        'message' => 'required|min:20|regex:/^[a-zA-Z .!,]+$/',


       ]);
   
       if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withInput();
          
       }
   
      
       $data = $request->only(['name', 'email', 'message']);
   
       // Create a new CustomerReview instance and persist to the database
       $create = CustomerReview::create($data);
   
       if ($create) {
        Alert::Success('Congrats', 'Review submitted successfully!');
           return redirect()->route('frontend.index')->with('success', 'Review submitted successfully!');
       } else {
           // Failure: Redirect back with an error flash message
           return redirect()->back()->with('error', 'Failed to submit review. Please try again.');
       }
   }

   public function user_reviews() {

    CustomerReview::query()->update(['is_read' => 1]);

    $reviews = CustomerReview::orderBy('id' , 'desc')->paginate(10);
    return view('layout.adminpanel.review' ,['reviews' => $reviews]);
   }

   public function checkNewReviews()
   { 
       // Fetch the original notification count from the database
       $originalNotificationCount = CustomerReview::count();
       
       // Count the new reviews that have not been marked as read
       $newReviewsCount = CustomerReview::where('is_read', false)->count();
   
       return response()->json(['newReviewsCount' => $newReviewsCount, 'originalNotificationCount' => $originalNotificationCount]);
   }
     
   public function checkNewOrders()
   { 
       // Fetch the original notification count from the database
       $originalNotificationCount = Order::count();
       
       // Count the new reviews that have not been marked as read
       $newReviewsCount = Order::where('is_read', false)->count();
   
       return response()->json(['newReviewsCount' => $newReviewsCount, 'originalNotificationCount' => $originalNotificationCount]);
   }
   
}

