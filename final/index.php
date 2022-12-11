<?php 
    require_once('pages/routes.php');
    require_once('classes/PdoMethods.php');
    @session_start();
    
    $baseRoute = "index.php?page";

    
    // // If session password is not set
    if(!isset($_SESSION['password']) || !isset($_SESSION['email'])){
        // Make sure current page is not login
        if($_GET['page'] != 'login'){
            // Redirect to login
            header("Location: $baseRoute=login");
        }
    }
    else if (isset($_SESSION['password']) && isset($_SESSION['email'])){
        $pdo = new PdoMethods();
        $sqlresult = $pdo->selectBinded(
            "SELECT * FROM admins WHERE email = :email", 
            [[':email', $_SESSION['email'], 'str']]
        );

        if($sqlresult == "error" || $sqlresult == "noresults")
            header("Location: $baseRoute=login");
        
        foreach($sqlresult as $row){
            if(!password_verify($_SESSION['password'], $row['password']))
                header("Location: $baseRoute=login");
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>PHP Final</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>

	<body class="container">
		<?=$navBar?>
		<?=$result[0]?>
		<?=$result[1]?>
	</body>
</html> 