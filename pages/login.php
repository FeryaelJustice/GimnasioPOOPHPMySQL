<?php
$email = $password = "";
$emailErr = $passErr = "";
function loginHTML($email, $password, $emailErr, $passErr)
{
    echo '<div class="row">
    <div class="col-sm-4">
        <form class="form-group" name="login" method="POST" action="';
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    echo '">
            <caption><strong>Iniciar Sesión</strong></caption>
            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="';
    echo $email;
    echo '">
                <span class="error">* ';
    echo $emailErr;
    echo '</span>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="';
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
// Autologin
if (isset($_SESSION['usuario'])) {
    header('Location: /projects/tasku4dawes/index.php?page=reservar');
} else {
    loginHTML($email, $password, $emailErr, $passErr);
}
// Si viene de formulario post (login)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signin'])) {
        $_SESSION['usuario'] = $_POST['email'] . " / " . $_POST['password'];
        $_SESSION['logged'] = true;
        header('Location: /projects/tasku4dawes/index.php?page=reservar');
    }
    // echo $_SESSION['usuario'];
}
