<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificates extends Model
{
    use HasFactory;

    protected $table = 'user_certificates';
    protected $fillable = ['fk_user','fk_certificate','ref','start_date','end_date','expired_date','certificate_date','status','created_by'];
}
