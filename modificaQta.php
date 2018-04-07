<?php
session_start();
$_SESSION["titolo"] = "Modifica quantit&agrave;";
require_once 'files/header.php';
echo "<div class=\"container\">";
if (isset($_GET["codice"], $_GET["nord"])) {
    $codice = remove_multiple_spaces(filter_input(INPUT_GET, 'codice', FILTER_SANITIZE_STRING));
    $nord = remove_multiple_spaces(filter_input(INPUT_GET, 'nord', FILTER_SANITIZE_STRING));
    if ((strlen($codice) >= 1) && ctype_digit($nord)) {
        $sql = "SELECT qta FROM DettaglioOrdine WHERE codprod = {$codice} AND nord = {$nord}";
        $result = $conn->query($sql);
        $res = $result->fetch_assoc();
        if ($conn->error) {
            echo "<br><div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        ?> 
        <form action="modificaQta.php" method="post">
            <input type="hidden" name="codice" value="<?= $codice ?>" />
            <input type="hidden" name="nord" value="<?= $nord ?>" />
            <div class="form-group">
                <label>Quantit&agrave;</label>
                <input type="number" name="qta" class="form-control" value="<?= $res["qta"] ?>" autofocus required>
            </div>
            <button class="btn btn-lg btn-success btn-block" type="submit">Modifica</button>                 
        </form>
        <a class="btn btn-lg btn-danger btn-block" href="index.php" role="button">Annulla e torna a home</a>  
        <?php
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Codice del prodotto e/o numero dell'ordine non validi/o</div>";
    }
} else if (isset($_POST["codice"], $_POST["nord"], $_POST["qta"])) {
    $codice = remove_multiple_spaces(filter_input(INPUT_POST, 'codice', FILTER_SANITIZE_STRING));
    $nord = remove_multiple_spaces(filter_input(INPUT_POST, 'nord', FILTER_SANITIZE_STRING));
    $qta = filter_input(INPUT_POST, 'qta', FILTER_SANITIZE_NUMBER_INT);
    if ((strlen($codice) >= 1) && ctype_digit($nord) && $qta > 1) {
        $sql = "UPDATE DettaglioOrdine SET qta='{$qta}' WHERE codprod='{$codice}' AND nord='{$nord}'";
        $result = $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        echo "<div class=\"container\">";
        echo "<br><div class=\"alert alert-success\" role=\"alert\">Azione completata</div>";
        echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\"visualizzaProdotti.php?nord={$nord}\" role=\"button\">Torna a prodotti</a>";
        echo "</div>";
    }
} else {
    "<div class=\"alert alert-danger\" role=\"alert\">Errore</div>";
}
echo "</div>";
include 'files/footer.html';


