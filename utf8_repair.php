
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prüfungs Simulator1</title>
  </head>
  <body>

  <?
if($_POST["Speichern"] == true AND $_POST["senden"] == 234)
{
$servername = "localhost";
$username = "d0400a6b";
$password = "WE4mnsk6fA5pr9HHchoV";
$dbname = "d0400a6b"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

    // Überprüfen, ob Formular abgeschickt wurde
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Abfrage vorbereiten
        $id_tab = $_POST["question"];
        $sql = "SELECT * FROM p_simulator WHERE ID_sim = $id_tab ";
        
        // Abfrage vorbereiten
        $result = $conn->query($sql);
        
        // Überprüfen, ob Benutzer gefunden wurde und Passwort korrekt ist
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
                // Anmeldedaten sind korrekt, Sessionvariablen setzen
                $question = $row["question"]; 
                $answer1 = $row["answer1"];
                $answer2 = $row["answer2"];
                $answer3 = $row["answer3"];
                $answer4 = $row["answer4"];
                $answer5 = $row["answer5"];
               // echo "Anmeldung erfolgreich.";
              // echo "<br>";
              // echo "<a href='".$_SERVER["PHP_SELF"]."'>Zum geschützten Bereich</a>";
        } 
        $conn->close();

        echo "<form method='post'>
        <p>Frage: <textarea id='id_question_utf8' name='question_utf8' rows='25' cols='150'>$question</textarea></p>
        <p>Antwort 1:<input type='text' name='answer1_utf8' value='$answer1'></p>
        <p>Antwort 2:<input type='text' name='answer2_utf8' value='$answer2'></p>
        <p>Antwort 3:<input type='text' name='answer3_utf8' value='$answer3'></p>
        <p>Antwort 4:<input type='text' name='answer4_utf8' value='$answer4'></p>
        <p>Antwort 5:<input type='text' name='answer5_utf8' value='$answer5'></p>
        
        
        </p>
        <p><input type='submit' name='Speichern_utf8'></p>
        <input type='hidden' id='id_question' name='question_utf8_ID' value='$id_tab'>
        <input type='hidden' name='senden_utf8' value='123'>
        </form>";

//#######################
//###########datenbank eintrag ändern

    }

}

if($_POST["Speichern_utf8"] == true ){

    echo "update erfolgt";

        $servername = "localhost";
        $username = "d0400a6b";
        $password = "WE4mnsk6fA5pr9HHchoV";
        $dbname = "d0400a6b"; 


        $id_tab_utf8 = $_POST["question_utf8_ID"];
        $conn_update = new mysqli($servername, $username, $password, $dbname);
        $conn_update->set_charset("utf8");

        // Check connection
        if ($conn_update->connect_error) {
          die("Connection failed: " . $conn_update->connect_error);
        }
        $question_post = $_POST["question_utf8"];
        $answer1_post= $_POST["answer1_utf8"];
        $answer2_post= $_POST["answer2_utf8"];
        $answer3_post= $_POST["answer3_utf8"];
        $answer4_post= $_POST["answer4_utf8"];
        $answer5_post= $_POST["answer5_utf8"];

        $question_utf8 = mb_convert_encoding($question_post, 'UTF-8');
        $answer1_utf8 = mb_convert_encoding($answer1_post, 'UTF-8');
        $answer2_utf8 = mb_convert_encoding($answer2_post, 'UTF-8');
        $answer3_utf8 = mb_convert_encoding($answer3_post, 'UTF-8');
        $answer4_utf8 = mb_convert_encoding($answer4_post, 'UTF-8');
        $answer5_utf8 = mb_convert_encoding($answer5_post, 'UTF-8');


        $sql_update = "UPDATE p_simulator SET question='$question_utf8', answer1='$answer1_utf8', answer2='$answer2_utf8', answer3='$answer3_utf8', answer4='$answer4_utf8', answer5='$answer5_utf8' WHERE ID_sim='$id_tab_utf8' ";
            echo $sql_update;    
    if ($conn_update->query($sql_update) === TRUE) {
          echo "New record created successfully";
        }
          $conn_update->close();
    }
?>



<p>Bitte ID eingeben</p>
<form method="post">
  <p>ID <input type="text" id="id_question" name="question"></p>
<?
echo "<p>$question </p>";
echo "<p>$answer1 </p>";
echo "<p>$answer2 </p>";
echo "<p>$answer3 </p>";
echo "<p>$answer4 </p>";
echo "<p>$answer5 </p>";



?>
  <p><input type="submit" name="Speichern"></p>
  <input type="hidden" name="senden" value="234">
</form>
</body>
</html>