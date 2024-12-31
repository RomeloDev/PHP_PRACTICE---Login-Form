<?php

include 'session.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <h1>Welcome <?php echo $_SESSION['username'] ?></h1>

    <form action="logout.php" method="get">
        <input type="submit" value="LOGOUT">
    </form>
</body>
</html>