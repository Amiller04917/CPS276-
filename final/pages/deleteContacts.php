<?php
    function init(){
        global $elementsArr;
        if(isset($_POST['submit'])){
            if(isset($_POST['removeContact']))
                return deleteData($_POST);
        }
        return getForm("", "");
    }

    function deleteData($post){
    
            require_once('classes/PdoMethods.php');
            $pdo = new PdoMethods();
        
            // This was the last thing I wanted to do since repeatedly hitting the database is horrible for performance.
            // However, I presume implimenting a custom query builder would be out of scope for this project.

            foreach($post['removeContact'] as $id){
                $sql = "DELETE FROM contacts WHERE id = :id";
                $bindings = [
                    [":id", $id, 'str']
                ];
                $result = $pdo->otherBinded($sql, $bindings);
            
                if($result == "error"){
                    return getForm("<p>There was a problem processing your request</p>", "");
                }
            }

            if($result != "error") {
                return getForm("<p>Contact(s)removed</p>", "");
            }
    }

    function getForm($acknowledgement, $elementsArr){
        require_once('classes/PdoMethods.php');
        $pdo = new PdoMethods();
        $sqlresult = $pdo->selectNotBinded(
            "SELECT * FROM contacts"
        );

        if($sqlresult == "error" || $sqlresult == "noresults")
            return getForm(["<p>There was a problem processing your request</p>", ""]);

        $output = "";
        foreach($sqlresult as $row)
            $output .= <<<HTML
                <tr>
                    <td>{$row['name']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['city']}</td>
                    <td>{$row['state']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['dob']}</td>
                    <td>{$row['contacts']}</td>
                    <td>{$row['age']}</td>
                    <td><input type="checkbox" name="removeContact[]" value="{$row['id']}"></td>
                </tr>
            HTML;

        $form = 
        <<<HTML
            <h1>Delete Admin(s)</h1>
            <form method="post" action="index.php?page=deleteContacts">
                <input type="submit" name="submit" value="Delete" class="btn btn-primary">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>DOB</th>
                                <th>Contacts</th>
                                <th>Age</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            $output
                        </tbody>
                    </table>
                </div>
            </form>
        HTML;
        
        /* HERE I RETURN AN ARRAY THAT CONTAINS AN ACKNOWLEDGEMENT AND THE FORM.  THIS IS DISPLAYED ON THE INDEX PAGE. */
        return [$acknowledgement, $form];
        
    }

?>

