<?php
session_start();
$_SESSION["titolo"] = "Gestisci utenti";
require_once 'files/header.php';
if (strcmp($_SESSION['username'],"Administrator")!==0) {
    header("Location: index.php");
    die();
}

echo "<div class=\"container\">";
$sql = "SELECT Username FROM Utenti";
$result = $conn->query($sql);
if ($conn->error) {
    echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
    die;
}
?>
<br><div class="alert alert-danger" role="alert">Attenzione! La pressione sul tasto elimina rimuoverà l'utente senza chiedere conferma!</div>
<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Elimina</th>
        </tr>
    </thead>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row[Username]}</td>";
        if (strcmp($uname, "Administrator") !== 0)
            echo "<td><a class=\"btn btn-danger\" href=\"eliminaUtenti.php?username={$row[Username]}\" role=\"button\">Elimina</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    if (isset($_GET["username"])) {
        $uname = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
        if (strcmp($uname, "Administrator") !== 0) {
            $sql = "DELETE FROM Utenti WHERE Username='{$uname}'";
            $conn->query($sql);
            if ($conn->error) {
                echo "<div class=\"alert alert-warning\" role=\"alert\"> Azione fallita: . $conn->error</div>";
                die;
            } else {
                header("Location: eliminaUtenti.php");
                die();
            }
        } else {
            echo "<br><div class=\"alert alert-primary\" role=\"alert\">L'account di amministrazione non può essere eliminato</div>";
        }
    }
    echo "</div>";
    include 'files/footer.html';

    