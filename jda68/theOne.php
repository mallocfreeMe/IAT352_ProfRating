<html lang="en">
<body>

<?php
$theOneIndex = $_GET['id'];
if (is_numeric($theOneIndex)) {
    $test = fopen("assets/ratemyprofessors.csv", "r");

    $testIndex = 0;
    while (($line = fgetcsv($test)) !== false) {
        if ($testIndex == $theOneIndex) {
            foreach ($line as $cell) {
                // length: 6 cells
                echo htmlspecialchars($cell) . "<br>";
            }
            break;
        }
        $testIndex++;
    }

    fclose($test);
} else {
    echo "something is wrong";
}
?>

</body>
</html>
