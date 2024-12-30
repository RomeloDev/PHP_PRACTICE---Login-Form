<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <form action="index.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" name="username" id="username" required><br>
            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" id="password" required><br>
            <label for="confirm-password">Confirm Password:</label><br>
            <input type="password" name="confirm-password" id="confirm-password" required><br>
            <input type="submit" value="Register" name="register">
        </form>
        <br>
        <div class="redirect">
            Already have an account?<a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>

<?php
    include 'connect.php';//importing the db connection file

    if(isset($_POST['register'])){
        //variable declaration
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm-password']);
        //password hashing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        //check if fields are empty
        if(empty($username) || empty($email) || empty($password) || empty($confirm_password)){
            echo "<script>alert('All fields required')</script>";
        }

        //check if username already exists
        $checkUsername = "SELECT * FROM accounts WHERE username = ?";
        $stmt = $conn->prepare($checkUsername);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            echo "<script>alert('Username already exists!')</script>";
        }
        //check if email already exists
        $checkEmail = "SELECT * FROM accounts WHERE email = ?";
        $stmt = $conn->prepare($checkEmail);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            echo "<script>alert('Email already exists!')</script>";
        }
        //check if password is equal to confirm password
        elseif($password !== $confirm_password){
            echo "Password and confirm password not match";
        }else{
            //prepare an insert statement
            $insertQuery = "INSERT INTO `accounts`(`id`, `username`, `email`, `password`) VALUES(null, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            //Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            //execution
            if($stmt->execute()){
                echo "Account created successfully";
                echo "<script>window.location.href = 'login.php'</script> ";
            }else{
                echo "Error creating account";
            }
        }
        //Close Statement and connection
        $stmt->close();
        $conn->close();
    }
?>