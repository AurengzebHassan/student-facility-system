<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function products()
    {
        // Retrieve all categories with their associated subcategories
        $categories = Category::with('subcategories')->get();

        return view('layout.adminpanel.product', compact('categories'));
    }
    public function getSubcategories($categoryId)
    {
        // Retrieve subcategories for the given category ID
        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        // Return the subcategories as JSON response
        return response()->json(['subcategories' => $subcategories]);
    }
    public function addproducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'image' => 'required', // Example validation rules for image upload
            'price' => 'required',
            'total_quantity' => 'required',

        ]);

        if ($validator->fails()) {
            // Alert::error('Error', 'All fields are required!');
            return redirect()->back()->with('error', 'All fields are required!')->withInput();
        }
        // Check if the product already exists
        $existingProduct = Product::where('name', $request->name)
                            ->whereNull('deleted_at')
                            ->first();

        if ($existingProduct) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Product with this name already exists.']);
        }
        $existingSubcategoryProduct = Product::where('subcategory_id', $request->subcategory_id)
            ->where('id', '!=', $request->product_id)
            ->first();

        if ($existingSubcategoryProduct) {
            return redirect()->back()->withInput()->withErrors(['subcategoryerror' => 'Subcategory is already used for another product.']);
        } else {
            // $categoryId = $request->input('category_id');
            $request_parameters = $request->toArray();
            $data = [];

            $data['uuid'] = Str::uuid()->toString();
            $data['name'] = $request_parameters['name'];
            $data['description'] = $request_parameters['description'];
            $data['category_id'] = $request_parameters['category_id'];
            $data['subcategory_id'] = $request_parameters['subcategory_id'];
            // Handle image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('product/images/', $filename);
                $data['image'] = $filename;
            }

            $data['price'] = $request_parameters['price'];
            $data['total_quantity'] = $request_parameters['total_quantity'];

            //   dd($data);

            $create = Product::create($data);

            if ($create) {
                session()->flash('success', 'Products added successfully');
                // Alert::Success('Success', 'Product added Successfully.');
                return redirect()->route('instock');
            } else {
                Alert::error('Error', 'Oops! Something went Wrong');
                return redirect()->back()->withInput();
            }
        }
    }




    //  instock
    public function instock(Request $request)
    {
        $searchQuery = $request->input('search');
    
        $productsQuery = Product::where(function ($query) {
            $query->where('remaining_quantity', '>=', 10)
                ->orWhereNull('remaining_quantity');
        })->where('archive', 0)->orderBy('created_at', 'desc');;
    
        if ($searchQuery) {
            $productsQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }
    
        $products = $productsQuery->paginate(20); // Paginate the results
    
        return view('layout.adminpanel.Stock', [
            'products' => $products, // Pass the paginated products to the view
            'searchQuery' => $searchQuery,
        ]);
    }


    public function outstock()
    {
        $product = Product::Where('remaining_quantity', '<=', 10)->get();
        // Alert::Warning('Warning', 'Product is out of stock');
        return view('layout.adminpanel.outstock', ['products' => $product]);
    }

    public function edit(Request $request, $uuid)
    {
        $uuid = $request->uuid;

        // dd($uuid);
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $product = Product::where('uuid', $uuid)->first();
        // dd($product); 

        return view('layout.adminpanel.update', compact('product', 'categories', 'subcategories'));
    }


    // public function updateProduct(Request $request)
    // {
    //     $request_params = $request->toArray();

    //     if (isset($request_params['uuid'])) {
    //         $uuid = $request_params['uuid'];
    //         $product = Product::where('uuid', $uuid)->first(); // Retrieve the product instance

    //         if ($product) {
    //             $product->name = $request_params['name'];
    //             $product->description = $request_params['description'];
    //             $product->price = $request_params['price'];
    //             $product->total_quantity = $request_params['total_quantity'];

    //              // Set remaining_quantity to NULL
    //         $product->remaining_quantity = null;
    //             // Check if new image is uploaded
    //             if ($request->hasFile('image')) {
    //                 // Delete the previous image if it exists
    //                 if ($product->image) {
    //                     Storage::delete('product/images/' . $product->image);
    //                 }

    //                 // Store the new image
    //                 $file = $request->file('image');
    //                 $extension = $file->getClientOriginalExtension();
    //                 $filename = time() . '.' . $extension;
    //                 $file->move('product/images/', $filename);
    //                 $product->image = $filename;
    //             }

    //             $product->save(); // Save changes to the database
    //             // Alert::Success('Success', 'Product updated Successfully.');
    //             return redirect()->route('instock');
    //         } else {
    //             Alert::error('Error', 'Product not found');
    //             return redirect()->back();
    //         }
    //     } else {
    //         Alert::error('Error', 'Oops! Something went Wrong');
    //         return redirect()->back();
    //     }
    // }
    public function updateProduct(Request $request)
    {
        // Validate the form data
        $request->validate([
            'category_id' => 'required',
            'subcategory_id'  => 'required',
            'name' => [
                'required',
                Rule::unique('products', 'name')->where(function ($query) use ($request) {
                    // Check if the product exists in both active and soft-deleted states
                    return $query->where('name', $request->name)->whereNull('deleted_at')->where('uuid', '!=', $request->uuid);
                }),
            ],       
            'description' => 'required',
            'price' => 'required|numeric',
            'total_quantity' => 'required|integer',
            // 'image' => 'required', 
        ], [
            'category_id.required' => 'The category is required.',
            'subcategory_id.required' => 'The Subcategory is required.',
            'name.required' => 'The product name is required.',
            'name.unique' => 'The product name already taken.',
            'description.required' => 'The description field is required.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a number.',
            'total_quantity.required' => 'The total quantity field is required.',
            'total_quantity.integer' => 'The total quantity must be an integer.',
            // 'image.required' => 'The image field is required.',
    
        ]);
    
        $product = Product::where('uuid', $request->uuid)->first();
    
        if (!$product) {
            Alert::error('Error', 'Product not found');
            return redirect()->back();
        }
    
        // Store the current total quantity for comparison later
        $previousTotalQuantity = $product->total_quantity;
    
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->total_quantity = $request->total_quantity;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
    
      // Check if the total quantity has changed
if ($request->total_quantity != $previousTotalQuantity) {
    // Check if admin wants to reset remaining quantity
    if ($request->has('reset_remaining_quantity') && $request->reset_remaining_quantity) {
        // Reset remaining_quantity to null
        $product->remaining_quantity = null;
    } else {
        // If remaining_quantity is currently null, keep it null after the update
        if ($product->remaining_quantity === null) {
            $product->remaining_quantity = null;
        } else {
            // Update remaining_quantity based on the difference in total_quantity
            $difference = $request->total_quantity - $previousTotalQuantity;
            $product->remaining_quantity += $difference;
        }
    }
} else {
    // If the total quantity hasn't changed, but admin wants to reset remaining quantity, set it to null
    if ($request->has('reset_remaining_quantity') && $request->reset_remaining_quantity) {
        $product->remaining_quantity = null;
    }
}


    
        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Delete the previous image if it exists
            if ($product->image) {
                Storage::delete('product/images/' . $product->image);
            }
    
            // Store the new image
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('product/images/', $filename);
            $product->image = $filename;
        }
        //   dd($product);
        $product->save(); // Save changes to the database
    
        return redirect()->route('instock');
    }

    public function hideproduct(Request $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        if ($product) {
            $product->update(['archive' => 1]);
            return redirect()->route('instock')->with('success', 'Product hide successfully.');
        } else {
            return redirect()->back()->with('fail', 'Product not found.');
        }

        //         $product = Product::where('uuid', $request);
        //         $product->update([

        //             'archive' => 1

        //         ]);
        //         return redirect()->route('instock');
    }
    public function unhide($uuid)
    {
        $product = Product::where('uuid', $uuid)->first();

        if ($product) {
            $product->update(['archive' => 0]);

            return redirect()->route('instock')->with('success', 'Product unhide successfully.');
        } else {
            return redirect()->route('instock')->with('error', 'Product not found.');
        }
    }

    public function unhideproducts(Request $request)
    {
        $searchQuery = $request->input('search');

        $productsQuery = Product::where(function ($query) {
            $query->where('archive', 1);
        });



        if ($searchQuery) {
            $productsQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        $products = $productsQuery->get();
        return view('layout.adminpanel.hide', [
            'products' => $products,
            'searchQuery' => $searchQuery,
        ]);
    }

    public function deleteproduct($uuid) {
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
