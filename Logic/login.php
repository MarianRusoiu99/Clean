<?php
include('conn.php');



if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}


if ($stmt = $con->prepare('SELECT id, Password FROM employees WHERE Username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;

            $result = mysqli_query($con, " select Usertype from employees where id = '$id' " );
            $row = $result->fetch_assoc();
            $user = $row['Usertype'];
            echo $user;

            
            if ($user == '1') {
                header("Location: ../profile.html");
            }else{
                if ($user == '0') {
                    header("Location: ../admindashboard.html");
                }
            }
        } else {
            // Incorrect password
            
            echo 'Incorrect password!';
        }
    } else {
        // Incorrect username
        echo 'Incorrect username!';
    }


	$stmt->close();
}
?>



