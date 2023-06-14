

<?php

function main(array $args): array
{
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

    $sql = "INSERT INTO product (`name`) VALUES ('brinks')";

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
