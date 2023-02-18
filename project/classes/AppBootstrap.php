<?php

    class AppBootstrap {
        public static function startApp(){
            self::registerAutoLoader();
        }

        private static function registerAutoLoader(){
            spl_autoload_register(function($className){
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