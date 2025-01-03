<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRecords extends Model
{
    use HasFactory;

    protected $table = 'group_record';
    protected $fillable = ['fk_record','fk_group'];

    public function data_group() {
        return $this->hasOne(Group::class,'id','fk_group');
    }

    public function data_user() {
        return $this->hasOne(ModuleRecords::class,'id','fk_record');
    }
}
