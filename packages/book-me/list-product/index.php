

<?php

function main(array $args): array
{
    $companyId = $args['company_id'] ?? 1;

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

    $sql = "SELECT `id`, `name`, `status` FROM products WHERE `company_id` = '$companyId' AND `status` = '1'";
    $result = $conn->query($sql);
    $data = [
        'company_id' => $companyId,
        'products' => $result->fetch_all(MYSQLI_ASSOC)
    ];
    $result->free_result();
    $conn->close();

    return [
        'status' => 200,
        'data' => $data
    ];
}
