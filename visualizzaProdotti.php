<?php
session_start();
$_SESSION["titolo"] = "Visualizza prodotti";
require_once 'files/header.php';
echo "<div class=\"container\">";

if (isset($_GET["nord"])) {
    $nord = remove_multiple_spaces(filter_input(INPUT_GET, 'nord', FILTER_SANITIZE_STRING));
    if (ctype_digit($nord)) {
        $sql = "SELECT codprod,nome,prezzo,qta FROM OrdineNomeProdottiPrezzo WHERE nord = {$nord}";
        $result = $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-primary\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        echo "<br><a class=\"btn btn-lg btn-success btn-block\" href=\"aggiungiProdotti.php?id={$nord}\" role=\"button\">Aggiungi prodotti</a>";
        if ($result->num_rows > 0) {
            ?> 
            <table class="table">
                <thead>
                    <tr>
                        <th>Codice</th>
                        <th>Nome</th>
                        <th>Prezzo unitario</th>
                        <th>Quantità</th>
                        <th>Prezzo totale</th>
                        <th>Modifica quantità</th>
                        <th>Elimina</th>
                    </tr>
                </thead>
                <?php
                //Contatore dove salverò il prezzo totale dell'ordine
                $costoTOT = 0;
                while ($row = $result->fetch_assoc()) {
                    $p = $row[prezzo];
                    $q = $row[qta];
                    $pt = $p*$q;
                    $costoTOT += $pt;
                    echo "<tr><td>{$row[codprod]}</td><td>{$row[nome]}</td><td>{$p}</td><td>{$q}</td><td>{$pt}</td>"
                    . "<td><a class=\"btn btn-primary\" href=\"modificaQta.php?codice={$row[codprod]}&nord={$nord}\" role=\"button\">Modifica quantità</a></td>"
                    . "<td><a class=\"btn btn-danger\" href=\"eliminaProdottoDO.php?codice={$row[codprod]}&nord={$nord}\" role=\"button\">Elimina</a></td>";
                }
                echo "</table>";
                echo "<div><h3>Totale: $costoTOT</h3></div>";
            } else {
                echo "<br><div class=\"alert alert-primary\" role=\"alert\">Aggiungere almeno un prodotto</div>";
                echo "<a class=\"btn btn-lg btn-primary btn-block\" href=\"index.php\" role=\"button\">Torna alla home</a>";
            }
        } else {
            echo "<div class=\"alert alert-danger\" role=\"alert\">Numero dell'ordine non valido</div>";
        }
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Inserire un numero per l'ordine</div>";
    }
    echo "</div>";
    include 'files/footer.html';


    