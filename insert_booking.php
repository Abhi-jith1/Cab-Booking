<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $pickdate = $_POST['pickdate'];
    $dropdate = $_POST['dropdate'];
    $picktime = $_POST['picktime'];
    $accno = $_POST['accno'];
    $cvv = $_POST['cvv'];

    // Connect to database
   

    if ($conn->connect_error) {
        die("<h3 style='color:red;'>Database Connection Failed: " . $conn->connect_error . "</h3>");
    }

    // Insert data
    $sql = "INSERT INTO booking (pickup, dropoff, pickdate, dropdate, picktime, accno, cvv)
            VALUES ('$pickup', '$dropoff', '$pickdate', '$dropdate', '$picktime', '$accno', '$cvv')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('🎉 Booking Successful!');
                window.location.href='booking.html';
              </script>";
    } else {
        echo "<h3 style='color:red;'>Error: " . $conn->error . "</h3>";
    }

    $conn->close();
}
?>
