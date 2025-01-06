<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATTestGroup extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'cbt_tesgrup';
    protected $fillable = ['tstgrp_grup_id'];
    public $primaryKey = 'tstgrp_tes_id';
    public $timestamps = false;
    
}
