<!-- http://localhost/www-kn-2022/index.php/ -->

<?php
    echo "123<br/>";

    $a = 5;
    $b = "abv";
    
    echo $a . $b . "<br/>";

    $data = ["foo" => "bar", 1 => ["something"], ];

    foreach ($data as $key => $value){
        $stringToPrint = "the value for {$key} is ";

        if(is_array($value)){
            foreach($value as $k => $v){
                $stringToPrint .= "[$k : $v]";
            }
        }else{
            $stringToPrint .= $value;
        }

        echo $stringToPrint . "<br/>"; 
    }
?>
 
<?php
    echo "php";
    //echo 'Hello '.htmlentities($_GET["name"]).'!';
    //echo 'Hello '.htmlentities($_POST["name"]).'!';
?>    