<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\JobListing;


class JobApiTest extends TestCase
{
    use RefreshDatabase;

    // Create a user for authentication
    private function authenticateUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }


    /** @test */
    public function it_can_create_a_job_listing()
    {
        $user = $this->authenticateUser();

        $data = [
            'title' => 'Software Engineer',
            'description' => 'Develop awesome software.',
            'company_name' => 'Tech Corp',
            'location' => 'Remote',
            'salary' => 50000,
        ];

        $response = $this->post(route('job-listings.store'), $data);

        // Check if the job listing was created in the database
        $this->assertDatabaseHas('job_listings', $data);

        // Check if we got a successful response
        $response->assertRedirect(route('job-listings.index'));
        $response->assertSessionHas('success', 'Job listing created successfully!');
    }

    /** @test */
    public function it_can_view_a_job_listing()
    {
        $user = $this->authenticateUser();
        $jobListing = JobListing::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('job-listings.show', $jobListing->id));

        $response->assertStatus(200);
        $response->assertSee($jobListing->title);
    }
    /** @test */
    public function it_can_update_a_job_listing()
    {
        $user = $this->authenticateUser();
        $jobListing = JobListing::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'title' => 'Updated Job Title',
            'description' => 'Updated description.',
            'company_name' => 'Updated Company',
            'location' => 'Updated Location',
            'salary' => 60000,
        ];

        $response = $this->put(route('job-listings.update', $jobListing->id), $updatedData);

        // Check if the job listing was updated in the database
        $this->assertDatabaseHas('job_listings', $updatedData);

        $response->assertRedirect(route('job-listings.index'));
        $response->assertSessionHas('success', 'Job listing updated successfully');
    }
   /** @test */
   public function it_can_delete_a_job_listing()
   {
       $user = $this->authenticateUser();
       $jobListing = JobListing::factory()->create(['user_id' => $user->id]);

       $response = $this->delete(route('job-listings.destroy', $jobListing->id));

       // Check if the job listing was deleted from the database
       $this->assertDatabaseMissing('job_listings', ['id' => $jobListing->id]);

       $response->assertRedirect(route('job-listings.index'));
       $response->assertSessionHas('success', 'Job listing deleted successfully');
   }

  /*  /** @test
    public function it_cannot_delete_a_job_listing_if_not_the_owner()
    {
        $user = $this->authenticateUser();
        $jobListing = JobListing::factory()->create();

        $response = $this->delete(route('job-listings.destroy', $jobListing->id));

        $response->assertRedirect(route('job-listings.index'));
        $response->assertSessionHas('error', 'Unauthorized');
    }



  /** @test
public function it_requires_authentication_for_create_update_delete()
{
    // Try to create a job listing without authentication
    $response = $this->post(route('job-listings.store'), []);
    $response->assertRedirect(route('login'));

    // Try to update a job listing without authentication
    $jobListing = JobListing::factory()->create();
    $response = $this->put(route('job-listings.update', $jobListing->id), []);
    $response->assertRedirect(route('login'));

    // Try to delete a job listing without authentication
    $response = $this->delete(route('job-listings.destroy', $jobListing->id));
    $response->assertRedirect(route('login'));
}
*/
}
