<div class="row">
    <div class="col-sm-8">
        <?php
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
        ?>
        <div class="alert alert-primary" role="alert">
            <div class="row">
                <div class="col-sm-9">
                    <h2> Usuaris</h2>
                </div>
                <div class="col-sm-3">
                    <form method="POST" action="./pages/actions/usuari/crea_usuari.php">
                        <input type="hidden" name="id" value="id">
                        <button type="submit" class="btn btn-primary"><img src="./static/add.png" width="32">Afegir Usuari</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <?php
            $sql = "SELECT idclient, nom, llinatges, telefon FROM clients";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            ?>
                <table id="userList" class="table table-bordered table-hover table-striped">
                    <tr>
                        <th>ID client</th>
                        <th>nom</th>
                        <th>llinatges</th>
                        <th>telefon</th>
                        <th></th>
                    </tr>
                    <?php
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["idclient"] . "</td><td>" . $row["nom"] . "</td><td>" . $row["llinatges"] . "</td><td>" . $row["telefon"] . "</td>";
                    ?>
                        <td>
                            <a href="./pages/actions/usuari/modificar_usuari.php?id=<?php echo $row["idclient"] ?>"><img src="./static/pencil.png" width="32"></a>
                            <a href="./pages/actions/usuari/elimina_usuari.php?id=<?php echo $row["idclient"] ?>"><img src="./static/remove.png" width="32"></a>
                        </td>
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