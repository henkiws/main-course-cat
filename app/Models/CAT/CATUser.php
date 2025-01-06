<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATUser extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'user';
    protected $fillable = ['username','password','nama','opsi1','opsi2','keterangan','level'];
    public $primaryKey = 'id';
    public $timestamps = false;
}
