<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATTestUser extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'cbt_tes_user';
    protected $fillable = ['tesuser_tes_id','tesuser_user_id','tesuser_status','tesuser_creation_time','tesuser_comment','tesuser_token'];
    public $primaryKey = 'tesuser_id';
    public $timestamps = false;
}
