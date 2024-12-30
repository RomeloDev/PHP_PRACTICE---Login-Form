<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login" name="login">
        </form>
        <br>
        <div class="redirect">
            Don't have an account? <a href="index.php">Register</a>
        </div>
    </div>
</body>
</html>

<?php
    include 'connect.php';

    //start the session
    session_start();

    //check if session is invalid or empty
    if($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])){
        $_SESSION['status'] = 'invalid';
    }
    //if session is valid, redirect to homepage
    if($_SESSION['status'] == 'valid'){
        echo "<script>window.location.href = 'homepage.php'</script> ";
    }

    //submit form logic
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        //select query prepare statement
        $query = "SELECT password FROM accounts WHERE username = ?";
        $stmt = $conn->prepare($query);

        if(!$stmt){
            die("Error preparing a statement: {$conn->error}");
        }

        //bind username variable to the preparedStatement as parameters
        $stmt->bind_param("s", $username);
        //execution
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $stmt->bind_result($password_db);
            $stmt->fetch();

            //check if password is valid 
            if(password_verify($password, $password_db)){
                $_SESSION['status'] = 'valid';
                $_SESSION['username'] = $username;
                echo "<script>window.location.href = 'homepage.php'</script> ";
            }else{
                $_SESSION['status'] = 'invalid';
                echo "Invalid Credentials!";
            }

            $stmt->close();
        }
    }

    
?>