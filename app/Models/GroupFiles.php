<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupFiles extends Model
{
    use HasFactory;

    protected $table = 'group_files';
    protected $fillable = ['fk_module_file','fk_group'];

    public function data_group() {
        return $this->hasOne(Group::class,'id','fk_group');
    }

    public function data_user() {
        return $this->hasOne(ModuleFiles::class,'id','fk_module_file');
    }
}
