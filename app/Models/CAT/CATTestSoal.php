<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATTestSoal extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'cbt_tes_soal';
    protected $fillable = ['tessoal_tesuser_id','tessoal_user_ip','tessoal_soal_id','tessoal_jawaban_text','tessoal_nilai','tessoal_creation_time',
                        'tessoal_display_time','tessoal_change_time','tessoal_reaction_time','tessoal_ragu','tessoal_order','tessoal_num_answers',
                        'tessoal_comment','tessoal_audio_play'];
    public $primaryKey = 'tessoal_id';
    public $timestamps = false;
}
