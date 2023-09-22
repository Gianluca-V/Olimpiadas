<?php
switch ($request_method) {
    case 'GET':
        // Get all Nurses or a specific Nurse by ID
        if ($parts[4] !== "") {
            $Nurses_id = intval($parts[4]);
            getNurse($Nurses_id);
        } else {
            getNurses();
        }
        break;
    case 'POST':
        // Create a new Nurse
        $data = json_decode(file_get_contents("php://input"));
        createNurse($data);
        break;
    case 'PUT':
        // Update a Nurse by ID
        $data = json_decode(file_get_contents("php://input"));
        $Nurse_id = intval($_GET['id']);
        updateNurse($Nurse_id, $data);
        break;
    case 'DELETE':
        // Delete a Nurse by ID
        $Nurse_id = intval($_GET['id']);
        deleteNurse($Nurse_id);
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed"));
        break;
}

function getNurses()
{
    global $conn;
    $sql = "SELECT * FROM Nurses";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $Nurses = array();
        while ($row = $result->fetch_assoc()) {
            $Nurses[] = $row;
        }
        echo json_encode($Nurses);
    } else {
        echo json_encode(array());
    }
}

function getNurse($Nurse_id)
{
    global $conn;
    $sql = "SELECT * FROM Nurses WHERE ID = $Nurse_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Nurse not found"));
    }
}

function createNurse($data)
{
    global $conn;
    // Assuming $data contains the necessary fields for creating a Nurse
    $FirstName = $conn->real_escape_string($data->FirstName);
    $LastName = floatval($data->LastName);
    $DNI	 = intval($data->DNI);
    $Phone = $conn->real_escape_string($data->Phone);
    $Address = $conn->real_escape_string($data->Address);

    $sql = "INSERT INTO Nurses (FirstName, LastName, DNI, Phone, Address) 
            VALUES ('$FirstName', $LastName, $DNI, '$Phone', '$Address')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Nurse created successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating Nurse: " . $conn->error));
    }
}

function updateNurse($Nurse_id, $data)
{
    global $conn;
    $id = intval($Nurse_id);
    $FirstName = $conn->real_escape_string($data->FirstName);
    $LastName = floatval($data->LastName);
    $DNI = intval($data->DNI);
    $Phone = $conn->real_escape_string($data->Phone);
    $Address = $conn->real_escape_string($data->Address);

    $sql = "INSERT INTO Nurses (FirstName, LastName, DNI, Phone, Address) 
            VALUES ('$FirstName', '$LastName', $DNI, '$Phone', '$Address') WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Nurse updated successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating Nurse: " . $conn->error));
    }
}

function deleteNurse($Nurse_id)
{
    global $conn;
    $id = intval($Nurse_id);
    $sql = "DELETE FROM Nurses WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Nurse deleted successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error deleting Nurse: " . $conn->error));
    }
}


?>
