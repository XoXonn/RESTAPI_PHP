<?php
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('function.php');
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "GET") {


    if (isset($_GET["id"])) {
        $taskList = getTask($_GET);
        echo $taskList;

    } else {
        $taskList = getTaskList();
        echo $taskList;
    }

} else if ($requestMethod == "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (isset($_GET['id'])) {
        $data = [
            'status' => 405,
            'messsage' => $requestMethod . 'Method Not Allowed'
        ];
        header('HTTP/1.0 405 Method Not Allowed');
        echo json_encode($data);
    } else {
        if (empty($inputData)) {
            $response = createTask($_POST);
        } else {
            $response = createTask($inputData);

        }
    }
    echo $response;

} else if ($requestMethod == "PUT") {
    $inputData = json_decode(file_get_contents("php://input"), true);

    $response = updateTask($inputData, $_GET);
    echo $response;
} else if ($requestMethod == "DELETE") {

    $deleteList = deleteTask($_GET);
    echo $deleteList;

} else {
    $data = [
        'status' => 405,
        'messsage' => $requestMethod . 'Method Not Allowed'
    ];
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode($data);
}


?>