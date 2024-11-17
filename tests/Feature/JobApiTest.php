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

    $response = $this->post(route('register.submit'), $data);

    $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
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

      $response->assertSessionHasErrors(['name', 'email', 'password']);
      $this->assertCount(0, User::all());
  }
   /** @test */
   public function a_user_can_login_with_valid_credentials()
   {

       $user = User::factory()->create([
           'password' => Hash::make('password123')
       ]);

       $response = $this->post(route('login'), [
           'email' => $user->email,
           'password' => 'password123',
       ]);

       $response->assertRedirect(route('job-listings.index'));
       $this->assertAuthenticatedAs($user);
   }
/** @test */
public function login_fails_with_invalid_credentials()
{

    $user = User::factory()->create([
        'password' => Hash::make('password123')
    ]);

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors('error');
    $this->assertGuest();
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

        $this->assertDatabaseHas('job_listings', $data);
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


       $this->assertDatabaseMissing('job_listings', ['id' => $jobListing->id]);

       $response->assertRedirect(route('job-listings.index'));
       $response->assertSessionHas('success', 'Job listing deleted successfully');
   }


public function it_validates_required_fields_for_create()
{
    $user = $this->authenticateUser();

    $data = [
        'title' => '',
        'description' => 'Develop awesome software.',
        'company_name' => 'Tech Corp',
        'location' => 'Remote',
        'salary' => 50000,
        'experience_level' => 'junior',
        'job_type' => 'full-time',
        'industry' => 'Technology',
    ];

    $response = $this->post(route('job-listings.store'), $data);

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
        'salary' => -1000,
        'experience_level' => 'junior',
        'job_type' => 'full-time',
        'industry' => 'Technology',
    ];

    $response = $this->post(route('job-listings.store'), $data);


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
