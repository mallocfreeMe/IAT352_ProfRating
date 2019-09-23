<html lang="en">
<body>

<br>

<?php

@$name = $_GET["name"];

if (!empty($name)) {
    echo "Hello " . $name . "<br>";
    echo "this is personalize page";
    echo "Welcome to ProRating, !!!!";
    echo "<br>";
    echo "You just need to click few steps to finish registration";
} else {
    header("Location: ../register.php");
    die();
}

?>

</body>
</html>