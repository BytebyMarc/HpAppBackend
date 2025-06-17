<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prüfungs Simulator1</title>
  </head>
  <body>
<p>Bitte geben sie hier die neuen Prüfungsfragen ein!b</p>

<? 
if(!isset($_POST["senden"]))
{
echo "<form method='post'>

<p>Fremdwort: <input type='text' name='lexikon' size='50' required ></p>

<p>Frage: <textarea id='id_question' name='contend' rows='25' cols='150'></textarea></p>

</p>
<p><input type='submit' name='Speichern'></p>
<input type='hidden' name='senden' value='234'>
</form>

<form method='post'>
<p>ID <input type='text' name='id_lexikon'></p>
<input type='hidden' name='senden' value='321'>
<p><input type='submit' name='Speichern'></p>

</form>"; 
}



?>


  <?php

if(isset($_POST["senden"]) && $_POST["senden"] == 321)
{

  echo "update eintrag";

  $id_lex = $_POST["id_lexikon"];

  echo $id_lex;

  include("include/mysql.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

  $sql = "SELECT * FROM lexikon_hppsy WHERE Id_lexikon = $id_lex ";
  
  // Abfrage vorbereiten
  $result = $conn->query($sql);
  
  // Überprüfen, ob Benutzer gefunden wurde und Passwort korrekt ist
  if($result->num_rows == 1){
      $row = $result->fetch_assoc();
          // Anmeldedaten sind korrekt, Sessionvariablen setzen
          $lexikon_ok = $row["lexikon"]; 
          $contend_ok = $row["contend"]; 
          echo "Anmeldung erfolgreich.";
        // echo "<br>";
        // echo "<a href='".$_SERVER["PHP_SELF"]."'>Zum geschützten Bereich</a>";
  } 
  $conn->close();


 echo "<form method='post'>

 <p>Fremdwort: <input type='text' name='lexikon_update' size='50' value='$lexikon_ok' required ></p>

 <p>Frage: <textarea id='id_question' name='contend_update' rows='25' cols='150'>$contend_ok</textarea></p>
 <input type='hidden' name='id_lexikon' value='$id_lex'>
 </p>
 <p><input type='submit' name='Speichern'></p>
 <input type='hidden' name='senden' value='999'>
</form>";


}




// update vorhandene id
if(isset($_POST["Speichern"]) && $_POST["senden"] == 999){
$servername = "localhost";
$username = "d0400a6b";
$password = "WE4mnsk6fA5pr9HHchoV";
$dbname = "d0400a6b"; 

$id_lex = $_POST["id_lexikon"];

$lexikon_update = $_POST["lexikon_update"];
$contend_update = $_POST["contend_update"];

$lexikon_update_utf8 = mb_convert_encoding($lexikon_update, 'UTF-8');
$contend_update_utf8 = mb_convert_encoding($contend_update, 'UTF-8');


$conn_update = new mysqli($servername, $username, $password, $dbname);
$conn_update->set_charset("utf8");

// Check connection
if ($conn_update->connect_error) {
  die("Connection failed: " . $conn_update->connect_error);
}

$sql_update = "UPDATE lexikon_hppsy SET lexikon='$lexikon_update_utf8', contend='$contend_update_utf8' WHERE Id_lexikon='$id_lex' ";
    echo $sql_update;    
if ($conn_update->query($sql_update) === TRUE) {
  echo "New record created successfully";
}
  $conn_update->close();



}






if(isset($_POST["Speichern"]) && $_POST["senden"] == 234)
{

echo "neues eintrag";
$lexikon = $_POST["lexikon"];
$contend = $_POST["contend"];

$lexikon_utf8 = mb_convert_encoding($lexikon, 'UTF-8');
$contend_utf8 = mb_convert_encoding($contend, 'UTF-8');



echo $lexikon_utf8;
include("include/mysql.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO lexikon_hppsy (lexikon, contend) VALUES ('$lexikon_utf8', $contend)";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
echo $sql;
$conn->close();

unset($lexikon); 
unset($contend);
unset($lexikon_utf8);
unset($contend_utf8);
unset($_POST["lexikon"]);
unset($_POST["contend"]);


}

?>
  </body>
</html>