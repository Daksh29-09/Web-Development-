<?php
// Path to the users JSON file
$jsonFile = 'users.json';

// Get the input data from the JSON request
$data = json_decode(file_get_contents("php://input"), true);

// Check if data is correctly retrieved
if (!$data || !isset($data['username']) || !isset($data['newPassword'])) {
    echo json_encode(["success" => false, "message" => "Invalid input data."]);
    exit;
}

$username = $data['username'];
$newPassword = $data['newPassword'];

// Check if users.json exists and read it
if (file_exists($jsonFile)) {
    $users = json_decode(file_get_contents($jsonFile), true);

    // Check for JSON decoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["success" => false, "message" => "Error reading user database."]);
        exit;
    }

    // Check if the user exists in the JSON
    if (isset($users[$username])) {
        // Update the user's password
        $users[$username]['password'] = $newPassword;

        // Save the updated data back to users.json
        if (file_put_contents($jsonFile, json_encode($users, JSON_PRETTY_PRINT))) {
            // Send a success response
            echo json_encode(["success" => true, "message" => "Password updated successfully!"]);
        } else {
            // Error saving file
            echo json_encode(["success" => false, "message" => "Error saving updated password to file."]);
        }
    } else {
        // Send an error response if the user does not exist
        echo json_encode(["success" => false, "message" => "Error: User does not exist!"]);
    }
} else {
    // Send an error response if users.json is missing
    echo json_encode(["success" => false, "message" => "Error: User database not found."]);
}
?>
