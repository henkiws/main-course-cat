<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificateDetails extends Model
{
    use HasFactory;

    protected $table = 'user_certificate_details';
    protected $fillable = ['fk_user_certificate','fk_cbt_test','score_text','score_number'];
}
