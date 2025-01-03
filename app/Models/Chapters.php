<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapters extends Model
{
    use HasFactory;

    protected $table = 'chapters';
    protected $fillable = ['fk_module','name','description','position','active','created_by'];

    public function data_module() {
        return $this->hasOne(Modules::class,'id','fk_module');
    }
}
