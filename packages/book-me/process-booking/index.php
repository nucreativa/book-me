

<?php

function main(array $args): array
{
    $productId = $args['product_id'];
    $date = $args['date'];
    $startTime = $args['start_time'];
    $endTime = $args['end_time'];

    $conn = new mysqli(
        getenv("MARIADB_HOST"),
        getenv("MARIADB_USER"),
        getenv("MARIADB_PASS"),
        getenv("MARIADB_DBNAME")
    );

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO bookings (`product_id`, `date`, `start`, `end`) VALUES ('$productId', '$date', '$startTime', '$endTime')";

    if ($conn->query($sql) === TRUE) {
        $status = 200;
        $message = 'OK';
    } else {
        $status = 400;
        $message = $conn->error;
    }

    $conn->close();

    return ['status' => $status, 'message' => $message];
}
