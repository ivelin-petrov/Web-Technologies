<?php
    $fileInfo = $_FILES['my-file'];

    if ($fileInfo['error']) {
        // error
        echo "error";
    } else {
        // move_uploaded_file($fileInfo['tmp_name'], './files/' . rand() . time() . '-' . $fileInfo['name']);
        
        // $filePathInfo = pathinfo($fileInfo['name']);
        // echo '.' . $filePathInfo['extension'];

        /*
        $dir = './files/';

        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    echo "<img src='./files/$file' />";
      
    // var_dump($_FILES);

          }
                closedir($dh);
            }
        }
        */

        header('Location: upload-result.html');

        // JS
        /*
        if(new URL(document.location.href).searchParams.get('success') == 'true') {
            document.body.innerText = 'Upload successful';
            document.getElementById('content').innerText = 'Upload successful';
        } else {
            document.body.innerText = 'Upload unsuccessful';
            document.getElementById('content').innerText = 'Upload unsuccessful';
        }

        window.setTimeout(() => {document.location = './test.html', 2000});
        */
    }

    function generateRandomFileName(array $fileInfo) : string {
        $filePathInfo = pathinfo($fileInfo['name']);
        return './files/' . rand() . time() . '.' . $filePathInfo['extension'];
    }

    function generateFileNameKeepOriginal(array $fileInfo) : string {
        return './files/' . rand() . time() . '-' . $fileInfo['name'];
    }

    function showAllImagesInFolder(string $dir) : void {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    echo "<img src='./$dir/$file' />";
                }
                closedir($dh);
            }
        }
    }

?>