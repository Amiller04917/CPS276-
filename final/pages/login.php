<?php
    require_once('classes/StickyForm.php');
    $stickyForm = new StickyForm();

    function init(){
        global $elementsArr, $stickyForm;
        if(isset($_POST['submit'])){
            $postArr = $stickyForm->validateForm($_POST, $elementsArr);
        
            if($postArr['masterStatus']['status'] == "noerrors")
                return addData($_POST);
            else
                return getForm("",$postArr);
            
        }
        else
            return getForm("", $elementsArr);
    }

    $elementsArr = [
        "masterStatus"=>[
            "status"=>"noerrors",
            "type"=>"masterStatus"
        ],
        "email"=>[
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>email cannot be blank and must be a valid email</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"amiller49@admin.com",
            "regex"=>"email"
        ],
        "password"=>[
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Password cannot be blank and must meet the standards</span>",
            "errorOutput"=>"",
            "type"=>"password",
            "value"=>"password",
            "regex"=>"password"
        ]
    ];

    function addData($post){
        global $elementsArr;  
    
            require_once('classes/PdoMethods.php');
            $pdo = new PdoMethods();
            $sql = "SELECT * FROM admins WHERE email = :email";
            $bindings = [
                [":email", $post['email'], 'str'],
            ];

            $result = $pdo->selectBinded($sql, $bindings);
            if($result == "error"){
                return getForm("<p>There was an error</p>", $elementsArr);
            }
            else if($result == "noresults"){
                return getForm("<p>Invalid credentials</p>", $elementsArr);
            }
            else {
                if(password_verify($post['password'], $result[0]['password'])){
                    session_start();
                    $_SESSION['email'] = $post['email'];
                    $_SESSION['password'] = $post['password'];
                    $_SESSION['name'] = $result[0]['name'];
                    header("Location: index.php?page=welcome");
                }
                else
                    return getForm("<p>Invalid credentials</p>", $elementsArr);
            }
    }

function getForm($acknowledgement, $elementsArr){

    global $stickyForm;
    
    $form = <<<HTML
        <div id="container">
            <h1>Login</h1>
            <form action="index.php?page=login" method="post">
                <div class="form-group">
                    <label for="email">Email {$elementsArr['email']['errorOutput']}</label>
                    <input type="email" name="email" id="email" class="form-control mb-2" value="{$elementsArr['email']['value']}" >
                    <label for="password">Password {$elementsArr['password']['errorOutput']}</label>
                    <input type="password" name="password" id="password" class="form-control mb-2" value="{$elementsArr['password']['value']}">
                    <input type="submit" name="submit" value="Login" class="btn btn-primary mb-2">
                </div>
            </form> 
        </div>
    HTML;
    
    /* HERE I RETURN AN ARRAY THAT CONTAINS AN ACKNOWLEDGEMENT AND THE FORM.  THIS IS DISPLAYED ON THE INDEX PAGE. */
    return [$acknowledgement, $form];
    
    }

?>

