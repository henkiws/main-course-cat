<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleFiles extends Model
{
    use HasFactory;

    protected $table = 'module_files';
    protected $fillable = ['title','description','date_class',
                            'tutor','filename','filepath','position','active','created_by'];

    public function data_group_files() {
        return $this->hasMany(GroupFiles::class,'fk_module_file','id');
    }
}
