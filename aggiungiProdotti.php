<?php
/**
 * Aggiunge i prodotti ad un ordine esistente
 */
session_start();
$_SESSION["titolo"] = "Aggiungi prodotti";
require_once 'files/header.php';
?>
<div class="container">
    <form action="aggiungiProdotti.php" method="post">
        <div class="form-group">
            <?php
            //Precompilazione form
            if (isset($_GET["id"])) {
                $id = remove_multiple_spaces(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING));
                if (ctype_digit($id)) {
                    $sql = "SELECT * FROM OrdiniNomiClienti WHERE id = {$id}";
                    $result = $conn->query($sql);
                    if ($conn->error) {
                        echo "<br><div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
                        die;
                    } else {
                        if ($result->num_rows > 0) {
                            $res = $result->fetch_assoc();
                        } else {
                            echo "<br><div class=\"alert alert-danger\" role=\"alert\">Nessun ordine trovato</div>";
                        }
                    }
                }
            }
            //Inserimento degli ordini
            else if (isset($_POST['nord'], $_POST['codice'], $_POST['quantita'])) {
                //Acquisizione degli input
                $codice = remove_multiple_spaces(filter_input(INPUT_POST, 'codice', FILTER_SANITIZE_STRING));
                $qta = filter_input(INPUT_POST, 'quantita', FILTER_SANITIZE_NUMBER_INT);
                $nord = filter_input(INPUT_POST, 'nord', FILTER_SANITIZE_NUMBER_INT);
                //Controllo la correttezza dei campi
                if ((strlen($codice) >= 1 ) && $qta >= 1 && $nord >= 0) {
                    $sql = "INSERT INTO DettaglioOrdine VALUES ('{$nord}','{$codice}','{$qta}')";
                    $conn->query($sql);
                    if ($conn->error) {
                        echo "<br><div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
                        die;
                    } else {
                        echo "<br><div class=\"alert alert-success\" role=\"alert\"> Azione eseguita con successo</div>";
                        echo "<a class=\"btn btn-lg btn-warning btn-block\" href=\"visualizzaProdotti.php?nord={$nord}\" role=\"button\">Fine e visualizza i prodotti dell'ordine</a>";
                    }
                } else {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">Errore</div>";
                }
                $sql = "SELECT * FROM OrdiniNomiClienti WHERE id = {$nord}";
                $result = $conn->query($sql);
                if ($conn->error) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
                    die;
                } else {
                    if ($result->num_rows > 0) {
                        $res = $result->fetch_assoc();
                    } else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">Nessun ordine trovato</div>";
                    }
                }
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">Id non valido</div>";
            }
            ?>
            <label>Numero ordine</label>
            <input name="nord" class="form-control" type="text" value="<?= $res[id] ?>" readonly>
            <label>Partita IVA</label>
            <input class="form-control" type="text" placeholder="<?= $res[piva] ?>" readonly>
            <label>Nome cliente</label>
            <input class="form-control" type="text" placeholder="<?= $res[nome] ?>" readonly>
            <label>Data ordine</label>
            <input class="form-control" type="text" placeholder="<?= $res[dataord] ?>" readonly>
            <label>Prodotto</label>
            <?php
            //Riempimento del menù a tendina
            $sql = "SELECT codice, nome FROM Prodotti ORDER BY nome";
            $result = $conn->query($sql);
            if ($conn->error) {
                echo "<div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
                die;
            } else {
                if ($result->num_rows > 0) {
                    echo "<select name=\"codice\" class=\"form-control\">";
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value=\"$row[codice]\">NOME: $row[nome] | CODICE: $row[codice]</option>";
                    }
                    echo "</select>";
                } else {
                    echo "<div class=\"alert alert-primary\" role=\"alert\">Nessun prodotto da aggiungere</div>";
                }
            }
            ?>
            <div class="form-group">
                <label>Quantità</label>
                <input type="number" name="quantita" class="form-control" required>
            </div>
        </div>
        <button class="btn btn-lg btn-success btn-block" type="submit">Aggiungi prodotto all'ordine</button>
    </form>
</div>        
<?php
include 'files/footer.html';
?>