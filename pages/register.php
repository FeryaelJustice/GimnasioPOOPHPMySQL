<?php
require_once(__DIR__ . '/../class/Usuari.php');

$nom = $llinatges = $telefon = $username = $password = $repeatpassword = "";
$nomErr = $llinatgesErr = $telefonErr = $usernameErr = $passwordErr = $repeatpasswordErr = "";

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

// Redirect if it's logged
if (isset($_SESSION['usuario'])) {
    header('Location: /projects/tasku4dawes/index.php?page=reservar');
}

// Register
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Comprobamos si venimos de solo esta pagina y no de otra
    if (isset($_POST["signup"])) {
        if ($_POST["password"] == $_POST["repeatpassword"]) {
            $usuari = new Usuari();
            if ($usuari->createUsuari($_POST["nom"], $_POST["llinatges"], $_POST["telefon"], $_POST["username"], $_POST["password"])) {
                $_SESSION['message'] = 'User created successfully';
                $_SESSION['message_type'] = 'success';
                echo "User creation successful";
                header('Location: /projects/tasku4dawes/index.php?page=login');
            } else {
                $_SESSION['message'] = 'User creation failed';
                $_SESSION['message_type'] = 'error';
                echo "User creation failed";
            }
        }else{
            $_SESSION['message'] = 'Las contraseñas no coinciden';
            $_SESSION['message_type'] = 'error';
            echo "Las contraseñas no coinciden";
            $passwordErr = "Las contraseñas no coinciden";
            $repeatpasswordErr = "Las contraseñas no coinciden";
        }
    }
}

// Pagina
?>
<div class="row">
    <div class="col-sm-4">
        <form class="form-group" name="register" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?page=register">
            <caption><strong>Registrarse</strong></caption>
            <p>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>">
                <span class="error">* <?php echo $nomErr; ?></span>
            </p>
            <p>
                <label for="llinatges">Llinatges:</label>
                <input type="text" id="llinatges" name="llinatges" value="<?php echo $llinatges; ?>">
                <span class="error">* <?php echo $llinatgesErr; ?></span>
            </p>
            <p>
                <label for="telefon">Telefon:</label>
                <input type="phone" id="telefon" name="telefon" value="<?php echo $telefon; ?>">
                <span class="error">* <?php echo $telefonErr; ?></span>
            </p>
            <p>
                <label for="username">Nom de usuari:</label>
                <input type="text" id="username" name="username" required value="<?php echo $username; ?>">
                <span class="error">* <?php echo $usernameErr; ?></span>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required value="<?php echo $password; ?>">
                <span class="error">* <?php echo $passwordErr; ?></span>
            </p>
            <p>
                <label for="repeatpassword">Repeat password:</label>
                <input type="password" id="repeatpassword" name="repeatpassword" required value="<?php echo $repeatpassword; ?>">
                <span class="error">* <?php echo $repeatpasswordErr; ?></span>
            </p>
            <div>
                <input class="btn btn-primary" type="submit" value="Registrarse" name="signup" style="margin-right: 5px; width: 60px; height:30px; font-weight: bold">
            </div>
        </form>
        <a href="/projects/tasku4dawes/index.php?page=login"><strong>Volver.</strong></a>
    </div>
</div>