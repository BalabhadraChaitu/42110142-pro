<?php
    if (isset($_POST['submit'])) {
        include 'dbcon.php';

        $book_id = $_POST['book_id'];
        $name = $_POST['name'];
        $author = $_POST['author'];
        $year = $_POST['year'];

        $sql = "INSERT INTO books (book_id, name, author, year_of_publication) 
                VALUES ('$book_id', '$name', '$author', '$year')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>New book inserted successfully</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        $conn->close();
    }
?>