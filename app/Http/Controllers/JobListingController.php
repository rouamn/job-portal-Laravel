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

        $this->jobListingService = $jobListingService;
    }

    /**
     * Display the list of job listings with pagination and filtering.
     */
    public function index(Request $request)
    {

        $itemsPerPage = $request->input('items_per_page', 6);
        $jobListings = $this->jobListingService->getFilteredJobListings($request)->paginate($itemsPerPage);
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

        if ($jobListing->user_id != Auth::id() && !Auth::user()->is_admin) {
            return redirect()->route('job-listings.index')->with('error', 'Unauthorized');
        }

        $validator = $this->validateJobListing($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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

        if ($jobListing->user_id != Auth::id() && !Auth::user()->is_admin) {
            return redirect()->route('job-listings.index')->with('error', 'Unauthorized');
        }

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
