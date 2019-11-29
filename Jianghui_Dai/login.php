<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in | ProfRating</title>
    <link rel="shortcut icon" type="image/png" href="assets/icons/favicon.png"/>
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/publicNavigationBar.css">
    <link rel="stylesheet" href="css/forLogin.css">

    <script>
        // use onsubmit method to validate the form before submitted to the php
        // I learnt it from https://www.w3schools.com/jsref/event_onsubmit.asp
        function validate() {
            let email = document.getElementById("loginFormEmail").value;
            let password = document.getElementById("loginFormPassword").value;
            if (password === "" || email === "") {
                alert("You do have to fill this stuff out, you know.");
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>

<body class="noScroll">

<!-- nav -->
<header>

    <nav>
        <div class="grid">

            <!-- search bar -->
            <div class="grid-col-1of3"></div>

            <div class="grid-col-1of3"></div>

            <div class="grid-col-1of3">
                <!-- nav log in button-->
                <button id="sideLoginButton" style="display: none" onclick="location.href='login.php'">Log in</button>

                <!-- nav sign up button-->
                <button id="sideSignUpButton" onclick="location.href='index.php'">Sign Up</button>
            </div>

        </div>
    </nav>

</header>

<!-- main content for the page-->
<div class="grid" id="loginCol">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3">

        <!-- website name -->
        <h1 class="websiteName">ProfRating</h1>

        <!-- log in form -->
        <form action="processLogin.php" id="loginForm" method="post" onsubmit="return validate();">
            <input type="email" name="email" placeholder="Email" id="loginFormEmail">
            <br>

            <input type="password" name="password" placeholder="Password" id="loginFormPassword">
            <br>

            <input type="submit" name="submit" value="Log in">
        </form>

    </div>

    <div class="grid-col-1of3"></div>

</div>

<!-- footer -->
<!-- A external link to the second page of the sign up page -->
<footer class="grid">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3">
        <a href="index.php#definition">What is ProfRating?</a>
    </div>

    <div class="grid-col-1of3"></div>

</footer>

</body>
</html>