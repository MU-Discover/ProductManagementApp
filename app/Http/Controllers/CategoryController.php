<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
        
public function search(Request $request)
{
    $query = $request->input('query');

    // Perform the search query on your model
    $categories = Category::where('name', 'LIKE', "%$query%")
        ->orWhere('description', 'LIKE', "%$query%")
        ->paginate(5); // Paginate the search categories

    return view('categories.index', compact('categories'));
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $categories = Category::latest()->paginate(5);
       return view('categories.index', compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // dd($request);
     $request->validate([
            'name'=> 'required', 
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image format and size
        ]);
        // dd("Ok !");
        
        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        // $category->image = $request->input('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public'); // Store image in 'public/categories' directory
            $category->image = $imagePath;
        }

        $category->save();

        // dd($category);
        return redirect()->route('category.index')->with('success', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();

        if ($category){
            return view('categories.update', compact('category'));
        }else{
            return back()->with('warning', 'Category not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
       $request->validate([
            'name'=> 'required', 
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
       ]);

       $input = $request->all();

        if ($image = $request->file('image')) {
            $imagePath = $request->file('image')->store('categories', 'public'); // Store image in 'public/books' directory
             $input['image'] = $imagePath;
        }else{
            unset($input['image']);
        }

        $category->update($input);

        return redirect()->route('category.index')->with('success', 'Category updated successfully');	
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($category_id)
    {
        if($category_id){
            DB::table('categories')->where('id',$category_id)->delete();
        }

        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }
}
