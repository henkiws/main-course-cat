<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATPeserta extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'cbt_user';
    protected $fillable = ['user_grup_id','user_name','user_password','user_regdate','user_ip','user_firstname','user_birthdate',
                        'user_birthplace','user_level','user_detail'];
    public $primaryKey = 'user_id';
    public $timestamps = false;
}
