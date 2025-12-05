<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Read query parameters
$country = isset($_GET['country']) ? trim($_GET['country']) : "";
$lookupType = isset($_GET['lookup']) ? trim($_GET['lookup']) : "countries";

// No country entered
if ($country === "") {
    echo "<p>No country provided.</p>";
    exit();
}

// ===============================================
// 1. CITIES LOOKUP
// ===============================================
if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {

    try {
        $stmt = $conn->prepare("
            SELECT cities.name AS name, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE ?
        ");

        $stmt->execute(["%$country%"]);
        $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($cities) === 0) {
            echo "<p>No city results found.</p>";
            exit();
        }

        echo '<table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>District</th>
                        <th>Population</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($cities as $city) {
            echo "<tr>
                    <td>" . htmlspecialchars($city['name']) . "</td>
                    <td>" . htmlspecialchars($city['district']) . "</td>
                    <td>" . htmlspecialchars($city['population']) . "</td>
                </tr>";
        }

        echo "</tbody></table>";
        exit();
    } catch (Exception $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        exit();
    }
}


// ===============================================
// 2. COUNTRY LOOKUP
// ===============================================
if ($lookupType !== "cities") {

    $stmt = $conn->prepare("
        SELECT name, continent, independence_year, head_of_state
        FROM countries
        WHERE name LIKE ?
    ");
    $stmt->execute(["%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) === 0) {
        echo "<p>No results found.</p>";
        exit();
    }

    // Output HTML table
    echo '<table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Continent</th>
                    <th>Independence</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['continent']) . "</td>
                <td>" . htmlspecialchars($row['independence_year']) . "</td>
                <td>" . htmlspecialchars($row['head_of_state']) . "</td>
            </tr>";
    }

    echo "</tbody></table>";
    exit();
}
?>
