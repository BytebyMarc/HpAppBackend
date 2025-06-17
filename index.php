<?php
// index.php - Haupt-Einstiegspunkt für das Admin-Backend
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Backend</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding-top: 20px;
            box-sizing: border-box;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar li {
            padding: 15px 20px;
        }
        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .main {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
        }
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
        <!-- Weitere Links hier -->
    </ul>
</nav>
</body>
</html>
