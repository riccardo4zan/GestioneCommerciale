<?php
session_start();
$_SESSION["titolo"] = "Elimina ordine";
require_once 'files/header.php';
echo "<div class=\"container\">";
if (isset($_POST["id"])) {
    $id = remove_multiple_spaces(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING));
    if (ctype_digit($id)) {
        $sql = "DELETE FROM Ordini WHERE id = {$id}";
        $result = $conn->query($sql);
        if ($conn->error) {
            echo "<div class=\"alert alert-danger\" role=\"alert\"> Azione fallita: . $conn->error</div>";
            die;
        }
        ?>
        <div class="alert alert-danger" role="alert">Azione completata</div>
        <a class="btn btn-lg btn-success btn-block" href="mostraOrdini.php" role="button">Torna a tutti gli ordini</a>  
        <?php
    }
} else if (isset($_GET["id"])) {
    $id = remove_multiple_spaces(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING));
    if (ctype_digit($id)){
        ?>
        <h1>Procedere? Tutti i prodotti associati a questo ordine verranno elimiati. L'azione è irreversibile!</h1>       
        <form action="eliminaOrdine.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>" />
            <button class="btn btn-lg btn-danger btn-block" type="submit">Elimina</button>                 
        </form>
        <a class="btn btn-lg btn-success btn-block" href="mostraOrdini.php" role="button">Annulla e torna a tutti gli ordini</a>  
        <?php
    } else {
        echo "<div class=\"alert alert-primary\" role=\"alert\">Numero dell'ordine non valido</div>";
    }
} else {
    echo "<div class=\"alert alert-primary\" role=\"alert\">Errore</div>";
}
echo "</div>";
include 'files/footer.html';
