<?php

namespace App\Repositories;

use App\Models\UserCertificates;
use App\Models\UserCertificateDetails;
use App\Models\Certificates;
use App\Models\CAT\CATTestUser;
use App\Models\CAT\CATTest;
use App\Models\User;
use iio\libmergepdf\Merger;
use Carbon\Carbon;
use Storage;
use DB;

class UserCertificateRepository
{
    
    public function getAll() {
        return UserCertificates::get();
    }

    public function getPaginate($paginate = 10) {
        $query = UserCertificates::with(['data_details','data_certificate','data_user']);
        if(auth()->user()->hasRole('peserta')) {
            $query->where('fk_user',auth()->user()->id);
        }
        $result = $query->paginate(10);
        return $result;
    }
    public function FetchById($id) {
        return UserCertificates::findOrFail($id);
    }

    public function generateCert($fk_cert, $fk_user) {
        DB::beginTransaction();
        try {
            $cert = Certificates::find($fk_cert);
            $user = User::find($fk_user);
            $data = [
                "cert" => $cert,
                "user" => $user
            ];

            $count = UserCertificates::count();
            $ref = str_pad(($count+1), 5, "0", STR_PAD_LEFT).'-'.$cert->batch.'-'.date('Y');
            $data_array = [
                "fk_user"      => $user->id,
                "fk_certificate"      => $cert->id,
                "ref"      => $ref,
                "start_date"      => Carbon::now()->subDay(20),
                "end_date"      => Carbon::now()->subDay(10),
                "expired_date"      => null,
                "certificate_date"      => Carbon::now(),
                "status"      => 1,
                "path"      => 'data/cert/cert_&_transkip_'.$cert->id.'.pdf',
                "created_by"      => auth()->user()->id,
            ];
            $newReq = new \Illuminate\Http\Request($data_array);
            $result = $this->create($newReq);

            if( $result['status'] == "success" ) {
                $merger = new Merger();

                $data['data'] = $result['data'];

                $pdf1 = \App::make('dompdf.wrapper');
                $pdf1->getDomPDF()->set_option("enable_php", true);
                $html_cert 	= view('cert.pdf_cert', $data)->render();
                // $result_cert = $pdf1->loadHtml($html_cert)->setPaper('a4', 'landscape')->setWarnings(false)->save(base_path() . '/public/data/cert/cert_'.$cert->id.'.pdf');
                $result_cert = $pdf1->loadHtml($html_cert)->setPaper('a4', 'landscape')->setWarnings(false)->output();
    
                $pdf = \App::make('dompdf.wrapper');
                $pdf->getDomPDF()->set_option("enable_php", true);
                $html_transkip 	= view('cert.pdf_transkip', $data)->render();
                // $result_transkip = $pdf->loadHtml($html_transkip)->setPaper('a4', 'portrait')->setWarnings(false)->save(base_path() . '/public/data/cert/transkip_'.$cert->id.'.pdf');
                $result_transkip = $pdf->loadHtml($html_transkip)->setPaper('a4', 'portrait')->setWarnings(false)->output();
    
                $merger->addRaw($result_cert);
                $merger->addRaw($result_transkip);
                
                $mergedPdf = $merger->merge();
                DB::commit();

                $headers = [
                    'Content-Type' => 'application/pdf'
                ];
                return response()->streamDownload(function () use ($cert, $mergedPdf)  { 
                    Storage::disk('public_html')->put('data/cert/cert_&_transkip_'.$cert->id.'.pdf', $mergedPdf);
                    echo $mergedPdf;
                }, 'cert_&_transkip_'.$cert->id.'.pdf', $headers);

                
            }else{
                DB::rollback();
                return [
                    "status"    => "error",
                    "msg"       => $result['msg'],
                    "data"      => []
                ];
            }
        }catch (\Exception $e) {
            DB::rollback();
            return [
                "status"    => "error",
                "msg"       => $e->getMessage(),
                "data"      => []
            ];
        } 
    }

    public function create($request) {
        $data   = [
            "fk_user"      => $request->get('fk_user'),
            "fk_certificate"      => $request->get('fk_certificate'),
            "ref"      => $request->get('ref'),
            "start_date"      => $request->get('start_date'),
            "end_date"      => $request->get('end_date'),
            "expired_date"      => $request->get('expired_date'),
            "certificate_date"      => $request->get('certificate_date'),
            "status"      => 1,
            "path"      => $request->get('path'),
            "created_by"      => auth()->user()->id,
        ];

        $UserCertificates   = UserCertificates::create($data);

        $cert = Certificates::find($UserCertificates->fk_certificate);
        $user = User::find($UserCertificates->fk_user);
        $details  = json_decode($cert->details);

        foreach($details as $key => $val) {
            $cbtTest = CATTestUser::where('tesuser_tes_id',$val)->where('tesuser_user_id',$user->fk_cbt_student)->first();
            if( isset($cbtTest->tesuser_id) ) {
                $query_skor = DB::select('SELECT SUM(tessoal_nilai) AS hasil, COUNT(CASE  WHEN tessoal_nilai=0 THEN 1 END) AS jawaban_salah, COUNT(*) AS total_soal FROM cbt_tes_soal WHERE tessoal_tesuser_id="'.$cbtTest->tesuser_id.'"');
                $cbt = CATTest::where('tes_id',$val)->first();

                $skor_max = $cbt->tes_max_score;
                $skor_test = $query_skor[0]->hasil;
                $skor_test_text = $this->get_nilai_predikat($skor_test, $skor_max);
                
                $res = UserCertificateDetails::Create([
                    "fk_user_certificate" => $UserCertificates->id,
                    "fk_cbt_test" => $val,
                    "score_text" => $skor_test_text,
                    "score_number" => $skor_test,
                ]);
            }
        }

        $data = UserCertificates::with(['data_details','data_certificate','data_user'])->find($UserCertificates->id);
       
        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => $data
        ];
    }

    public function update($id, $request)
    {
        $data   = [
            "fk_user"      => $request->get('fk_user'),
            "fk_certificate"      => $request->get('fk_certificate'),
            "ref"      => $request->get('ref'),
            "start_date"      => $request->get('start_date'),
            "end_date"      => $request->get('end_date'),
            "expired_date"      => $request->get('expired_date'),
            "certificate_date"      => $request->get('certificate_date'),
            "status"      => 1,
            "path"      => $request->get('path'),
            "created_by"      => auth()->user()->id,
        ];

        $UserCertificates   = UserCertificates::find($id);
        $UserCertificates->update($data);

        return [
            "status"    => "success",
            "msg"       => "Data has been saved successfully!",
            "data"      => []
        ];
    }

    public function delete($id) {
        UserCertificates::destroy($id);
        return [
            "status"    => "success",
            "msg"       => "Deleted Successfuly",
            "data"      => []
        ];
    }

    function get_nilai_predikat($skor, $max_skor){
        $percent = ($skor/$max_skor)*100;
        if( $percent <= 100 && $percent >= 81 ) {
            $predikat = "A";
        }elseif( $percent <= 80 && $percent >= 61 ) {
            $predikat = "B";
        }elseif( $percent <= 60 && $percent >= 41 ) {
            $predikat = "C";
        }elseif( $percent <= 40 && $percent >= 21 ) {
            $predikat = "D";
        }else{
            $predikat = "E";
        }
        return $predikat;
    }
    
}