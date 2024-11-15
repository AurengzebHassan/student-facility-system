<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function show_category(Request $request)
    {
        $searchQuery = $request->input('search');
    
        // Retrieve categories based on search query
        $categories = Category::query()
            ->where('name', 'LIKE', "%$searchQuery%")
            ->get();
    
        return view('layout.adminpanel.category', [
            'categories' => $categories,
            'searchQuery' => $searchQuery,
        ]);
    }
    

    public function edit_category($id)
    {
        // Retrieve the category by its ID
        $category = Category::find($id);

        if (!$category) {
            // Handle case where category is not found
            return redirect()->back()->with('error', 'Category not found.');
        }

        // Return view with the category data
        return view('layout.adminpanel.editcategory', compact('category'));
    }

    public function update_main_category(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'description' => 'required',
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'description.required' => 'The description field is required.',
        ]);

        // Find the category by its ID
        $category = Category::findOrFail($id);

        // Update the category data
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];

        // Save the updated category
        $category->save();
        session()->flash('success', 'Category updated successfully');
        // Redirect back with success message
        return redirect()->route('showcategory', $id);
    }

    public function delete_main_category($id)
    {
        $category = Category::find($id);
        // dd($id);
        $category->delete();
        session()->flash('success', 'Category deleted successfully');
        return redirect()->route('showcategory');
    }
    public function add_category()
    {
        return view('layout.adminpanel.addcategory');
    }

    public function add_new_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',

        ]);

        if ($validator->fails()) {
            // Alert::error('Error', 'All fields are required!');
            return redirect()->back()->with('error', 'All fields are required!');
        }
        // Check if the product already exists
        $existingProduct = Category::where('name', $request->name)->first();

        if ($existingProduct) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Category with this name already exists.']);
        } else {
            $request_parameters = $request->toArray();
            $data = [];

            // $data['uuid'] = Str::uuid()->toString();
            $data['name'] = $request_parameters['name'];
            $data['description'] = $request_parameters['description'];


            //   dd($data);
            
            $create = Category::create($data);
            if ($create) {
                session()->flash('success', 'Category added successfully');
                return redirect()->route('showcategory');
            } else {
                return redirect()->back()->withInput();
            }
        }
    }

    public function show_sub_category(Request $request)
    {
        $searchQuery = $request->input('search');
        $subcategories = SubCategory::query()
            ->where('name', 'LIKE', "%$searchQuery%")
            ->paginate(20); 
    
        return view('layout.adminpanel.subcategory', [
            'subcategories' => $subcategories,
            'searchQuery' => $searchQuery,
        ]);
    }

    public function add_sub_category()
    {
        $categories = Category::all();
        return view('layout.adminpanel.addsubcategory', ['categories' => $categories]);
    }


    public function add_new_sub_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'description' => 'required',
            'main_category' => 'required|exists:categories,id', // Ensure main_category exists in categories table
        ]);
        // dd($request);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'All fields are required!');
        }

        $mainCategory = Category::find($request->main_category);

        if (!$mainCategory) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Invalid main category selected.']);
        }

        // Check if the subcategory already exists under the main category
        $existingSubCategory = $mainCategory->subcategories()->where('name', $request->name)->first();

        if ($existingSubCategory) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Subcategory with this name already exists under the selected main category.']);
        }

        $subCategoryData = [
            'name' => $request->name,
            // 'description' => $request->description,
            'category_id' => $mainCategory->id,
        ];
        
        // Create the subcategory under the main category
        $subCategory = $mainCategory->subcategories()->create($subCategoryData);
        session()->flash('success', 'Sub-Category added successfully');
        // Category::create($data);
        if ($subCategory) {
            // ->with('success', 'Subcategory added successfully.')
            return redirect()->route('showsubcategory');
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to add subcategory.']);
        }
    }

    public function edit_sub_category($id)
    {
        // dd($id);
        // Retrieve the subcategory by its ID
        $subcategories = SubCategory::find($id);

        if (!$subcategories) {
            // Handle case where subcategory is not found
            return redirect()->back()->with('error', 'Subcategory not found.');
        }

        // Retrieve all categories to populate the dropdown
        $categories = Category::all();

        // Return view with the subcategory and categories data
        return view('layout.adminpanel.editsubcategory', compact('subcategories', 'categories'));
    }
    public function update_sub_category(Request $request, $id)
    {


        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subcategories')->where(function ($query) use ($request, $id) {
                    return $query->where('category_id', $request->input('category_id'))->where('id', '!=', $id);
                }),
                
            ],
            // Add any other validation rules as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Retrieve the subcategory by its ID
        $subcategory = SubCategory::find($id);

        if (!$subcategory) {
            return redirect()->back()->with('error', 'Subcategory not found.');
        }

        // Update the subcategory attributes
        $subcategory->name = $request->input('name');
        $subcategory->category_id = $request->input('category_id'); // Update category ID
        session()->flash('success', 'Sub-Category updated successfully');
        // Save the updated subcategory
        $subcategory->save();

        // Redirect back with success message
        return redirect()->route('showsubcategory');
    }

    public function delete_sub_category($id)
    {
        $category = SubCategory::find($id);
        // dd($id);
        $category->delete();
        session()->flash('success', 'Sub-Category deleted successfully');
        return redirect()->route('showsubcategory');
    }
}
