<?php
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $data_file_xlsx = '/var/www/html/data/data_file.xlsx';

    if (file_exists($data_file_xlsx)) {
        $spreadsheet = IOFactory::load($data_file_xlsx);
        $sheet = $spreadsheet->getActiveSheet();
    } else {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $headers = ['Название книги', 'Автор', 'Жанры', 'Год издания', 'Издательство', 'ISBN', 'Количество страниц', 'Возрастное ограничение', 'Дата поступления', 'Вес (г)', 'Стоимость', 'Описание'];
        $sheet->fromArray($headers, null, 'A1');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $book = trim($_POST['book'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $year = trim($_POST['year'] ?? '');
        $publisher = trim($_POST['publisher'] ?? '');
        $isbn = trim($_POST['isbn'] ?? '');
        $pages = trim($_POST['pages'] ?? '');
        $age = trim($_POST['age'] ?? '');
        $release_date = trim($_POST['release_date'] ?? '');
        $weight = trim($_POST['weight'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        
        $genres = $_POST['genre'] ?? [];
        $genres_str = implode(', ', $genres);

        $lastRow = $sheet->getHighestRow() + 1;
        $sheet->fromArray([$book, $author, $genres_str, $year, $publisher, $isbn, $pages, $age, $release_date, $weight, $price, $summary], null, "A$lastRow");

        $writer = new Xlsx($spreadsheet);
        $writer->save($data_file_xlsx);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
?>
