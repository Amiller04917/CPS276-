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
            "value"=>"Scott",
            "regex"=>"name"
        ],
        "address" => [
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Address cannot be blank and or must be a standard address</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"123 Someplace",
            "regex"=>"address"
        ],
        "city"=>[
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>City cannot be blank and or must be a standard city</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"Anywhere",
            "regex"=>"name"
        ],
        "state"=>[
            "type"=>"select",
            "options"=>["mi"=>"Michigan","oh"=>"Ohio","pa"=>"Pennslyvania","tx"=>"Texas", "wa"=>"Washington"],
            "selected"=>"mi",
            "regex"=>"name"
        ],
        "phone"=>[
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Phone cannot be blank and or must be a valid phone number</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"999.999.9999",
            "regex"=>"phone"
        ],
        "email"=>[
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>email cannot be blank and or must be a valid email</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"amiller@test.com",
            "regex"=>"email"
        ],
        "dob" => [
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>Date of Birth cannot be blank and or must be a valid date</span>",
            "errorOutput"=>"",
            "type"=>"text",
            "value"=>"12/25/1999",
            "regex"=>"date"
        ],
        "contact"=>[
            "type"=>"checkbox",
            "action"=>"notRequired",
            "status"=>["Newsletter"=>"", "Email Updates"=>"", "Text Updates"=>""]
        ],
        "age"=>[
            "errorMessage"=>"<span style='color: red; margin-left: 15px;'>You must select an age.</span>",
            "errorOutput"=>"",
            "type"=>"radio",
            "action"=>"required",
            "value"=>["10-18"=>"", "19-30"=>"", "30-50"=>"", "51+"=>""]
        ]
    ];

    function addData($post){
        global $elementsArr;  
    
            require_once('classes/PdoMethods.php');
            $pdo = new PdoMethods();
        
            $sql = "INSERT INTO contacts (name, address, city, state, phone, email, dob, contacts, age) VALUES (:name, :address, :city, :state, :phone, :email, :dob, :contacts, :age)";
            $bindings = [
                [":name", $post['name'], "str"],
                [":address", $post['address'], "str"],
                [":city", $post['city'], "str"],
                [":state", $post['state'], "str"],
                [":phone", $post['phone'], "str"],
                [":email", $post['email'], "str"],
                [":dob", $post['dob'], "str"],
                [":contacts", isset($post['contact']) ? implode(", ", $post['contact']) : "No contact options selected", "str"],
                [":age", $post['age'], "str"]
            ];

            $result = $pdo->otherBinded($sql, $bindings);
        
            if($result == "error"){
                return getForm("<p>There was an error adding the record.</p>", $elementsArr);
            }
            else {
                return getForm("<p>Contact Added</p>", $elementsArr);
            }
        
    }

function getForm($acknowledgement, $elementsArr){

    global $stickyForm;
    $options = $stickyForm->createOptions($elementsArr['state']);
    
    $form = <<<HTML
        <form method="post" action="index.php?page=addContact">
            <div class="form-group">
                <label for="name">Name (letters only) {$elementsArr['name']['errorOutput']}</label>
                <input type="text" class="form-control" id="name" name="name" value="{$elementsArr['name']['value']}" >
            
                <label for="address">Address (just numbers and street) {$elementsArr['address']['errorOutput']}</label>
                <input type="text" class="form-control" id="address" name="address" value="{$elementsArr['address']['value']}" >

                <label for="city">City {$elementsArr['city']['errorOutput']}</label>
                <input type="text" class="form-control" id="city" name="city" value="{$elementsArr['city']['value']}" >

                <label for="phone">Phone {$elementsArr['phone']['errorOutput']}</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{$elementsArr['phone']['value']}" >

                <label for="email">Email {$elementsArr['email']['errorOutput']}</label>
                <input type="email" name="email" id="email" class="form-control mb-2" value="{$elementsArr['email']['value']}" >
                
                <label for="date">Date of Birth {$elementsArr['dob']['errorOutput']}</label>
                <div class='input-group date' id='date'>
                    <input type="text" class="form-control" id="dob" name="dob" value="{$elementsArr['dob']['value']}">
                </div> 

                <label for="state">State</label>
                <select class="form-control" id="state" name="state">
                    $options
                </select>
            </div>
            <p>Please select all contact types you would like (optional)</p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="contact[]" id="contact1" value="Newsletter" {$elementsArr['contact']['status']['Newsletter']}>
                <label class="form-check-label" for="contact1">Newsletter</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="contact[]" id="contact2" value="Email Updates" {$elementsArr['contact']['status']['Email Updates']}>
                <label class="form-check-label" for="contact2">Email Updates</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="contact[]" id="contact3" value="Text Updates" {$elementsArr['contact']['status']['Text Updates']}>
                <label class="form-check-label" for="contact3">Text Updates</label>
            </div>
                
            <p>Please select an age range (you must check at least one) {$elementsArr['age']['errorOutput']}</p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="age" id="age1" value="10-18"  {$elementsArr['age']['value']['10-18']}>
                <label class="form-check-label" for="age1">10-18</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="age" id="age2" value="19-30"  {$elementsArr['age']['value']['19-30']}>
                <label class="form-check-label" for="age2">19-30</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="age" id="age3" value="30-50"  {$elementsArr['age']['value']['30-50']}>
                <label class="form-check-label" for="age3">30-50</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="age" id="age4" value="51+"  {$elementsArr['age']['value']['51+']}>
                <label class="form-check-label" for="age4">51+</label>
            </div>
            <div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    HTML;
    
    /* HERE I RETURN AN ARRAY THAT CONTAINS AN ACKNOWLEDGEMENT AND THE FORM.  THIS IS DISPLAYED ON THE INDEX PAGE. */
    return [$acknowledgement, $form];
    
    }

?>

