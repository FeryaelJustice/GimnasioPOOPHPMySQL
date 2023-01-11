<?php
require __DIR__ . '../../../../database/db.php';

require __DIR__ . '../../../../partials/header.php';

// Redirect if it's not logged
if (!isset($_SESSION['usuario'])) {
    header('Location: /projects/tasku4dawes/index.php?page=login');
}

$id = null;
$nom = $llinatges = $username = $password = "";
$telefon = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nom = $_POST["name"];
    $llinatges = $_POST["surname"];
    $telefon = $_POST["phone"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sqlUpdate = "UPDATE usuaris SET nom='$nom', llinatges='$llinatges', telefon='$telefon', username='$telefon', password=SHA2('$password',256) WHERE idusuari = $id";
    $result = $conn->query($sqlUpdate);
    if ($result) {
        $_SESSION['message'] = 'User edited successfully';
        $_SESSION['message_type'] = 'success';
?>
        <div class="alert alert-success" role="alert">
            Registro editado
        </div>
    <?php
    } else {
        $_SESSION['message'] = 'User edit failed';
        $_SESSION['message_type'] = 'error';
    ?>
        <div class="alert alert-danger" role="alert">
            Fallo al editar registro
        </div>
<?php
    }
}
?>

<div class="row">
    <div class="col-sm-8">
        <div class="alert alert-primary" role="alert">
            <div class="row">
                <div class="col-sm-9">
                    <h2> Edita usuaris</h2>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <?php
            $sql = "SELECT idusuari, nom, llinatges, telefon, username, password FROM usuaris";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            ?>
                <table id="userList" class="table table-bordered table-hover table-striped">
                    <tr>
                        <th>ID client</th>
                        <th>nom</th>
                        <th>llinatges</th>
                        <th>telefon</th>
                        <th>nom de usuari</th>
                        <th>contrasenya (SHA2)</th>
                        <th></th>
                    </tr>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                    ?>
                        <form class="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <td>
                                <input type="text" name="id" readonly value="<?= $row["idusuari"] ?>">
                            </td>
                            <td>
                                <input type="text" name="name" id="name" value="<?= $row["nom"] ?>">
                            </td>
                            <td>
                                <input type="text" name="surname" id="surname" value="<?= $row["llinatges"] ?>">
                            </td>
                            <td>
                                <input type="text" name="phone" id="phone" value="<?= $row["telefon"] ?>">
                            </td>
                            <td>
                                <input type="text" name="username" id="username" value="<?= $row["username"] ?>">
                            </td>
                            <td>
                                <input type="password" name="password" id="password" value="<?= $row["password"] ?>">
                            </td>
                            <td>
                                <input type="image" src="../../../static/check.png" alt="Submit" width="32">
                            </td>
                        </form>
                        </tr>";
                    <?php
                        echo "</tr>";
                    }
                    ?>
                </table>
            <?php
            } else {
                echo "0 results";
            }
            $result->free();
            ?>
        </div>
    </div>

</div>

<?php
require  __DIR__ . '../../../../partials/footer.php';
?>