<?php

    namespace App\models;

    use App\core\Database;
    use PDO;
    use PDOException;

    class Book {
        private PDO $db;

        public function __construct() {
            $this->db = Database::connect();
        }

        public function getAll(): array {
            $query = "
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
            ";
    
            $stmt = $this->db->query($query);
            return $stmt->fetchAll();
        }
        
        public function existsByIsbn(string $isbn): bool {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM books WHERE book_isbn = :isbn");
            $stmt->execute([':isbn' => $isbn]);
            return $stmt->fetchColumn() > 0;
        }

        public function create(array $book): void {
            $db = $this->db;
        
            $db->beginTransaction();
        
            try {
                $stmt = $db->prepare("
                    INSERT INTO books 
                    (book_created_at, book_updated_at, book_name, book_author, book_year, book_publisher, book_isbn, book_pages, book_age, book_release_date, book_weight, book_price, book_summary)
                    VALUES (NOW(), NOW(), :name, :author, :year, :publisher, :isbn, :pages, :age, :release, :weight, :price, :summary)
                    RETURNING book_id
                ");
        
                $stmt->execute([
                    ':name'     => $book['book_name'],
                    ':author'   => $book['book_author'],
                    ':year'     => $book['book_year'],
                    ':publisher'=> $book['book_publisher'],
                    ':isbn'     => $book['book_isbn'],
                    ':pages'    => $book['book_pages'],
                    ':age'      => $book['book_age'],
                    ':release'  => $book['book_release_date'],
                    ':weight'   => $book['book_weight'],
                    ':price'    => $book['book_price'],
                    ':summary'  => $book['book_summary']
                ]);
        
                $book_id = $stmt->fetchColumn();
        
                # Вставка жанров
                foreach ($book['genres'] as $genre_name) {
                    # Найти genre_id или вставить новый
                    $stmt = $db->prepare("SELECT genre_id FROM genres WHERE genre_name = :name");
                    $stmt->execute([':name' => $genre_name]);
                    $genre_id = $stmt->fetchColumn();
        
                    if (!$genre_id) {
                        $stmt = $db->prepare("INSERT INTO genres (genre_name) VALUES (:name) RETURNING genre_id");
                        $stmt->execute([':name' => $genre_name]);
                        $genre_id = $stmt->fetchColumn();
                    }
        
                    # Связать книгу с жанром
                    $stmt = $db->prepare("INSERT INTO book_genre (book_id, genre_id) VALUES (:book_id, :genre_id)");
                    $stmt->execute([':book_id' => $book_id, ':genre_id' => $genre_id]);
                }
        
                $db->commit();
            } catch (PDOException $e) {
                $db->rollBack();
                die("Ошибка при добавлении книги: " . $e->getMessage());
            }
        }
        
        public function deleteById(int $id): void {
            $db = $this->db;
            $stmt = $db->prepare("DELETE FROM books WHERE book_id = :id");
            $stmt->execute([':id' => $id]);
        }

        public function getById(int $id): ?array {
            $stmt = $this->db->prepare("
                SELECT b.*, STRING_AGG(g.genre_name, ', ') AS genres
                FROM books b
                LEFT JOIN book_genre bg ON b.book_id = bg.book_id
                LEFT JOIN genres g ON g.genre_id = bg.genre_id
                WHERE b.book_id = :id
                GROUP BY b.book_id
            ");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch() ?: null;
        }

        public function update(array $book): void {
            $db = $this->db;
            $db->beginTransaction();
        
            try {
                $stmt = $db->prepare("
                    UPDATE books SET
                        book_name = :name,
                        book_author = :author,
                        book_year = :year,
                        book_publisher = :publisher,
                        book_isbn = :isbn,
                        book_pages = :pages,
                        book_age = :age,
                        book_release_date = :release,
                        book_weight = :weight,
                        book_price = :price,
                        book_summary = :summary,
                        book_updated_at = NOW()
                    WHERE book_id = :id
                ");
                $stmt->execute([
                    ':id'       => $book['book_id'],
                    ':name'     => $book['book_name'],
                    ':author'   => $book['book_author'],
                    ':year'     => $book['book_year'],
                    ':publisher'=> $book['book_publisher'],
                    ':isbn'     => $book['book_isbn'],
                    ':pages'    => $book['book_pages'],
                    ':age'      => $book['book_age'],
                    ':release'  => $book['book_release_date'],
                    ':weight'   => $book['book_weight'],
                    ':price'    => $book['book_price'],
                    ':summary'  => $book['book_summary']
                ]);

                $stmt = $db->prepare("DELETE FROM book_genre WHERE book_id = :id");
                $stmt->execute([':id' => $book['book_id']]);

                foreach ($book['genres'] as $genre_name) {
                    $stmt = $db->prepare("SELECT genre_id FROM genres WHERE genre_name = :name");
                    $stmt->execute([':name' => $genre_name]);
                    $genre_id = $stmt->fetchColumn();

                    if (!$genre_id) {
                        $stmt = $db->prepare("INSERT INTO genres (genre_name) VALUES (:name) RETURNING genre_id");
                        $stmt->execute([':name' => $genre_name]);
                        $genre_id = $stmt->fetchColumn();
                    }

                    $stmt = $db->prepare("INSERT INTO book_genre (book_id, genre_id) VALUES (:book_id, :genre_id)");
                    $stmt->execute([':book_id' => $book['book_id'], ':genre_id' => $genre_id]);
                }

                $db->commit();
            } catch (PDOException $e) {
                $db->rollBack();
                die("Ошибка при обновлении: " . $e->getMessage());
            }
        }

    }

?>