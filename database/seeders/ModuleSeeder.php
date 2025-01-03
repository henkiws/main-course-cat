<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modules;
use App\Models\ModuleFiles;
use App\Models\ModuleRecords;
use App\Models\GroupFiles;
use App\Models\GroupRecords;
use App\Models\Chapters;
use App\Models\ChapterVideos;
use Carbon\Carbon;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $module1 = Modules::create([
            "name" => "Undang-Undang Kepabeanan 1",
            "description" => "Description Undang-Undang Kepabeanan 1",
            "image" => ('data/sample.webp'),
            "position" => 1,
            "created_by" => 1
        ]);

        $module2 = Modules::create([
            "name" => "Undang-Undang Kepabeanan 2",
            "description" => "Description Undang-Undang Kepabeanan 2",
            "image" => ('data/sample.webp'),
            "position" => 2,
            "created_by" => 1
        ]);

        $module3 = Modules::create([
            "name" => "Undang-Undang Kepabeanan 3",
            "description" => "Description Undang-Undang Kepabeanan 3",
            "image" => ('data/sample.webp'),
            "position" => 3,
            "created_by" => 1
        ]);

        for($i=1; $i<=5; $i++) {
            $file = ModuleFiles::create([
                "title" => "Pertemuan File ".$i,
                "description" => "description File ".$i,
                "date_class" => Carbon::now(),
                "tutor" => "user ".$i,
                "filename" => "myfilename.jpg",
                "filepath" => ('data/sample.webp'),
                "position" => $i,
                "active" => 1,
                "created_by" => 1
            ]);

            GroupFiles::create([
                "fk_group" => 1,
                "fk_module_file" => $file->id
            ]);
        }

        // records
        for($i=1; $i<=5; $i++) {
            $record = ModuleRecords::create([
                "title" => "Pertemuan Record ".$i,
                "description" => "description record ".$i,
                "date_class" => Carbon::now(),
                "tutor" => "user ".$i,
                "link" => 'https://youtu.be/dB3mB9x9sN4',
                "position" => $i,
                "active" => 1,
                "created_by" => 1
            ]);

            GroupRecords::create([
                "fk_group" => 1,
                "fk_record" => $record->id
            ]);
        }
        // end records

        for($i=1; $i<=3; $i++) {
            $chapter1 = Chapters::create([
                "fk_module" => $module1->id,
                "name" => "Ketentuan Umum ".$i,
                "description" => "Description Ketentuan Umum ".$i,
                "position" => $i,
                "active" => 1,
                "created_by" => 1
            ]);

            for($n=1; $n<=3; $n++) {
                ChapterVideos::create([
                    "fk_chapter" => $chapter1->id,
                    "link" => "https://youtu.be/dB3mB9x9sN4",
                    "title" => "Pertemuan ".$n,
                    "description" => "Undang-Undang Kepabeanan ".$n,
                    "date_class" => Carbon::now(),
                    "tutor" => "user ".$n,
                    "position" => $n,
                    "active" => 1,
                    "created_by" => 1
                ]);
            }
        }

        for($i=1; $i<=3; $i++) {
            $chapter2 = Chapters::create([
                "fk_module" => $module2->id,
                "name" => "Ketentuan Umum ".$i,
                "description" => "Description Ketentuan Umum ".$i,
                "position" => $i,
                "active" => 1,
                "created_by" => 1
            ]);

            for($n=1; $n<=3; $n++) {
                ChapterVideos::create([
                    "fk_chapter" => $chapter2->id,
                    "link" => "https://youtu.be/dB3mB9x9sN4",
                    "title" => "Pertemuan ".$n,
                    "description" => "Undang-Undang Kepabeanan ".$n,
                    "date_class" => Carbon::now(),
                    "tutor" => "user ".$n,
                    "position" => $n,
                    "active" => 1,
                    "created_by" => 1
                ]);
            }
        }

        for($i=1; $i<=3; $i++) {
            $chapter3 = Chapters::create([
                "fk_module" => $module3->id,
                "name" => "Ketentuan Umum ".$i,
                "description" => "Description Ketentuan Umum ".$i,
                "position" => $i,
                "active" => 1,
                "created_by" => 1
            ]);

            for($n=1; $n<=3; $n++) {
                ChapterVideos::create([
                    "fk_chapter" => $chapter3->id,
                    "link" => "https://youtu.be/dB3mB9x9sN4",
                    "title" => "Pertemuan ".$n,
                    "description" => "Undang-Undang Kepabeanan ".$n,
                    "date_class" => Carbon::now(),
                    "tutor" => "user ".$n,
                    "position" => $n,
                    "active" => 1,
                    "created_by" => 1
                ]);
            }
        }
    }
}
