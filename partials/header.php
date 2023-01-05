<?php
// SESSION
// Start session
session_start();

// NAVIGATION
// Defined allowed pages (bona practica)
define("allowed", [
    "reservar",
    "reserves",
    "usuaris"
]);
$page = (isset($_GET['page'])) ? $_GET['page'] : 'reservar';
?>

<!-- HEADER -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Fernando Gonzalez Serrano">
    <meta name="description" content="Tasca DWES3 - Gimnàs amb mySQL">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Tasca DWES3 - Gimnàs amb mySQL</title>
</head>

<body>

    <!-- NAVEGACIÓ -->
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/projects/tasku3dawes/index.php?page=reservar"><strong>Gimnàs</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <!-- <a class="nav-link disabled">Home</a> -->
                    <a class="nav-link<?php echo ($page == "reservar" ? " active\" aria-current=\"page" : "")?>" href="/projects/tasku3dawes/index.php?page=reservar">Reservar pista</a>
                    <a class="nav-link<?php echo ($page == "reserves" ? " active\" aria-current=\"page" : "")?>" href="/projects/tasku3dawes/index.php?page=reserves">Veure reserves</a>
                    <a class="nav-link<?php echo ($page == "usuaris" ? " active\"aria-current=\"page" : "")?>" href="/projects/tasku3dawes/index.php?page=usuaris">Usuaris</a>
                </div>
            </div>
        </div>
    </nav>