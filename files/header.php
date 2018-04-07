<?php
/**
 * Header HTML per la barra di navigazione
 * Crea la connessione con il DB
 * Funzione usata nella validazione dei campi
 */
if (!isset($_SESSION["username"], $_SESSION["password"])) {  
    header("Location: login.php");
    die();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $_SESSION["titolo"]?></title>
        <meta charset="ISO-8859-15">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Riccardo Forzan">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Gestione commerciale</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3" aria-controls="[collapsingNavbar3_navbar_collpase]" aria-expanded="false" aria-label="Toggle navigation"> 
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="collapsingNavbar3">
                <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <?php
        
        /**
         * Funzione che rimuove gli spazi bianchi multipli
         */
        function remove_multiple_spaces($string){
            return preg_replace('/\s+/', ' ', $string);
        }
        
        //Connessione al DB
        $ini = parse_ini_file('config/config.ini');
        $conn = new mysqli($ini['db_serveradr'], $ini['db_username'], $ini['db_password'], $ini['db_name']);
        if ($conn->connect_error) {
            echo "<div class=\"alert alert-primary\" role=\"alert\"> Connessione fallita: . $conn->connect_error</div>";
            die;
        }