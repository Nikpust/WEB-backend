<?php
    require 'db.php';
    $twig = require 'twig.php';

    $stmt = $database->query("
        SELECT 
            b.book_id,
            b.book_name,
            b.book_author,
            b.book_year,
            b.book_publisher,
            b.book_isbn,
            b.book_pages,
            b.book_age,
            b.book_release_date,
            b.book_weight,
            b.book_price,
            b.book_summary,
            STRING_AGG(g.genre_name, ', ') AS genres
        FROM books b
        LEFT JOIN book_genre bg ON b.book_id = bg.book_id
        LEFT JOIN genres g ON g.genre_id = bg.genre_id
        GROUP BY b.book_id
    ");

    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo $twig->render('table-books.twig', ['books' => $books]);
?>