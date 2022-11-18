<?php 
    class NameConverter {
        function convertName(string $name = null){
            if(is_null($name)){ // Sanity check
                return "You must enter a name <br>";
            }
            $name = strtolower($name);
            return $name;
        }
    } 
?>