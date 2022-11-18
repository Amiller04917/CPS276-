<?php 
    require_once 'classes/PdoMethods.php';
    class fileUploadProc {

    function Create($file, $fileName) {
        $root = __DIR__;
        $filePath = "$root/directories/$fileName." . explode(".", $file['name'])[1];

        //echo $filePath;
        if(file_exists($filePath)) 
            return "<p>A file already exists with that name</p>";

        if(copy($file['tmp_name'], $filePath)) {

            // Inserting the fileName and filePath into the database.
            $pdo = new PdoMethods();
            $sql = "INSERT INTO pdfFilelist (fileName, filePath) VALUES (:name, :path)";
            $pdo->otherBinded($sql, array(
                array(':name', $fileName, 'str'),
                array(':path', 'directories/' . $fileName . '.pdf', 'str')
            ));

            return "<p>File has been uploaded.</p>";
        }
        else
            return "<p>Unable to upload file.</p>";
    }

    function Fetch() {
        $pdo = new PdoMethods();
        $sql = "SELECT * FROM pdfFilelist";
        $result = $pdo->selectNotBinded($sql);
        return $result;
    }
} ?>