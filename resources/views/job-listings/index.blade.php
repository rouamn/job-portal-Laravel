@extends('layouts.app')

@section('content')

<div class="container">

    <!-- Success and error messages -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @auth
        <a href="{{ route('job-listings.create') }}" class="btn btn-primary mt-3">Create Job Listing</a>
    @endauth

    <!-- Search Form with auto-submit on input change -->
    <form action="{{ route('job-listings.index') }}" method="GET" id="searchForm">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="title" class="form-control" placeholder="Search by title" value="{{ request('title') }}" id="titleInput" oninput="submitForm()">
            </div>
            <div class="col-md-3">
                <input type="text" name="location" class="form-control" placeholder="Search by location" value="{{ request('location') }}" id="locationInput" oninput="submitForm()">
            </div>
            <div class="col-md-2">
                <input type="number" name="salary_min" class="form-control" placeholder="Min Salary" value="{{ request('salary_min') }}" id="salaryMinInput" oninput="submitForm()">
            </div>
            <div class="col-md-2">
                <input type="number" name="salary_max" class="form-control" placeholder="Max Salary" value="{{ request('salary_max') }}" id="salaryMaxInput" oninput="submitForm()">
            </div>

            <!-- Experience Level Filter -->
            <div class="col-md-2">
                <select name="experience_level" class="form-control" id="experienceLevelInput" onchange="submitForm()">
                    <option value="">Select Experience Level</option>
                    <option value="junior" {{ request('experience_level') == 'junior' ? 'selected' : '' }}>Junior</option>
                    <option value="mid" {{ request('experience_level') == 'mid' ? 'selected' : '' }}>Mid-level</option>
                    <option value="senior" {{ request('experience_level') == 'senior' ? 'selected' : '' }}>Senior</option>
                </select>
            </div>

            <!-- Job Type Filter -->
            <div class="col-md-2">
                <select name="job_type" class="form-control" id="jobTypeInput" onchange="submitForm()">
                    <option value="">Select Job Type</option>
                    <option value="full-time" {{ request('job_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time" {{ request('job_type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="freelance" {{ request('job_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                </select>
            </div>
        </div>
    </form>

    <!-- Job Listings Display in 3-Column Grid -->
    <div class="row mt-4">
        @foreach($jobListings as $jobListing)
            <div class="col-md-4 mb-3">
                <div class="card" style="max-width: 600px; padding: 5px; margin: 0 auto;">
                    <div class="card-body">
                        <h5><a href="{{ route('job-listings.show', $jobListing->id) }}" class="text-decoration-none">{{ $jobListing->title }}</a></h5>
                        <p class="text-muted">{{ $jobListing->company_name }} - {{ $jobListing->location }}</p>
                        <p><strong>{{ $jobListing->salary }} USD</strong></p>

                        <!-- Buttons aligned in the same line -->
                        <div class="d-flex align-items-center">
                            <!-- Details Button (Always visible) -->
                            <a href="{{ route('job-listings.show', $jobListing->id) }}" class="btn btn-info btn-sm me-2">Details</a>

                            <!-- Show Edit and Delete buttons only if the authenticated user is the creator -->
                            @if (Auth::check() && Auth::id() === $jobListing->user_id)
                                <a href="{{ route('job-listings.edit', $jobListing->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                                <form action="{{ route('job-listings.destroy', $jobListing->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job listing?');">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Custom Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- Previous Page Link -->
            <li class="page-item {{ $jobListings->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $jobListings->previousPageUrl() }}" tabindex="-1">Previous</a>
            </li>
            <!-- Page Numbers -->
            @for ($i = 1; $i <= $jobListings->lastPage(); $i++)
                <li class="page-item {{ $jobListings->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $jobListings->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <!-- Next Page Link -->
            <li class="page-item {{ $jobListings->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $jobListings->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </nav>
</div>

<script>
    // JavaScript function to submit the form on input change
    function submitForm() {
        document.getElementById('searchForm').submit(); // Automatically submit the form
    }
</script>

@endsection
