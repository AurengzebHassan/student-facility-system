<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function show_payment_method(Request $request)
    {
        $searchQuery = $request->input('search');
            $paymentMethods = PaymentMethod::query()
            ->where('method_name', 'LIKE', "%$searchQuery%")
            ->get();
    
        return view('layout.payment.payment', [
            'paymentMethods' => $paymentMethods,
            'searchQuery' => $searchQuery,
        ]);
    }

    public function new_payment_method()
    {
        return view('layout.payment.addpayment');
    }

    public function add_payment_method(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method_name' => 'required',
            'account_name' => 'required',
            'account_number' => 'required|unique:payment_methods', // Add unique rule here
            'branch' => 'required',
        ], [
            'account_number.unique' => 'The account number is already in use.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'All fields are required!')->withErrors($validator)->withInput();
        }

        // Check if the payment method already exists with the same values for all fields
        $existingPaymentMethod = PaymentMethod::where('method_name', $request->method_name)
            ->where('account_name', $request->account_name)
            ->where('account_number', $request->account_number)
            ->where('branch', $request->branch)
            ->first();

        if ($existingPaymentMethod) {
            return redirect()->back()->withInput()->withErrors(['error' => 'A payment method with these details already exists.']);
        }

        $data = $request->only(['method_name', 'account_name', 'account_number', 'branch']);
        $paymentMethod = PaymentMethod::create($data);

        if ($paymentMethod) {
            return redirect()->route('showpayment.method')->with('success', 'Payment method added successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add payment method.');
        }
    }

    public function edit_payment_method($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id); // Find the payment method by its ID

        // Pass the found payment method to the view for editing
        return view('layout.payment.editpayment', ['paymentMethod' => $paymentMethod]);
    }

    public function update_payment_method(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'method_name' => 'required',
            'account_name' => 'required',
            'account_number' => 'required|unique:payment_methods,account_number,' . $id,
            'branch' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); // Flash old input data to the session
        }

        // Find the payment method by ID
        $paymentMethod = PaymentMethod::findOrFail($id);

        // Update the payment method with the new data
        $paymentMethod->update([
            'method_name' => $request->input('method_name'),
            'account_name' => $request->input('account_name'),
            'account_number' => $request->input('account_number'),
            'branch' => $request->input('branch'),
        ]);

        // Redirect back with a success message
        return redirect()->route('showpayment.method')
            ->with('success', 'Payment method updated successfully.');
    }

    public function delete_payment_method(Request $request, $id)
    {
        // Find the payment method by ID
        $paymentMethod = PaymentMethod::findOrFail($id);

        // Delete the payment method
        $paymentMethod->delete();

        // Redirect back with a success message
        return redirect()->route('showpayment.method')->with('success', 'Payment method deleted successfully.');
    }

    public function getPaymentMethodsAndDetails()
    {
        // Fetch payment methods and their details from the database
        $paymentMethods = PaymentMethod::all();
    
        // Transform payment methods into the required format (value-label pairs) and include details
        $formattedMethods = $paymentMethods->map(function ($method) {
            return [
                'value' => $method->id, // Accessing the id property of individual model instance
                'label' => $method->method_name,
                'details' => [
                    'accountName' => $method->account_name,
                    'accountNumber' => $method->account_number,
                    'branch' => $method->branch,
                ]
            ];
        });
    
        return response()->json($formattedMethods);
    }
    
}
