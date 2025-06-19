<?php
// newQuest.php - Seite zum Hinzufügen neuer Prüfungsfragen mit Monat, Jahr und Mehrfachauswahl

// Fehleranzeige für Entwicklung
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Datenbankkonfiguration
$dbHost = 'localhost';
$dbName = 'd0400a6b';
$dbUser = 'd0400a6b';
$dbPass = 'GoZR6ywyZGi84oa4HdEQ';

// Verbindung aufbauen
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die('Verbindungsfehler (' . $conn->connect_errno . '): ' . $conn->connect_error);
}
// Zeichensatz auf UTF8MB4 setzen, damit Umlaute richtig gespeichert werden
if (! $conn->set_charset('utf8mb4')) {
    error_log('Fehler beim Setzen des Charsets: ' . $conn->error);
}

$errors = [];
$added  = isset($_GET['added']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Frage, Monat, Jahr einlesen
    $question = trim($_POST['question'] ?? '');
    $month    = trim($_POST['month']    ?? '');
    $year     = trim($_POST['year']     ?? '');

    // 2. Antworten per Textarea einlesen und splitten
    $raw   = trim($_POST['answers'] ?? '');
    $lines = preg_split('/\r\n|\r|\n/', $raw, -1, PREG_SPLIT_NO_EMPTY);

    // 3. Präfix A)–E) entfernen (Groß-/Kleinschreibung, normale und geschützte Leerzeichen)
    $cleaned = array_map(function($line) {
        return trim(
            preg_replace(
                '/^\s*[A-E]\)[\s\x{00A0}]*/iu',
                '',
                $line
            )
        );
    }, $lines);

    // 4. Mindestens 5 Antworten erforderlich
    if (count($cleaned) < 5) {
        $errors[] = 'Bitte gib fünf Antworten, jeweils in einer eigenen Zeile, ein.';
    }

    // 5. Exakt 5 Antworten verwenden, Überschuss ignorieren, ggf. auffüllen
    $answers = array_slice($cleaned, 0, 5);
    for ($i = count($answers); $i < 5; $i++) {
        $answers[] = '';
    }

    // 6. Richtige Antworten einlesen
    $correct = $_POST['correct'] ?? [];
    $correctText = '';
    foreach ($correct as $c) {
        $correctText .= $c;
    }

    // === Validierung ===
    if (empty($question)) {
        $errors[] = 'Bitte geben Sie eine Frage ein.';
    }
    foreach ($answers as $idx => $ans) {
        if ($ans === '') {
            $errors[] = 'Antwort ' . ($idx + 1) . ' darf nicht leer sein.';
        }
    }
    if (!is_array($correct) || count($correct) < 1) {
        $errors[] = 'Bitte wählen Sie mindestens eine richtige Antwort aus.';
    } else {
        foreach ($correct as $c) {
            if (!in_array($c, ['1','2','3','4','5'], true)) {
                $errors[] = 'Ungültige Auswahl bei den richtigen Antworten.';
                break;
            }
        }
    }

    // === Speichern, wenn alles valid ist ===
    if (empty($errors)) {
        $stmt = $conn->prepare(
            'INSERT INTO p_simulator 
             (question, month, year, answer1, answer2, answer3, answer4, answer5, right1, activ)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $m = 10;
        $y = 2021;
        $correctCsv = (int)$correctText; // z.B. "13" => 13
        $activ = 1;

        $stmt->bind_param(
            'siissssssi',
            $question,
            $m,
            $y,
            $answers[0],
            $answers[1],
            $answers[2],
            $answers[3],
            $answers[4],
            $correctCsv,
            $activ
        );

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header('Location: ' . $_SERVER['PHP_SELF'] . '?added=1');
            exit;
        } else {
            $errors[] = 'Fehler beim Speichern: ' . $stmt->error;
            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neue Frage hinzufügen</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #2c3e50; color: #ecf0f1; padding-top: 20px; box-sizing: border-box; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li a { display: block; padding: 12px 20px; color: inherit; text-decoration: none; }
        .sidebar ul li a:hover { background-color: #34495e; }
        .content { flex-grow: 1; padding: 40px; background-color: #ecf0f1; box-sizing: border-box; }
        .content h1 { margin-top: 0; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; }
        .form-group input[type="text"], .form-group textarea, .form-group input[type="number"] { width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; font-size: 1rem; }
        .form-group .small-input { width: 100px; display: inline-block; margin-right: 10px; }
        .form-actions { text-align: right; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; background-color: #2980b9; color: #fff; font-size: 1rem; cursor: pointer; }
        .btn:hover { background-color: #3498db; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-error { background-color: #e74c3c; color: #fff; }
        .alert-success { background-color: #2ecc71; color: #fff; }
    </style>
</head>
<body>
<nav class="sidebar">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="cat.php">Kategorien bearbeiten</a></li>
        <li><a href="catedit.php">Kategorien zuweisen</a></li>
        <li><a href="newQuest.php">Neue Fragen hinzufügen</a></li>
        <li><a href="listQuest.php">Liste aller Fragen</a></li>
    </ul>
</nav>
<div class="content">
    <h1>Neue Prüfungsfrage hinzufügen</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($added): ?>
        <div class="alert alert-success">
            Die Frage wurde erfolgreich gespeichert.
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="question">Frage</label>
            <textarea id="question" name="question" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label>Monat und Jahr der Frage</label>
            <input type="number" name="month" class="small-input" min="1" max="12" placeholder="MM">
            <input type="number" name="year" class="small-input" min="1900" max="<?= date('Y') ?>" placeholder="YYYY">
        </div>

        <div class="form-group">
            <label for="answers">Antworten (je eine pro Zeile)</label>
            <textarea id="answers" name="answers" rows="5" placeholder="A) Erste Antwort&#10;B) Zweite Antwort&#10;…"></textarea>
        </div>

        <div class="form-group">
            <label>Richtige Antworten (Mehrfachauswahl)</label>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <label>
                    <input type="checkbox" name="correct[]" value="<?= $i ?>"> Antwort <?= $i ?>
                </label>
            <?php endfor; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Speichern</button>
        </div>
    </form>
</div>
</body>
</html>
