<?php

namespace App\Http\Controllers;

use App\Http\Services\JobListingService;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use JWTAuth;  //
class JobListingController extends Controller
{
    protected $jobListingService;

    // Injecting the service into the controller
    public function __construct(JobListingService $jobListingService)
    {
        //$this->middleware('auth')->except(['index', 'show']);  // Allow public access for viewing job listings
        $this->jobListingService = $jobListingService;
    }

    /**
     * Display the list of job listings with pagination and filtering.
     */
    public function index(Request $request)
    {
        // Get the number of items per page from the request, default to 6 if not provided
        $itemsPerPage = $request->input('items_per_page', 6);  // Default to 6 if not set

        // Generate a cache key based on all the request parameters (including the items_per_page)
        $cacheKey = 'job_listings_' . md5(json_encode(array_merge($request->all(), ['items_per_page' => $itemsPerPage])));

        // Use cache to optimize fetching of job listings with filtering and pagination
        $jobListings = Cache::remember($cacheKey, 60, function () use ($request, $itemsPerPage) {
            // Fetch filtered job listings from the service, then paginate the results
            return $this->jobListingService->getFilteredJobListings($request)->paginate($itemsPerPage);
        });

        // Return the Blade view with the job listings and pagination
        return view('job-listings.index', compact('jobListings'));
    }

    /**
     * Show the form for creating a new job listing.
     */
    public function create()
    {
        return view('job-listings.create');
    }

    /**
     * Store a newly created job listing in the database.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = $this->validateJobListing($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new job listing via the service layer
        $this->jobListingService->createJobListing($request);

        return redirect()->route('job-listings.index')->with('success', 'Job listing created successfully!');
    }

    /**
     * Display the details of a specific job listing.
     */
    public function show($id)
    {
        $jobListing = JobListing::find($id);

        if (!$jobListing) {
            return redirect()->route('job-listings.index')->with('error', 'Job listing not found');
        }

        return view('job-listings.show', compact('jobListing'));
    }

    /**
     * Show the form to edit a specific job listing.
     */
    public function edit($id)
    {
        $jobListing = JobListing::find($id);

        if (!$jobListing) {
            return redirect()->route('job-listings.index')->with('error', 'Job listing not found');
        }

        // Ensure only the listing's owner or an admin can edit
        if ($jobListing->user_id != Auth::id() && !Auth::user()->is_admin) {
            return redirect()->route('job-listings.index')->with('error', 'Unauthorized');
        }

        return view('job-listings.edit', compact('jobListing'));
    }

    /**
     * Update the specified job listing in the database.
     */
    public function update(Request $request, $id)
    {
        $jobListing = JobListing::find($id);

        if (!$jobListing) {
            return redirect()->route('job-listings.index')->with('error', 'Job listing not found');
        }

        // Ensure only the listing's owner or an admin can update
        if ($jobListing->user_id != Auth::id() && !Auth::user()->is_admin) {
            return redirect()->route('job-listings.index')->with('error', 'Unauthorized');
        }

        // Validate the updated data
        $validator = $this->validateJobListing($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the job listing via the service layer
        $this->jobListingService->updateJobListing($request, $jobListing);

        return redirect()->route('job-listings.index')->with('success', 'Job listing updated successfully');
    }

    /**
     * Remove the specified job listing from the database.
     */
    public function destroy($id)
    {
        $jobListing = JobListing::find($id);

        if (!$jobListing) {
            return redirect()->route('job-listings.index')->with('error', 'Job listing not found');
        }

        // Ensure only the listing's owner or an admin can delete
        if ($jobListing->user_id != Auth::id() && !Auth::user()->is_admin) {
            return redirect()->route('job-listings.index')->with('error', 'Unauthorized');
        }

        // Delete the job listing via the service layer
        $this->jobListingService->deleteJobListing($jobListing);

        return redirect()->route('job-listings.index')->with('success', 'Job listing deleted successfully');
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
            'experience_level' => 'required|string|in:junior,mid,senior,expert',
            'job_type' => 'required|string|in:full-time,part-time,contract,freelance,remote',
            'industry' => 'required|nullable|string|max:255',
        ]);
    }
}
