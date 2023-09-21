<?php
switch ($request_method) {
    case 'GET':
        // Get all Users or a specific User by ID
        if ($parts[4] !== "") {
            $Users_id = intval($parts[4]);
            getUser($Users_id);
        } else {
            getUsers();
        }
        break;
    case 'POST':
        // Create a new User
        $data = json_decode(file_get_contents("php://input"));
        createUser($data);
        break;
    case 'PUT':
        // Update a User by ID
        $data = json_decode(file_get_contents("php://input"));
        $User_id = intval($_GET['id']);
        updateUser($User_id, $data);
        break;
    case 'DELETE':
        // Delete a User by ID
        $User_id = intval($_GET['id']);
        deleteUser($User_id);
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed"));
        break;
}

function getUsers()
{
    global $conn;
    $sql = "SELECT * FROM Users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $Users = array();
        while ($row = $result->fetch_assoc()) {
            $Users[] = $row;
        }
        echo json_encode($Users);
    } else {
        echo json_encode(array());
    }
}

function getUser($User_id)
{
    global $conn;
    $sql = "SELECT * FROM Users WHERE ID = $User_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "User not found"));
    }
}

function createUser($data)
{
    global $conn;
    // Assuming $data contains the necessary fields for creating a User
    $UserName = $conn->real_escape_string($data->UserName);
    $Password = floatval($data->Password);

    $sql = "INSERT INTO Users (UserName, Password) 
            VALUES ('$UserName', '$Password')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "User created successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating User: " . $conn->error));
    }
}

function updateUser($User_id, $data)
{
    global $conn;
    $id = intval($User_id);
    $UserName = $conn->real_escape_string($data->UserName);
    $Password = floatval($data->Password);

    $sql = "INSERT INTO Users (UserName, Password) 
            VALUES ('$UserName', '$Password') WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "User updated successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating User: " . $conn->error));
    }
}

function deleteUser($User_id)
{
    global $conn;
    $id = intval($User_id);
    $sql = "DELETE FROM Users WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "User deleted successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error deleting User: " . $conn->error));
    }
}
?>
