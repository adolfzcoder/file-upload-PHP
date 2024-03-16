<?php
// Include database connection
include 'db_conn.php';

function uploadFile($file, $name, $description, $marks) {
    $targetDir = "files/";

    // If no name is provided, extract the filename from the uploaded file
    if (empty($name)) {
        $name = pathinfo($file["name"], PATHINFO_FILENAME);
    }

    $targetFile = $targetDir . basename($file["name"]);

    global $mysqli;

    // Upload file
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // Insert file details into database
        $stmt = $mysqli->prepare("INSERT INTO documents (name, description, marks, file_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $name, $description, $marks, $targetFile);
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $mysqli->error;
            return false;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
        return false;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $marks = intval($_POST["marks"]);
    $file = $_FILES["file"];

    // Upload file and insert details into database
    if (uploadFile($file, $name, $description, $marks)) {
        echo "File uploaded successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 100px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #302f49;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include("navbar.php") ?>
    <div class="container">
        <h2>Upload Document</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" ><br>
            <input type="text" name="description" placeholder="Description" ><br>
            <input type="number" name="marks" placeholder="Marks" ><br>
            <input type="file" name="file" ><br>
            <input type="submit" value="Upload">
        </form>
    </div>
</body>
</html>
