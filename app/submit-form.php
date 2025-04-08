<?php
    require 'validation.php';
    require "db.php";

    date_default_timezone_set("Europe/Moscow");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $book = $_POST['book'] ?? '';
        $author = $_POST['author'] ?? '';
        $year = $_POST['year'] ?? '';
        $publisher = $_POST['publisher'] ?? '';
        $genres = $_POST['genre'] ?? [];
        $isbn = $_POST['isbn'] ?? '';
        $pages = $_POST['pages'] ?? '';
        $age = $_POST['age'] ?? '';
        $release_date = $_POST['release_date'] ?? '';
        $weight = $_POST['weight'] ?? '';
        $price = $_POST['price'] ?? '';
        $summary = $_POST['summary'] ?? '';
        $genres_str = implode(', ', $genres);
        
        if ($age == "")         $age = 'Не указано';
        if ($genres_str == "")  $genres_str = 'Не указано';
        if ($summary == "")     $summary = 'Не указано';

        $book = clean_input($book);
        $author = clean_input($author);
        $year = clean_input($year);
        $publisher = clean_input($publisher);
        $isbn = clean_input($isbn);
        $pages = clean_input($pages);
        $release_date = clean_input($release_date);
        $weight = clean_input($weight);
        $price = clean_input($price);
        $summary = clean_input($summary, false);

        $patterns = require 'patterns.php';
        $message = "";

        if (!validation($book, $patterns['book']) || strlen($book) > 255) {
            $message .= " название книги,";
        }
        if (!validation($author, $patterns['author'])) {
            $message .= " автор,";
        }
        if (!validation($year, $patterns['year']) || $year > date('Y') + 1) {
            $message .= " год издания,";
        }
        if (!validation($publisher, $patterns['publisher'])) {
            $message .= " издательство,";
        }
        if (!validation($isbn, $patterns['isbn'])) {
            $message .= " ISBN,";
        }
        if (!validation($pages, $patterns['pages']) || $pages < 1 || $pages > 100000) {
            $message .= " количество страниц,";
        }
        if (!validation($weight, $patterns['weight']) || $weight < 1 || $weight > 100000) {
            $message .= " вес,";
        }
        if (!validation($price, $patterns['price'])) {
            $message .= " стоимость,";
        }
        if (!validation($summary, $patterns['summary'])) {
            $message .= " описание,";
        }
        
        if ($message != "") {
            $message = rtrim($message, ',');
            echo    "<script>
                        alert('Некорректные данные в полях: $message! Форма будет очищена');
                        window.location.href = '/';
                    </script>";
            exit();
        }

        try {
            $sql =  "
                        SELECT book_id FROM books 
                        WHERE book_isbn = :isbn
                    ";
            $sth = $database->prepare($sql);
            $sth->execute([':isbn' => $isbn]);
            $test = $sth->fetch(PDO::FETCH_ASSOC);

            if ($test) {
                echo    "<script>
                            alert('Книга с таким ISBN уже существует!');
                            window.location.href = '/';
                        </script>";
                exit();
            }

            $sql =  "
                        INSERT INTO books (book_created_at, book_updated_at, book_name, book_author, book_year, book_publisher, book_isbn, book_pages, book_age, book_release_date, book_weight, book_price, book_summary)
                        VALUES (:created_at, :updated_at, :book, :author, :year, :publisher, :isbn, :pages, :age, :release_date, :weight, :price, :summary)
                        RETURNING book_id
                    ";
            $sth = $database->prepare($sql);
            $time = date("Y-m-d H:i:s");
            $sth->execute([
                ':created_at'   => $time,
                ':updated_at'   => $time,
                ':book'         => $book,
                ':author'       => $author,
                ':year'         => $year,
                ':publisher'    => $publisher,
                ':isbn'         => $isbn,
                ':pages'        => $pages,
                ':age'          => $age,
                ':release_date' => $release_date,
                ':weight'       => $weight,
                ':price'        => $price,
                ':summary'      => $summary
            ]);
            $book_id = $sth->fetchColumn();

            foreach ($genres as $genre_name) {
                $sql =  "
                            SELECT genre_id
                            FROM genres
                            WHERE genre_name = :name
                        ";
                $sth = $database->prepare($sql);
                $sth->execute([':name' => $genre_name]);
                $genre_id = $sth->fetchColumn();
    
                if (!$genre_id) {
                    $sql =  "
                                INSERT INTO genres (genre_name)
                                VALUES (:name)
                                RETURNING genre_id
                            ";
                    $sth = $database->prepare($sql);
                    $sth->execute([':name' => $genre_name]);
                    $genre_id = $sth->fetchColumn();
                }
                
                $sql =  "
                            INSERT INTO book_genre (book_id, genre_id)
                            VALUES (:book_id, :genre_id)
                        ";
                $sth = $database->prepare($sql);
                $sth->execute([':book_id' => $book_id, ':genre_id' => $genre_id]);
            }
        } catch (PDOException $e) {
            echo    "<script>
                        alert('Ошибка при добавлении книги в базу данных!');
                        window.location.href = '/;
                    </script>";
            exit();
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
?>