<?php
    $fileInfo = $_FILES['my-file'];

    // create new Db pet-pics
    /*
        id - INT, auto_increment
        filename - VARCHAR(200)
        owner_id - INT

    */

    if ($fileInfo['error']) {
        // error
        echo "error";
    } else {
        /*
        $connection = (new Db())->getConnection();
        
        $loggedUserId = $_SESSION['user_id'];
        
        // prepare statement -> "insert into `pet-pics` (owner_id) values (?)"
        // execute([$loggedUserId]);
        
        $filename = $connection->lastInsertId(). "." . $filePathInfo = ...;
        move_uploaded_file($fileInfo['tmp_name'], './files/' . $filename);
        
        $update = $connection->prepare('update `pet-pics` set filename = :filename where id = :id');
        $update->execute(['filename' => $filename,'id' => $fileId,]);
        */
    }

    // header('Location: upload-result.html?success=' . $success);

?>