<?php
ob_start();
require "../config.php";
session_start();

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // validation
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi.";
    } else {
        // Check credentials
        $stmt = $pdo->prepare(
            "SELECT username, password, jabatan FROM pegawai WHERE username = ?",
        );
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["username"] = $user["username"];
            $_SESSION["jabatan"] = $user["jabatan"];

            if ($_SESSION["jabatan"] === "Bendahara") {
                header("Location: ../dashboard/admin/index.php");
            } else {
                header("Location: ../dashboard/other/index.php");
            }
            exit();
        } else {
            $error = "Username atau password salah.";
        }
    }
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
ob_end_flush();
?>

<?php include "inc/header.php"; ?>
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Sign In</h4>
                                <p class="mb-0">Enter your username and password</p>
                            </div>
                        <div class="card-body">
                            <?php if ($error): ?>
                            <div class="error"><?php echo htmlspecialchars(
                                $error,
                            ); ?></div>
                            <?php endif; ?>
                            <form method="POST" action="index.php">
                                <div class="mb-3">
                                    <input type="text" class="form-control form-control-lg" placeholder="username" aria-label="username" name="username">
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" name="password">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-5 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                    <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('../assets/img/login2.jpg'); background-size: 800px 100%; background-repeat: no-repeat; background-position: center;">
                        <span class="mask bg-dark bg-gradient opacity-6"></span>
                        <h4 class="mt-5 text-white font-weight-bolder position-relative">"MA"</h4>
                        <p class="text-white position-relative">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include "inc/footer.php"; ?>
