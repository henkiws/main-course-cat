<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATGroup extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'cbt_user_grup';
    protected $fillable = ['grup_nama'];
    public $primaryKey = 'grup_id';
    public $timestamps = false;
}
