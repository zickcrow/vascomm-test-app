<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return Inertia::render('User/Index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'is_admin' => ['boolean']
        ])->validate();
  
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'is_admin' => $validatedData['is_admin'],
            'password' => Hash::make($validatedData['password']),
        ]);
  
        return redirect()->back()->with('message', 'User Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'is_admin' => ['boolean']
        ])->validate();
  
        if ($request->has('id')) {
            $user->find($request->input('id'))->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'is_admin' => $validatedData['is_admin'],
                'password' => Hash::make($validatedData['password']),
            ]);
            return redirect()->back()->with('message', 'User Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back();
    }
}
