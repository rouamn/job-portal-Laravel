<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class JobListing extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if table name matches the plural form of the model name)
    protected $table = 'job_listings';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'title',
        'description',
        'company_name',
        'location',
        'salary',
        'experience_level',
        'job_type',          
        'industry',
        'user_id',
    ];

    /**
     * Define the inverse relationship with the User model.
     *
     * A job listing belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);  // Each job listing belongs to one user
    }
}
