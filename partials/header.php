<?php
// SESSION
// Start session
session_start();

// NAVIGATION
// Defined allowed pages (bona practica)
define("allowed", [
    "login",
    "register",
    "reservar",
    "reserves",
    "usuaris"
]);
$page = (isset($_GET['page'])) ? $_GET['page'] : 'login';

// Sign out
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["signout"])) {
        unset($_SESSION['usuario']);
        $_SESSION['message'] = 'User signed out successfully';
        $_SESSION['message_type'] = 'success';
        header('Location: /projects/tasku4dawes/index.php?page=login');
    }
}
?>


<!-- HEADER -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Fernando Gonzalez Serrano">
    <meta name="description" content="Tasca DWES4 - Gimnàs amb mySQL">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Tasca DWES4 - Gimnàs amb mySQL</title>
</head>

<body>

    <!-- NAVEGACIÓ -->
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/projects/tasku4dawes/index.php?page=login"><strong>Gimnàs</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <!-- <a class="nav-link disabled">Home</a> -->
                    <a class="nav-link<?php echo ($page == "reservar" ? " active\" aria-current=\"page" : "") ?>" href="/projects/tasku4dawes/index.php?page=reservar">Reservar pista</a>
                    <a class="nav-link<?php echo ($page == "reserves" ? " active\" aria-current=\"page" : "") ?>" href="/projects/tasku4dawes/index.php?page=reserves">Veure reserves</a>
                    <a class="nav-link<?php echo ($page == "usuaris" ? " active\"aria-current=\"page" : "") ?>" href="/projects/tasku4dawes/index.php?page=usuaris">Usuaris</a>
                    <?php
                    // <a class="nav-link" href="/login.php?page=login">Sign out</a>
                    if (isset($_SESSION['usuario'])) {
                    ?>
                        <form class="" form-inline my-2 my-lg-0"" name="signOut" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input class="form-control mr-sm-2" type="submit" value="Cerrar sesión" name="signout"></input>
                        </form>
                        <a class="nav-link" style="color:white;">
                            <?php
                                $user = explode("/",$_SESSION['usuario']);
                                echo "Nom: $user[0]";
                                echo "/ Llinatges: $user[1]";
                            ?>
                        </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>