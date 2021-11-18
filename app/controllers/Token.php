<?php

namespace AppC;

require_once  '../../vendor/autoload.php';

class Token
{
     public static function base64url_encode($data)
     {
          return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
     }

     public function login($id)
     {

          $key = getenv('JWT_KEY');
          // $key = 'estacionamento-tiburcio';

          $header = [
               'typ' => 'JWT',
               'alg' => 'HS256'
          ];

          $peyload = [
               'id' => $id
          ];

          // JSON 
          $header = json_encode($header);
          $peyload = json_encode($peyload);

          // Base64
          $header = self::base64url_encode($header);
          $peyload = self::base64url_encode($peyload);

          $assingnatury = hash_hmac('sha256', $header . '.' . $peyload, $key, true);

          $assingnatury = self::base64url_encode($assingnatury);

          $token = $header . '.' . $peyload . '.' . $assingnatury;

          $_SESSION['token_session'] = $token;
          return $token;
     }

     function checkAuth()
     {
          if (isset($_SESSION['token_session']) && $_SESSION['token_session'] != null) {
               $token = explode('.', $_SESSION['token_session']);
               $header = $token[0];
               $payload = $token[1];
               $assingnatury = $token[2];

               $validation = hash_hmac('sha256', $header . '.' . $payload, getenv('JWT_KEY'), true);

               $isValid = self::base64url_encode($validation);

               if ($assingnatury === $isValid) {

                    return true;
               }
          }
          return false;
     }
}
