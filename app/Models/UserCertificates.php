<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificates extends Model
{
    use HasFactory;

    protected $table = 'user_certificates';
    protected $fillable = ['fk_user','fk_certificate','ref','start_date','end_date','expired_date','certificate_date','status','path','created_by'];

    public function data_details() {
        return $this->hasMany(UserCertificateDetails::class,'fk_user_certificate','id');
    }

    public function data_certificate() {
        return $this->hasOne(Certificates::class,'id','fk_certificate');
    }

    public function data_user() {
        return $this->hasOne(User::class,'id','fk_user');
    }

}
