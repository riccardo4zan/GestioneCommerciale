<?php
session_start();
$_SESSION["titolo"] = "Registra utente";
require_once 'files/header.php';
if (strcmp($_SESSION['username'],"Administrator")!==0) {
    header("Location: index.php");
    die();
}
?>
<br>
<div class='container'>
    <center>
        <h1>Registra nuovo utente</h1>
        <form action="registraUtente.php" method="post"
              <div class="form-group">
                <input name="username" class="form-control" placeholder="Username" required autofocus><br>
                <input type="Password" name="password1" class="form-control" placeholder="Password" required><br>
                <input type="Password" name="password2" class="form-control" placeholder="Ripeti password" required><br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Registra</button>
        </form>
            <?php
            if (isset($_POST["username"], $_POST["password1"], $_POST["password2"])) {
                $uname = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $psw1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);
                $psw2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
                if (strcmp($psw1, $psw2) === 0) {
                    $pswh = password_hash($psw1, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO Utenti(username,password) VALUES ('{$uname}','{$pswh}')";
                    $conn->query($sql);
                    if ($conn->error) {
                        echo "<div class=\"alert alert-warning\" role=\"alert\"> Azione fallita: . $conn->error</div>";
                        die;
                    } else {
                        echo "<br><div class=\"alert alert-success\" role=\"alert\"> Azione eseguita con successo</div>";
                    }
                }
            }
            echo "</center>";
            echo "</div>";
            include 'files/footer.html';
            