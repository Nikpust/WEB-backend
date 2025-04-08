<?php
    function validation($data, $pattern) {
        return preg_match($pattern, $data);
    }

    function clean_input($value, $remove_repeats = true) {
        if ($remove_repeats) {
            $value = preg_replace('/([^\wа-яА-ЯёЁ])\1+/u', '$1', $value);
        }
        $value = preg_replace('/^[^a-zA-ZА-Яа-яёЁ0-9]+/u', '', $value);
        return $value;
    }
?>