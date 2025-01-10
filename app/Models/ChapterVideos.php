<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterVideos extends Model
{
    use HasFactory;

    protected $table = 'chapter_videos';
    protected $fillable = ['fk_chapter','link','title','description','date_class',
                            'tutor','position','active','created_by','filepath'];
}
