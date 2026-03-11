<?php

if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['survey_name'])) {
    $survey_name = $_POST['survey_name'];
    echo "<h2>Survey Name: ". $survey_name . "</h2>";

    # loop through the questions and options
    $handle = fopen($_FILES['file']['tmp_name'], "r");

    while (($row = fgetcsv($handle)) !== FALSE) {
        echo "<b>Question:</b> " . $row[0] . "<br>";

        for ($i = 1; $i < count($row); $i++) {
            if (!empty($row[$i])) {
                echo "- " . $row[$i] . "<br>";
            }
        }

        echo "<br>";
    }

    fclose($handle);
}
?>