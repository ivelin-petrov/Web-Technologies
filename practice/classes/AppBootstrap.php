<?php

    class AppBootstrap{
        public static function startApp(){
            self::startSession();

            self::registerAutoLoader();
        }

        private static function startSession(){
            session_start();
        }

        private static function registerAutoLoader(){
            spl_autoload_register(function($className){
                // важно е къде импортваме класа
                $classLocation = [
                    "./classes/"
                ];
        
                foreach($classLocation as $location){
                    $possibleClassLocation = $location . $className . '.php';
                
                    if(file_exists($possibleClassLocation)){
                        require_once $possibleClassLocation;
                    }
                }
            });
        }
    };

?>