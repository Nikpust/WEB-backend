<?php

    namespace App\controllers;

    use App\models\Book;
    use App\core\Patterns;
    use App\core\Validation;
    use App\core\BaseController;

    class BookController extends BaseController {

        public function index(): void {
            $model = new Book();
            $books = $model->getAll();
    
            $role = $_SESSION['user_role'] ?? null;

            if ($role === 'admin') {
                echo $this->twig->render('books.twig', ['books' => $books]);
            } else {
                echo $this->twig->render('catalog.twig', ['books' => $books]);
            }
        }

        public function save(): void {
            header('Content-Type: application/json');

            $patterns = Patterns::all();
            $errors = [];
            
            $book = trim($_POST['book'] ?? '');
            $author = trim($_POST['author'] ?? '');
            $year = trim($_POST['year'] ?? '');
            $publisher = trim($_POST['publisher'] ?? '');
            $isbn = trim($_POST['isbn'] ?? '');
            $pages = trim($_POST['pages'] ?? '');
            $weight = trim($_POST['weight'] ?? '');
            $price = trim($_POST['price'] ?? '');
            $summary = trim($_POST['summary'] ?? '');
            $release_date = trim($_POST['release_date'] ?? '');
            $genres = $_POST['genre'] ?? ['Не указано'];
            $age = $_POST['age'] ?? 'Не указано';
            $genres_str = implode(', ', $genres);

            $book = Validation::clean($book);
            $author = Validation::clean($author);
            $year = Validation::clean($year);
            $publisher = Validation::clean($publisher);
            $isbn = Validation::clean($isbn);
            $pages = Validation::clean($pages);
            $weight = Validation::clean($weight);
            $price = Validation::clean($price);
            $summary = Validation::clean($summary, false);

            if (!Validation::validate($book, $patterns['book']) || strlen($book) > 255) {
                $errors[] = 'Название';
            }
            if (!Validation::validate($author, $patterns['author'])) {
                $errors[] = 'Автор';
            }
            if (!Validation::validate($year, $patterns['year']) || $year > date('Y') + 1) {
                $errors[] = 'Год';
            }
            if (!Validation::validate($publisher, $patterns['publisher'])) {
                $errors[] = 'Издательство';
            }
            if (!Validation::validate($isbn, $patterns['isbn'])) {
                $errors[] = 'ISBN';
            }
            if (!Validation::validate($pages, $patterns['pages']) || $pages < 1 || $pages > 100000) {
                $errors[] = 'Страницы';
            }
            if (!Validation::validate($weight, $patterns['weight']) || $weight < 1 || $weight > 100000) {
                $errors[] = 'Вес';
            }
            if (!Validation::validate($price, $patterns['price'])) {
                $errors[] = 'Цена';
            }
            if (!Validation::validate($summary, $patterns['summary'])) {
                $errors[] = 'Описание';
            }
        
            if (!empty($errors)) {
                echo json_encode([
                    'success' => false,
                    'message' => "Некорректные поля: $errors"
                ], JSON_UNESCAPED_UNICODE);
                exit();
            }

            $data = [
                'book_name'         => $book,
                'book_author'       => $author,
                'book_year'         => $year,
                'book_publisher'    => $publisher,
                'book_isbn'         => $isbn,
                'book_pages'        => $pages,
                'book_weight'       => $weight,
                'book_price'        => $price,
                'book_summary'      => $summary,
                'book_release_date' => $release_date,
                'book_age'          => $age,
                'genres'            => $genres
            ];
            
            $model = new Book();
            if ($model->existsByIsbn($isbn)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Книга с таким ISBN уже существует!'
                ], JSON_UNESCAPED_UNICODE);
                exit();
            }
        
            $model->create($data);
            echo json_encode([
                'success' => true,
                'message' => 'Книга успешно добавлена!'
            ], JSON_UNESCAPED_UNICODE);
            exit();
        }

        public function delete(): void {
            header('Content-Type: application/json');

            $id = $_POST['id'] ?? null;
            if (!$id || !is_numeric($id)) {
                echo json_encode(['success' => false, 'message' => 'Некорректный ID']);
                return;
            }

            $model = new Book();
            $model->deleteById($id);
            echo json_encode(['success' => true, 'message' => 'Книга удалена']);
        }
        
        public function get(): void {
            header('Content-Type: application/json');
        
            $id = $_GET['id'] ?? null;
            if (!$id || !is_numeric($id)) {
                echo json_encode(['success' => false, 'message' => 'Некорректный ID']);
                return;
            }
        
            $model = new Book();
            $model = $model->getById($id);
        
            if (!$model) {
                echo json_encode(['success' => false, 'message' => 'Книга не найдена']);
                return;
            }
        
            echo json_encode(['success' => true, 'data' => $model], JSON_UNESCAPED_UNICODE);
        }

        public function update(): void {
            header('Content-Type: application/json');
        
            $id = $_POST['id'] ?? null;
            if (!$id || !is_numeric($id)) {
                echo json_encode(['success' => false, 'message' => 'Некорректный ID']);
                return;
            }
        
            $patterns = Patterns::all();
            $errors = [];
            
            $book = trim($_POST['book'] ?? '');
            $author = trim($_POST['author'] ?? '');
            $year = trim($_POST['year'] ?? '');
            $publisher = trim($_POST['publisher'] ?? '');
            $isbn = trim($_POST['isbn'] ?? '');
            $pages = trim($_POST['pages'] ?? '');
            $weight = trim($_POST['weight'] ?? '');
            $price = trim($_POST['price'] ?? '');
            $summary = trim($_POST['summary'] ?? '');
            $release_date = trim($_POST['release_date'] ?? '');
            $genres = $_POST['genre'] ?? ['Не указано'];
            $age = $_POST['age'] ?? 'Не указано';
            $genres_str = implode(', ', $genres);

            $book = Validation::clean($book);
            $author = Validation::clean($author);
            $year = Validation::clean($year);
            $publisher = Validation::clean($publisher);
            $isbn = Validation::clean($isbn);
            $pages = Validation::clean($pages);
            $weight = Validation::clean($weight);
            $price = Validation::clean($price);
            $summary = Validation::clean($summary, false);

            if (!Validation::validate($book, $patterns['book']) || strlen($book) > 255) {
                $errors[] = 'Название';
            }
            if (!Validation::validate($author, $patterns['author'])) {
                $errors[] = 'Автор';
            }
            if (!Validation::validate($year, $patterns['year']) || $year > date('Y') + 1) {
                $errors[] = 'Год';
            }
            if (!Validation::validate($publisher, $patterns['publisher'])) {
                $errors[] = 'Издательство';
            }
            if (!Validation::validate($isbn, $patterns['isbn'])) {
                $errors[] = 'ISBN';
            }
            if (!Validation::validate($pages, $patterns['pages']) || $pages < 1 || $pages > 100000) {
                $errors[] = 'Страницы';
            }
            if (!Validation::validate($weight, $patterns['weight']) || $weight < 1 || $weight > 100000) {
                $errors[] = 'Вес';
            }
            if (!Validation::validate($price, $patterns['price'])) {
                $errors[] = 'Цена';
            }
            if (!Validation::validate($summary, $patterns['summary'])) {
                $errors[] = 'Описание';
            }

            if (!empty($errors)) {
                $errorList = implode(', ', $errors);
                echo json_encode([
                    'success' => false,
                    'message' => "Некорректные поля: $errorList"
                ], JSON_UNESCAPED_UNICODE);
                exit();
            }

            $data = [
                'book_id'          => $id,
                'book_name'        => $book,
                'book_author'      => $author,
                'book_year'        => $year,
                'book_publisher'   => $publisher,
                'book_isbn'        => $isbn,
                'book_pages'       => $pages,
                'book_weight'      => $weight,
                'book_price'       => $price,
                'book_summary'     => $summary,
                'book_release_date'=> $release_date,
                'book_age'         => $age,
                'genres'           => $genres
            ];
        
            $model = new Book();
            $model->update($data);
        
            echo json_encode(['success' => true, 'message' => 'Книга обновлена!'], JSON_UNESCAPED_UNICODE);
        }
        
    }

?>