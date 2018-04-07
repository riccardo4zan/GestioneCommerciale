<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <meta charset="ISO-8859-15">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Riccardo Forzan">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <form class="form-signin" action="login.php" method="post">
                <center>
                    <br><h2 class="form-signin-heading">Login</h2><br>
                </center>
                <div class="form-group">
                    <input name="username" class="form-control" placeholder="Username" required autofocus><br>
                    <input type="Password" name="password" class="form-control" placeholder="Password" required><br>
                    <?php
                    session_start();
                    if (isset($_POST['username'], $_POST['password'])) {
                        //Acquisizione degli input
                        $uname = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
                        $psswd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                        //Connessione al DB
                        $ini = parse_ini_file('config/config.ini');
                        $conn = new mysqli($ini['db_serveradr'], $ini['db_username'], $ini['db_password'], $ini['db_name']);
                        if ($conn->connect_error) {
                            echo "<div class=\"alert alert-primary\" role=\"alert\"> Connessione fallita: . $conn->connect_error</div>";
                            die;
                        }
                        //Ottengo la password con hash presente nel database
                        $sql = "SELECT password FROM Utenti WHERE username='{$uname}'";
                        $res = $conn->query($sql)->fetch_assoc();
                        $psswdb = $res["password"];
                        //Valido la password
                        if (password_verify($psswd, $psswdb)) {
                            $_SESSION['username'] = $uname;
                            $_SESSION['password'] = $psswdb;
                            header("Location: index.php");
                            die();
                        } else {
                            echo "<div class=\"alert alert-danger\" role=\"alert\">Credenziali errate</div>";
                        }
                    }
                    ?>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Entra</button>
                </div>
            </form>
        </div>
    </body>
</html>
