<?php 

    if (! function_exists('getYouTubeID')) {
        function getYouTubeID($url) {
            if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                return $matches[1];
            }
            parse_str(parse_url($url, PHP_URL_QUERY), $vars);
            if (!empty($vars['v'])) {
                return $vars['v'];
            }
            if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                return $matches[1];
            }
            return '';
        }
    }

    if (! function_exists('getCBTName')) {
        function getCBTName($id) {
            $result = \App\Models\CAT\CATTest::where('tes_id',$id)->first();
            return $result->tes_nama??'';
        }
    }

    if (! function_exists('alreadyTest')) {
        function alreadyTest($test_id,$user_id) {
            $result = \App\Models\CAT\CATTestUser::where('tesuser_tes_id',$test_id)->where('tesuser_user_id',$user_id)->first();
            return isset($result->tesuser_id)?true:false;
        }
    }

    if (! function_exists('alreadyGeneratedCert')) {
        function alreadyGeneratedCert($fk_cert,$fk_user) {
            $result = \App\Models\UserCertificates::where('fk_user',$fk_user)->where('fk_certificate',$fk_cert)->first();
            return isset($result->id)?true:false;
        }
    }

    if (! function_exists('pathDownloadCert')) {
        function pathDownloadCert($fk_cert,$fk_user) {
            $result = \App\Models\UserCertificates::where('fk_user',$fk_user)->where('fk_certificate',$fk_cert)->first();
            return asset($result->path);
        }
    }

?>