<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $fillable = ['name','description','image','fk_cbt_group','active','created_by'];

    public function data_group_user() {
        return $this->hasMany(UserGroup::class,'fk_group','id');
    }
}
