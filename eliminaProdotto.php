<?php
session_start();
$_SESSION["titolo"] = "Elimina prodotto";
require_once 'files/header.php';
echo "<div class=\"container\">";
if (isset($_POST["codice"])) {
    $codice = remove_multiple_spaces(filter_input(INPUT_POST, 'codice', FILTER_SANITIZE_STRING));
    if ((strlen($codice) >= 1)) {
        $sql = "DELETE FROM Prodotti WHERE codice = {$codice}";
        $result = $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        echo "<div class=\"alert alert-danger\" role=\"alert\">Azione completata</div>";
        echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\"mostraProdotti.php\" role=\"button\">Torna a prodotti</a>";
    }
} else if (isset($_GET["codice"])) {
    $codice = remove_multiple_spaces(filter_input(INPUT_GET, 'codice', FILTER_SANITIZE_STRING));
    if ((strlen($codice) >= 1)) {
        ?>
        <h1>Procedere? Il prodotto in questione verrà eliminato da tutti gli ordini a cui è associato. L'operazione non è reversibile!</h1>
        <form action="eliminaProdotto.php" method="post">
            <input type="hidden" name="codice" value="<?= $codice ?>" />
            <button class="btn btn-lg btn-danger btn-block" type="submit">Elimina</button>                 
        </form>
        <a class="btn btn-lg btn-danger btn-block" href="mostraProdotti.php" role="button">Annulla e torna a prodotti</a>
        <?php
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Numero del prodotto non valido</div>";
    }
} else {
    echo "<div class=\"alert alert-primary\" role=\"alert\">Errore</div>";
}
echo "</div>";
include 'files/footer.html';
