<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleRecords extends Model
{
    use HasFactory;

    protected $table = 'module_records';
    protected $fillable = ['title','description','date_class',
                            'tutor','link','position','active','created_by'];


    public function data_group_records() {
        return $this->hasMany(GroupRecords::class,'fk_record','id');
    }
}
