<?php


    require_once 'fileUploadProc.php';
    $upload = new fileUploadProc();
    $result = $upload->Fetch();
    if($result == null) {
        $output = "<p>No files found</p>";
    }
    else 
    {
        $output = "<li>";

        foreach($result as $row) {
            $output .= "<a target='_blank' href='./$row[filePath]'>$row[fileName]</a><br>";
        }
        $output .= "</li>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>File List</title>
</head>
<body class="container">
    <h1>List Files</h1>
    <a href="index.php">Add File</a>
    <?=$output?>
</body>
</html> 