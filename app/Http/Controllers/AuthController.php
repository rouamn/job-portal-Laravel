<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register'); // Return registration form view
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login'); // Return login form view
    }

    // User Registration
    public function register(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Optionally, you can generate JWT here, but in Blade views, it’s not necessary unless you need it
        // $token = JWTAuth::fromUser($user);

        // Redirect to login page or dashboard after successful registration
        return redirect()->route('login.form')->with('success', 'Registration successful. Please login.');
    }

    public function login(Request $request)
    {
        // Validate credentials with custom error messages
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'regex:/@/'],
            'password' => 'required|string',
        ], [
            'email.regex' => 'The email must contain an "@" symbol.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password is required.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Attempt login
        if (auth()->attempt($request->only('email', 'password'))) {
            // Authentication passed
            return redirect()->route('job-listings.index');
        } else {
            return back()->withErrors(['error' => 'Invalid credentials'])->withInput();
        }
    }


  // Logout function
  public function logout(Request $request)
  {
      auth()->logout();  // Log the user out

      // Optionally, invalidate the session for JWT-based authentication
      // JWTAuth::invalidate(JWTAuth::getToken());

      // Redirect to the home or login page after logout
      return redirect()->route('login.form')->with('success', 'You have been logged out successfully.');
  }
}
