<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prüfungs Simulator1</title>
  </head>
  <body>
<p>Bitte geben sie hier die neuen Prüfungsfragen ein!b</p>
<form method="post">
  <p>Frage: <textarea id="id_question" name="question" rows="25" cols="150"></textarea></p>
  <p>Antwort 1:<input type="text" name="answer1"><input type="checkbox" name="richtig1" value="1"></p>
  <p>Antwort 2:<input type="text" name="answer2"><input type="checkbox" name="richtig1" value="2"></p>
  <p>Antwort 3:<input type="text" name="answer3"><input type="checkbox" name="richtig1" value="3"></p>
  <p>Antwort 4:<input type="text" name="answer4"><input type="checkbox" name="richtig1" value="4"></p>
  <p>Antwort 5:<input type="text" name="answer5"><input type="checkbox" name="richtig1" value="5"></p>
  <p><select name="month" size="2" value="3">
      <option value="3">März</option>
      <option value="10">Oktoker</option>
    </select>
    <select name="year" size="22" value="2011"> 
     
      <option>2011</option>
      <option>2012</option>
      <option>2013</option>
      <option>2014</option>
      <option>2015</option>
      <option>2016</option>
      <option>2017</option>
      <option>2018</option>
      <option>2019</option>
      <option>2020</option>
      <option>2021</option>
      <option>2022</option>
      <option>2023</option>
      <option>2024</option>
    </select>
  
  </p>
  <p><input type="submit" name="Speichern"></p>
  <input type="hidden" name="senden" value="234">
</form>
  <?php

if($_POST["Speichern"] == true AND $_POST["question"] == true)
{


$question = $_POST["question"];
$answer1 = $_POST["answer1"];
$answer2 = $_POST["answer2"];
$answer3 = $_POST["answer3"];
$answer4 = $_POST["answer4"];
$answer5 = $_POST["answer5"];

$question_utf8 = mb_convert_encoding($question, 'UTF-8');

$answer1_utf8 = mb_convert_encoding($answer1, 'UTF-8');
$answer2_utf8 = mb_convert_encoding($answer2, 'UTF-8');
$answer3_utf8 = mb_convert_encoding($answer3, 'UTF-8');
$answer4_utf8 = mb_convert_encoding($answer4, 'UTF-8');
$answer5_utf8 = mb_convert_encoding($answer5, 'UTF-8');


$richtig1 = $_POST["richtig1"];


$month = $_POST["month"];
$year = $_POST["year"];

$true = true;

include("include/mysql.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO p_simulator (activ, question, answer1,answer2,answer3,answer4,answer5, right1, month, year)
VALUES ('$true', '$question_utf8', '$answer1_utf8', '$answer2_utf8', '$answer3_utf8', '$answer4_utf8', '$answer5_utf8', '$richtig1', '10', '2013')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
echo $sql;
$conn->close();

unset($question, $_POST["question"]); 
unset($answer1, $_POST["answer1"]);
unset($answer2, $_POST["answer2"]);
unset($answer3, $_POST["answer3"]);
unset($answer4, $_POST["answer4"]);
unset($answer5, $_POST["answer5"]);
unset($richtig1, $_POST["richtig1"]);


$month = $_POST["month"];
$year = $_POST["year"];

}

?>
  </body>
</html>