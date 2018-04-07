<?php
session_start();
$_SESSION["titolo"] = "Modifica cliente";
require_once 'files/header.php';
echo "<div class=\"container\">";
if (isset($_GET["piva"])) {
    $piva = filter_input(INPUT_GET, 'piva', FILTER_SANITIZE_STRING);
    if (ctype_digit($piva) && (strlen($piva) == 11) && $piva > 0) {
        $sql = "SELECT * FROM Clienti WHERE piva = {$piva}";
        $result = $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        if ($result->num_rows > 0) {
            $res = $result->fetch_assoc();
            ?>
            <form action="modificaCliente.php" method="post">
                <div class="form-group">
                    <label>Partita iva</label>
                    <input name="newpiva" class="form-control" autofocus required value="<?= $res[piva] ?>">
                    <!-- Campo nasconsto per passare la PIVA vecchia -->
                    <input type="hidden" name="oldpiva" value="<?= $res[piva] ?>" />
                </div>
                <div class="form-group">
                    <label>Nome</label>
                    <input name="nome" class="form-control" required value="<?= $res[nome] ?>">
                </div>
                <div class="form-group">
                    <label>Indirizzo</label>
                    <input name="indirizzo" class="form-control" required value="<?= $res[indirizzo] ?>">
                </div>
                <button class="btn btn-lg btn-success btn-block" type="submit">Modifica</button>
            </form>
            <a class="btn btn-lg btn-danger btn-block" href="index.php" role="button">Annulla e torna a home</a>  
            <?php
        } else {
            echo "<br><div class=\"alert alert-primary\" role=\"alert\">Cliente inesistente</div>";
        }
    }
} else if (isset($_POST['newpiva'], $_POST['nome'], $_POST['indirizzo'], $_POST['oldpiva'])) {
    //Acquisizione degli input
    $newpiva = remove_multiple_spaces(filter_input(INPUT_POST, 'newpiva', FILTER_SANITIZE_STRING));
    $oldpiva = remove_multiple_spaces(filter_input(INPUT_POST, 'oldpiva', FILTER_SANITIZE_STRING));
    $nome = remove_multiple_spaces(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
    $indirizzo = remove_multiple_spaces(filter_input(INPUT_POST, 'indirizzo', FILTER_SANITIZE_STRING));
    //Controllo la correttezza del campo contenente la partita iva, controllo che gli altri due campi abbiano dei valori
    if (ctype_digit($newpiva) && (strlen($newpiva) == 11) && $newpiva > 0 &&
            ctype_digit($oldpiva) && (strlen($oldpiva) == 11) && $oldpiva > 0 &&
            (strlen($nome) >= 1 && (strlen($indirizzo) >= 1))) {
        $sql = "UPDATE Clienti SET piva='{$newpiva}',nome='{$nome}',indirizzo='{$indirizzo}' WHERE piva='{$oldpiva}'";
        $conn->query($sql);
        if ($conn->error) {
            echo "<br><div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        } else {
            echo "<br><div class=\"alert alert-success\" role=\"alert\"> Azione eseguita con successo</div>";
            echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\"mostraClienti.php\" role=\"button\">Visualizza clienti</a>  ";
        }
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">Nel campo partita iva devono essere immessi obbligatoriamente solo 11 numeri</div>";
    }
} else {
    "<div class=\"alert alert-danger\" role=\"alert\">Errore</div>";
}
echo "</div>";
include 'files/footer.html';
