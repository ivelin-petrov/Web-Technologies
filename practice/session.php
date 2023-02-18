<?php

    require_once "./classes/AppBootstrap.php";

    AppBootstrap::startApp();

    //session_start();

    $response = [];

    switch($_SERVER['REQUEST_METHOD']){
        case 'GET': { // check login status
            if(isset($_SESSION['username'])){
                $response = [
                    'logged' => true,
                    'username' => $_SESSION['username']
                ];
            }else{
                $response = [
                    'logged' => false
                ];
            }

            // read data
            break;
        }
        case 'POST': { // login
            //$sessionData = json_decode(file_get_contents("php://input"), true);
            
            $sessionData = $_POST;

            //$username = $sessionData['username'];
            //$password = $sessionData['password'];

            $response = SessionRequestHandler::post($sessionData['username'], $sessionData['password']);

            break;
        }
        case 'DELETE': { // logout
            session_destroy();

            break;
        }
        default: {
            // request method not supported
        }
    }
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
    // fetch('./session.php').then(r=>r.json()).then(r=>console.log(r));
    // fetch('./session.php', {'method': 'POST', 'body': JSON.stringify({'username': 'Ivo', 'password': 0000})}).then(r=>r.json()).then(r=>console.log(r));
    
    // fetch('./owner.php', {'method': 'POST', 'body': JSON.stringify({'username': 'Ivo', 'password': 0000})}).then(r=>r.json()).then(r=>console.log(r));
    
    /*
    fetch('owner.php', {
        method: 'POST',
        body: JSON.stringify({
            'username': 'petlover',
            'password': '1234',
            'intro_text': 'pets =)'
        })
    })
    .then(r => r.json())
    .then(r => console.log(r));
    */

    /*
    fetch('session.php', {
        method: 'POST',
        body: JSON.stringify({
            'username': 'petlover',
            'password': '1234'
        })
    })
    .then(r => r.json())
    .then(r => console.log(r));
    */

?>