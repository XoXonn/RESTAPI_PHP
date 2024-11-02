<?php

require '../inc/dbcon.php';

// GET
function getTaskList()
{

    global $conn;

    $query = "SELECT * from task";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Tasks Found',
                'data' => $res
            ];
            header('HTTP/1.0 200 OK');
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Task Found',
            ];
            header('HTTP/1.0 404 No Task Found');
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }
}

//GET 1 Specific Item
function getTask($id)
{
    global $conn;

    if ($id['id'] == NULL) {
        $data = [
            'status' => 422,
            'message' => 'Enter Task ID',
        ];
        header('HTTP/1.0 422');
        return json_encode($data);
    }

    $taskid = mysqli_real_escape_string($conn, $id['id']);

    $query = "SELECT * FROM task WHERE id='$taskid' LIMIT 1";
    $query_run = mysqli_query($conn, $query);


    if ($query_run) {
        if (mysqli_num_rows($query_run) == 1) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Tasks Found',
                'data' => $res
            ];
            header('HTTP/1.0 200 OK');
            return json_encode($data);

        } else {
            $data = [
                'status' => 404,
                'message' => 'No Task Found',
            ];
            header('HTTP/1.0 404 No Task Found');
            return json_encode($data);
        }


    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }
}

//CREATE
function createTask($inputData)
{
    global $conn;

    $task_name = mysqli_real_escape_string($conn, $inputData['task_name']);
    // $time_made = date('Y-m-d H:i:s');
    // $completion = isset($inputData['completion']) ? (int)$inputData['completion'] : 0;
    $deadline = mysqli_real_escape_string($conn, $inputData['deadline']);


    if (empty(trim($task_name))) {
        $data = [
            'status' => 422,
            'message' => 'Enter Taskname',
        ];
        header('HTTP/1.0 422');
        return json_encode($data);

        // } else if (empty(trim($completion))) {
        //     $data = [
        //         'status' => 422,
        //         'message' => 'Enter Completion Status',
        //     ];
        //     header('HTTP/1.0 422');
        //     return json_encode($data);

    } else if (empty(trim($deadline))) {
        $data = [
            'status' => 422,
            'message' => 'Enter Deadline',
        ];
        header('HTTP/1.0 422');
        return json_encode($data);

    } else {
        $query = "INSERT INTO task (task_name,deadline) VALUES ('$task_name','$deadline')";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $data = [
                'status' => 201,
                'message' => 'Task Created Successfully'
            ];
            header('HTTP/1.0 201 Created');
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error'
            ];
            header('HTTP/1.0 500 Internal Server Error');
            return json_encode($data);
        }

    }
}

//UPDATE
function updateTask($inputData, $id)
{
    global $conn;

    if ($id['id'] == NULL) {
        $data = [
            'status' => 422,
            'message' => 'Enter Task ID',
        ];
        header('HTTP/1.0 422');
        return json_encode($data);
    }

    $taskid = mysqli_real_escape_string($conn, $id['id']);


    $task_name = mysqli_real_escape_string($conn, $inputData['task_name']);
    $deadline = mysqli_real_escape_string($conn, $inputData['deadline']);

    if (empty(trim($task_name))) {
        $data = [
            'status' => 422,
            'message' => 'Enter Taskname',
        ];
        header('HTTP/1.0 422');
        return json_encode($data);

    } else if (empty(trim($deadline))) {
        $data = [
            'status' => 422,
            'message' => 'Enter Deadline',
        ];
        header('HTTP/1.0 422');
        return json_encode($data);

    } else {
        $query = "UPDATE task SET task_name= '$task_name',deadline='$deadline' WHERE id = '$taskid' LIMIT 1" ;
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $data = [
                'status' => 201,
                'message' => 'Task Updated Successfully'
            ];
            header('HTTP/1.0 201 Updated');
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error'
            ];
            header('HTTP/1.0 500 Internal Server Error');
            return json_encode($data);
        }

    }
}

//DELETE
function deleteTask($id) {
    global $conn;

    if ($id['id'] == NULL) {
        $data = [
            'status' => 422,
            'message' => 'Enter Task ID',
        ];
        header('HTTP/1.0 422');
        return json_encode($data);
    }

    $taskid = mysqli_real_escape_string($conn, $id['id']);

    $query = "DELETE FROM task WHERE id = '$taskid' LIMIT 1" ;
        $query_run = mysqli_query($conn, $query);

        if (mysqli_affected_rows($conn) > 0) {
            $data = [
                'status' => 200,
                'message' => 'Task Deleted Successfully'
            ];
            header('HTTP/1.0 200 OK');
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Task Found'
            ];
            header('HTTP/1.0 404 Not Found');
        }
        return json_encode($data);
}



?>