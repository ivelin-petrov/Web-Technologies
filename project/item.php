<?php

    require_once "./classes/AppBootstrap.php";

    AppBootstrap::startApp();

    switch($_SERVER['REQUEST_METHOD']){
        case 'GET': {
            $response = ItemRequestHandler::get($_GET);

            break;
        }
        case 'POST': {
            $postData = json_decode(file_get_contents('php://input'));
            $value = (array) $postData;
            
            function csvToArray($csvFile){
                $file_to_read = fopen($csvFile, 'r');
                
                while (!feof($file_to_read)) {
                    $lines[] = fgetcsv($file_to_read, 1000, ','); 
                }
                
                fclose($file_to_read);
            
                return $lines;
            }
        
            $postData = csvToArray('./files/' . $value['fileName']);
                
            $response = ItemRequestHandler::post($postData);
                
            break;    
        }
        default: { }
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>