<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = [
        'id', 'dob', 'user_id', 'age', 'pan', 'pan_image', 'adhaar', 'gender', 'wife_name', 'wife_contact',
        'father_name', 'father_contact', 'mother_name', 'mother_contact', 'brother_name', 'brother_contact',
        'sister_name', 'sister_contact', 'child_name', 'child_contact', 'refference_name', 'refference_contact',
        'driving_experience', 'blood_group', 'adhaar_image', 'licence_image', 'account_details_image', 'resume', 'licence_no',
        'account_holder_name',
        'account_no',
        'isfc_code',
        'bank_name',
        'police_vf_image',
        'created_at', 'updated_at'
    ];
}
