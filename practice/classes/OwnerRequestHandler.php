<?php

    declare(strict_types=1);

    class OwnerRequestHandler {
        public static function get(array $params){
            
            $connection = (new Db())->getConnection();
            
            if(isset($params['id'])){
                //$query = $connection->query("SELECT * FROM `owners` WHERE id = " . $params['id']);
                
                //$statement = $connection->prepare("SELECT * FROM `owners` WHERE id = ?");
                //$statement->execute([$params['id']]);

                $statement = $connection->prepare("SELECT * FROM `owners` WHERE id = :id");
                $statement->execute(['id' => $params['id']]);

                //$dbRow = $query->fetch();
                $dbRow = $statement->fetch();

                //return new Owner(1, "sonic", "0000", "I love hedgehogs.");
                if($dbRow){
                    return new Owner((int)$dbRow['id'], $dbRow['username'], $dbRow['password'], $dbRow['intro_text']);
                }

                return null;
            }

            /*
            $query = $connection->query("SELECT * FROM `owners`");

            while($dbRow = $query->fetch()){
                $result[] = new Owner((int)$dbRow['id'], $dbRow['username'], $dbRow['password'], $dbRow['intro_text']);
            }
            */
            
            $statement = $connection->prepare("SELECT * FROM `owners`");
            $statement->execute([]);
            
            $owners = $statement->fetchAll();
            
            $result = [];
            
            for($i = 0; $i < count($owners); $i ++){
                $owner = $owners[$i];
                $result[] = new Owner((int)$owner['id'], $owner['username'], $owner['password'], $owner['intro_text']);
            }
            
            return $result;
            
            /*
            return [
                new Owner(1, "sonic", "0000", "I love hedgehogs."),
                new Owner(2, "spiderman", "0000", "I love spiders."),
                new Owner(3, "Patrick Catman", "1234", "I loves cats."),
            ];
            */
        }

        public static function post(array $data) : array {
            // filter -> remove unwanted data
            
            /*
            $filteredData = [
                'username' => $data['username'],
                'password' => $data['password'],
                'intro_text' => $data['intro_text']
            ];
            */

            // validation -> validate $filteredData
            
            // insert
            $connection = (new Db())->getConnection();
            $statement = $connection->prepare("INSERT INTO `owners` (`username`, `password`, `intro_text`) VALUES (:username, :password, :intro_text)");
            
            // = password_hash($password, PASSWORD_DEFAULT);
            
            if($statement->execute([
                'username' => $data['username'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'intro_text' => $data['intro_text']
            ])) {
                return $data;
            }
            
            // if($statement->execute($filteredData)){ return $filteredData; }

            throw new Exception("internal server error");
        }

        public static function put(){

        }

        public static function delete(){

        }
    };
?>