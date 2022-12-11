<?php
    session_status() === PHP_SESSION_ACTIVE ?: session_start();
    function init(){
        return ["<h1>Welcome</h1>","<p>Welcome {$_SESSION['name']}</p>"];
    }
?>

