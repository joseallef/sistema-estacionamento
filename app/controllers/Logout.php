<?php
    namespace AppC;

    class Logout
    {
        
        function __construct()
        {
            self::deslogar();
        }
        
        function deslogar()
        {
            session_start();
            
            header('Location: /');

            session_destroy();
        }
    }
    new Logout;