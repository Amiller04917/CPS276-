<?php
    $output = "";
    if(isset($_POST['submit'])) {
        require_once 'noteService.php';
        $noteService = new noteService();
        $output = $noteService->Add($_POST['note'], $_POST['dateTime']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Add Note</title>
</head>
<body class="container">
    <h1>Add Note</h1>
    <a href="notes.php">Display Notes</a>
    <?=$output?>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
                <label for="date" class="dateL mb-2 mt-2">Date and Time</label>
                <div class='input-group date' id='date'>
                    <input type="datetime-local" class="form-control" id="date" name="dateTime">
                </div> 
                <label for="note" class="noteL mb-2">Note</label>
                <div class="col">
                    <textarea style="height: 250px;" class="form-control mb-2"
                    id="note" name="note"></textarea>
                </div>
                <div/>
                <input type="submit" name="submit" class="btn btn-primary mb-2" value="Add Note">
            </div>
        </div>
    </form>
</body>
</html> 