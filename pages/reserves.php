<?php
// Redirect if it's not logged
if (!isset($_SESSION['usuario'])) {
    header('Location: /projects/tasku4dawes/index.php?page=login');
}

require_once(__DIR__ . '../../class/Reserva.php');
require_once(__DIR__ . '../../class/ReservaSingleInstance.php');
require_once(__DIR__ . '../../class/Pista.php');

$res = new Reserva();
$pista = new Pista();
$id_usuario = explode("/", $_SESSION['usuario'])[0];

// Get pistaID -> Nom pista en un array
$pistes = $pista->getPistes();
// Testing (COMMENT)
/*
foreach ($pistes as $key => $value){
    echo "/$key" . "-" . "$value";
}
*/

// Get reservas del usuari
$reservasUsuario = $res->reservesPerUsuari($id_usuario);
// Testing (COMMENT)
/*
foreach ($reservasUsuario as $reserva){
    echo $reserva->date . "/";
}
*/

// Calculate the date of Monday for the current week
$monday = date('Y-m-d', strtotime('monday this week'));
// Calculate the date of Friday for the current week
$friday = date('Y-m-d', strtotime('friday this week'));

// Retrieve the bookings for this week
$bookings = $res->llistaReserves($monday, $friday);

// Create an array to store the bookings for each day
$bookingsByDay = array();

// Iterate through each booking and store it in the appropriate day in the array
foreach ($bookings as $booking) {
    if (!isset($bookingsByDay[date('Y-m-d', strtotime($booking->date))])) {
        $bookingsByDay[date('Y-m-d', strtotime($booking->date))] = array();
    }
    $bookingsByDay[date('Y-m-d', strtotime($booking->date))][] = $booking;
}

// Check bookings in this week (only testing, have to comment)
/*
foreach ($bookingsByDay as $booki) {
    foreach ($booki as $b) {
        echo "$b->date / ";
    }
}
*/

?>

