<?php
require('includes/config.php');
if(!isset($_SESSION['user_id'])){
    header('Location: /typing.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard |TypingGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/navbar.php';?>
    <div class="container">
        <h2>Welcome back, <?php echo $_SESSION['fname']; ?></h2>
        <a href="/typing.php/" class="btn btn-lg btn-outline-secondary">Practice Typing</a>
        <?php 
    $query = "SELECT u.username, r.wpm, r.cpm, r.mistakes
    FROM records r
    JOIN users u ON r.user_id = u.id
    WHERE r.id IN (
        SELECT MAX(id)
        FROM records
        WHERE user_id = r.user_id
    )
    ORDER BY r.wpm DESC
    LIMIT 1";

$result = $conn->query($query);

if ($result->num_rows > 0) {
echo '<div class="container mt-4">
      <h2 class="mb-4">Your Top Record</h2>
      <table class="table table-striped">
          <thead>
              <tr>
                  <th scope="col">Username</th>
                  <th scope="col">WPM</th>
                  <th scope="col">CPM</th>
                  <th scope="col">Mistakes</th>
              </tr>
          </thead>
          <tbody>';

while ($row = $result->fetch_assoc()) {
  echo '<tr>
          <td>' . htmlspecialchars($row['username']) . '</td>
          <td>' . htmlspecialchars($row['wpm']) . '</td>
          <td>' . htmlspecialchars($row['cpm']) . '</td>
          <td>' . htmlspecialchars($row['mistakes']) . '</td>
        </tr>';
}

echo '</tbody>
    </table>
  </div>';
} else {
echo '<p>No records found for the user.</p>';
}


$userId = $_SESSION['user_id'];
$query = "SELECT u.username, r.wpm, r.cpm, r.mistakes FROM records r JOIN users u ON r.user_id = u.id WHERE r.user_id = $userId ORDER BY r.wpm DESC, r.mistakes ASC LIMIT 10";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    echo '<div class="container mt-4">
            <h2 class="mb-4">Your Top Records</h2><table class="table table-striped"><thead><tr><th scope="col">#</th><th scope="col">Username</th><th scope="col">WPM</th><th scope="col">CPM</th><th scope="col">Mistakes</th></tr> </thead><tbody>';
    $rank = 1;
    while ($row = $result->fetch_assoc()) {
        echo '<tr><th scope="row">' . $rank . '</th><td>' . htmlspecialchars($row['username']) . '</td><td>' . htmlspecialchars($row['wpm']) . '</td><td>' . htmlspecialchars($row['cpm']) . '</td><td>' . htmlspecialchars($row['mistakes']) . '</td></tr>';
        $rank++;
    }

    echo '</tbody>
          </table>
        </div>';
} else {
    echo '<p>No records.</p>';
}

?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
