<html lang="en">
<body>

<!-- Navigation Menu-->
<nav class="navigation">
    <figure>
        <img src="assets/images/logoHead.png">
    </figure>

    <input type="text" placeholder="Search Prof" size="50">
</nav>

<?php
// https://stackoverflow.com/questions/518795/dynamically-display-a-csv-file-as-an-html-table-on-a-web-page
echo "<table>\n\n";
$f = fopen("assets/data/ratemyprofessors.csv", "r");

$countForFirstLine = 0;
$index = 0;
while (($line = fgetcsv($f)) !== false) {
    echo "<tr>";
    $count = 0;

    foreach ($line as $cell) {
        // length: 6 cells
        if ($count == 0 && $countForFirstLine == 1) {
            echo "<td><a href='theOne.php?id="
                . $index
                . "'>"
                . htmlspecialchars($cell)
                . "</a></td>";
        } else {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }

        if ($count <= 5) {
            $count++;
        } else {
            $count = 0;
        }
    }

    if ($countForFirstLine == 0) {
        $countForFirstLine++;
    }

    $index++;
    echo "</tr>\n";
}
fclose($f);
echo "\n</table>";
?>

</body>
</html>
