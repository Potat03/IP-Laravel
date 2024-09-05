<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function create(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin,email',
            'password' => 'required|string|min:3',
            'status' => 'required|string',
        ]);

        Admin::create([
            'role' => $validatedData['role'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'status' => $validatedData['status']
        ]);

        return redirect()->route('login2')->with('success', 'Admin created successfully!');
    }
}
