<?php

require __DIR__ . '../../../../database/db.php';

// Redirect if it's not logged
if (!isset($_SESSION['usuario'])) {
    header('Location: /projects/tasku4dawes/index.php?page=login');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM reserves WHERE idusuari=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $_SESSION['message'] = 'User deleted successfully';
        $_SESSION['message_type'] = 'success';
    } catch (Exception $e) {
        echo "Delete transaction reserves failed";
        $_SESSION['message'] = 'User deleted failed';
        $_SESSION['message_type'] = 'error';
        die();
    } finally {
        $stmt->close();
    }

    try {
        $stmt = $conn->prepare("DELETE FROM usuaris WHERE idusuari=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $_SESSION['message'] = 'User deleted successfully';
        $_SESSION['message_type'] = 'success';
    } catch (Exception $e) {
        echo "Delete transaction usuaris failed";
        $_SESSION['message'] = 'User deleted failed';
        $_SESSION['message_type'] = 'error';
        die();
    } finally {
        $stmt->close();
    }

    header('Location: /projects/tasku4dawes/index.php?page=usuaris');
}
