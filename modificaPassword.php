<?php
session_start();
$_SESSION["titolo"] = "Modifica password";
require_once 'files/header.php';
?>
<br>
<div class='container'>
    <h1>Modifica password</h1>
    <form action="modificaPassword.php" method="post">
        <div class="form-group">
            <input type="Password" name="password1" class="form-control" placeholder="Password" required><br>
            <input type="Password" name="password2" class="form-control" placeholder="Ripeti password" required><br>
            <button class="btn btn-lg btn-warning btn-block" type="submit">Cambia</button>
        </div>
    </form>
    <a class="btn btn-lg btn-danger btn-block" href="index.php" role="button">Annulla e torna a home</a>
</div>
<?php
if (isset($_POST["password1"], $_POST["password2"])) {
    $psw1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);
    $psw2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
    if (strcmp($psw1, $psw2) === 0) {
        $pswh = password_hash($psw1, PASSWORD_DEFAULT);
        $sql = "UPDATE Utenti SET password='{$pswh}' WHERE username = '{$_SESSION["username"]}'";
        $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-warning\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        } else {
            header("Location: index.php");
            die();
        }
    }
}

include 'files/footer.php';
