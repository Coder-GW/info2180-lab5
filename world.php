<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$country = isset($_GET['country']) ? trim($_GET['country']) : "";

// If no country was entered
if ($country === "") {
    echo "<p>No country provided.</p>";
    exit();
}

// Prepared SQL statement (SECURE)
$stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE ?");
$stmt->execute(["%$country%"]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($results) === 0) {
    echo "<p>No results found.</p>";
    exit();
}
?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= htmlspecialchars($row['name']) . " is ruled by " . htmlspecialchars($row['head_of_state']); ?></li>
<?php endforeach; ?>
</ul>
