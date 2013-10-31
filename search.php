<html>
<head>
<Title>Search</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<h1>Search</h1>
<p>Enter a name to search</p>
<form method="post" action="search.php" enctype="multipart/form-data" >
      Search  <input type="text" name="search" id="search"/></br>
      <input type="submit" name="submit" value="Submit" />
</form>
<?php
    // DB connection info
    $host = "eu-cdbr-azure-west-b.cloudapp.net";
    $user = "b36fc1a8a79d0d";
    $pwd = "7eea1a8b";
    $db = "firstAppDB";
    // Connect to database.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    // Return search results
    if(!empty($_POST)) {

        $search = $_POST['search'];
        $sql_select = "SELECT * FROM registration_tbl WHERE name LIKE ?";
        //$stmt = $conn->query($sql_select);
        $stmt = $conn->prepare($sql_select);
        $stmt->bindValue(1, '%'.$search.'%');

        $stmt->execute();

        $registrants = $stmt->fetchAll(); 
        if(count($registrants) > 0) {
            echo "<h2>People who are registered:</h2>";
            echo "<table>";
            echo "<tr><th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>Company</th>";
            echo "<th>Date</th></tr>";
            foreach($registrants as $registrant) {
                echo "<tr><td>".$registrant['name']."</td>";
                echo "<td>".$registrant['email']."</td>";
                echo "<td>".$registrant['company_name']."</td>";
                echo "<td>".$registrant['date']."</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<h3>No hits found.</h3>";
        }
    }
?>
</body>
</html>
