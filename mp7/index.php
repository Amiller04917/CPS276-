<?php
    $output = "";
    if(isset($_POST['submit'])) {
        if(!array_key_exists('fIn', $_FILES))
            return;
            
        if($_FILES["fIn"]["error"] == 4){
            $output = "<p>Please select a file.</p>";
        }
        else if(empty($_POST['name'])){
            $output = "<p>Please enter a name for the file.</p>";
        }
        else if($_FILES['fIn']['type'] != "application/pdf"){ // Yes this method is vulnerable to a file upload attack
            $output = "<p>File type is not supported</p>";
        }
        else if($_FILES['fIn']['size'] > 100000){
            $output = "<p>File size is too large</p>";
        }
        else{
            require_once 'fileUploadProc.php';
            $upload = new fileUploadProc();
            $output = $upload->Create($_FILES['fIn'], $_POST['name']);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>File Uploader</title>
</head>
<body class="container">
    <h1>File uploader</h1>
    <a href="listFiles.php">File List</a>
    <?=$output?>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
                <label for="name" class="nameL mb-2 mt-2">File Name</label>
                <div class="col">
                    <input type="text" class="form-control mb-2 mt-2" name="name" id="name">
                </div> 
                <div/>
                <div class="col">
                    <input type="file" class="form-control-file mb-2 mt-2" name="fIn" id="fIn">
                </div>
                <div/>
                <input type="submit" name="submit" class="btn btn-primary mb-2" value="Upload File">
            </div>
        </div>
    </form>
</body>
</html> 