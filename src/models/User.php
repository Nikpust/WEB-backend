<?php

    namespace App\models;
    
    use App\core\Database;
    use PDO;
    use PDOException;

    class User {

        private PDO $db;
        private string $adminKey = 'admin';

        public function __construct() {
            $this->db = Database::connect();
        }

        public function register(array $data): array {
            $fullname = trim($data['name'] ?? '');
            $email    = trim($data['email'] ?? '');
            $password = $data['password'] ?? '';
            $isAdmin  = isset($data['is_admin']);
            $adminKey = $data['admin_key'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['success' => false, 'message' => 'Невалидный email'];
            }
            if (strlen($password) < 6) {
                return ['success' => false, 'message' => 'Пароль должен содержать не менее 6 символов'];
            }

            $role = 'user';
            if ($isAdmin) {
                if ($adminKey !== $this->adminKey) {
                    return ['success' => false, 'message' => 'Неверный ключ администратора'];
                } else {
                    $role = 'admin';
                }
            }

            try {
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE user_email = :email");
                $stmt->execute([':email' => $email]);
                
                if ($stmt->fetchColumn() > 0) {
                    return ['success' => false, 'message' => 'Email уже используется'];
                }

                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("
                    INSERT INTO users 
                      (user_fullname, user_email, user_password, user_role, user_created_at)
                    VALUES 
                      (:name, :email, :pass, :role, NOW())
                ");
                $stmt->execute([
                    ':name'  => $fullname,
                    ':email' => $email,
                    ':pass'  => $hashed,
                    ':role'  => $role
                ]);

                return ['success' => true, 'message' => 'Регистрация успешна!'];
            } catch (PDOException $e) {
                return ['success' => false, 'message' => 'Ошибка БД: ' . $e->getMessage()];
            }
        }

        public function login(array $data): array {
            $email = trim($data['email'] ?? '');
            $password = $data['password'] ?? '';

            try {
                $stmt = $this->db->prepare("SELECT * FROM users WHERE user_email = :email");
                $stmt->execute([':email' => $email]);

                $user = $stmt->fetch();

                if (!$user || !password_verify($password, $user['user_password'])) {
                    return ['success' => false, 'message' => 'Неверный email или пароль'];
                }

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_role'] = $user['user_role'];
                $_SESSION['user_name'] = $user['user_fullname'];

                return [
                    'success' => true,
                    'message' => 'Вход успешен!',
                    'redirect' => '/'
                ];
            } catch (PDOException $e) {
                return ['success' => false, 'message' => 'Ошибка БД: ' . $e->getMessage()];
            }
        }

    }
    
?>