<?php
session_start();
$_SESSION["titolo"] = "Index";
require_once 'files/header.php';
?>
<div class="container">
    <center>
        <br>
        <font color="#33cc33"><h1>Benvenuto <?= $_SESSION["username"] ?></h1></font>
        <br>
        <a class="btn btn-lg btn-success" style="width:50%;" href="nuovoCliente.php" role="button">Aggiugi un nuovo cliente</a>
        <br><br>
        <a class="btn btn-lg btn-success" style="width:50%;" href="nuovoProdotto.php" role="button">Aggiugi un nuovo prodotto</a>
        <br><br>
        <a class="btn btn-lg btn-success" style="width:50%;" href="nuovoOrdine.php" role="button">Aggiugi un nuovo ordine</a> 
        <br><br>
        <a class="btn btn-lg btn-info" style="width:50%;" href="mostraClienti.php" role="button">Mostra clienti</a>
        <br><br>
        <a class="btn btn-lg btn-info" style="width:50%;" href="mostraProdotti.php" role="button">Mostra prodotti</a>
        <br><br>
        <a class="btn btn-lg btn-info" style="width:50%;" href="mostraOrdini.php" role="button">Mostra ordini</a>
        <br><br>
        <a class="btn btn-lg btn-warning" style="width:50%;" href="modificaPassword.php" role="button">Modifica password</a>
        <?php
        if (strcmp($_SESSION['username'],"Administrator")===0) {
            ?>
            <div>
                <br>
                <h1>Gestisci gli utenti</h1>
                <br>
                <a class="btn btn-lg btn-primary" style="width:50%;" href="registraUtente.php" role="button">Registra nuovo utente</a>
                <br>
                <br>
                <a class="btn btn-lg btn-primary" style="width:50%;" href="eliminaUtenti.php" role="button">Elimina utenti</a>
            </div>
            <?php
        }
        ?>
    </center>
    <div>        
        <?php
        include 'files/footer.php';
        