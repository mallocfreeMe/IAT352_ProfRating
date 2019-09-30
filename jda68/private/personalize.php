<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personalize | ProfRating</title>
    <link rel="shortcut icon" type="image/png" href="../assets/icons/favicon.png"/>
    <link rel="stylesheet" href="css/grid.css">
</head>


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