<?php
// Redirect if it's not logged
if (!isset($_SESSION['usuario'])) {
    header('Location: /projects/tasku4dawes/index.php?page=login');
}

// VALIDATION
$diaErr = $horaErr = $tipusErr = $usuariErr = "";
$dia = $hora = "";
$tipus = $usuari = 0;
$validForm = true;
$validFormVacios = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check si estan vacios
    if (empty($_POST["dia"])) {
        $diaErr = "Dia is required";
        $validFormVacios = false;
    } else {
        $dia = test_input($_POST["dia"]);
    }

    if (empty($_POST["hora"])) {
        $horaErr = "Hora is required";
        $validFormVacios = false;
    } else {
        $hora = test_input($_POST["hora"]);
    }

    if (empty($_POST["tipus"])) {
        $tipusErr = "Tipus no valid";
        $validFormVacios = false;
    } else {
        $tipus = test_input($_POST["tipus"]);
    }

    if (empty($_POST["usuari"])) {
        $usuariErr = "Usuari no valid";
        $validFormVacios = false;
    } else {
        $usuari = test_input($_POST["usuari"]);
    }

    // Check si ya existe
    $dataCompleta = join_date_and_time($_POST["dia"], $_POST["hora"]);
    $sql = "SELECT * FROM reserves";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($valores = $result->fetch_assoc()) {
            if (($valores["idpista"] == $_POST["tipus"]) && ($valores["data"] == $dataCompleta)) {
                $validForm = false;
                $_SESSION['message'] = 'Reserva creation failed';
                $_SESSION['message_type'] = 'error';
                break;
            }
        }
    }
    $result->free();
    if ($validForm && $validFormVacios) {
        // prepare and bind
        try {
            $stmt = $conn->prepare("INSERT INTO reserves (data, idpista, idclient) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $dataCompleta, $tipus, $usuari);
            $stmt->execute();
            $_SESSION['message'] = 'Reserva created successfully';
            $_SESSION['message_type'] = 'success';
        } catch (Exception $e) {
            echo "crear reserva failed";
            $_SESSION['message'] = 'Reserva creation failed';
            $_SESSION['message_type'] = 'error';
        } finally {
            $stmt->close();
        }
    }
}

// Sanitize input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function join_date_and_time($date, $time)
{
    $only_date = date('Y-m-d', strtotime($date));
    $only_time = date('H:i:s', strtotime($time));
    $full_date = date('Y-m-d H:i:s', strtotime("$only_date $only_time"));
    return $full_date;
}

?>
<!-- Page -->
<div class="row">
    <div class="col-sm-4">
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
        <div class="alert alert-info" role="alert">
            Tenir en compte que no es pot reservar els dissabtes y diumenges.
        </div>
        <form class="form-group" name="reserva" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2> Reserva pista</h2>
            <p>
                <label for="dia">Dia:</label>
                <input type="date" id="dia" name="dia" value="<?php echo $dia; ?>">
                <span class="error">* <?php echo $diaErr; ?></span>
                <br /><br />
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" min="15:00" max="20:59" value="<?php echo $hora; ?>">
                <span class="error">* <?php echo $horaErr; ?></span>
            </p>

            <h2> Tipus pista </h2>
            <p>
                <select name="tipus" id="tipus" value="<?php echo $tipus ?>">
                    <option value="0">Seleccione:</option>
                    <?php
                    $sql = "SELECT * FROM pistes";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($valores = $result->fetch_assoc()) {
                            if ($valores["idpista"] == $_POST["tipus"]) {
                                echo '<option value="' . $valores["idpista"] . '" selected >' . $valores["tipo"] . '</option>';
                            } else {
                                echo '<option value="' . $valores["idpista"] . '">' . $valores["tipo"] . '</option>';
                            }
                        }
                    }
                    $result->free();
                    ?>
                </select>
                <span class="error">* <?php echo $tipusErr; ?></span>
            </p>

            <h2> Usuari</h2>
            <p>
                <select class="form-select" id="usuari" name="usuari">
                    <option value="0">Seleccione:</option>
                    <?php
                    $sql = "SELECT * FROM clients";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($valores = $result->fetch_assoc()) {
                            if ($valores["idclient"] == $_POST["usuari"]) {
                                echo '<option value="' . $valores["idclient"] . '" selected >' . $valores["nom"] . " " . $valores["llinatges"] . '</option>';
                            } else {
                                echo '<option value="' . $valores["idclient"] . '">' . $valores["nom"] . " " . $valores["llinatges"] . '</option>';
                            }
                        }
                    }
                    $result->free();
                    ?>
                </select>
                <span class="error">* <?php echo $usuariErr; ?></span>
            </p>
            <div style="text-align: center">
                <input class="btn btn-primary" type="submit" value="Enviar" name="enviar" style="margin-right: 5px; width: 60px; height:30px; font-weight: bold">
            </div>
        </form>
        <?php
        if (!$validForm) {
        ?>
            <div class="alert alert-danger" role="alert">
                Ya existe una reserva para ese dia y hora
            </div>
        <?php
        } else if (!$validFormVacios) {
        ?>
            <div class="alert alert-danger" role="alert">
                Uno o más campos están vacíos
            </div>
        <?php
        }
        ?>
    </div>
</div>