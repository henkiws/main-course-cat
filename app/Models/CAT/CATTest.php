<?php

namespace App\Models\CAT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CATTest extends Model
{
    use HasFactory;

    protected $connection = 'mysql_cat';    

    protected $table = 'cbt_tes';
    protected $fillable = ['tet_nama','tes_detail','tes_begin_time','tes_end_time','tes_duration_time','tes_ip_range','tes_results_to_users',
                            'tes_detail_to_users','tes_score_right','tes_score_wrong','tes_score_unanswered','tes_max_score','multiple_test','always_available','tes_token'];
    public $primaryKey = 'tes_id';
    public $timestamps = false;
}
