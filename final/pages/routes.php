<?php
    $navBar = "";
    $baseRoute = "index.php?page";
    if(isset($_GET)){
        $path = $_GET['page'];
        session_start();
        
        if($path != 'login'){

            $navBar=<<<HTML
                <nav>
                    <a href="index.php?page=addContact">Add Contact</a> | 
                    <a href="index.php?page=deleteContacts">Delete contact(s)</a> |
            HTML;

            require_once('classes/PdoMethods.php');
            $pdo = new PdoMethods();
            $sqlresult = $pdo->selectBinded(
                "SELECT * FROM admins WHERE email = :email", 
                [[':email', $_SESSION['email'], 'str']]
            );

            if($sqlresult == "error" || $sqlresult == "noresults")
                header("Location: $baseRoute=login");
            
            if(password_verify($_SESSION['password'], $sqlresult[0]['password']))
                if($sqlresult[0]['status'] == "admin")
                    $navBar .= <<<HTML
                        <a href="index.php?page=addAdmin">Add Admin</a> |
                        <a href="index.php?page=deleteAdmins">Delete Admin</a> |
                    HTML;
            

            $navBar .= <<<HTML
                    <a href="index.php?page=logout">Logout</a>
                </nav>
            HTML;
        }

        $routes = [ 
            'welcome'=> 'pages/welcome.php',
            'login'=> 'pages/login.php',
            'logout'=> 'logout.php',
            'addContact'=> 'pages/addContact.php',
            'deleteContacts'=> 'pages/deleteContacts.php',
            'addAdmin'=> 'pages/addAdmin.php',
            'deleteAdmins'=> 'pages/deleteAdmins.php'
        ];
        
        if (array_key_exists($path, $routes)) {
            // if sqlresults isn't null and path is admin but user is not admin then redirect to welcome
            if(isset($sqlresult) && ($path == 'addAdmin' || $path == 'deleteAdmin') && $sqlresult[0]['status'] != 'admin')
                header("Location: $baseRoute=welcome");

            $pclass = require_once($routes[$path]);
            $result = init();
        }else {
            header("Location: $baseRoute=welcome");
        }
    }
    else {
        header("Location: $baseRoute=welcome");
    }
?>
