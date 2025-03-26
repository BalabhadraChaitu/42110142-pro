<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tenant') {
    header('Location: login.php');
    exit();
}

$tenant_id = $_SESSION['tenant_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM tenants WHERE tenant_id = $tenant_id";
$result = $conn->query($sql);
$tenant = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_maintenance'])) {
        $description = $_POST['description'];
        $sql = "INSERT INTO maintenance_requests (tenant_id, complaint, request_date) VALUES ($tenant_id, '$description', CURDATE())";
        $conn->query($sql);
        echo "<script>alert('Maintenance request submitted successfully!');</script>";
    } elseif (isset($_POST['pay_rent'])) {
        $amount = $_POST['amount'];
        $payment_date = $_POST['payment_date'];
        $utr_no = $_POST['utr_no'];  
        $payment_method = $_POST['payment_method'];

        $sql = "INSERT INTO paid_rents (tenant_id, payment_date, amount, utr_no, payment_method) 
                VALUES ($tenant_id, '$payment_date', $amount, '$utr_no', '$payment_method')";
        $conn->query($sql);
        echo "<script>alert('Rent payment successful!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h2 {
            text-align: center;
        }
        .menu {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }
        .menu-button {
            padding: 15px 25px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .menu-button:hover {
            background-color: #45a049;
        }
        form {
            margin-bottom: 30px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .section {
            display: none;
        }
        .active {
            display: block;
        }
       
        .logout-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .logout-btn:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Dashboard</h2>
        
        <div class="logout-container">
            <form action="logout.php" method="POST">
                <input type="submit" class="logout-btn" value="Logout">
            </form>
        </div>

        <div class="menu">
            <button class="menu-button" onclick="showSection('leaseDetails')">Lease Details</button>
            <button class="menu-button" onclick="showSection('payRent')">Pay Rent</button>
            <button class="menu-button" onclick="showSection('maintenanceRequest')">Report an Issue</button>
        </div>

        <div id="leaseDetails" class="section active">
            <h3>Your Lease Details</h3>
            <p>Name: <?php echo $tenant['name']; ?></p>
            <p>Email: <?php echo $tenant['email']; ?></p>
            <p>Apartment ID: <?php echo $tenant['apartment_id']; ?></p>
            <p>Lease Period: <?php echo $tenant['lease_start'] . " to " . $tenant['lease_end']; ?></p>
        </div>

        <div id="payRent" class="section">
            <h3>Pay Rent</h3>
            <form action="user_dashboard.php" method="POST">
                Amount: <input type="text" name="amount" required><br>
                Payment Date: <input type="date" name="payment_date" required><br>
                UTR Number: <input type="text" name="utr_no" required><br>

                Payment Method: 
                <select name="payment_method" required>
                    <option value="UPI">UPI</option>
                    <option value="IMPS">IMPS</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select><br>

                <h4>Bank Account Details</h4>
                <p>Account Name: XYZ Apartment Rentals</p>
                <p>Account Number: 123456789012</p>
                <p>Bank: ABC Bank</p>
                <p>IFSC Code: ABCD1234567</p>

                <input type="submit" name="pay_rent" value="Pay Rent">
            </form>
        </div>

        <div id="maintenanceRequest" class="section">
            <h3>Submit Maintenance Request</h3>
            <form action="user_dashboard.php" method="POST">
                Description: <textarea name="description" required></textarea><br>
                <input type="submit" name="submit_maintenance" value="Submit Request">
            </form>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => section.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');
        }

        document.addEventListener("DOMContentLoaded", function() {
            showSection('leaseDetails');
        });
    </script>
</body>
</html>
