<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATJawaban extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'cbt_jawaban';
    protected $fillable = ['jawaban_soal_id','jawaban_detail','jawaban_benar','jawaban_aktif'];
    public $primaryKey = 'jawaban_id';
    public $timestamps = false;
}
