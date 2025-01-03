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

?>