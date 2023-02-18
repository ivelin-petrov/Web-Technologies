<?php

    declare(strict_types=1);

    class ItemRequestHandler {
        public static function get(array $params){
            
            $connection = (new Db())->getConnection();

            if(isset($params['instance']) && isset($params['price']) && isset($params['region'])){
                
                $statement = $connection->prepare("SELECT * FROM `items` WHERE instance LIKE :instance AND region LIKE :region");
                $statement->execute(['instance' => '%' . $params['instance'] . '%',
                                     'region' => '%' . $params['region'] . '%']);

                $items = $statement->fetchAll();

                $result = [];

                switch($params['price']){
                    case 'daily': {
                        $priceMultiplier = 1;
                        break;
                    }
                    case 'weekly': {
                        $priceMultiplier = 7;
                        break;
                    }
                    case 'monthly': {
                        $priceMultiplier = 30;
                        break;
                    }
                    case 'annually': {
                        $priceMultiplier = 365;
                        break;
                    }
                    default: { }
                }

                for($i = 0; $i < count($items); $i ++){
                    $item = $items[$i];
                    $result[] = new Item((string)$item['provider'], (string)$item['instance'], (int)$item['vcpu'], (int)$item['memory'], 
                                         (string)$item['storage'], (int)$item['network'], 
                                         (float)(round($priceMultiplier * $item['price'], 4)), (string)$item['region']);
                }

                return $result;
            }
            
            $statement = $connection->prepare("SELECT * FROM `items`");
            $statement->execute([]);
            
            $items = $statement->fetchAll();
            
            $result = [];
            
            for($i = 0; $i < count($items); $i ++){
                $item = $items[$i];
                $result[] = new Item((string)$item['provider'], (string)$item['instance'], (int)$item['vcpu'], (int)$item['memory'], 
                                     (string)$item['storage'], (int)$item['network'], (float)$item['price'], (string)$item['region']);
            }
            
            return $result;
        }

        public static function post(array $data) : array {
            $connection = (new Db())->getConnection();

            $statement1 = $connection->prepare("SELECT COUNT(*), price FROM `items` WHERE instance = :instance AND 
                                                                                                        region = :region");

            $statement2 = $connection->prepare("UPDATE `items` SET price = :price WHERE instance = :instance AND region = :region");

            $statement3 = $connection->prepare("INSERT INTO `items` (`provider`, `instance`, `vcpu`, `memory`, `storage`, `network`, `price`, `region`) 
                                            VALUES (:provider, :instance, :vcpu, :memory, :storage, :network, :price, :region)");

            $result = array();

            for($i = 0; $i < count($data); $i ++){
                $statement1->execute([
                    'instance' => $data[$i][1],
                    'region' => $data[$i][7],
                ]);

                $tmp = $statement1->fetch();

                $counter = $tmp['COUNT(*)'];
                $oldPrice = $tmp['price'];


                if($counter >= 1 && $oldPrice != $data[$i][6]){
                    $statement2->execute([
                        'instance' => $data[$i][1],
                        'price' => $data[$i][6],
                        'region' => $data[$i][7],
                    ]);
                    
                    $result[] = ['instance' => $data[$i][1], 'priceDiff' => round($data[$i][6] - $oldPrice, 4), 'region' => $data[$i][7]];

                }else if($counter == 0){
                    $statement3->execute([
                        'provider' => $data[$i][0],
                        'instance' => $data[$i][1],
                        'vcpu' => $data[$i][2],
                        'memory' => $data[$i][3],
                        'storage' => $data[$i][4],
                        'network' => $data[$i][5],
                        'price' => $data[$i][6],
                        'region' => $data[$i][7],
                    ]);
                }
            }

            return $result;
        }
    };
?>