<?php
    require 'vendor/autoload.php';
    require 'db.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    try {
        $stmt = $database->query("
            SELECT 
                b.book_name,
                b.book_author,
                STRING_AGG(g.genre_name, ', ') AS genres,
                b.book_year,
                b.book_publisher,
                b.book_isbn,
                b.book_pages,
                b.book_age,
                b.book_release_date,
                b.book_weight,
                b.book_price,
                b.book_summary
            FROM books b
            LEFT JOIN book_genre bg ON b.book_id = bg.book_id
            LEFT JOIN genres g ON g.genre_id = bg.genre_id
            GROUP BY b.book_id
        ");
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo    "<script>
                    alert('Ошибка при формировании таблицы!');
                    window.location.href = '/;
                </script>";
        exit();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = [
        'Название', 'Автор', 'Жанры', 'Год', 'Издательство', 'ISBN', 'Страницы',
        'Возраст', 'Дата поступления', 'Вес (г)', 'Цена (₽)', 'Описание'
    ];

    $sheet->fromArray($headers, null, 'A1');

    $row = 2;
    foreach ($books as $book) {
        $sheet->fromArray(array_values($book), null, 'A' . $row++);
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Books.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
?>