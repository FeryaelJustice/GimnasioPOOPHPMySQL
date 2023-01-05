<?php

require __DIR__ . '../../../../partials/header.php';

?>

<br>
<form name="newuser" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <caption><strong>CREAR USUARI</strong></caption>
    <br>
    <br>
    <label for="name">Nom:</label>
    <input type="text" name="name" id="name">
    <br>
    <br>
    <label for="surname">Llinatges:</label>
    <input type="text" name="surname" id="surname">
    <br>
    <br>
    <label for="phone">Telefon:</label>
    <input type="number" name="phone" id="phone">
    <br>
    <br>
    <input type="hidden" name="id" value="">
    <input type="submit" value="Enviar">
    <input type="reset" value="Reset">
</form>
<br>

<?php
require  __DIR__ . '../../../../partials/footer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Comprobamos si venimos de otra pagina
    if ($_POST["id"] != "id") {
        require __DIR__ . '../../../../database/db.php';

        try {
            $stmt = $conn->prepare("INSERT INTO clients (nom, llinatges, telefon) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $_POST["name"], $_POST["surname"], $_POST["phone"]);
            $stmt->execute();
            $_SESSION['message'] = 'User created successfully';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            echo "Create transaction failed";
            $_SESSION['message'] = 'User creation failed';
            $_SESSION['message_type'] = 'error';
            die();
        } finally {
            $stmt->close();
        }

        header('Location: /projects/tasku3dawes/index.php?page=usuaris');
    }
}
