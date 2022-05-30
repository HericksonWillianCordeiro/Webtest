<?php

if (!empty($_POST['id'])) {
    require '../config.php';

    $id = $_POST['id'];
    $todos = $conn->prepare("SELECT id, checked FROM todos WHERE id=?");
    $todos->execute([$id]);

    $todo = $todos->fetch();
    $todoId = $todo['id'];
    $isChecked = $todo['checked'] ? 0 : 1;

    $updateParams = " SET checked = $isChecked ";
    if (!empty($_POST['updateTitle'])) {
        $updateParams = " SET title = '" . addslashes($_POST['title']) . "'";
    }

    $stmt = $conn->prepare("UPDATE todos {$updateParams} WHERE id=?");
    $res = $stmt->execute([$todoId]);

    if ($res) {
        header("Location: ../index.php?message=success");
    } else {
        header("Location: ../index.php?message=error");
    }

    $conn = null;
        exit();
} else {
    header("Location: ../index.php?message=required");
}