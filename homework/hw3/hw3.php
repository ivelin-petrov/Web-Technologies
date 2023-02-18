<?php

    class Status implements jsonSerializable {
        private $errors;

        public function __construct(array $errors){
            $this->errors = $errors;
        }

        public function jsonSerialize(): array {
            if(count($this->errors) == 0){
                return [
                    "success" => true,
                ];

            }else{
                return [
                    "success" => false,
                    "errors" => $this->errors
                ];
            }
        }
    };

    class RequestHandler {
        private static function checkLength(string $elem, string $elemC, int $lt, int $gt) : string {
            $len = mb_strlen($elem);
            
            if($len < $lt){
                return "$elemC трябва да е с дължина поне $lt символа, а вие сте въвели $len.";
            }elseif($len > $gt){
                return "$elemC трябва да е с дължина най-много $gt символа, а вие сте въвели $len.";
            }else{
                return "";
            }
        }
        
        public static function post($params){
            $result_errors = [];
            
            if(isset($params['name'])){
                $errorToAdd = RequestHandler::checkLength($params['name'], 'Името на учебния предмет', 2, 150);

                if(mb_strlen($errorToAdd) > 0){
                    $result_errors["name"] = $errorToAdd;
                }
            }else{
                $result_errors["name"] = "Името на учебния предмет е задължително поле.";
            }
            
            if(isset($params['teacher'])){
                $errorToAdd = RequestHandler::checkLength($params['teacher'], 'Името на преподавателя', 3, 200);
                
                if(mb_strlen($errorToAdd) > 0){
                    $result_errors["teacher"] = $errorToAdd;
                }
            }else{
                $result_errors["teacher"] = "Името на преподавателя е задължително поле.";
            }
            
            if(isset($params['description'])){
                $len = mb_strlen($params['description']);

                if($len < 10){
                    $result_errors["description"] = "Описанието трябва да е с дължина поне 10 символа, а вие сте въвели $len.";
                }
            }else{
                $result_errors["description"] = "Описанието е задължително поле.";
            }

            if(isset($params['group'])){
                $group = $params['group'];

                if((strcmp($group, 'М') != 0) && (strcmp($group, 'ПМ') != 0) && (strcmp($group, 'ОКН') != 0) && (strcmp($group, 'ЯКН') != 0)){
                    $result_errors["group"] = "Невалидна група, изберете една от М, ПМ, ОКН и ЯКН";
                }
            }else{
                $result_errors["group"] = "Групата е задължително поле.";
            }

            if(isset($params['credits'])){
                $credits = $params['credits'];
                
                if(!ctype_digit($credits) || $credits <= 0){
                    $result_errors["credits"] = "Броят кредити трябва да е цяло положително число.";
                }
            }else{
                $result_errors["credits"] = "Кредитите са задължително поле.";
            }

            return new Status($result_errors);
        }
    };

    /*
        const sendPostRequestAsFormData = (data) => {
            let formData = new FormData();
            for(key in data){
                formData.append(key, data[key]);
            }

            return fetch('./81974_hw3.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(displayInConsole);
        }

        const displayInConsole = (data) => {
            console.log(data);
        }
        
        sendPostRequestAsFormData({"name": "Езотерични похвати в ООП", "description": "Похвати", "group": "ЕП", "credits": 4})
        sendPostRequestAsFormData({"name": "Предмет", "teacher": "Преподавател", "description": "нещо смислено", "group": "ОКН", "credits": 1})
    */

    switch($_SERVER['REQUEST_METHOD']){
        case 'POST': {
            $response = RequestHandler::post($_POST);
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            break;
        }
        default: { }
    }

?>
