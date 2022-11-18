<?php
    require_once 'classes/PdoMethods.php';
    class noteService {
        function Add($note, $dateTime) {
            $pdo = new PdoMethods();
            $sql = "INSERT INTO notes (note, date_time) VALUES (:note, :dateTime)";
            $pdo->otherBinded($sql, array(
                array(':note', $note, 'str'),
                array(':dateTime', $dateTime, 'str')
            ));
            return "<p>Note has been added</p>";
        }
        
        function fetch($begDate, $endDate) {
            $pdo = new PdoMethods();
            $sql = "SELECT * FROM notes WHERE date_time BETWEEN CAST(:begDate AS DATE) AND CAST(:endDate AS DATE);";
            $result = $pdo->selectBinded($sql, array(
                array(':begDate', $begDate, 'str'),
                array(':endDate', $endDate, 'str')
            ));
            // For each note in result set, create a table row
            $output = "<table class='table table-striped'>
            <thead>
                <tr>
                    <th scope='col'>Note</th>
                    <th scope='col'>Date and Time</th>
                </tr>";
            foreach($result as $row) {
                $output .= "<tr><td>" . $row['note'] . "</td><td>" . $row['date_time'] . "</td></tr>";
            }
            $output .= "</thead></table>";
            // $output = "<table class='table table-striped'>
            // <thead>
            //     <tr>
            //         <th scope='col'>Note</th>
            //         <th scope='col'>Date and Time</th>
            //     </tr>
            // </thead>
            // <tbody>";
            return $output;
        }
    }
?>