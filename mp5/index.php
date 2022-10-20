<?php   
    $output = "";
    if(isset($_POST['createFile']) && !empty($_POST['name']) && !empty($_POST['filecontent'] )) {
        require_once 'directories.php';
        $createDir = new Directories();
        $output = $createDir->Create($_POST['name'], $_POST['filecontent']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>File and Directory</title>
</head>
<body class="container">
    <h1>File and Directory Assingment</h1>
    <p>Enter a folder and the contents of the file. Folder names should contain alphanumeric characters only.</p>
    <?=$output?>
    <form method="POST" action="">
        <div class="form-group">
            <div class="row">
                <div class="col">
                </div>
                <label for="name" class="nameL mb-2 mt-2">Folder Name</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" name="name" id="name">
                </div>
                <label for="filecontent" class="filecontentL mb-2">File Content</label>
                <div class="col">
                    <textarea style="height: 250px;" class="form-control mb-2"
                    id="filecontent" name="filecontent"></textarea>
                    <input type="submit" name="createFile" class="btn btn-primary mb-2" value="Add Folder">
                </div>
            </div>
        </div>
    </form>
</body>
</html> 