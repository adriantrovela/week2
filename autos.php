<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<title>Adrian Trovela's Autos Page</title>
</head>
<body>
    <div class="container">
    <?php
        require_once "pdo.php";
        if (isset($_GET['name'])) {
            echo "<h1>Tracking Autos for ".$_GET['name']."</h1>";
        } else {
            die("Name parameter missing");
        }
        if(isset($_POST['logout'])) {
            header('Location: index.php');
        } else {
         
            if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {

                if ($_POST['make'] == "") {
                    echo "<p style='color: red'>Make is required</p>";
                } elseif (is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
                        $stmt = $pdo->prepare('INSERT INTO autos
                            (make, year, mileage) VALUES ( :mk, :yr, :mi)');
                            
                        $stmt->execute(array(
                            ':mk' => $_POST['make'],
                            ':yr' => $_POST['year'],
                            ':mi' => $_POST['mileage'])
                        );

                        echo "<p style='color: green'>Record inserted</p>";
                } else {
                    echo "<p style='color: red'>Mileage and year must be numeric</p>";   
                }
            }   
        }
    ?>
    <form method="post">
        <p>Make:
            <input name="make">
        </p>
        <p>Year:
            <input size="40" name="year">
        </p>
        <p>Mileage:
            <input size="40" name="mileage">
        </p>
        <p>
            <input type="submit" value="Add" name="Add" />
            <input type="submit" value="logout" name="logout" />
        </p>
    </form>
    <h2>Automobiles</h2>
    <ul>
        <?php
            
            $statement = $pdo->query("SELECT auto_id, make, year, mileage FROM autos");
            
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<li> ";
                echo $row['year']." ";
                echo htmlentities($row['make'])." / ";
                echo $row['mileage'];
                echo "</li>";
            }
        ?>
    </ul>
    </div>
</body>
</html>