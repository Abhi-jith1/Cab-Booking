<?php
include 'db.php'; // DB connection

$fuel = '';
$company = '';
$result = null;

if (isset($_GET['fuel']) && isset($_GET['company'])) {
    $fuel = mysqli_real_escape_string($conn, $_GET['fuel']);
    $company = mysqli_real_escape_string($conn, $_GET['company']);

    $sql = "SELECT car.*, c.cmpname, m.mname 
            FROM cab_details car 
            JOIN company c ON car.cmpid = c.cmpid 
            JOIN model m ON car.mid = m.mid 
            WHERE car.fuel = '$fuel' AND c.cmpid = '$company'";
    $result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car List</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background: #eef2f7;
    margin: 0;
    padding: 20px;
  }

  h2 {
    text-align: center;
    color: #222;
    font-size: 28px;
    margin-bottom: 30px;
  }

  .car-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 25px;
    max-width: 1300px;
    margin: 0 auto;
  }

  .car-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
  }

  .car-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
  }

  .car-card img {
    width: 100%;
    height: 220px;
    object-fit: contain; 
    border-radius: 12px;
    margin-bottom: 15px;
    background: #fafafa;
    padding: 10px;
  }

  .car-card h3 {
    text-align: center;
    margin: 10px 0 15px;
    font-size: 22px;
    color: #333;
    font-weight: 600;
  }

  .view-btn {
    display: block;
    margin: 0 auto 15px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: transform 0.2s, background 0.3s;
  }

  .view-btn:hover {
    background: linear-gradient(135deg, #0056b3, #003c82);
    transform: scale(1.05);
  }

  /* Details with smooth expand/collapse */
  .details {
    max-height: 0;
    overflow: hidden;
    margin-top: 0;
    background: #f9fafc;
    border-radius: 12px;
    padding: 0 18px;
    font-size: 15px;
    color: #444;
    box-shadow: inset 0 2px 6px rgba(0,0,0,0.05);
    transition: max-height 0.5s ease, padding 0.3s ease, margin 0.3s ease;
  }

  .details.open {
    max-height: 1000px; /* big enough for content */
    padding: 18px;
    margin-top: 15px;
  }

  .details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 20px;
  }

  .details p {
    margin: 5px 0;
  }

  .details span {
    font-weight: 600;
    color: #111;
  }

  .extra-images {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
  }

  .extra-images img {
    width: 120px;
    height: 90px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s;
    cursor: pointer;
  }

  .extra-images img:hover {
    transform: scale(1.08);
  }
</style>

</head>
<body>
  <h2>Cars with Fuel Type: <?php echo htmlspecialchars($fuel); ?></h2>
  <div class="car-list">
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='car-card'>";

            $imgFile = $row['image'];
            $imgPath = "admin/uploads/" . $imgFile;
            if (empty($imgFile) || !file_exists($imgPath)) {
                $imgPath = "placeholder.jpg";
            }
            echo "<img src='" . htmlspecialchars($imgPath) . "' alt='Car Image'>";
            echo "<h3>" . htmlspecialchars($row['cmpname']) . " " . htmlspecialchars($row['mname']) . "</h3>";

            echo "<button class='view-btn' onclick='toggleDetails(this)'>View Details</button>";

            echo "<div class='details'>";
            echo "<p><span>Cab ID:</span> " . htmlspecialchars($row['cab_id']) . "</p>";
            echo "<p><span>Type:</span> " . htmlspecialchars($row['type']) . "</p>";
            echo "<p><span>No. of Seats:</span> " . htmlspecialchars($row['no_of_seat']) . "</p>";
            echo "<p><span>Registration No:</span> " . htmlspecialchars($row['regno']) . "</p>";
            echo "<p><span>Fuel:</span> " . htmlspecialchars($row['fuel']) . "</p>";
            echo "<p><span>Rent:</span> " . htmlspecialchars($row['rent']) . "</p>";
            echo "<p><span>Power Steering:</span> " . htmlspecialchars($row['power_steering']) . "</p>";
            echo "<p><span>Leather Seat:</span> " . htmlspecialchars($row['l_seat']) . "</p>";
            echo "<p><span>Central Lock:</span> " . htmlspecialchars($row['c_lock']) . "</p>";
            echo "<p><span>Driver Airbag:</span> " . htmlspecialchars($row['d_airbag']) . "</p>";
            echo "<p><span>Passenger Airbag:</span> " . htmlspecialchars($row['p_airbag']) . "</p>";
            echo "<p><span>Anti Lock:</span> " . htmlspecialchars($row['anti_lock']) . "</p>";
            echo "<p><span>Status:</span> " . htmlspecialchars($row['status']) . "</p>";
            echo "<p><span>Owner ID:</span> " . htmlspecialchars($row['ownerid']) . "</p>";
            echo "<p><span>Driver ID:</span> " . htmlspecialchars($row['driver_id']) . "</p>";

            if (!empty($row['image1']) || !empty($row['image2'])) {
                echo "<div class='extra-images'>";
                if (!empty($row['image1'])) {
                    echo "<img src='admin/uploads/" . htmlspecialchars($row['image1']) . "' alt='Extra Image'>";
                }
                if (!empty($row['image2'])) {
                    echo "<img src='admin/uploads/" . htmlspecialchars($row['image2']) . "' alt='Extra Image'>";
                }
                echo "</div>";
            }

            echo "</div>"; // details end
            echo "</div>"; // card end
        }
    } else {
        echo "<p style='text-align:center; grid-column: 1/-1;'>No cars found for this selection.</p>";
    }
    ?>
  </div>

<script>
  function toggleDetails(button) {
    const card = button.closest(".car-card");
    const details = card.querySelector(".details");

    if (details.classList.contains("open")) {
      details.classList.remove("open");
      button.textContent = "View Details";
    } else {
      details.classList.add("open");
      button.textContent = "Hide Details";
    }
  }
</script>


</body>
</html>
