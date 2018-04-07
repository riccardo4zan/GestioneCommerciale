<?php
session_start();
$_SESSION["titolo"] = "Mostra ordini";
require_once 'files/header.php';
echo "<div class=\"container\">";
$sql;
/**
 * Se passo la partita iva voglio vedere gli ordini di quel cliente
 * Se gli passo qualcosa nel campo di ricerca voglio vedere le cose relative
 * Sennò mi mostra tutti gli ordini
 */
if (isset($_GET["piva"])) {
    $piva = remove_multiple_spaces(filter_input(INPUT_GET, 'piva', FILTER_SANITIZE_STRING));
    if (ctype_digit($piva) && (strlen($piva) == 11) && $piva > 0) {
        $sql = "SELECT * FROM OrdiniNomiClienti WHERE piva = {$piva} ORDER BY dataord";
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Errore nel valore della partita iva</div>";
        die;
    }
}else if(isset($_POST["campoRicerca"])){
    $cr = remove_multiple_spaces(filter_input(INPUT_POST, 'campoRicerca', FILTER_SANITIZE_STRING));
    $sql = "SELECT * FROM OrdiniNomiClienti WHERE id LIKE '%{$cr}%' OR nome LIKE '%{$cr}%' OR piva LIKE '%{$cr}%' OR dataord LIKE '%{$cr}%'";
} else {
    $sql = "SELECT * FROM OrdiniNomiClienti ORDER BY dataord DESC";
}

$result = $conn->query($sql);
if ($conn->error) {
    echo "<div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
    die;
}
if ($result->num_rows > 0) {
    ?> 
    <br>
    <form action="mostraOrdini.php" type="text" method="post">
        <div style="display: inline">
            <input name="campoRicerca" placeholder="Cerca qualsiasi informazione all'interno di tutti gli ordini" style="width: 85%">
            <button class="btn btn-outline-success" type="submit" style="width: 10%">Cerca</button>
        </div>
    </form>
    <br>
<table class="table">
        <thead>
            <tr>
                <th>Numero</th>
                <th>Nome</th>
                <th>Partita IVA</th>
                <th>Data Effettuazione</th>
                <th>Prodotti nell'ordine</th>
                <th>Elimina ordine</th>
            </tr>
        </thead>
        <?php

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row[id]}</td><td>{$row[nome]}</td><td>{$row[piva]}</td><td>{$row[dataord]}</td>"
            . "<td><a class=\"btn btn-warning\" href=\"visualizzaProdotti.php?nord={$row[id]}\" role=\"button\">Visualizza</a></td>"
            . "<td><a class=\"btn btn-danger\" href=\"eliminaOrdine.php?id={$row[id]}\" role=\"button\">Elimina</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Nessun ordine da mostrare</div>";
    }
    echo "</div>";
    include 'files/footer.html';
    