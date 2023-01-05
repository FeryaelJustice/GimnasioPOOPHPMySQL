<?php
// NO UTILITZAR AQUEST CODI, ES UNA PROVA
// PER FER-HO EN UNA PÁGINA EXTERNA
?>

<?php

require __DIR__ . '../../../../database/db.php';

require __DIR__ . '../../../../partials/header.php';

$id = null;
$nom = "";
$llinatges = "";
$telefon = 0;

// Recuperar valores de tabla antes de cargar
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        $id = $_GET['id'];
        $sqlSelect = "SELECT * FROM clients WHERE idclient = $id";
        $result = $conn->query($sqlSelect);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["idclient"] == $id) {
                    $nom = $row["nom"];
                    $llinatges = $row["llinatges"];
                    $telefon = $row["telefon"];
                    break;
                }
            }
        }
    }
}
?>

<form name="edituser" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label for="name">Nom:</label>
    <input type="text" name="name" id="name" value="<?= $nom ?>">
    <label for="surname">Llinatges:</label>
    <input type="text" name="surname" id="surname" value="<?= $llinatges ?>">
    <label for="phone">Telefon:</label>
    <input type="number" name="phone" id="phone" value="<?= $telefon ?>">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="submit" value="Enviar">
</form>

<?php
require  __DIR__ . '../../../../partials/footer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        /*
        $stmt = $conn->prepare("UPDATE clients SET nom=?,llinatges=?,telefon=? WHERE idclient = ?)");
        $stmt->bind_param("ssss", $_POST["name"], $_POST["surname"], $_POST["phone"], $_POST["id"]);
        $stmt->execute();
        */
        $idToUpdate = $_POST["id"];
        $nomToUpdate = $_POST["name"];
        $llinatgesToUpdate = $_POST["surname"];
        $telefonToUpdate = $_POST["phone"];
        $sqlUpdate = "UPDATE clients SET nom='$nomToUpdate', llinatges='$llinatgesToUpdate', telefon='$telefonToUpdate' WHERE idclient = $idToUpdate";

        if ($conn->query($sqlUpdate) === TRUE) {
            echo "Record updated successfully";
        } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        echo "Edit transaction failed";
        die();
    }
    /*finally {
        $stmt->close();
    }
    */

    $_SESSION['message'] = 'Task edited Successfully';
    $_SESSION['message_type'] = 'warn';
    header('Location: /projects/tasku3dawes/index.php?page=usuaris');
}
?>