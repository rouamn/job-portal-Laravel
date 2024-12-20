<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job Listing</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <div class="card shadow-sm" style="max-width: 800px; margin: 0 auto; padding: 5px;">
            <div class="card-header">
                <h2>Create Job Listing</h2>
            </div>
            <form action="{{ route('job-listings.store') }}" method="POST">
                @csrf
                <div class="form-row mb-3">
                    <div class="form-group col-md-6">
                        <label for="title">Job Title</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                        >
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="company_name">Company Name</label>
                        <input type="text" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" >
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="form-group col-md-12">
                        <label for="description">Job Description</label>
                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="form-group col-md-6">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" >
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="salary">Salary</label>
                        <input type="number" id="salary" name="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary') }}" >
                        @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="form-group col-md-6">
                        <label for="experience_level">Experience Level</label>
                        <select id="experience_level" name="experience_level" class="form-control @error('experience_level') is-invalid @enderror">
                            <option value="">Select Experience Level</option>
                            <option value="junior" {{ old('experience_level') == 'junior' ? 'selected' : '' }}>Junior</option>
                            <option value="mid" {{ old('experience_level') == 'mid' ? 'selected' : '' }}>Mid</option>
                            <option value="senior" {{ old('experience_level') == 'senior' ? 'selected' : '' }}>Senior</option>
                            <option value="expert" {{ old('experience_level') == 'expert' ? 'selected' : '' }}>Expert</option>
                        </select>
                        @error('experience_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="industry">Industry</label>
                        <input type="text" id="industry" name="industry" class="form-control @error('industry') is-invalid @enderror" value="{{ old('industry') }}">
                        @error('industry')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="job_type">Job Type</label>
                    <select id="job_type" name="job_type" class="form-control @error('job_type') is-invalid @enderror">
                        <option value="">Select Job Type</option>
                        <option value="full-time" {{ old('job_type') == 'full-time' ? 'selected' : '' }}>Full-Time</option>
                        <option value="part-time" {{ old('job_type') == 'part-time' ? 'selected' : '' }}>Part-Time</option>
                    </select>
                    @error('job_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Create Listing</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
