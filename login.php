<!DOCTYPE html>
<html>
<head>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<title>Adrian Trovela's Login Page</title>
</head>
<body>
<div class="container">
<?php
        require_once "pdo.php";

        if ( isset($_POST['who']) && isset($_POST['pass'])  ) {

            if($_POST['who'] == "" || $_POST['pass'] == "") {
                echo '<p style="color: red">User name and password are required</p>';   
            } elseif (strpos($_POST['who'], '@') == false) {
                    echo '<p style="color: red">Email must have an at-sign (@)</p>';  
            } else {
                $sql = "SELECT name FROM users 
                WHERE email = :em AND password = :pw";

                $stmt = $pdo->prepare($sql);
                
                $stmt->execute(array(
                    ':em' => $_POST['who'], 
                    ':pw' => $_POST['pass']));
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

         
                
                if ( $row === FALSE ) {
                    $hash = hash('sha256', $_POST['pass']);
                    error_log("Login fail ".$_POST['who']." $hash");
                    echo "<p style='color: red'>Incorrect password</p>";
                } else { 
                    error_log("Login success ".$_POST['who']);
                    echo "<p>Login success.</p>\n";
                    header("Location: autos.php?name=".urlencode($_POST['who']));
                }
            }
        }
    ?>
<h1>Please Log In</h1>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the three character name of the 
programming language used in this class (all lower case) 
followed by 123. -->
</p>
</div>
</body>

  