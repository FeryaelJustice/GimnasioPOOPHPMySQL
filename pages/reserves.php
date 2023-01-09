<?php
// Redirect if it's not logged
if (!isset($_SESSION['usuario'])) {
    header('Location: /projects/tasku4dawes/index.php?page=login');
}
?>
<div class="alert alert-info" role="alert">
    Tenir en compte que les fletxes van amb retràs, és a dir, que quan fas click a la fletxa de la dreta, no es veuen els canvis fins que no fas click a la fletxa de l'esquerra o dreta una altra vegada.
    Per exemple: esteim a 20/04, quan fas click a la dreta, la cookie s'estableix a 24/04, però no es veuen els canvis fins que dones click una altra vegada (en aquest moment la cookie estará a 28/04 si dones a la dreta, si es a l'esquerra estará a 20/04, i així)
</div>
<?php
if (!isset($_COOKIE["dateFrom"]) && !isset($_COOKIE["dateTo"])) {
    setcookie("dateFrom", gmdate("Y-m-d\TH:i:s\Z", time()), time() + 3600, "/");
    setcookie("dateTo", gmdate("Y-m-d\TH:i:s\Z", strtotime('+4 day', time())), time() + 3600, "/");
} else {
    setcookie("dateFrom", gmdate("Y-m-d\TH:i:s\Z", time()), time() + 3600, "/");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST["operation"] == "up") {
            setcookie("dateFrom", gmdate("Y-m-d\TH:i:s\Z", strtotime('+4 day', strtotime($_COOKIE["dateFrom"]))), time() + 3600, "/");
            setcookie("dateTo", gmdate("Y-m-d\TH:i:s\Z", strtotime('+4 day', strtotime($_COOKIE["dateTo"]))), time() + 3600, "/");

            /*
            if (empty($_GET['status'])) {
                header('/projects/tasku4dawes/index.php?page=reserves&status=1');
            }
            */
        } else if ($_POST["operation"] == "down") {
            setcookie("dateFrom", gmdate("Y-m-d\TH:i:s\Z", strtotime('-4 day', strtotime($_COOKIE["dateFrom"]))), time() + 3600, "/");
            setcookie("dateTo", gmdate("Y-m-d\TH:i:s\Z", strtotime('-4 day', strtotime($_COOKIE["dateTo"]))), time() + 3600, "/");

            /*
            if (empty($_GET['status'])) {
                header('/projects/tasku4dawes/index.php?page=reserves&status=1');
            }
            */
        }
    } else {
        setcookie("dateFrom", gmdate("Y-m-d\TH:i:s\Z", time()), time() + 3600, "/");
        setcookie("dateTo", gmdate("Y-m-d\TH:i:s\Z", strtotime('+4 day', time())), time() + 3600, "/");
    }
}
?>
<div class="row">
    <div class="col-sm-8">
        <div class="alert alert-primary" role="alert">
            <div class="row">
                <div class="col-sm-2">
                    <form class="form-group" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?page=reserves"; ?>">
                        <input type="hidden" name="operation" value="down">
                        <button type="submit"><img src="./static/left.png" style="cursor:pointer"></button>
                    </formc>
                </div>
                <div class="col-sm-8">
                    <h2> Reserves setmana <?php
                                            $time = null;
                                            if (isset($_COOKIE["dateFrom"])) {
                                                $time = strtotime($_COOKIE["dateFrom"]);
                                            }
                                            $day = date("d", $time);
                                            $month = date("m", $time);
                                            echo ($day . "/" . $month) ?> a <?php
                                                                            $timeTo = null;
                                                                            if (isset($_COOKIE["dateTo"])) {
                                                                                $timeTo = strtotime($_COOKIE["dateTo"]);
                                                                            }
                                                                            $dayTo = date("d", $timeTo);
                                                                            $monthTo = date("m", $timeTo);
                                                                            echo ($dayTo . "/" . $monthTo) ?></h2>
                </div>
                <div class="col-sm-2">
                    <form class="form-group" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?page=reserves"; ?>">
                        <input type="hidden" name="operation" value="up">
                        <button type="submit"><img src="./static/right.png" style="cursor:pointer"></button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        $diesSetmana = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
        $dateFrom = null;
        $dateTo = null;
        if (isset($_COOKIE["dateFrom"])) {
            $dateFrom = $_COOKIE["dateFrom"];
        }
        if (isset($_COOKIE["dateTo"])) {
            $dateTo = $_COOKIE["dateTo"];
        }
        $sql = "SELECT * FROM reserves WHERE data BETWEEN '$dateFrom' AND '$dateTo'";
        $result = $conn->query($sql);
        echo $result->num_rows . ' resultats.   ';
        if ($result->num_rows > 0) {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <caption>Els dissabtes i diumenges no están disponibles.</caption>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Dilluns</th>
                            <th>Dimarts</th>
                            <th>Dimecres</th>
                            <th>Dijous</th>
                            <th>Divendres</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- FORMA INCORRECTA PERO A MIG FUNCIONAR (la forma correcta de hacerlo pero que aun no conseguí que funcione está en deprecated/ -->
                        <?php
                        // output data of each row

                        $diesSetmana = array("1", "2", "3", "4", "5");
                        // $horesDisponibles = ["15:00", "16:00", "17:00", "18:00", "19:00", "20:00"];
                        // $index = 0; // per el while i anar posant els dies de la setmana
                        // echo "<tr><td>" . $horesDisponibles[$index] . "</td><td>" . $row["data"] . "</td><td>" . $row["idpista"] . "</td><td>" . $row["idclient"] . "</td></tr>";

                        // 15:00
                        echo "<tr>";
                        echo "<td>15:00</td>";
                        while ($row = $result->fetch_assoc()) {
                            if (date('H', strtotime($row["data"])) == "15") { // Si el registro es hora 15
                                foreach ($diesSetmana as $dia) { // Recorremos lunes a viernes
                                    if ($dia == date('N', strtotime($row["data"]))) { // 'N' es para dias de la semana (1 = dilluns, 7 = diumenge) Si el dia es igual al dia de la semana del registro
                                        // Dia de la semana especifico con hora especifica (registros)
                                        echo "<td>";
                                        $sqlField = "SELECT * FROM reserves WHERE reserves.data = '$row[data]'"; // en una fecha concreta tantas reservas
                                        $resultField = $conn->query($sqlField);
                                        if ($resultField->num_rows > 0) {
                                            while ($rowField = $resultField->fetch_assoc()) {
                                                // obtener los datos de cada reserva
                                                $sqlDatosReserva = "SELECT pistes.tipo, clients.nom, clients.llinatges FROM reserves INNER JOIN pistes ON pistes.idpista = '$rowField[idpista]' INNER JOIN clients ON clients.idclient = '$rowField[idclient]' WHERE reserves.data = '$rowField[data]'";
                                                $resultDatosReserva = $conn->query($sqlDatosReserva);
                                                if ($resultDatosReserva->num_rows > 0) {
                                                    while ($rowDatosReserva = $resultDatosReserva->fetch_assoc()) {
                                                        echo $rowDatosReserva["nom"] . " " . $rowDatosReserva["llinatges"] . ": " . $rowDatosReserva["tipo"] . " | ";
                                                        // Si no funciona bien quitar el break
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        echo "</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                }
                                break;
                            }
                        }
                        echo "</tr>";
                        // 16:00
                        echo "<tr>";
                        echo "<td>16:00</td>";
                        while ($row = $result->fetch_assoc()) {
                            if (date('H', strtotime($row["data"])) == "16") {
                                foreach ($diesSetmana as $dia) { // Recorremos lunes a viernes
                                    if ($dia == date('N', strtotime($row["data"]))) { // 'N' es para dias de la semana (1 = dilluns, 7 = diumenge) Si el dia es igual al dia de la semana del registro
                                        // Dia de la semana especifico con hora especifica (registros)
                                        echo "<td>";
                                        $sqlField = "SELECT * FROM reserves WHERE reserves.data = '$row[data]'"; // en una fecha concreta tantas reservas
                                        $resultField = $conn->query($sqlField);
                                        if ($resultField->num_rows > 0) {
                                            while ($rowField = $resultField->fetch_assoc()) {
                                                // obtener los datos de cada reserva
                                                $sqlDatosReserva = "SELECT pistes.tipo, clients.nom, clients.llinatges FROM reserves INNER JOIN pistes ON pistes.idpista = '$rowField[idpista]' INNER JOIN clients ON clients.idclient = '$rowField[idclient]' WHERE reserves.data = '$rowField[data]'";
                                                $resultDatosReserva = $conn->query($sqlDatosReserva);
                                                if ($resultDatosReserva->num_rows > 0) {
                                                    while ($rowDatosReserva = $resultDatosReserva->fetch_assoc()) {
                                                        echo $rowDatosReserva["nom"] . " " . $rowDatosReserva["llinatges"] . ": " . $rowDatosReserva["tipo"] . " | ";
                                                        // Si no funciona bien quitar el break
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        echo "</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                }
                                break;
                                break;
                            }
                        }
                        echo "</tr>";
                        // 17:00
                        echo "<tr>";
                        echo "<td>17:00</td>";
                        while ($row = $result->fetch_assoc()) {
                            if (date('H', strtotime($row["data"])) == "17") {
                                foreach ($diesSetmana as $dia) { // Recorremos lunes a viernes
                                    if ($dia == date('N', strtotime($row["data"]))) { // 'N' es para dias de la semana (1 = dilluns, 7 = diumenge) Si el dia es igual al dia de la semana del registro
                                        // Dia de la semana especifico con hora especifica (registros)
                                        echo "<td>";
                                        $sqlField = "SELECT * FROM reserves WHERE reserves.data = '$row[data]'"; // en una fecha concreta tantas reservas
                                        $resultField = $conn->query($sqlField);
                                        if ($resultField->num_rows > 0) {
                                            while ($rowField = $resultField->fetch_assoc()) {
                                                // obtener los datos de cada reserva
                                                $sqlDatosReserva = "SELECT pistes.tipo, clients.nom, clients.llinatges FROM reserves INNER JOIN pistes ON pistes.idpista = '$rowField[idpista]' INNER JOIN clients ON clients.idclient = '$rowField[idclient]' WHERE reserves.data = '$rowField[data]'";
                                                $resultDatosReserva = $conn->query($sqlDatosReserva);
                                                if ($resultDatosReserva->num_rows > 0) {
                                                    while ($rowDatosReserva = $resultDatosReserva->fetch_assoc()) {
                                                        echo $rowDatosReserva["nom"] . " " . $rowDatosReserva["llinatges"] . ": " . $rowDatosReserva["tipo"] . " | ";
                                                        // Si no funciona bien quitar el break
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        echo "</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                }
                                break;
                                break;
                            }
                        }
                        echo "</tr>";
                        // 18:00
                        echo "<tr>";
                        echo "<td>18:00</td>";
                        while ($row = $result->fetch_assoc()) {
                            if (date('H', strtotime($row["data"])) == "18") {
                                foreach ($diesSetmana as $dia) { // Recorremos lunes a viernes
                                    if ($dia == date('N', strtotime($row["data"]))) { // 'N' es para dias de la semana (1 = dilluns, 7 = diumenge) Si el dia es igual al dia de la semana del registro
                                        // Dia de la semana especifico con hora especifica (registros)
                                        echo "<td>";
                                        $sqlField = "SELECT * FROM reserves WHERE reserves.data = '$row[data]'"; // en una fecha concreta tantas reservas
                                        $resultField = $conn->query($sqlField);
                                        if ($resultField->num_rows > 0) {
                                            while ($rowField = $resultField->fetch_assoc()) {
                                                // obtener los datos de cada reserva
                                                $sqlDatosReserva = "SELECT pistes.tipo, clients.nom, clients.llinatges FROM reserves INNER JOIN pistes ON pistes.idpista = '$rowField[idpista]' INNER JOIN clients ON clients.idclient = '$rowField[idclient]' WHERE reserves.data = '$rowField[data]'";
                                                $resultDatosReserva = $conn->query($sqlDatosReserva);
                                                if ($resultDatosReserva->num_rows > 0) {
                                                    while ($rowDatosReserva = $resultDatosReserva->fetch_assoc()) {
                                                        echo $rowDatosReserva["nom"] . " " . $rowDatosReserva["llinatges"] . ": " . $rowDatosReserva["tipo"] . " | ";
                                                        // Si no funciona bien quitar el break
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        echo "</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                }
                                break;
                                break;
                            }
                        }
                        echo "</tr>";
                        // 19:00
                        echo "<tr>";
                        echo "<td>19:00</td>";
                        while ($row = $result->fetch_assoc()) {
                            if (date('H', strtotime($row["data"])) == "19") {
                                foreach ($diesSetmana as $dia) { // Recorremos lunes a viernes
                                    if ($dia == date('N', strtotime($row["data"]))) { // 'N' es para dias de la semana (1 = dilluns, 7 = diumenge) Si el dia es igual al dia de la semana del registro
                                        // Dia de la semana especifico con hora especifica (registros)
                                        echo "<td>";
                                        $sqlField = "SELECT * FROM reserves WHERE reserves.data = '$row[data]'"; // en una fecha concreta tantas reservas
                                        $resultField = $conn->query($sqlField);
                                        if ($resultField->num_rows > 0) {
                                            while ($rowField = $resultField->fetch_assoc()) {
                                                // obtener los datos de cada reserva
                                                $sqlDatosReserva = "SELECT pistes.tipo, clients.nom, clients.llinatges FROM reserves INNER JOIN pistes ON pistes.idpista = '$rowField[idpista]' INNER JOIN clients ON clients.idclient = '$rowField[idclient]' WHERE reserves.data = '$rowField[data]'";
                                                $resultDatosReserva = $conn->query($sqlDatosReserva);
                                                if ($resultDatosReserva->num_rows > 0) {
                                                    while ($rowDatosReserva = $resultDatosReserva->fetch_assoc()) {
                                                        echo $rowDatosReserva["nom"] . " " . $rowDatosReserva["llinatges"] . ": " . $rowDatosReserva["tipo"] . " | ";
                                                        // Si no funciona bien quitar el break
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        echo "</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                }
                                break;
                                break;
                            }
                        }
                        echo "</tr>";
                        // 20:00
                        echo "<tr>";
                        echo "<td>20:00</td>";
                        while ($row = $result->fetch_assoc()) {
                            if (date('H', strtotime($row["data"])) == "20") {
                                foreach ($diesSetmana as $dia) { // Recorremos lunes a viernes
                                    if ($dia == date('N', strtotime($row["data"]))) { // 'N' es para dias de la semana (1 = dilluns, 7 = diumenge) Si el dia es igual al dia de la semana del registro
                                        // Dia de la semana especifico con hora especifica (registros)
                                        echo "<td>";
                                        $sqlField = "SELECT * FROM reserves WHERE reserves.data = '$row[data]'"; // en una fecha concreta tantas reservas
                                        $resultField = $conn->query($sqlField);
                                        if ($resultField->num_rows > 0) {
                                            while ($rowField = $resultField->fetch_assoc()) {
                                                // obtener los datos de cada reserva
                                                $sqlDatosReserva = "SELECT pistes.tipo, clients.nom, clients.llinatges FROM reserves INNER JOIN pistes ON pistes.idpista = '$rowField[idpista]' INNER JOIN clients ON clients.idclient = '$rowField[idclient]' WHERE reserves.data = '$rowField[data]'";
                                                $resultDatosReserva = $conn->query($sqlDatosReserva);
                                                if ($resultDatosReserva->num_rows > 0) {
                                                    while ($rowDatosReserva = $resultDatosReserva->fetch_assoc()) {
                                                        echo $rowDatosReserva["nom"] . " " . $rowDatosReserva["llinatges"] . ": " . $rowDatosReserva["tipo"] . " | ";
                                                        // Si no funciona bien quitar el break
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        echo "</td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                }
                                break;
                                break;
                            }
                        }
                        echo "</tr>";
                        ?>
                        <!-- END FORMA INCORRECTA PERO A MIG FUNCIONAR -->
                    </tbody>
                </table>
            </div>
        <?php
        }
        $result->free();
        ?>
    </div>
</div>