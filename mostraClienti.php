<?php
session_start();
$_SESSION["titolo"] = "Mostra clienti";
require_once 'files/header.php';
echo "<div class=\"container\">";

$sql;
//SE È SETTATO QUALCOSA SUL CAMPO DI RICERCA ALLORA PROVO A VEDERE SE UNO DEI CAMPI PIVA, NOME o INDIRIZZO 
if(isset($_POST["campoRicerca"])){
    $cr = remove_multiple_spaces(filter_input(INPUT_POST, 'campoRicerca', FILTER_SANITIZE_STRING));
    $sql = "SELECT * FROM Clienti WHERE piva LIKE '%{$cr}%' OR nome LIKE '%{$cr}%' OR indirizzo LIKE '%{$cr}%'";
}else{
    //Sennò mostro tutti i clienti
    $sql = "SELECT * FROM Clienti";
}
$result = $conn->query($sql);
if ($conn->error) {
    echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
    die;
}

if ($result->num_rows > 0) {
    ?>
    <br>
    <form action="mostraClienti.php" type="text" method="post">
        <div style="display: inline">
            <input name="campoRicerca" placeholder="Cerca qualsiasi informazione all'interno dei clienti" style="width: 85%">
            <button class="btn btn-outline-success" type="submit" style="width: 10%">Cerca</button>
        </div>
    </form>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Partita IVA</th>
                <th>Nome</th>
                <th>Indirizzo</th>
                <th>Modifica</th>
                <th>Elimina</th>
                <th>Visualizza ordini</th>
            </tr>
        </thead>
        <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row[piva]}</td><td>{$row[nome]}</td><td>{$row[indirizzo]}</td>"
                . "<td><a class=\"btn btn-primary\" href=\"modificaCliente.php?piva={$row[piva]}\" role=\"button\">Modifica</a></td>"
                . "<td><a class=\"btn btn-danger\" href=\"eliminaCliente.php?piva={$row[piva]}\" role=\"button\">Elimina</a></td>"
                . "<td><a class=\"btn btn-secondary\" href=\"mostraOrdini.php?piva={$row[piva]}\" role=\"button\">Visualizza</a></td>"
                . "</tr>";
            }
            echo "</table>";
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Nessun cliente trovato</div>";
    }
    echo "</div>";
    include 'files/footer.html';
    