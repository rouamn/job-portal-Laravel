<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\JobListing;
use Illuminate\Support\Facades\Hash;

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
public function a_user_can_register_successfully()
{
    $data = [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ];

    // Update this line to use 'register.submit' instead of 'register'
    $response = $this->post(route('register.submit'), $data);

    // Assert that the user was created
    $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    // Assert that the response redirects to the login page
    $response->assertRedirect(route('login.form'));
    $response->assertSessionHas('success', 'Registration successful. Please login.');
}
  /** @test */
  public function registration_fails_with_invalid_data()
  {
      $data = [
          'name' => '',
          'email' => 'invalidemail',
          'password' => '123',
          'password_confirmation' => '1234'
      ];

      $response = $this->post(route('register.submit'), $data);

      // Assert that the validation errors are returned
      $response->assertSessionHasErrors(['name', 'email', 'password']);
      $this->assertCount(0, User::all());  // No user should be created
  }
   /** @test */
   public function a_user_can_login_with_valid_credentials()
   {
       // Create a user with a hashed password
       $user = User::factory()->create([
           'password' => Hash::make('password123')  // Ensure the password is hashed
       ]);

       $response = $this->post(route('login'), [
           'email' => $user->email,
           'password' => 'password123',
       ]);

       // Assert the user is redirected to the job listings page
       $response->assertRedirect(route('job-listings.index'));
       $this->assertAuthenticatedAs($user);  // Assert the user is authenticated
   }
/** @test */
public function login_fails_with_invalid_credentials()
{
    // Create a user
    $user = User::factory()->create([
        'password' => Hash::make('password123')
    ]);

    // Try logging in with incorrect credentials
    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ]);

    // Assert that an error message is shown
    $response->assertSessionHasErrors('error');
    $this->assertGuest();  // Assert that the user is not authenticated
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
            'experience_level' => 'junior',
            'job_type' => 'full-time',
            'industry' => 'Technology',
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
            'experience_level' => 'junior',
            'job_type' => 'full-time',
            'industry' => 'Technology',
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


public function it_validates_required_fields_for_create()
{
    $user = $this->authenticateUser();

    $data = [
        'title' => '', // Invalid data: missing required field
        'description' => 'Develop awesome software.',
        'company_name' => 'Tech Corp',
        'location' => 'Remote',
        'salary' => 50000,
        'experience_level' => 'junior',
        'job_type' => 'full-time',
        'industry' => 'Technology',
    ];

    $response = $this->post(route('job-listings.store'), $data);

    // Check for validation errors in the response
    $response->assertSessionHasErrors('title');
}

/** @test */
public function it_validates_invalid_salary_for_create()
{
    $user = $this->authenticateUser();

    $data = [
        'title' => 'Software Engineer',
        'description' => 'Develop awesome software.',
        'company_name' => 'Tech Corp',
        'location' => 'Remote',
        'salary' => -1000, // Invalid salary: negative value
        'experience_level' => 'junior',
        'job_type' => 'full-time',
        'industry' => 'Technology',
    ];

    $response = $this->post(route('job-listings.store'), $data);

    // Check for validation errors in the response
    $response->assertSessionHasErrors('salary');
}



/** @test */
public function it_requires_authentication_for_create()
{
    $data = [
        'title' => 'Software Engineer',
        'description' => 'Develop awesome software.',
        'company_name' => 'Tech Corp',
        'location' => 'Remote',
        'salary' => 50000,
        'experience_level' => 'junior',
        'job_type' => 'full-time',
        'industry' => 'Technology',
    ];

    $response = $this->post(route('job-listings.store'), $data);

    $response->assertRedirect(route('login'));
}


}
