<?php
switch ($request_method) {
    case 'GET':
        // Get all Calls or a specific Call by ID
        if ($parts[4] !== "") {
            $Calls_id = intval($parts[4]);
            getCall($Calls_id);
        } else {
            getCalls();
        }
        break;
    case 'POST':
        // Create a new Call
        $data = json_decode(file_get_contents("php://input"));
        createCall($data);
        break;
    case 'PUT':
        // Update a Call by ID
        $data = json_decode(file_get_contents("php://input"));
        $Call_id = intval($parts[4]);
        updateCall($Call_id, $data);
        break;
    case 'DELETE':
        // Delete a Call by ID
        $Call_id = intval($parts[4]);
        deleteCall($Call_id);
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed"));
        break;
}

function getCalls()
{
    global $conn;
    $sql = "SELECT * FROM Calls";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $Calls = array();
        while ($row = $result->fetch_assoc()) {
            $Calls[] = $row;
        }
        echo json_encode($Calls);
    } else {
        echo json_encode(array());
    }
}

function getCall($Call_id)
{
    global $conn;
    $sql = "SELECT * FROM Calls WHERE ID = $Call_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Call not found"));
    }
}

function createCall($data)
{
    global $conn;
    // Assuming $data contains the necessary fields for creating a Call
    $Type = $conn->real_escape_string($data->Type);
    $ResponseTime = floatval($data->ResponseTime);
    $Attended = intval($data->Attended);

    $sql = "INSERT INTO Calls (Type, ResponseTime, Attended) 
            VALUES ('$Type', $ResponseTime, $Attended)";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Call created successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating Call: " . $conn->error));
    }
}

function updateCall($Call_id, $data)
{
    global $conn;
    $id = intval($Call_id);
    $Type = $conn->real_escape_string($data->Type);
    $ResponseTime = floatval($data->ResponseTime);
    $Attended = intval($data->Attended);

    $sql = "INSERT INTO Calls (Type, ResponseTime, Attended) 
            VALUES ('$Type', $ResponseTime, $Attended) WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Call updated successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating Call: " . $conn->error));
    }
}

function deleteCall($Call_id)
{
    global $conn;
    $id = intval($Call_id);
    $sql = "DELETE FROM Calls WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Call deleted successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error deleting Call: " . $conn->error));
    }
}


?>
