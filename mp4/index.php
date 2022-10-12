<?php   
    $output = "";
    if(isset($_POST['add']) && !empty($_POST['name'])){
        require_once 'addNameProc.php';
        $addName = new AddNamesProc();
        $output = $addName->addClearNames($_POST['name']) . $_POST['namelist'];
    }
    if(isset($_POST['clear']))
        $output = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Name Adder</title>
</head>
<body class="container">
    <form method="POST" action="">
        <div class=form-group>
            <div class="row">
                <h1>Add Names</h1>
                <div class="col">
                    <input type="submit" name="add" class="btn btn-primary mb-2" value="Add Name">
                    <input type="submit" name="clear" class="btn btn-primary mb-2" value="Clear Names">
                </div>
                <label for="name">Enter Name</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" name="name" id="name" placeholder="Enter Name">
                </div>
                <label for="namelist">List of Names</label>
                <div class="col">
                    <textarea style="height: 500px;" class="form-control"
                    id="namelist" name="namelist"><?=$output?></textarea>
                </div>
            </div>
        </div>
    </form>
</body>
</html>