<?php
switch ($request_method) {
    case 'GET':
        // Get all Areas or a specific Area by ID
        if($parts[4] === "-v"){
            getAreasWithNurses();
        }
        else if ($parts[4] !== "") {
            $Areas_id = intval($parts[4]);
            getArea($Areas_id);
        }
        else {
            getAreas();
        }
        break;
    case 'POST':
        // Create a new Area
        $data = json_decode(file_get_contents("php://input"));
        createArea($data);
        break;
    case 'PUT':
        // Update a Area by ID
        $data = json_decode(file_get_contents("php://input"));
        $Area_id = intval($parts[4]);
        updateArea($Area_id, $data);
        break;
    case 'DELETE':
        // Delete a Area by ID
        $Area_id = intval($parts[4]);
        deleteArea($Area_id);
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed"));
        break;
}

function getAreas()
{
    global $conn;
    $sql = "SELECT * FROM Areas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $Areas = array();
        while ($row = $result->fetch_assoc()) {
            $Areas[] = $row;
        }
        echo json_encode($Areas);
    } else {
        echo json_encode(array());
    }
}

function getArea($Area_id)
{
    global $conn;
    $sql = "SELECT * FROM Areas WHERE ID = $Area_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Area not found"));
    }
}

function createArea($data)
{
    global $conn;
    // Assuming $data contains the necessary fields for creating a Area
    $Name = $conn->real_escape_string($data->Name);

    $sql = "INSERT INTO Areas (Name) 
            VALUES ('$Name')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Area created successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating Area: " . $conn->error));
    }
}

function updateArea($Area_id, $data)
{
    global $conn;
    $id = intval($Area_id);
    $Name = $conn->real_escape_string($data->Name);

    $sql = "INSERT INTO Areas (Name) 
            VALUES ('$Name') WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Area updated successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error creating Area: " . $conn->error));
    }
}

function deleteArea($Area_id)
{
    global $conn;
    $id = intval($Area_id);
    $sql = "DELETE FROM Areas WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Area deleted successfully"));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error deleting Area: " . $conn->error));
    }
}

function getAreasWithNurses()
{
    global $conn;
    
    $sql = "SELECT
                areas.Name AS AreaName,
                nurses.FirstName AS NurseFirstName,
                nurses.LastName AS NurseLastName
            FROM
                Areas
            LEFT JOIN
                Patients ON areas.ID = patients.Location
            LEFT JOIN
                Nurses ON patients.Nurse = nurses.ID
            ORDER BY
                areas.Name, nurses.FirstName, nurses.LastName";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $areasData = array();
        $currentArea = null;

        while ($row = $result->fetch_assoc()) {
            $areaName = $row['AreaName'];
            $nurseFirstName = $row['NurseFirstName'];
            $nurseLastName = $row['NurseLastName'];

            if ($currentArea === null || $currentArea['areaName'] !== $areaName) {
                if ($currentArea !== null) {
                    $areasData[] = $currentArea;
                }

                $currentArea = array(
                    'areaName' => $areaName,
                    'nurses' => array(),
                );
            }

            if ($nurseFirstName !== null && $nurseLastName !== null) {
                $currentArea['nurses'][] = array(
                    'name' => $nurseFirstName . ' ' . $nurseLastName,
                );
            }
        }

        if ($currentArea !== null) {
            $areasData[] = $currentArea;
        }

        echo json_encode($areasData);
    } else {
        echo json_encode(array());
    }
}


?>
