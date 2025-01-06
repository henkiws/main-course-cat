<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATSoal extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'cbt_soal';
    protected $fillable = ['soal_topik_id','soal_detail','soal_tipe','soal_kunci','soal_difficulty','soal_aktif','soal_audio_play',
                            'soal_timer','soal_inline_answer','soal_auto_next'];
    public $primaryKey = 'soal_id';
    public $timestamps = false;
}