<div class="row">
    <div class="col-sm-8">
        <!-- Header of table -->
        <div class="alert alert-primary" role="alert">
            <div class="row">
                <div class="col-sm-2">
                    <form class="form-group" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?page=reserves"; ?>">
                        <input type="hidden" name="operation" value="down">
                        <button type="submit"><img src="./static/left.png" style="cursor:pointer"></button>
                        </formc>
                </div>
                <div class="col-sm-8">
                    <h2> Reserves setmana <?php echo $monday ?> a <?php echo $friday ?></h2>
                </div>
                <div class="col-sm-2">
                    <form class="form-group" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?page=reserves"; ?>">
                        <input type="hidden" name="operation" value="up">
                        <button type="submit"><img src="./static/right.png" style="cursor:pointer"></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <th></th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </thead>
                <tbody>
                    <tr striped>
                        <td>16:00</td>
                        <td>
                            <?php
                            // Display the track name for each booking on Monday
                            $monday = date('Y-m-d', strtotime($monday));
                            // echo $monday;
                            if (isset($bookingsByDay[$monday])) {
                                foreach ($bookingsByDay[$monday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "16") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Tuesday
                            $tuesday = date('Y-m-d', strtotime('+1 day', strtotime($monday)));
                            if (isset($bookingsByDay[$tuesday])) {
                                foreach ($bookingsByDay[$tuesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "16") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Wednesday
                            $wednesday = date('Y-m-d', strtotime('+2 day', strtotime($monday)));
                            if (isset($bookingsByDay[$wednesday])) {
                                foreach ($bookingsByDay[$wednesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "16") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Thursday
                            $thursday = date('Y-m-d', strtotime('+3 day', strtotime($monday)));
                            if (isset($bookingsByDay[$thursday])) {
                                foreach ($bookingsByDay[$thursday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "16") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Friday
                            $friday = date('Y-m-d', strtotime('+4 day', strtotime($monday)));
                            if (isset($bookingsByDay[$friday])) {
                                foreach ($bookingsByDay[$friday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "16") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>17:00</td>
                        <td>
                            <?php
                            // Display the track name for each booking on Monday
                            $monday = date('Y-m-d', strtotime($monday));
                            // echo $monday;
                            if (isset($bookingsByDay[$monday])) {
                                foreach ($bookingsByDay[$monday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "17") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Tuesday
                            $tuesday = date('Y-m-d', strtotime('+1 day', strtotime($monday)));
                            if (isset($bookingsByDay[$tuesday])) {
                                foreach ($bookingsByDay[$tuesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "17") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Wednesday
                            $wednesday = date('Y-m-d', strtotime('+2 day', strtotime($monday)));
                            if (isset($bookingsByDay[$wednesday])) {
                                foreach ($bookingsByDay[$wednesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "17") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Thursday
                            $thursday = date('Y-m-d', strtotime('+3 day', strtotime($monday)));
                            if (isset($bookingsByDay[$thursday])) {
                                foreach ($bookingsByDay[$thursday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "17") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Friday
                            $friday = date('Y-m-d', strtotime('+4 day', strtotime($monday)));
                            if (isset($bookingsByDay[$friday])) {
                                foreach ($bookingsByDay[$friday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "17") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>18:00</td>
                        <td>
                            <?php
                            // Display the track name for each booking on Monday
                            $monday = date('Y-m-d', strtotime($monday));
                            // echo $monday;
                            if (isset($bookingsByDay[$monday])) {
                                foreach ($bookingsByDay[$monday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "18") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Tuesday
                            $tuesday = date('Y-m-d', strtotime('+1 day', strtotime($monday)));
                            if (isset($bookingsByDay[$tuesday])) {
                                foreach ($bookingsByDay[$tuesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "18") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Wednesday
                            $wednesday = date('Y-m-d', strtotime('+2 day', strtotime($monday)));
                            if (isset($bookingsByDay[$wednesday])) {
                                foreach ($bookingsByDay[$wednesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "18") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Thursday
                            $thursday = date('Y-m-d', strtotime('+3 day', strtotime($monday)));
                            if (isset($bookingsByDay[$thursday])) {
                                foreach ($bookingsByDay[$thursday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "18") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Friday
                            $friday = date('Y-m-d', strtotime('+4 day', strtotime($monday)));
                            if (isset($bookingsByDay[$friday])) {
                                foreach ($bookingsByDay[$friday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "18") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>19:00</td>
                        <td>
                            <?php
                            // Display the track name for each booking on Monday
                            $monday = date('Y-m-d', strtotime($monday));
                            // echo $monday;
                            if (isset($bookingsByDay[$monday])) {
                                foreach ($bookingsByDay[$monday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "19") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Tuesday
                            $tuesday = date('Y-m-d', strtotime('+1 day', strtotime($monday)));
                            if (isset($bookingsByDay[$tuesday])) {
                                foreach ($bookingsByDay[$tuesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "19") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Wednesday
                            $wednesday = date('Y-m-d', strtotime('+2 day', strtotime($monday)));
                            if (isset($bookingsByDay[$wednesday])) {
                                foreach ($bookingsByDay[$wednesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "19") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Thursday
                            $thursday = date('Y-m-d', strtotime('+3 day', strtotime($monday)));
                            if (isset($bookingsByDay[$thursday])) {
                                foreach ($bookingsByDay[$thursday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "19") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Friday
                            $friday = date('Y-m-d', strtotime('+4 day', strtotime($monday)));
                            if (isset($bookingsByDay[$friday])) {
                                foreach ($bookingsByDay[$friday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "19") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>20:00</td>
                        <td>
                            <?php
                            // Display the track name for each booking on Monday
                            $monday = date('Y-m-d', strtotime($monday));
                            // echo $monday;
                            if (isset($bookingsByDay[$monday])) {
                                foreach ($bookingsByDay[$monday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "20") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Tuesday
                            $tuesday = date('Y-m-d', strtotime('+1 day', strtotime($monday)));
                            if (isset($bookingsByDay[$tuesday])) {
                                foreach ($bookingsByDay[$tuesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "20") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Wednesday
                            $wednesday = date('Y-m-d', strtotime('+2 day', strtotime($monday)));
                            if (isset($bookingsByDay[$wednesday])) {
                                foreach ($bookingsByDay[$wednesday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "20") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Thursday
                            $thursday = date('Y-m-d', strtotime('+3 day', strtotime($monday)));
                            if (isset($bookingsByDay[$thursday])) {
                                foreach ($bookingsByDay[$thursday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "20") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Display the track name for each booking on Friday
                            $friday = date('Y-m-d', strtotime('+4 day', strtotime($monday)));
                            if (isset($bookingsByDay[$friday])) {
                                foreach ($bookingsByDay[$friday] as $booking) {
                                    if (date('H', strtotime($booking->date)) == "20") {
                                        $nomPista = "";
                                        foreach ($pistes as $key => $value) {
                                            if ($booking->id_pista == $key) {
                                                $nomPista = $value;
                                            }
                                        }
                                        if ($id_usuario == $booking->id_client) {
                                            echo "<strong style='color:red'>" . $nomPista . "(TEVA)</strong><br>";
                                        } else {
                                            echo "<p>" . $nomPista . "</p><br>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>