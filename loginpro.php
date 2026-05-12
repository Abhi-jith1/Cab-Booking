<?php
include 'db.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt ="SELECT * FROM login WHERE username = '$username' and password='$password'";
    $result =mysqli_query($conn,$stmt);
    if ($result->num_rows == 1) {
        $row = mysqli_fetch_assoc($result);
            if ($row['Usertype'] == 'Admin') {
                header("Location: admin/index.html");
                exit();
                // redirect to admin dashboard
            } else {
                header("Location: index.html");
                exit();
                // redirect to user dashboard
            }
        
    } else {
        echo "Invalid Username.";
    }

   

?>