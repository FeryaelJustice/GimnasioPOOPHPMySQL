<?php
require_once(__DIR__ . '/../class/Usuari.php');

$username = $password = "";
$usernameErr = $passErr = "";
$usuari = new Usuari();

// Mensajes de la web
if (isset($_SESSION['message']) && $_SESSION['message'] != "") {
    if (isset($_SESSION['message_type']) && $_SESSION['message_type'] == "success") {
?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['message'] ?>
        </div>
    <?php
    } else if (isset($_SESSION['message_type']) && $_SESSION['message_type'] == "error") {
    ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION['message'] ?>
        </div>
<?php
    }
}

function loginHTML($username, $password, $usernameErr, $passErr)
{
    echo '<div class="row">
    <div class="col-sm-4">
        <form class="form-group" name="login" method="POST" action="';
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    echo '">
            <caption><strong>Iniciar Sesión</strong></caption>
            <p>
                <label for="username">Nom de usuari:</label>
                <input type="text" id="username" name="username" required value="';
    echo $username;
    echo '">
                <span class="error">* ';
    echo $usernameErr;
    echo '</span>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required value="';
    echo $password;
    echo '">
                <span class="error">* ';
    echo $passErr;
    echo '</span>
            </p>
            <div>
                <input class="btn btn-primary" type="submit" value="Iniciar sesión" name="signin" style="margin-right: 5px; width: 60px; height:30px; font-weight: bold">
            </div>
        </form>
        <a href="/projects/tasku4dawes/index.php?page=register"><strong>¿Aún no tienes una cuenta? Haz click aquí para registrarte.</strong></a>
    </div>
</div>';
}

// Pagina
// Autologin
if (isset($_SESSION['usuario'])) {
    header('Location: /projects/tasku4dawes/index.php?page=reservar');
} else {
    loginHTML($username, $password, $usernameErr, $passErr);
}

// Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Comprobamos si venimos de solo esta pagina y no de otra
    if (isset($_POST['signin'])) {
        if ($usuari->checkUser($_POST["username"], $_POST["password"])) {
            $usuari->getUsuari($_POST["username"], $_POST["password"]);
            // echo $usuari -> nom . " / " . $usuari -> llinatges;
            // $_POST['nom'] . " / " . $_POST['llinatges'] . " / " . $_POST['telefon'] . " / " . $_POST['username'] . " / " . $_POST['password'];
            // serialize and unserialize to store objects in sessions (recommended way)
            $_SESSION['usuario'] = $usuari -> id . " / " . $usuari -> nom . " / " . $usuari -> llinatges;
            $_SESSION['message'] = 'User logged successfully';
            $_SESSION['message_type'] = 'success';
            echo "User logged";
            header('Location: /projects/tasku4dawes/index.php?page=reservar');
        } else {
            $_SESSION['message'] = 'User not logged successfully. User not found.';
            $_SESSION['message_type'] = 'error';
            echo "User not found";
        }
    }
    // echo $_SESSION['usuario'];
}