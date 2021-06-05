<?php

namespace F360\Language;

/**
 * Classe de atuação como suporte ao processamento de linguagens.
 */
class Support
{
    public static function read_test_data($file_name)
    {
        $full_path = "./input_files/${file_name}";
        $content =  file_get_contents($full_path);
        $sanitized = trim($content);
    
        return $sanitized;
    }
}
