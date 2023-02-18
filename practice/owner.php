<?php

    // include "./classes/Owner.php";
    // require "./classes/Owner.php";
    require_once "./classes/AppBootstrap.php";

    AppBootstrap::startApp();

    //var_dump($_SERVER); // -> ctrl+u
    //var_dump($_GET);
    
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET': {
            if(isset($_SESSION['username'])){
                $response = OwnerRequestHandler::get($_GET);
            }else{
                http_response_code(401);
                $response = null;
            }

            // read data
            break;
        }
        case 'POST': {
            $postData = json_decode(file_get_contents("php://input")); // json format
            
            //$postData = $_POST; // formData format
            
            try {
                $response = OwnerRequestHandler::post($postData);
            } catch (Exception $exception){
                http_response_code(500);
                $response = [
                    'success' => false,
                    'error' => $exception->getMessage()
                ];
            }
            // insert
            break;
        }
        case 'PUT': {
            $response = OwnerRequestHandler::update();
            // update
            break;
        }
        case 'DELETE': {
            $response = OwnerRequestHandler::delete();
            // delete
            break;
        }
        default: {
            // request method not supported
        }
    }
    
    //echo json_encode($response, true);
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

    //switch ($_REQUEST['HTTP_METHOD']){}

    //$owner = new Owner(1, "sonic", "0000", "I love hedgehogs.");
    //echo $owner->getIntroText();

    




?>