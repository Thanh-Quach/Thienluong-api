<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // CHECK TOKEN
    public static function tokenValidate(){
         // Attempt to extract the token from the Bearer header
         if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            header('HTTP/1.0 400 Bad Request');
            echo 'Token not found in request';
            exit;
          }
          $jwt = $matches[1];
          if (! $jwt) {
            // No token was able to be extracted from the authorization header
            header('HTTP/1.0 400 Bad Request');
            exit;
          }
          JWT::$leeway += 60;
         $token = JWT::decode((string)$jwt, new Key('ThienLuong','HS512'));

         return $token;
    }

    // GENERATE UNIQUE ID
    public static function v4() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    
          // 32 bits for "time_low"
          mt_rand(0, 0xffff), mt_rand(0, 0xffff),
    
          // 16 bits for "time_mid"
          mt_rand(0, 0xffff),
    
          // 16 bits for "time_hi_and_version",
          // four most significant bits holds version number 4
          mt_rand(0, 0x0fff) | 0x4000,
    
          // 16 bits, 8 bits for "clk_seq_hi_res",
          // 8 bits for "clk_seq_low",
          // two most significant bits holds zero and one for variant DCE1.1
          mt_rand(0, 0x3fff) | 0x8000,
    
          // 48 bits for "node"
          mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
      }
    public static function v5($namespace, $name) {
        if(!self::is_valid($namespace)) return false;
    
        // Get hexadecimal components of namespace
        $nhex = str_replace(array('-','{','}'), '', $namespace);
    
        // Binary Value
        $nstr = '';
    
        // Convert Namespace UUID to bits
        for($i = 0; $i < strlen($nhex); $i+=2) {
          $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
        }
    
        // Calculate hash value
        $hash = sha1($nstr . $name);
    
        return sprintf('%08s-%04s-%04x-%04x-%12s',
    
          // 32 bits for "time_low"
          substr($hash, 0, 8),
    
          // 16 bits for "time_mid"
          substr($hash, 8, 4),
    
          // 16 bits for "time_hi_and_version",
          // four most significant bits holds version number 5
          (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
    
          // 16 bits, 8 bits for "clk_seq_hi_res",
          // 8 bits for "clk_seq_low",
          // two most significant bits holds zero and one for variant DCE1.1
          (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
    
          // 48 bits for "node"
          substr($hash, 20, 12)
        );
      }
      public static function is_valid($uuid) {
        return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                          '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
      }
}
