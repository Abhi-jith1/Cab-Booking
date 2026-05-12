<?php
include 'db.php';

    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password =$_POST['password'];
  

    // Insert into registration table
    $stmt1 = "INSERT INTO registration (Name, Contact, Address, Email, Username, Password, Status) VALUES ('$name','$contact','$address','$email','$username','$password','user')";
    mysqli_query($conn,$stmt1);
    // Insert into login table
    $stmt2 = "INSERT INTO login (Username, Password, Usertype) VALUES ('$username', '$password','User')";
    mysqli_query($conn,$stmt2);
        echo "Registration successful.";
 if (!isset($_SESSION['user'])) {
    header("Location: Login.html");
    exit();
}



   

?>