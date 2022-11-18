<?php
    $output = "";
    if(isset($_POST['submit'])) {
        if(!isset($_POST['begDate']) || !isset($_POST['endDate'])) 
            return;
        require_once 'noteService.php';
        $noteService = new noteService();
        $output = $noteService->fetch($_POST['begDate'], $_POST['endDate']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Note List</title>
</head>
<body class="container">
    <h1>Display Notes</h1>
    <a href="index.php">Add Note</a>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
                <label for="bdate" class="bdateL mb-2 mt-2">Beginning Date</label>
                <div class='input-group date' id='bdate'>
                    <input type="date" class="form-control" id="begDate" name="begDate">
                </div> 
                
                <label for="edate" class="edateL mb-2 mt-2">End Date</label>
                <div class='input-group date' id='edate'>
                    <input type="date" class="form-control" id="endDate" name="endDate">
                </div> 
                <div/>
                <input type="submit" name="submit" class="btn btn-primary mb-2 mt-2" value="Get Notes">
                <div/>
                <?=$output?>
            </div>
        </div>
    </form>
</body>
</html> 