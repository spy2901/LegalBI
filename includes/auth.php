<?php
require_once '../config/db.php';

function login($username, $password)
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, password_hash, uloga FROM korisnici WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hash, $uloga);
        if ($stmt->fetch() && password_verify($password, $hash)) {

            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['uloga'] = $uloga;

            header("Location: ../index.php");
            exit();
        }
    }
    return false;
}

function registerUser($username, $password, $repeatPassword, $role)
{
    global $conn;

    // 1. Provera da li su lozinke iste
    if ($password !== $repeatPassword) {
        return ['success' => false, 'message' => 'Lozinke se ne poklapaju.'];
    }

    // 2. Provera duplikata korisničkog imena
    $stmt = $conn->prepare("SELECT id FROM korisnici WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        return ['success' => false, 'message' => 'Korisničko ime već postoji.'];
    }

    // 3. Hashovanje lozinke
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // 4. Ubacivanje u bazu
    $stmt = $conn->prepare("INSERT INTO korisnici (username, password_hash, uloga) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $passwordHash, $role);
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Korisnik uspešno registrovan.'];
    } else {
        return ['success' => false, 'message' => 'Došlo je do greške prilikom registracije.'];
    }
}
