<?php
    if (isset($_POST['submit'])) 
    {
        include 'dbcon.php';

        $book_id = $_POST['book_id'];
        $name = $_POST['name'];
        $author = $_POST['author'];
        $year = $_POST['year'];

        $query =mysqli_query($conn,"insert into books(book_id,name,author,year_of_publication) Values ('$book_id','$name','$author','$year')");
               
        if($query) { 
            echo "<p>New book inserted successfully</p>";
        } 
        else
        {
            echo "<p>error</p>";
        }

        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Insert Book Details</title>
    <script src="script.js"></script>
    <style>body {
    font-family: calibri, sans-serif;
    background-color: burlywood;
    padding: 30px;
}

h2 {
    text-align: center;
    color: black;
}

form {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 100px purple;
    max-width: 500px;
    margin: auto;
}

label {
    display: block;
    margin-bottom: 8px;
    color: blue;
}

input[type="text"],
input[type="number"] {
    width: 480px;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid blueviolet;
    border-radius: 10px;
}

input[type="submit"] {
    background-color: green;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 100px;
    cursor: pointer;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: skyblue;
}
</style>
    
    
</head>
<body>
    <h2>Insert Book Details</h2>
    <form method="POST">
        <label for="book_id">Book ID NO:</label>
        <input type="text" id="book_id" name="book_id" required><br><br>
        
        <label for="name">Name of the Book:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="author">Author Name:</label>
        <input type="text" id="author" name="author" required><br><br>
        
        <label for="year">Year of Publication:</label>
        <input type="number" id="year" name="year" required><br><br>
        
        <input type="submit" name="submit" value="Submit Book Details">
    </form>
</body>
</html>
