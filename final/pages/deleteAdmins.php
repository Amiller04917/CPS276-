<?php
    function init(){
        global $elementsArr;
        if(isset($_POST['submit'])){
            if(isset($_POST['removeAdmin']))
                return deleteData($_POST);
        }
        return getForm("", "");
    }

    function deleteData($post){
    
            require_once('classes/PdoMethods.php');
            $pdo = new PdoMethods();
        
            // This was the last thing I wanted to do since repeatedly hitting the database is horrible for performance.
            // However, I presume implimenting a custom query builder would be out of scope for this project.

            foreach($post['removeAdmin'] as $id){
                $sql = "DELETE FROM admins WHERE id = :id";
                $bindings = [
                    [":id", $id, 'str']
                ];
                $result = $pdo->otherBinded($sql, $bindings);
            
                if($result == "error"){
                    return getForm("<p>There was a problem processing your request</p>", "");
                }
            }

            if($result != "error") {
                return getForm("<p>Admin(s)removed</p>", "");
            }
    }

    function getForm($acknowledgement, $elementsArr){
        require_once('classes/PdoMethods.php');
        $pdo = new PdoMethods();
        $sqlresult = $pdo->selectNotBinded(
            "SELECT * FROM admins"
        );

        if($sqlresult == "error" || $sqlresult == "noresults")
            return getForm(["<p>There was a problem processing your request</p>", ""]);

        $output = "";
        foreach($sqlresult as $row)
            $output .= <<<HTML
                <tr>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['password']}</td>
                    <td>{$row['status']}</td>
                    <td><input type="checkbox" name="removeAdmin[]" value="{$row['id']}"></td>
                </tr>
            HTML;

        $form = 
        <<<HTML
            <h1>Delete Admin(s)</h1>
            <form method="post" action="index.php?page=deleteAdmins">
                <input type="submit" name="submit" value="Delete" class="btn btn-primary">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Status</th>
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

