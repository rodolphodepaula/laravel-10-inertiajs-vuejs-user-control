<?php
/**
 * Funcoes Helpers para Sanitizar Dados.
 */

 /*
  * Sanitizando Codes (Items)
  */
if (! function_exists('sanitize_code')) {
    function sanitize_code($value)
    {
        $value = str_replace('.', '', $value);
        $value = str_replace('-', '', $value);
        $value = str_replace('_ ', '', $value);

        return trim($value);
    }
}

if (! function_exists('sanitize_document')) {
    function sanitize_document($value)
    {
        $value = str_replace('.', '', $value);
        $value = str_replace('-', '', $value);
        $value = str_replace('_ ', '', $value);

        return trim($value);
    }
}

if (! function_exists('remove_accents')) {
    function remove_accents($string)
    {
        return iconv('UTF-8', 'US-ASCII//TRANSLIT//IGNORE', $string);
    }
}

if (! function_exists('uc_word')) {
    function uc_word($text)
    {
        return trim(mb_convert_case($text, MB_CASE_TITLE));
    }
}

if (! function_exists('sanitize_mail')) {
    function sanitize_mail($email)
    {
        return strtolower(remove_accents(trim($email)));
    }
}

if (! function_exists('display_name')) {
    function display_name($nome = '')
    {
        $nomes = explode(' ', trim($nome));
        $nome = trim(array_shift($nomes));
        if (! empty($nomes)) {
            $nome .= ' '.trim(array_pop($nomes));
        }

        return trim($nome);
    }
}

if (! function_exists('first_name')) {
    function first_name($text)
    {
        $text = explode(' ', $text);

        return $text[0] ?? $text;
    }
}

if (! function_exists('name_email')) {
    function name_email($email)
    {
        $text = explode('@', sanitize_mail($email));
        $text = str_replace(['.', '_'], ' ', $text[0] ?? $text);

        return uc_word($text);
    }
}

if (! function_exists('money')) {
    function money($value = null, $currency = 'BRL')
    {
        $value = number_format($value, 2, ',', '.');
        if ($value !== false) {
            $value = ($currency == 'BRL' ? 'R$' : 'US$').' '.$value;
        }

        return $value;
    }
}

if (! function_exists('moneyDecimal')) {
    function moneyDecimal($value = null, $currency = 'BRL')
    {
        if (empty($value)) {
            return 0;
        }

        if (is_float($value)) {
            return floatval(number_format($value, 2, '.', ''));
        }

        if (preg_match('/^\d+(?:\.\d{0,2})?$/', $value)) {
            return floatval(number_format($value, 2, '.', ''));
        }

        if ($currency == 'BRL') {
            $value = str_replace(['R$', '.'], '', $value);
            $value = str_replace(',', '.', $value);
            $value = number_format($value, 2, '.', '');
        } else {
            $value = str_replace(['US$', ','], '', $value);
            $value = number_format($value, 2, '.', '');
        }

        return floatval($value);
    }
}

if (! function_exists('human_filesize')) {
    function human_filesize($size, $precision = 1)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $step = 1024;
        $i = 0;
        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }

        return round($size, $precision).$units[$i];
    }
}
