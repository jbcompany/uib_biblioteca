<?php
session_start();
require_once '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM userAccess WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['login_success'] = 'Inicio de sesión correcto.';
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['login_error'] = 'Contraseña incorrecta.';
            $_SESSION['old_login_email'] = $email;
            header("Location: ../session.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = 'Usuario no encontrado.';
        $_SESSION['old_login_email'] = $email;
        header("Location: ../session.php");
        exit();
    }
}
?>