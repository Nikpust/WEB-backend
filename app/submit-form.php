<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $book = trim($_POST['book'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $year = trim($_POST['year'] ?? '');
        $publisher = trim($_POST['publisher'] ?? '');
        $price = trim($_POST['price'] ?? '');

        $genres = $_POST['genre'] ?? [];
        $genres_str = implode(', ', $genres);
        
        $data_file_cvs = 'data_file.csv';
        $data = [$book, $author, $genres_str, $year, $publisher, $price];

        if (($file = fopen($data_file_cvs, 'a')) !== false) {
            fputcsv($file, $data);
            fclose($file);
        }

        header('Location: index.php');
        exit();
    }
?>