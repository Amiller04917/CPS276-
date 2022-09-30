<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body class="container">
    <ul>
    <?php  
        for ($i = 1; $i < 5; $i++) {
            echo "<li> $i";
            echo "<ul>";
            for($j = 1; $j < 6; $j++) {
                echo "<li>" . $j . "</li>";
            }
            echo "</ul>";
            echo "</li>";
        }
    ?>
    </ul>
</body>
</html>