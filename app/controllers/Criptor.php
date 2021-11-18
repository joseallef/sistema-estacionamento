<?php
    namespace AppC;
    
    class Criptor
    {
        public function base64($vlr, $tipo)
        {
            switch($tipo){
                case 1: $resl = base64_encode($vlr); break;
                case 2: $resl = base64_decode($vlr); break;
            }
            return $resl;
        }

    }

?>