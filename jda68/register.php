<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up | ProfRating</title>
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/forRegister.css">
</head>

<body>

<header>

    <nav>
        <div class="grid">

            <div class="grid-col-1of3">
                <img src="assets/images/logoHead.png" class="searchIcon">
                <input type="text" placeholder="Search Prof" size="50" id="searchBar">
            </div>

            <div class="grid-col-1of3"></div>

            <div class="grid-col-1of3">
                <button id="sideLoginButton" style="display: none" onclick="location.href='login.php'">Log in</button>
            </div>

        </div>
    </nav>

</header>

<!-- First page-->
<section class="firstPage">

    <div class="grid">

        <div class="grid-col-1of3"></div>

        <div class="grid-col-1of3" id="topPart">

            <h1 class="websiteName">ProfRating</h1>

            <p class="websiteSlogan">Join us, find the professor you are looking for.</p>
            <br>

            <!-- register button for new users -->
            <button id="startButton" onclick="showForm()">Get Started</button>
            <br>

            <!-- registration form -->
            <form action="processRegister.php" method="post" id="registrationForm" style="display: none">

                <input type="email" name="email" placeholder="Email">
                <br>

                <input type="password" name="password" placeholder="Password">
                <br>

                <input type="text" name="username" placeholder="Username">
                <br>

                <input id="sign_up_button" type="submit" name="submit" value="Sign up">
                <br>
            </form>

            <!-- login button for registered users -->
            <button onclick="location.href='login.php'" id="loginButton">Log In</button>
            <br>

            <!-- a link for visitors to visit -->
            <a href="explore.php" class="visitorLink" id="visitor_link">Here's what trending</a>


            <script type="text/javascript">
                // learn how show and hide form from https://www.w3schools.com/howto/howto_js_toggle_hide_show.asp
                function showForm() {
                    let registrationForm = document.getElementById("registrationForm");
                    let loginButton = document.getElementById("loginButton");
                    let startButton = document.getElementById("startButton");
                    let sideLoginButton = document.getElementById("sideLoginButton");
                    let visitorLink= document.getElementById("visitor_link");

                    if (registrationForm.style.display === "none") {
                        registrationForm.style.display = "block";
                        loginButton.style.display = "none";
                        sideLoginButton.style.display = "block";
                    }

                    startButton.style.display = "none";
                    visitorLink.style.display = "none";
                }
            </script>
        </div>

        <div class="grid-col-1of3"></div>

    </div>

</section>

<!-- footer -->
<!-- An internal link to the second page -->
<footer class="grid">

    <div class="grid-col-1of3"></div>

    <div class="grid-col-1of3">
        <a href="#definition">What is ProfRating?</a>
    </div>

    <div class="grid-col-1of3"></div>

</footer>

<!-- Second Page -->
<section class="secondPage" id="definition">
    <div class="grid"></div>
</section>


<!-- Third Page -->
<section class="thirdPage">
    <div class="grid"></div>
</section>

</body>

</html>