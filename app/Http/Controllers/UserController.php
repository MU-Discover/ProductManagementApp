<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Home page
    public function home(){
        $products = Product::all();
        return view('home', compact('products'));
    }
    /**
     * Display a listing of the resource.
     */
    public function login(Request $req)
    {
        $user = User::where('email', $req->input('email'))->first();
        // dd($user);
        if($user){
              if (Hash::check($req->input('password'), $user->password)) {
                // dd($user);
                $req->session()->put('email', $user->email);
                $req->session()->put('name', $user->name);
                session()->flash('success', 'Success message here');
                return redirect()->route('home')->with('success', 'Register in successfully ');
            }else{
                session()->flash('warning', 'Something wrong when saving your information ');
                return back()
                ->withInput();  // To repopulate the form with old input data
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function register(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // dd($request->input('password'), $request->input('confirm_password'));
        if($request->input('password') == $request->input('confirm_password')){
            // dd('ok');
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $request->input('password');

            if($user){
                $user->save();
                $request->session()->put('email', $user->email);
            }
        }
        if(session('email')){
             session()->flash('success', 'Success message here');
            return redirect()->route('home')->with('success', 'Register in successfully ');
        }else{
            session()->flash('warning', 'Something wrong when saving your information ');
            return back()
            ->withInput();  // To repopulate the form with old input data
            }
    }

}
