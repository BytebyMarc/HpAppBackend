<?php
// pages/edit_categories.php
// Fehler-Reporting aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verbindung zur Datenbank herstellen
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


// Verarbeitung des Formulars zum Hinzufügen einer Kategorie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_name'])) {
    $name = $mysqli->real_escape_string(trim($_POST['category_name']));
    if ($name !== '') {
        $sql_insert = "INSERT INTO categories (name) VALUES ('$name')";
        $mysqli->query($sql_insert);
    }
    header('Location: ?page=edit_categories');
    exit;
}

// Abfrage aller Kategorien
$sql = "SELECT id, name FROM categories ORDER BY id ASC";
$result = $mysqli->query($sql);
?>

<h1>Kategorien bearbeiten</h1>

<!-- Formular zum Hinzufügen -->
<form method="post" action="?page=edit_categories">
    <label for="category_name">Neue Kategorie:</label>
    <input type="text" id="category_name" name="category_name" required>
    <button type="submit">Hinzufügen</button>
</form>

<!-- Liste aller Kategorien -->
<table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse; margin-top:20px;">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Aktionen</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td style="text-align:center;">
                    <a href="?page=assign_categories&edit_id=<?= $row['id'] ?>" title="Bearbeiten">✏️</a>
                    &nbsp;
                    <a href="?page=delete_category&id=<?= $row['id'] ?>" title="Löschen" onclick="return confirm('Kategorie wirklich löschen?');">🗑️</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="3" style="text-align:center;">Keine Kategorien vorhanden.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
