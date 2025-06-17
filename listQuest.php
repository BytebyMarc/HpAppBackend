<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// pages/list_questions.php
// Verbindung zur Datenbank herstellen (Konfigurationsdatei)
define('DB_HOST', 'localhost');
define('DB_USER', 'd0400a6b');
define('DB_PASS', 'GoZR6ywyZGi84oa4HdEQ');
define('DB_NAME', 'd0400a6b');

// MySQLi-Verbindung herstellen
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verbindungsfehler abfangen
if ($mysqli->connect_error) {
    die('Verbindung fehlgeschlagen (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
}

// Zeichensatz setzen
$mysqli->set_charset('utf8mb4');


// Abfrage aller Fragen
$sql = "SELECT ID_sim, activ, question, answer1, answer2, answer3, answer4, answer5, right1, month, year, Timestamp FROM p_simulator ORDER BY ID_sim ASC";
$result = $mysqli->query($sql);
?>

<h1>Liste aller Fragen</h1>
<table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse;">
    <thead>
    <tr>
        <th>ID</th>
        <th>Aktiv</th>
        <th>Frage</th>
        <th>Antworten</th>
        <th>Richtige Antwort</th>
        <th>Monat</th>
        <th>Jahr</th>
        <th>Erstellt am</th>
        <th>Aktionen</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['ID_sim']) ?></td>
                <td><?= $row['activ'] ? 'Ja' : 'Nein' ?></td>
                <td><?= nl2br(htmlspecialchars($row['question'])) ?></td>
                <td>
                    <?php
                    // Antworten anzeigen
                    $answers = [];
                    for ($i = 1; $i <= 5; $i++) {
                        if (!empty($row['answer'.$i])) {
                            $answers[] = htmlspecialchars($row['answer'.$i]);
                        }
                    }
                    echo implode('<br>', $answers);
                    ?>
                </td>
                <td><?= htmlspecialchars($row['right1']) ?></td>
                <td><?= htmlspecialchars($row['month']) ?></td>
                <td><?= htmlspecialchars($row['year']) ?></td>
                <td><?= htmlspecialchars($row['Timestamp']) ?></td>
                <td style="text-align:center;">
                    <!-- Edit- und Lösch-Symbole als Links -->
                    <a href="edit.php" title="Bearbeiten">bearbeiten</a>
                    &nbsp;
                    <a href="delet.php" title="Löschen" onclick="return confirm('Frage wirklich löschen?');">Löschen</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="9" style="text-align:center;">Keine Fragen gefunden.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
