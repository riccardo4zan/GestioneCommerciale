<?php
session_start();
$_SESSION["titolo"] = "Elimina prodotti";
require_once 'files/header.php';
echo "<div class=\"container\">";
if (isset($_GET["codice"], $_GET["nord"])) {
    $codice = remove_multiple_spaces(filter_input(INPUT_GET, 'codice', FILTER_SANITIZE_STRING));
    $nord = remove_multiple_spaces(filter_input(INPUT_GET, 'nord', FILTER_SANITIZE_STRING));
    if ((strlen($codice) >= 1) && ctype_digit($nord)) {
        ?>
        <h1>Procedere?</h1>
        <form action="eliminaProdottoDO.php" method="post">
            <input type="hidden" name="codice" value="<?= $codice ?>" />
            <input type="hidden" name="nord" value="<?= $nord ?>" />
            <button class="btn btn-lg btn-danger btn-block" type="submit">Elimina</button>                 
        </form>
        <a class="btn btn-lg btn-success btn-block" href="visualizzaProdotti.php?nord=<?= $nord?>" role="button">Annulla e torna all'ordine</a>  
        <?php
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Codice del prodotto e/o numero dell'ordine non validi/o</div>";
    }
} else if (isset($_POST["codice"], $_POST["nord"])) {
    $codice = remove_multiple_spaces(filter_input(INPUT_POST, 'codice', FILTER_SANITIZE_STRING));
    $nord = remove_multiple_spaces(filter_input(INPUT_POST, 'nord', FILTER_SANITIZE_STRING));
    if ((strlen($codice) >= 1) && ctype_digit($nord)) {
        $sql = "DELETE FROM DettaglioOrdine WHERE codprod = {$codice} AND nord = {$nord}";
        $result = $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        echo "<div class=\"alert alert-danger\" role=\"alert\">Azione completata</div>";
        echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\"visualizzaProdotti.php?nord={$nord}\" role=\"button\">Torna all'ordine</a>";
    }
} else {
    "<div class=\"alert alert-danger\" role=\"alert\">Errore</div>";
}
echo "</div>";
include 'files/footer.html';
