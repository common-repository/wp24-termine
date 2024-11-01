<?php
namespace APD\ArtDesign;
defined('ABSPATH')or die();
class Helper
{
    public function sanitize($str, $quotes = ENT_NOQUOTES)
    {
        $str = htmlspecialchars(trim($str), $quotes);
        return $str;
    }

    public function FileSizeConvert($bytes)
    {
        if (empty($bytes)) {
            return;
        }
        $bytes = floatval($bytes);
        $arBytes = array(
      0 => array("UNIT" => "TB", "VALUE" => pow(1024, 4)),
      1 => array("UNIT" => "GB", "VALUE" => pow(1024, 3)),
      2 => array("UNIT" => "MB", "VALUE" => pow(1024, 2)),
      3 => array("UNIT" => "KB", "VALUE" => 1024),
      4 => array("UNIT" => "B", "VALUE" => 1),
      );
        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

    public function random_string()
    {
        if (function_exists('random_bytes')) {
            $bytes = random_bytes(5);
            $str = bin2hex($bytes);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes(5);
            $str = bin2hex($bytes);
        } elseif (function_exists('mcrypt_create_iv')) {
            $bytes = mcrypt_create_iv(5, MCRYPT_DEV_URANDOM);
            $str = bin2hex($bytes);
        } else {
            $str = md5(uniqid('blog_login_art_picture_design', true));
        }
        return $str;
    }
}
