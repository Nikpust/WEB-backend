<?php

    namespace App\core;

    class Patterns {
        public static function all(): array {
            return [
                'book' => '/^[a-zA-ZА-Яа-яёЁ0-9\s.,№"\'-()]+$/u',
                'author' => '/^[a-zA-ZА-Яа-яёЁ\s.,-]+$/u',
                'year' => '/^\d{1,4}$/',
                'publisher' => '/^[a-zA-ZА-Яа-яёЁ0-9\s.,-]+$/u',
                'isbn' => '/^\d{13}$/',
                'pages' => '/^\d+$/',
                'age' => '/^\d+$/',
                'weight' => '/^\d+(\.\d{1,2})?$/',
                'price' => '/^\d+(\.\d{1,2})?$/',
                'summary' => '/^[a-zA-ZА-Яа-яёЁ0-9\s.,!?"\'-:()]+$/u'
            ];
        }
    }
    
?>