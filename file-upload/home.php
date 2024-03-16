<?php
// Include database connection
include 'db_conn.php';

//function to handle file upload
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

//check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $marks = intval($_POST["marks"]);
    $file = $_FILES["file"];

    //upload file and insert details into database
    if (uploadFile($file, $name, $description, $marks)) {
        echo "File uploaded successfully.";
    }
}

// Function to search for files
function searchFiles($query) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, name FROM documents WHERE name LIKE ?");
    $searchQuery = "%" . $query . "%";
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Check if search query is submitted
if (isset($_GET["q"])) {
    $query = $_GET["q"];
    $files = searchFiles($query);
}

// function to retrieve all uploaded files
function getAllFiles() {
    global $mysqli;
    $result = $mysqli->query("SELECT id, name FROM documents");
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Upload</title>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 100px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 16px;
            text-align: left;
        }
        th {
            background-color: #302f49;
            color: #fff;
        }
        a {
            color: #302f49;
            text-decoration: none;
        }
    </style>
</head>
<body>
    
    <?php include("navbar.php");?>
    <div class="container">
        

        <h2>Search Documents</h2>
        <form method="get" action="">
            <input type="text" name="q" placeholder="Search...">
            <input type="submit" value="Search">
        </form>

        <?php if (isset($files) && !empty($files)) : ?>
            <h2>Search Results</h2>
            <table>
                <tr>
                    <th>Name</th>
                </tr>
                <?php foreach ($files as $file) : ?>
                    <tr>
                        <td><a href="document.php?id=<?= $file['id'] ?>"><?= $file['name'] ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <h2>All Uploaded Files</h2>
        <table>
            <tr>
                <th>Name</th>
            </tr>
            <?php $allFiles = getAllFiles(); ?>
            <?php foreach ($allFiles as $file) : ?>
                <tr>
                    <td><a href="document.php?id=<?= $file['id'] ?>"><?= $file['name'] ?></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
