<?php
session_start();
$_SESSION["titolo"] = "Nuovo ordine";
require_once 'files/header.php';
echo "<div class=\"container\">";
?>
<form action="nuovoOrdine.php" method="post">
    <div class="form-group">
        <label>Cliente</label>                   
        <?php
        //Riempimento del menù a tendina
        $sql = "SELECT nome, piva FROM Clienti ORDER BY nome";
        $result = $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        } else {
            if ($result->num_rows > 0) {
                echo "<select name=\"piva\" class=\"form-control\">";
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"$row[piva]\">NOME: $row[nome] | PIVA: $row[piva]</option>";
                }
                echo "</select>";
            } else {
                echo "<div class=\"alert alert-ptimary\" role=\"alert\"> Aggiungere almeno un cliente</div>";;
            }
        }
        ?>
    </div>
    <div class="form-group">
        <label>Data</label>
        <input name="data" type="text" placeholder="YYYY-MM-DD" class="form-control" required>
    </div>
    <button class="btn btn-lg btn-success btn-block" type="submit">Crea</button>
</form>
<a class="btn btn-lg btn-danger btn-block" href="index.php" role="button">Annulla e torna a home</a>
<?php
//Una volta impostata la PIVA e la data, le valido e immetto i dati nella tabella del DB
//Acquisizione degli input
if (isset($_POST['piva'], $_POST['data'])) {
    $piva = remove_multiple_spaces(filter_input(INPUT_POST, 'piva', FILTER_SANITIZE_STRING));
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
    //Esplodo la data per validarla
    list($y, $m, $d) = explode('-', $data);
    //Controllo la correttezza dei campi
    if (ctype_digit($piva) && (strlen($piva) == 11) && $piva > 0 && checkdate($m, $d, $y)) {
        $sql = "INSERT INTO Ordini (piva,dataord) VALUES ('{$piva}','{$data}')";
        $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        echo "<br><div class=\"alert alert-success\" role=\"alert\"> Azione eseguita con successo</div>";
        //Prendo l'id dell'ultimo inserimento effettuato
        $lid = $conn->insert_id;
        echo "<a href=\"aggiungiProdotti.php?id={$lid}\"><button class=\"btn btn-lg btn-warning btn-block\">Aggiungi prodotti all'ordine</button></a>";
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">Nel campo partita iva devono essere immessi obbligatoriamente solo 11 numeri. Il campo data deve essere nel formato YYYY-MM-DD (Es: 2001-01-01)</div>";
    }
}
echo "</div>";
include 'files/footer.html';
