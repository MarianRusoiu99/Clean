<?php
include('conn.php');
header('Location: ../index.html');

if(isset($_POST['Submit'])){
    $Username = $_REQUEST['username'];
    $Nume = $_REQUEST['nume'];
    $Prenume = $_REQUEST['prenume'];
    $Email = $_REQUEST['email'];
    $Phone = $_REQUEST['phone'];
    $Password = $_REQUEST['password'];
    $Password = password_hash($Password, PASSWORD_DEFAULT);
    $User = 1;

}

$result = mysqli_query($con, " select * from employees " );
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['Email'] == $Email || $row['Username']== $Username){
                header('Location: ../register.html');
                echo "Username or Email already in use.";
                exit;
            }
        }
    }



$sql = mysqli_query($con, "INSERT INTO employees  VALUES (NULL,'$Username', '$Password', '$Nume','$Prenume','$Email','$Phone','$User')" );
if($sql){
    echo "cont facut cu success";
    
}else {
    echo "eroare boss";
}

     
exit;




?>