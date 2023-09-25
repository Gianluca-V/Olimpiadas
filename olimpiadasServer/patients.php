<?php
switch ($request_method) {
    case 'GET':
        // Get all Patients or a specific Patient by ID
        if ($parts[4] !== "") {
            $patients_id = intval($parts[4]);
            getPatient($patients_id);
        } else {
            getPatients();
        }
        break;
    case 'POST':
        // Create a new Patient
        $data = json_decode(file_get_contents("php://input"));
        createPatient($data);
        break;
    case 'PUT':
        // Update a Patient by ID
        $data = json_decode(file_get_contents("php://input"));
        $patient_id = intval($parts[4]);
        updatePatient($patient_id, $data);
        break;
    case 'DELETE':
        // Delete a Patient by ID
        $patient_id = intval($parts[4]);
        deletePatient($patient_id);
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed"));
        break;
}

function getPatients()
{
    global $conn;
    $sql = "SELECT * FROM Patients";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $Patients = array();
        while ($row = $result->fetch_assoc()) {
            $Patients[] = $row;
        }
        echo json_encode($Patients);
    } else {
        echo json_encode(array());
    }
}

function getPatient($patient_id)
{
    global $conn;
    $sql = "SELECT * FROM Patients WHERE ID = $patient_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Patient not found"));
    }
}

function createPatient($data)
{
    global $conn;
    // Assuming $data contains the necessary fields for creating a Patient
    $FirstName = $conn->real_escape_string($data->FirstName);
    $LastName = $conn->real_escape_string($data->LastName);
    $DNI	 = intval($data->DNI);
    $Phone = $conn->real_escape_string($data->Phone);
    $Address = $conn->real_escape_string($data->Address);
    $BirthDate = $conn->real_escape_string($data->BirthDate);
    $Location = $conn->real_escape_string($data->Location);
    $Nurse = $conn->real_escape_string($data->Nurse);

    $sql = "INSERT INTO Patients (FirstName, LastName, DNI, Phone, Address, BirthDate, Location, Nurse) 
            VALUES ('$FirstName', $LastName, $DNI, '$Phone', '$Address', $BirthDate, '$Location', '$Nurse')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Patient created successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating Patient: " . $conn->error));
    }
}

function updatePatient($patient_id, $data)
{
    global $conn;
    $id = intval($patient_id);
    $FirstName = $conn->real_escape_string($data->FirstName);
    $LastName = $conn->real_escape_string($data->LastName);
    $DNI	 = intval($data->DNI);
    $Phone = $conn->real_escape_string($data->Phone);
    $Address = $conn->real_escape_string($data->Address);
    $BirthDate = $conn->real_escape_string($data->BirthDate);
    $Location = $conn->real_escape_string($data->Location);
    $Nurse = $conn->real_escape_string($data->Nurse);

    $sql = "INSERT INTO Patients (FirstName, LastName, DNI, Phone, Address, BirthDate, Location, Nurse) 
            VALUES ('$FirstName', '$LastName', $DNI, '$Phone', '$Address', '$BirthDate', $Location, $Nurse) WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Patient updated successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating Patient: " . $conn->error));
    }
}

function deletePatient($patient_id)
{
    global $conn;
    $id = intval($patient_id);
    $sql = "DELETE FROM Patients WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Patient deleted successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error deleting Patient: " . $conn->error));
    }
}


?>
