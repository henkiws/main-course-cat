<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;

    protected $table = 'modules';
    protected $fillable = ['name','description','image','position','active','created_by'];

    public function data_chapters() {
        return $this->hasMany(Chapters::class,'fk_module','id');
    }
}
