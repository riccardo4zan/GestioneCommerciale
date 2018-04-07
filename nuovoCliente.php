<?php
session_start();
$_SESSION["titolo"] = "Nuovo cliente";
require_once 'files/header.php';
echo "<div class=\"container\">";
if (isset($_POST['piva'], $_POST['nome'], $_POST['indirizzo'])) {
    //Acquisizione degli input
    $piva = remove_multiple_spaces(filter_input(INPUT_POST, 'piva', FILTER_SANITIZE_STRING));
    $nome = remove_multiple_spaces(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
    $indirizzo = remove_multiple_spaces(filter_input(INPUT_POST, 'indirizzo', FILTER_SANITIZE_STRING));
    //Controllo la correttezza del campo contenente la partita iva, controllo che gli altri due campi abbiano dei valori
    if (ctype_digit($piva) && (strlen($piva) == 11) && $piva > 0 && (strlen($nome) >= 1 && (strlen($indirizzo) >= 1))) {
        $sql = "INSERT INTO Clienti VALUES ('{$piva}','{$nome}','{$indirizzo}')";
        $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        } else {
            echo "<br><div class=\"alert alert-success\" role=\"alert\"> Azione eseguita con successo</div>";
            echo "<a class=\"btn btn-lg btn-success btn-block\" href=\"mostraClienti.php\" role=\"button\">Visualizza clienti</a>";
        }
    } else {
        echo "<br><div class=\"alert alert-danger\" role=\"alert\">Nel campo partita iva devono essere immessi obbligatoriamente solo 11 numeri</div>";
    }
}
?>
<form action="nuovoCliente.php" method="post">
    <div class="form-group">
        <label>Partita iva</label>
        <input name="piva" class="form-control" autofocus required>
    </div>
    <div class="form-group">
        <label>Nome</label>
        <input name="nome" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Indirizzo</label>
        <input name="indirizzo" class="form-control" required>
    </div>
    <button class="btn btn-lg btn-success btn-block" type="submit">Aggiungi</button>
</form>
<a class="btn btn-lg btn-danger btn-block" href="index.php" role="button">Torna a home</a>
<?php
echo "</div>";
include 'files/footer.html';
