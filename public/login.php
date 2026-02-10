<?php
session_start();
require_once '../includes/auth.php';
if (isset($_SESSION['username']) && isset($_SESSION['uloga'])) {
    header("Location: ../index.php");
    exit(200);
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (isset($username) && isset($password)) {
        login($username, $password);
    } else {
        $error = 'Neispravno korisničko ime ili lozinka.';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login - LegalBI</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <div class="brand-logo">
                                            <!-- Logo ikona -->
                                            <i class="fa-solid fa-scale-balanced"
                                                style="font-size:32px; color:#2f7be5; margin-right:10px;"></i>

                                            <!-- Naziv -->
                                            <span class="brand-title"
                                                style="font-size:22px; font-weight:700; color:#2f7be5;">
                                                Legal<span style="color:#1f2937;">BI</span>
                                            </span>

                                        </div>
                                        <!-- <img src="../assets/images/yucom-logo.jpg" alt="YUCOM Komitet pravnika za ljudska prava"> -->
                                    </div>
                                    <form method="post">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Username</strong></label>
                                            <input type="text" name="username" placeholder="Korisničko ime" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" placeholder="Lozinka" required class="form-control">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>