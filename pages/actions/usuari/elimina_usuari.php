<?php

require __DIR__ . '../../../../database/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM reserves WHERE idclient=?");
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
        $stmt = $conn->prepare("DELETE FROM clients WHERE idclient=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $_SESSION['message'] = 'User deleted successfully';
        $_SESSION['message_type'] = 'success';
    } catch (Exception $e) {
        echo "Delete transaction clients failed";
        $_SESSION['message'] = 'User deleted failed';
        $_SESSION['message_type'] = 'error';
        die();
    } finally {
        $stmt->close();
    }

    header('Location: /projects/tasku3dawes/index.php?page=usuaris');
}
