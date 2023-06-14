

<?php

function main(array $args): array
{
    $productId = $args['product_id'] ?? 1;

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

    $sql = "SELECT A.`date`, A.`start_time`, A.`end_time`, A.`product_id`, B.`name` 
            FROM (
                SELECT *
                FROM bookings 
                WHERE `product_id` = '$productId' AND `start_time` >= CURTIME() AND `date` = CURDATE()
                UNION
                SELECT *
                FROM bookings 
                WHERE `product_id` = '$productId' AND `end_time` >= CURTIME() AND `date` = CURDATE()
            ) A 
            JOIN products B ON A.product_id = B.id
            ORDER BY start_time ASC";
    $result = $conn->query($sql);
    $data = [
        'product_id' => $productId,
        'upcoming' => $result->fetch_all(MYSQLI_ASSOC)
    ];
    $result->free_result();
    $conn->close();

    return [
        'status' => 200,
        'data' => $data
    ];
}
