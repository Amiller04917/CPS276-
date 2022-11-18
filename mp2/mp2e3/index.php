<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>RowCell</title>
</head>
<body>
    <?php
        // Adding 1 so if the variable is set through a user input they don't have to know index starts at 0
        $row = 15 + 1;
        $cell = 5 + 1;
        echo "<table border='1'>";
        for($i = 1; $i < $row; $i++) {
            echo "<tr>";
            for($j = 1; $j < $cell; $j++) {
                echo "<td> Row $i Cell $j </td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    ?>
</body>
</html>