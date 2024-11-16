@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="text-center">
                    <h3 class="fw-bold mb-4">Welcome</h3>
                </div>
                <div class="card-body">
                    <!-- Display Global Errors -->
                    @if ($errors->any())
                    <div role="alert" style="color: red; display: flex; align-items: center;">
                        <i class="fas fa-exclamation-circle me-2" style="color: red;"></i>
                        <strong>Oops!</strong> Please check your input and try again.
                    </div>
                @endif



                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="johndoe@example.com" value="{{ old('email') }}" >
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" >
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-gradient w-100">Login</button>
                    </form>
                </div>
                <div class="card-footer">
                    <p class="mb-0">Don't have an account? <a href="{{ route('register.form') }}" class="text-decoration-none">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
