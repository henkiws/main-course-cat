<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATTestSoalJawaban extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'cbt_tes_soal_jawaban';
    protected $fillable = ['soaljawaban_jawaban_id','soaljawaban_selected','soaljawaban_order','soaljawaban_position'];
    public $primaryKey = 'soaljawaban_tessoal_id';
    public $timestamps = false;
}
