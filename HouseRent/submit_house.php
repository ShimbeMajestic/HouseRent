<?php
require 'db.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $price = $_POST['price'] ?? '';
    $image = $_FILES['image'];

    // Define the target directory for uploaded images (absolute path)
    $targetDir = __DIR__ . "/Images/"; // Uses the current directory's absolute path
    $targetFile = $targetDir . basename($image["name"]);

    // Ensure the directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory with write permissions
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($image["tmp_name"], $targetFile)) {
        // Prepare and execute the SQL statement
        $stmt = $pdo->prepare('INSERT INTO houses (name, description, location, price, image_url) VALUES (:name, :description, :location, :price, :image_url)');
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'location' => $location,
            'price' => $price,
            'image_url' => "Images/" . basename($image["name"]) // Save relative path in DB
        ]);

        // Prepare the success response
        $response = array("success" => true);
        echo json_encode($response);
        exit(); // Ensure the script stops here after sending the response
    } else {
        // Prepare the error response
        $response = array("success" => false, "message" => "Error uploading image.");
        echo json_encode($response);
    }
} else {
    // Prepare the error response for invalid request method
    $response = array("success" => false, "message" => "Invalid request method.");
    echo json_encode($response);
}
?>
