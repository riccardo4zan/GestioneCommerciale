<?php
session_start();
$_SESSION["titolo"] = "Elimina cliente";
require_once 'files/header.php';
echo "<div class=\"container\">";
if (isset($_POST["piva"])) {
    $piva = filter_input(INPUT_POST, 'piva', FILTER_SANITIZE_STRING);
    if (ctype_digit($piva) && (strlen($piva) == 11) && $piva > 0) {
        $sql = "DELETE FROM Clienti WHERE piva = {$piva}";
        $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        ?>
        <div class="alert alert-danger" role="alert">Azione completata</div>
        <a class="btn btn-lg btn-primary btn-block" href="mostraClienti.php" role="button">Visualizza i clienti</a>
        <?php
    }
} else if (isset($_GET["piva"])) {
    $piva = filter_input(INPUT_GET, 'piva', FILTER_SANITIZE_STRING);
    if (ctype_digit($piva) && (strlen($piva) == 11) && $piva > 0) {
        ?>            
        <form action="eliminaCliente.php" method="post">
            <h1>Procedere? Tutti gli ordini ed i loro dettagli, relativi al cliente in questione saranno eliminati e non sarà possibile recuperarli!</h1>
            <input type="hidden" name="piva" value="<?= $piva ?>" />
            <button class="btn btn-lg btn-danger btn-block" type="submit">Elimina</button>                 
        </form>
        <a class="btn btn-lg btn-success btn-block" href="mostraClienti.php" role="button">Annulla e torna a clienti</a>  
        <?php
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Partita iva non valida</div>";
    }
}
echo "</div>";
include 'files/footer.html';
