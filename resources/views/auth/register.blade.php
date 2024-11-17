@extends('layouts.app')

@section('title', 'Register')

@section('content')

    <div class="container" style="height: 100vh; display: flex; justify-content: center; align-items: center;">
        <div class="col-md-4">
            <div class="card">
                <div class="text-center">
                    <h3 class="fw-bold mb-4">Create an Account</h3>
                </div>
                <div class="card-body">
                    <!-- Display Global Errors -->
                    @if ($errors->any())
                        <div role="alert" style="color: red; display: flex; align-items: center;">
                            <i class="fas fa-exclamation-circle me-2" style="color: red;"></i>
                            <strong>Oops!</strong> Please check your input and try again.
                        </div>
                    @endif

                    <form action="{{ route('register.submit') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="johndoe@example.com" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm your password">
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-gradient w-100">Register</button>
                    </form>
                </div>
                <div class="card-footer">
                    <p class="mb-0">Already have an account? <a href="{{ route('login.form') }}" class="text-decoration-none">Login</a></p>
                </div>
            </div>
        </div>
    </div>

@endsection
