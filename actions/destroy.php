<?php

if (!empty($_POST['id'])) {
    require '../config.php';

    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM todos WHERE id=?");
    $res = $stmt->execute([$id]);

    if ($res) {
        header("Location: ../index.php?message=success");
    } else {
        header("Location: ../index.php?message=error");
    }

    $conn = null;
    exit();
} else {
    header("Location: ../index.php?error=required");
}