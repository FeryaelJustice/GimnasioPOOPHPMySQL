<?php
// Redirect if it's not logged
if (!isset($_SESSION['usuario'])) {
    header('Location: ./index.php?page=login');
}
?>
<div class="row">
    <div class="col-sm-8">
        <?php
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
                $_SESSION['message'] = "";
            }
        }
        ?>
        <div class="alert alert-primary" role="alert">
            <div class="row">
                <div class="col-sm-9">
                    <h2> Usuaris</h2>
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
                    </tr>
                    <?php
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["idusuari"] . "</td><td>" . $row["nom"] . "</td><td>" . $row["llinatges"] . "</td><td>" . $row["telefon"] . "</td><td>" . $row["username"] . "</td><td>" . $row["password"] . "</td>";
                    ?>
                        </tr>";
                    <?php
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