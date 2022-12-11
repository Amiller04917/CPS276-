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
        "name"=>[
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Name cannot be blank and or must be a standard name</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"Alex",
            "regex"=>"name"
        ],
        "email"=>[
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>email cannot be blank and or must be a valid email</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"amiller@test.com",
            "regex"=>"email"
        ],
        "password"=>[
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Password cannot be blank and or must be meet the 8min to 20max char requirement.</span>",
            "errorOutput"=>"",
            "type"=>"password",
            "value"=>"fakepw",
            "regex"=>"password"
        ],
        "status"=>[
            "type"=>"select",
            "options"=>[
                "admin"=>"Admin",
                "staff"=>"Staff"
            ],
            "selected"=>"admin",
            "regex"=>"name"
        ]
    ];


    function addData($post){
        global $elementsArr;  
    
            require_once('classes/PdoMethods.php');
            $pdo = new PdoMethods();
        
            // Check if email already exists in database admins if so return error
            $sql = "SELECT * FROM admins WHERE email = :email";
            $bindings = [
                [':email',$post['email'],'str']
            ];
            $result = $pdo->selectBinded($sql, $bindings);
            if($result != "error" && count($result) > 0){
                return getForm("<span style='color: red; margin-left: 15px;'>That email already exists</span>", $elementsArr);
            }

            $sql = "INSERT INTO admins (name, email, password, status) VALUES (:name, :email, :password, :status)";

            $bindings = [
                [':name',$post['name'],'str'],
                [':email',$post['email'],'str'],
                [':password',password_hash($post['password'], PASSWORD_DEFAULT),'str'],
                [':status',$post['status'],'str']
            ];
            
            $result = $pdo->otherBinded($sql, $bindings);
        
            if($result == "error"){
                return getForm("<p>There was a problem processing your form</p>", $elementsArr);
            }
            else {
                return getForm("<p>User Added</p>", $elementsArr);
            }
        
    }

    /*THIS IS THEGET FROM FUCTION WHICH WILL BUILD THE FORM BASED UPON UPON THE (UNMODIFIED OF MODIFIED) ELEMENTS ARRAY. */
    function getForm($acknowledgement, $elementsArr){

        global $stickyForm;
        $options = $stickyForm->createOptions($elementsArr['status']);
        
        /* THIS IS A HEREDOC STRING WHICH CREATES THE FORM AND ADD THE APPROPRIATE VALUES AND ERROR MESSAGES */
        $form = <<<HTML
            <form method="post" action="index.php?page=addAdmin">
                <div class="form-group">
                    <label for="name">Name (letters only){$elementsArr['name']['errorOutput']}</label>
                    <input type="text" class="form-control mb-2" id="name" name="name" value="{$elementsArr['name']['value']}" >
                    <label for="email">Email {$elementsArr['email']['errorOutput']}</label>
                    <input type="email" name="email" id="email" class="form-control mb-2" value="{$elementsArr['email']['value']}" >
                    <label for="password">Password {$elementsArr['password']['errorOutput']}</label>
                    <input type="password" name="password" id="password" class="form-control mb-2" value="{$elementsArr['password']['value']}" >
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control mb-2">
                        {$options}
                    </select>
                    <button type="submit" name="submit" class="btn btn-primary mb-2">Submit</button>
                </div>
            </form>
        HTML;
        
        /* HERE I RETURN AN ARRAY THAT CONTAINS AN ACKNOWLEDGEMENT AND THE FORM.  THIS IS DISPLAYED ON THE INDEX PAGE. */
        return [$acknowledgement, $form];
        
    }

?>

