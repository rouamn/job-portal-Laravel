<?php
namespace App\Http\Services;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobListingService
{
    /**
     * Get filtered job listings.
     */
    public function getFilteredJobListings(Request $request)
    {
        $query = JobListing::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('salary_min') && is_numeric($request->salary_min)) {
            $query->where('salary', '>=', $request->salary_min);
        }

        if ($request->filled('salary_max') && is_numeric($request->salary_max)) {
            $query->where('salary', '<=', $request->salary_max);
        }

        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }

        if ($request->filled('industry')) {
            $query->where('industry', 'like', '%' . $request->industry . '%');
        }

        $jobListings = $query->paginate(10);

        return $query;
    }


    /**
     * Create a new job listing.
     */
    public function createJobListing(Request $request)
    {
        // Validate the incoming request
        $validated = $this->validateJobListing($request);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 400);
        }

        return JobListing::create([
            'title' => $request->title,
            'description' => $request->description,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'salary' => $request->salary,
            'experience_level' => $request->experience_level,
            'job_type' => $request->job_type,
            'industry' => $request->industry,
            'user_id' => $request->user()->id,

        ]);
    }

    /**
     * Update the job listing.
     */
    public function updateJobListing(Request $request, JobListing $jobListing)
    {
        // Validate the incoming request
        $validated = $this->validateJobListing($request);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 400);
        }

        $jobListing->update([
            'title' => $request->title,
            'description' => $request->description,
            'company_name' => $request->company_name,
            'location' => $request->location,
            'salary' => $request->salary,
            'experience_level' => $request->experience_level,
            'job_type' => $request->job_type,
            'industry' => $request->industry,
            'user_id' => $request->user()->id,
        ]);
    }

    /**
     * Delete the job listing.
     */
    public function deleteJobListing(JobListing $jobListing)
    {
        $jobListing->delete();
    }

    /**
     * Validate the job listing data.
     */
    private function validateJobListing(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'experience_level' => 'nullable|string|in:junior,mid,senior,expert',
            'industry' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|in:full-time,part-time,contract,internship',

        ]);
    }
}
