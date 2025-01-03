<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    protected $table = 'group_users';
    protected $fillable = ['fk_user','fk_group'];

    public function data_group() {
        return $this->hasOne(Group::class,'id','fk_group');
    }

    public function data_user() {
        return $this->hasOne(User::class,'id','fk_user');
    }
}
