<?php
session_start();
$_SESSION["titolo"] = "Nuovo prodotto";
require_once 'files/header.php';
echo "<div class=\"container\">";
if (isset($_POST['codice'], $_POST['nome'], $_POST['prezzo'])) {
    //Acquisizione degli input
    $codice = remove_multiple_spaces(filter_input(INPUT_POST, 'codice', FILTER_SANITIZE_STRING));
    $nome = remove_multiple_spaces(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
    $prezzo = filter_input(INPUT_POST, 'prezzo', FILTER_SANITIZE_NUMBER_FLOAT);
    //Controllo la correttezza dei campi
    if ((strlen($codice) >= 1 ) && (strlen($nome) >= 1 ) && (strlen($prezzo) >= 1 ) && $prezzo > 0) {
        $sql = "INSERT INTO Prodotti VALUES ('{$codice}','{$nome}','{$prezzo}')";
        $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        } else {
            echo "<div class=\"alert alert-success\" role=\"alert\"> Azione eseguita con successo</div>";
            echo "<a class=\"btn btn-lg btn-success btn-block\" href=\"mostraProdotti.php\" role=\"button\">Visualizza prodotti</a>";
        }
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\"> Errore </div>";
    }
}
?>
<form action="nuovoProdotto.php" method="post">
    <div class="form-group">
        <label>Codice</label>
        <input name="codice" class="form-control" autofocus required>
    </div>
    <div class="form-group">
        <label>Nome</label>
        <input name="nome" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Prezzo</label>
        <input type="number" name="prezzo" class="form-control" required>
    </div>
    <button class="btn btn-lg btn-success btn-block" type="submit">Aggiungi</button>
</form>
<a class="btn btn-lg btn-danger btn-block" href="index.php" role="button">Annulla e torna a home</a>
<?php
echo "</div>";
include 'files/footer.html';
