<?php
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    function validation($data, $pattern) {
        return preg_match($pattern, $data) === 1;
    }

    function clean_input($value) {
        $value = preg_replace('/([^\wа-яА-ЯёЁ])\1+/u', '$1', $value);
        $value = preg_replace('/^[^a-zA-ZА-Яа-яёЁ0-9]+/u', '', $value);
        return $value;
    }

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

    $patterns = [
        'book' => '/^[a-zA-ZА-Яа-яёЁ0-9\s.,№"\'-()]+$/u',
        'author' => '/^[a-zA-ZА-Яа-яёЁ\s.,-]+$/u',
        'year' => '/^\d{1,4}$/',
        'publisher' => '/^[a-zA-ZА-Яа-яёЁ0-9\s.,-]+$/u',
        'isbn' => '/^\d{13}$/',
        'pages' => '/^\d+$/',
        'age' => '/^\d+$/',
        'weight' => '/^\d+(\.\d{1,2})?$/',
        'price' => '/^\d+(\.\d{1,2})?$/',
        'summary' => '/^[a-zA-ZА-Яа-яёЁ0-9\s.,!?"\'-]+$/u'
    ];

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
        
        if ($age == "") {
            $age = 'Не указано';
        }
        if ($genres_str == "") {
            $genres_str = 'Не указано';
        }
        if ($summary == "") {
            $summary = 'Не указано';
        }

        $book = clean_input($book);
        $author = clean_input($author);
        $year = clean_input($year);
        $publisher = clean_input($publisher);
        $isbn = clean_input($isbn);
        $pages = clean_input($pages);
        $release_date = clean_input($release_date);
        $weight = clean_input($weight);
        $price = clean_input($price);
        $summary = clean_input($summary);

        $message = "";

        if (!validation($book, $patterns['book'])) {
            $message .= " книга,";
        }
        if (!validation($author, $patterns['author'])) {
            $message .= " автор,";
        }
        if (!validation($year, $patterns['year'])) {
            $message .= " год издания,";
        }
        if (!validation($publisher, $patterns['publisher'])) {
            $message .= " издательство,";
        }
        if (!validation($isbn, $patterns['isbn'])) {
            $message .= " ISBN,";
        }
        if (!validation($pages, $patterns['pages'])) {
            $message .= " количество страниц,";
        }
        if (!validation($weight, $patterns['weight'])) {
            $message .= " вес,";
        }
        if (!validation($price, $patterns['price'])) {
            $message .= " стоимость,";
        }
        if (!validation($summary, $patterns['summary'])) {
            $message .= " описание,";
        }
        
        if ($message !== "") {
            $message = rtrim($message, ',');
            echo $message;
            // echo "<script>
            //         alert('Некорректные данные в полях: $message! Форма будет очищена');
            //         window.location.href = 'http://localhost:8080';
            //     </script>";
            exit();
        }

        $lastRow = $sheet->getHighestRow() + 1;
        $sheet->fromArray([$book, $author, $genres_str, $year, $publisher, $isbn, $pages, $age, $release_date, $weight, $price, $summary], null, "A$lastRow");

        $writer = new Xlsx($spreadsheet);
        $writer->save($data_file_xlsx);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
?>