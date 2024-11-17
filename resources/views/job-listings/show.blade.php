@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="text-center mb-4">
                <h1 class="display-4 font-weight-bold">{{ $jobListing->title }}</h1>
                <p class="text-muted">{{ $jobListing->company_name }} - {{ $jobListing->location }}</p>
                <p class="h3 text-primary"><strong>{{ $jobListing->salary }} USD</strong></p>
            </div>
            <div class="mb-4">
                <h4 class="font-weight-bold text-secondary">Job Description</h4>
                <p>{{ $jobListing->description }}</p>
            </div>
            <div class="row text-muted">
                <div class="col-md-4 mb-3">
                    <h5 class="font-weight-bold">Experience Level:</h5>
                    <p>{{ $jobListing->experience_level }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="font-weight-bold">Job Type:</h5>
                    <p>{{ $jobListing->job_type }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="font-weight-bold">Industry:</h5>
                    <p>{{ $jobListing->industry }}</p>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('job-listings.index') }}" class="btn btn-outline-primary btn-lg">Back to Listings</a>
            </div>
        </div>
    </div>
</div>

@endsection
