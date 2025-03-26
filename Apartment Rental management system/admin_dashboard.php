<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_apartment'])) {
        $address = $_POST['address'];
        $rent = $_POST['rent'];
        $sql = "INSERT INTO apartments (address, monthly_rent, available) VALUES ('$address', '$rent', 1)";
        $conn->query($sql);
    } elseif (isset($_POST['add_tenant'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $apartment_id = $_POST['apartment_id'];
        $lease_start = $_POST['lease_start'];
        $lease_end = $_POST['lease_end'];
        $sql = "INSERT INTO tenants (name, email, phone, apartment_id, lease_start, lease_end) 
                VALUES ('$name', '$email', '$phone', $apartment_id, '$lease_start', '$lease_end')";
        $conn->query($sql);
    } elseif (isset($_POST['record_payment'])) {
        $tenant_id = $_POST['tenant_id'];
        $user_id = $_POST['user_id'];
        $amount = $_POST['amount'];
        $payment_date = $_POST['payment_date'];
        $sql = "INSERT INTO payments (tenant_id, user_id, payment_date, amount) 
                VALUES ($tenant_id, $user_id, '$payment_date', $amount)";
        $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Required for absolute positioning inside */
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
            text-align: center;
            text-decoration: none;
        }
        .menu-button:hover {
            background-color: #45a049;
        }
        form {
            display: none; 
            margin-bottom: 30px;
        }
        form.active {
            display: block;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
       
        .logout-container {
            position: relative;
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
        <h2>Admin Dashboard</h2>
        
     
        <div class="logout-container">
            <form action="logout1.php" method="POST">
                <input type="submit" class="logout-btn" value="Logout">
            </form>
        </div>

        <div class="menu">
            <button class="menu-button" onclick="showSection('addApartment')">Add Apartment</button>
            <button class="menu-button" onclick="showSection('addTenant')">Add Tenant</button>
            <button class="menu-button" onclick="showSection('recordPayment')">Add Damage Fee/Fine</button>
        </div>

        <div id="addApartment">
            <h3>Add Apartment</h3>
            <form action="admin_dashboard.php" method="POST" class="active">
                Address: <input type="text" name="address" required><br>
                Rent: <input type="text" name="rent" required><br>
                <input type="submit" name="add_apartment" value="Add Apartment">
            </form>
        </div>

        <div id="addTenant">
            <h3>Add Tenant</h3>
            <form action="admin_dashboard.php" method="POST">
                Name: <input type="text" name="name" required><br>
                Email: <input type="email" name="email" required><br>
                Phone: <input type="text" name="phone" required><br>
                Apartment ID: <input type="text" name="apartment_id" required><br>
                Lease Start: <input type="date" name="lease_start" required><br>
                Lease End: <input type="date" name="lease_end" required><br>
                <input type="submit" name="add_tenant" value="Add Tenant">
            </form>
        </div>

        <div id="recordPayment">
            <h3>Record Damage Fee Payment</h3>
            <form action="admin_dashboard.php" method="POST">
                Tenant ID: <input type="text" name="tenant_id" required><br>
                User ID: <input type="text" name="user_id" required><br> 
                Amount: <input type="text" name="amount" required><br>
                Due Date: <input type="date" name="payment_date" required><br> 
                <input type="submit" name="record_payment" value="Record Payment">
            </form>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => form.classList.remove('active'));
            document.querySelector(`#${sectionId} form`).classList.add('active');
        }

        document.addEventListener("DOMContentLoaded", function() {
            showSection('addApartment');
        });
    </script>
</body>
</html>
