<?php 
    $_SESSION=array(); // Session destry wouldn't work so I did it this way in conjunction with destroy.
    session_destroy();
    header("Location: index.php?page=login");
?>