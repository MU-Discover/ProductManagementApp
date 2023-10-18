<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{    
public function searchH(Request $request)
{
    $query = $request->input('query');

    // Perform the search query on your model
    $products = Product::where('name', 'LIKE', "%$query%")
        ->orWhere('description', 'LIKE', "%$query%")
        ->orWhere('price', 'LIKE', "%$query%")
        ->orWhere('category_id', 'LIKE', "%$query%")
        ->paginate(5); // Paginate the search products

    return view('home', compact('products'));
}  
public function search(Request $request)
{
    $query = $request->input('query');

    // Perform the search query on your model
    $products = Product::where('name', 'LIKE', "%$query%")
        ->orWhere('description', 'LIKE', "%$query%")
        ->orWhere('price', 'LIKE', "%$query%")
        ->orWhere('category_id', 'LIKE', "%$query%")
        ->paginate(5); // Paginate the search products

    return view('products.index', compact('products'));
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $products = Product::latest()->paginate(5);
       return view('products.index', compact("products"));
    }
    public function create(){
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // dd($request);
     $request->validate([
            'name'=> 'required', 
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'quantity' => 'required | numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image format and size
        ]);
        // dd("Ok !");
        
        $product = new Product();
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->description = $request->input('description');
        // $product->image = $request->input('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // Store image in 'public/products' directory
            $product->image = $imagePath;
        }

        $product->save();

        // dd($product);
        return redirect()->route('product.index')->with('success', 'Product added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        $categories = Category::all();

        if ($product){
            return view('products.update', compact(['product','categories']));
        }else{
            return back()->with('warning', 'Product not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
       $request->validate([
            'name'=> 'required', 
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'quantity' => 'required | numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image format and size
       ]);

       $input = $request->all();

        if ($image = $request->file('image')) {
            $imagePath = $request->file('image')->store('products', 'public'); // Store image in 'public/books' directory
             $input['image'] = $imagePath;
        }else{
            unset($input['image']);
        }

        $product->update($input);

        return redirect()->route('product.index')->with('success', 'Product updated successfully');	
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($category_id)
    {
        if($category_id){
            DB::table('products')->where('id',$category_id)->delete();
        }

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
