<?php
$email = $password = $repeatpassword = "";
$emailErr = $passErr = $repeatpassErr = "";
// Redirect if it's logged
if (isset($_SESSION['usuario'])) {
    header('Location: /projects/tasku4dawes/index.php?page=reservar');
}
// Register
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Location: /projects/tasku4dawes/index.php?page=login');
}
?>
<div class="row">
    <div class="col-sm-4">
        <form class="form-group" name="register" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <caption><strong>Registrarse</strong></caption>
            <p>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error">* <?php echo $emailErr; ?></span>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>">
                <span class="error">* <?php echo $passErr; ?></span>
            </p>
            <p>
                <label for="repeatpassword">Repeat password:</label>
                <input type="password" id="repeatpassword" name="repeatpassword" value="<?php echo $repeatpassword; ?>">
                <span class="error">* <?php echo $repeatpassErr; ?></span>
            </p>
            <div>
                <input class="btn btn-primary" type="submit" value="Registrarse" name="enviar" style="margin-right: 5px; width: 60px; height:30px; font-weight: bold">
            </div>
        </form>
        <a href="/projects/tasku4dawes/index.php?page=login"><strong>Volver.</strong></a>
    </div>
</div>