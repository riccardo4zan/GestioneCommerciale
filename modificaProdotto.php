<?php
session_start();
$_SESSION["titolo"] = "Modifica prodotto";
require_once 'files/header.php';
echo "<div class=\"container\">";
if (isset($_GET["codice"])) {
    $codice = remove_multiple_spaces(filter_input(INPUT_GET, 'codice', FILTER_SANITIZE_STRING));
    if (strlen($codice) >= 1) {
        $sql = "SELECT * FROM Prodotti WHERE codice = {$codice}";
        $result = $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        if ($result->num_rows > 0) {
            $res = $result->fetch_assoc();
            ?>
            <form action="modificaProdotto.php" method="post">
                <div class="form-group">
                    <label>Codice</label>
                    <input name="newcodice" class="form-control" autofocus required value="<?= $res[codice] ?>">
                    <!-- Campo nasconsto per passare il codice vecchio -->
                    <input type="hidden" name="oldcodice" value="<?= $res[codice] ?>" />
                </div>
                <div class="form-group">
                    <label>Nome</label>
                    <input name="nome" class="form-control" required value="<?= $res[nome] ?>">
                </div>
                <div class="form-group">
                    <label>Costo</label>
                    <input type="number" name="prezzo" class="form-control" required value="<?= $res[prezzo] ?>">
                </div>
                <button class="btn btn-lg btn-warning btn-block" type="submit">Modifica</button>
            </form>
            <a class="btn btn-lg btn-danger btn-block" href="index.php" role="button">Annulla e torna a home</a>  
            <?php
        } else {
            echo "<br><div class=\"alert alert-primary\" role=\"alert\">Cliente inesistente</div>";
        }
    }
} else if (isset($_POST['newcodice'], $_POST['nome'], $_POST['prezzo'], $_POST['oldcodice'])) {
    //Acquisizione degli input
    $newcodice = remove_multiple_spaces(filter_input(INPUT_POST, 'newcodice', FILTER_SANITIZE_STRING));
    $oldcodice = remove_multiple_spaces(filter_input(INPUT_POST, 'oldcodice', FILTER_SANITIZE_STRING));
    $nome = remove_multiple_spaces(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
    $prezzo = filter_input(INPUT_POST, 'prezzo', FILTER_SANITIZE_NUMBER_FLOAT);
    //Controllo la correttezza dei campi
    if ((strlen($newcodice) >= 1 ) && (strlen($oldcodice) >= 1 ) && (strlen($nome) >= 1 ) && (strlen($prezzo) >= 1 ) && $prezzo > 0) {
        $sql = "UPDATE Prodotti SET codice='{$newcodice}',nome='{$nome}',prezzo='{$prezzo}' WHERE codice='{$oldcodice}'";
        $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        } else {
            echo "<br><div class=\"alert alert-success\" role=\"alert\"> Azione eseguita con successo</div>";
            echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\"mostraProdotti.php\" role=\"button\">Visualizza prodotti</a>";
        }
    } else {
        echo "<br><div class=\"alert alert-danger\" role=\"alert\">Errore nella compilazione del form/div>";
    }
} else {
    "<br><div class=\"alert alert-danger\" role=\"alert\">Errore</div>";
}
echo "</div>";
include 'files/footer.html';


