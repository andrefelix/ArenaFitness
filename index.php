    
<?php

if (!isset($appPath))
    require_once 'util/main.php';

require_once 'util/session.php';

if (isset($_SESSION['userID'])) {
    initSession();
}

?>

<!doctype html>
<html lang="pt">

<head>
    <title>Arena Fitness</title>
    <meta charset="utf-8">
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body class="body">

    <div class="container_">
        <form action="util/login.php" method="post">
            <fieldset>
                <div class="imgcontainer">
                    <img src="images/arena_fitness_logo.jpg" alt="Arena Fitness" class="avatar">
                </div>
                <legend>LOGIN</legend><br />
                <label><b>Nome:</b></label>
                <input type="text" name="login" id="login" placeHolder="Login"><br>
                <label><b>Senha:</b></label>
                <input type="password" name="password" id="password" placeHolder="Senha"><br>
                <button type="submit">Login</button>
                <p id="login-error">
                    <?php

                    if (isset($_GET['message']))
                        echo $_GET['message'];
                    ?>
                </p>

            </fieldset>
        </form>
    </div>

</body>

</html>
