<?php 
    class AddNamesProc {
        function addClearNames(string $name = null){
            $n = explode(" ", $name);
            return $n[1] . ", " . $n[0] . "\r\n";
        }
    } 
?>