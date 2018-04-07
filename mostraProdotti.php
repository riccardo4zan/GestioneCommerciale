<?php
session_start();
$_SESSION["titolo"] = "Mostra prodotti";
require_once 'files/header.php';
echo "<div class=\"container\">";

$sql;
//SE È SETTATO QUALCOSA SUL CAMPO DI RICERCA ALLORA PROVO A VEDERE SE UNO DEI CAMPI CODICE, NOME o PREZZO 
if(isset($_POST["campoRicerca"])){
    $cr = remove_multiple_spaces(filter_input(INPUT_POST, 'campoRicerca', FILTER_SANITIZE_STRING));
    $sql = "SELECT * FROM Prodotti WHERE codice LIKE '%{$cr}%' OR nome LIKE '%{$cr}%' OR prezzo LIKE '%{$cr}%'";
}else{
    //Sennò mostro tutti i clienti
    $sql = "SELECT * FROM Prodotti";
}

$result = $conn->query($sql);
if ($conn->error) {
    echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
    die;
}
if ($result->num_rows > 0) {
    ?>
    <br>
    <form action="mostraProdotti.php" type="text" method="post">
        <div style="display: inline">
            <input name="campoRicerca" placeholder="Cerca qualsiasi informazione all'interno di tutti i prodotti" style="width: 85%">
            <button class="btn btn-outline-success" type="submit" style="width: 10%">Cerca</button>
        </div>
    </form>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Codice</th>
                <th>Nome</th>
                <th>Prezzo</th>
                <th>Modifica</th>
                <th>Elimina</th>
            </tr>
        </thead>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row[codice]}</td><td>{$row[nome]}</td><td>{$row[prezzo]}</td>"
            . "<td><a class=\"btn btn-primary\" href=\"modificaProdotto.php?codice={$row[codice]}\" role=\"button\">Modifica</a></td>"
            . "<td><a class=\"btn btn-danger\" href=\"eliminaProdotto.php?codice={$row[codice]}\" role=\"button\">Elimina</a></td>"
            . "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Nessun prodotto trovato</div>";
    }
    echo "</div>";
    include 'files/footer.html';

    