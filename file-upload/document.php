<?php
include 'db_conn.php';

// Check if document ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Document ID is missing.";
    exit();
}

// Retrieve document details from the database
$id = $_GET['id'];
$stmt = $mysqli->prepare("SELECT name, description, file_path FROM documents WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// check if document exists
if ($result->num_rows === 0) {
    echo "Document not found.";
    exit();
}

$document = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $document['name'] ?></title>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            margin-top: 0;
        }
        p {
            margin-bottom: 20px;
        }
        a {
            color: #302f49;
            
        }
    </style>
</head>
<body>
    <?php include("navbar.php");?>
    <div class="container">
        <h2><?= $document['name'] ?></h2>
        <p><strong>Description:</strong> <?= $document['description'] ?></p>
        <p><strong>Download:</strong> <a style="text-decoration: none;
            font-weight: bold;" href="<?= $document['file_path'] ?>" target="_blank"><?= $document['file_path'] ?></a></p>
        <p><a href="home.php">Back to Home</a></p>
    </div>
</body>
</html>
