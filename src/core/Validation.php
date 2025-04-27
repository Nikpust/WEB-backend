<?php

    namespace App\core;

    class Validation {
        public static function validate(string $data, string $pattern): bool {
            return preg_match($pattern, $data);
        }

        public static function clean(string $value, bool $removeRepeats = true): string {
            if ($removeRepeats) {
                $value = preg_replace('/([^\wа-яА-ЯёЁ])\1+/u', '$1', $value);
            }
            $value = preg_replace('/^[^a-zA-ZА-Яа-яёЁ0-9]+/u', '', $value);
            return $value;
        }
    }
    
?>