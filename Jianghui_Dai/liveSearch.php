<?php

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// Create connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Jianghui_Dai";

$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// make a select query to verify whether data is inserted or not
$query = "SELECT DISTINCT NAME FROM Professor";

// get the returned data
$result = mysqli_query($connection, $query);

// create an empty array
$array = array("");

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($array, $row['NAME']);
    }
} else {
    echo "no result";
}

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $len = strlen($q);
    foreach ($array as $name) {
        if(!empty($name)) {
            if (stristr($q, substr($name, 0, $len))) {
                if ($hint === "") {
                    $hint = $name;
                } else {
                    $hint .= ", $name";
                }
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;

// close the connection
mysqli_close($connection);
?>