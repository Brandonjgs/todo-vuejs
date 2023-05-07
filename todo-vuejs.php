<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization');

$db_host = 'localhost';
$db_name = 'todo_vuejs';
$db_user = 'root';
$db_pass = '';

// Conection to data base
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verify conection
if ($conn->connect_error) {
    die('Error al conectar con la base de datos: ' . $conn->connect_error);
}

// Get all tasks
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['resource'] === 'todosList') {

    $data = json_decode(file_get_contents('php://input'), true);

    $search_value = $data['search_value'];
    $task_status = $data["task_status"];
    $order_by = $data["order_by"];

    $where = '';
    $where .= $task_status == "all" ? "" : " AND task_status = '$task_status'";
    $where .= $search_value == "" ? "" : " AND title LIKE '%$search_value%' OR description LIKE '%$search_value%'";
    $orderBy = is_null($order_by) ? " ORDER BY id DESC" : " ORDER BY $order_by ASC";

    $sql = "SELECT * FROM todos WHERE status = 1 $where $orderBy";
    $result = $conn->query($sql);
    $todos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $todos[] = $row;
        }
    }

    echo json_encode($todos);
}

// Get task by ID
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['resource'] === 'id') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'];

    $sql = 'SELECT * FROM todos WHERE id = ' . $id;
    $result = $conn->query($sql);
    $todo = $result->fetch_assoc();

    echo json_encode($todo);
}

// Delete task
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $_GET['resource'] === 'delete') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $status = $data['status'];

    $sql = "UPDATE todos SET status='$status' WHERE id=$id";
    $result = $conn->query($sql);

    if ($result) {
        $response = array(
            'message' => 'Éxito',
            'code' => 200
        );

        echo json_encode($response);
    } else {
        $response = array(
            'message' => $conn->error,
            'code' => 500
        );
    }
}

// Update to completed
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && $_GET['resource'] === 'completed') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $task_status = $data['task_status'];

    $sql = "UPDATE todos SET task_status='$task_status' WHERE id=$id";
    $result = $conn->query($sql);

    if ($result) {
        $response = array(
            'message' => 'Éxito',
            'code' => 200
        );

        echo json_encode($response);
    } else {
        $response = array(
            'message' => $conn->error,
            'code' => 500
        );
    }
}

// Insert or update task
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['resource'] === 'upsert') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'];
    $title = $data['title'];
    $description = $data['description'];

    if (isset($data['id']) && !empty($data['id'])) {
        $sql = "UPDATE todos SET title='$title', description='$description' WHERE id=$id";
    } else {
        $sql = "INSERT INTO todos (title, description, task_status, status) VALUES ('$title', '$description', 'pending', '1')";
    }

    $result = $conn->query($sql);

    if ($result) {
        $response = array(
            'message' => 'Éxito',
            'code' => 200
        );

        echo json_encode($response);
    } else {
        $response = array(
            'message' => $conn->error,
            'code' => 500
        );
    }
}
