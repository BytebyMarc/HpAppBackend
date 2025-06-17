<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prüfungs Simulator</title>
</head>




<body>
  <p>Liste der Prüfungsfragen</p>
  <?php

  include("include/mysql.php");

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT ID_sim, question, answer2 FROM p_simulator";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      echo "ID: " . $row["ID_sim"] . " - Frage: " . $row["question"] . " <br>";
    }
  } else {
    echo "0 results";
  }
  $conn->close();
  ?>

</body>

</html>