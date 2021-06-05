<?php

namespace F360\Language;

/**
 * Classe responsável pelo processamento da linguagem Klingon.
 */
class Klingon
{
    protected static $letters_foo;
    protected static $letters_bar;
    protected static $alphabet_map;

    protected $firstRun = false;
    protected $text;

    public function __construct($text)
    {
        self::$letters_foo = str_split("slfwk");
        self::$letters_bar = str_split("brqdnxjmvhtcgzp");

        self::$alphabet_map = array_flip(
            str_split("kbwrqdnfxjmlvhtcgzps")
        );

        $this->text = trim($text);
    }

    private function get_three_letters_words()
    {
        $text_exploded = explode(" ", $this->text);
        
        $three_letter_words = array_filter($text_exploded, function($word) {
            return strlen($word) === 3;
        });

        return $three_letter_words;
    }

    public function get_prepositions()
    {
        $three_letters_words = $this->get_three_letters_words();

        $prepositions = array_filter($three_letters_words, function($word) {
            $letters = str_split($word);
        
            // a. Verifica se é uma "letra do tipo bar".
            $isBarType = in_array($letters[2], self::$letters_bar);
        
            // b. Verifica se a palavra não contém a letra "d'.
            $notDLetter = !in_array("d", $letters);
        
            return $isBarType && $notDLetter;
        });
    
        return $prepositions;
    }

    private function get_eight_or_more_letters_words()
    {
        $text_exploded = explode(" ", $this->text);
        
        $three_letter_words = array_filter($text_exploded, function($word) {
            return strlen($word) >= 8;
        });

        return $three_letter_words;
    }

    public function get_verbs()
    {
        $eight_letters_words = $this->get_eight_or_more_letters_words();

        $verbs = array_filter($eight_letters_words, function($word) {
            $letters = str_split($word);
        
            // a. Verifica se é uma "letra do tipo foo".
            $lastLetter = array_pop($letters);
            $isFooType = in_array($lastLetter, self::$letters_foo);

            return $isFooType;
        });
    
        return $verbs;
    }

    public function get_verbs_in_first_person()
    {
        $verbs = $this->get_verbs();

        $verbs_in_first_person = array_filter($verbs, function($word) {
            $letters = str_split($word);
        
            // a. Verifica se é uma "letra do tipo bar".
            $lastLetter = array_shift($letters);
            $isBarType = in_array($lastLetter, self::$letters_bar);

            return $isBarType;
        });
    
        return $verbs_in_first_person;

    }

    public function get_vocabulary_list()
    {
        $text_exploded = explode(" ", $this->text);
    
        $words_sorted = $text_exploded;
        usort($words_sorted, function($a, $b) {
            $a_split = str_split($a);
            $b_split = str_split($b);

            $a_len = count($a_split);
            $b_len = count($b_split);

            $smaller_word = $a_len < $b_len ? $a_split : $b_split;
            $smaller_word_len = count($smaller_word);

            for($i = 0; $i < $smaller_word_len; $i++) {
                $a_letter = $a_split[$i];
                $b_letter = $b_split[$i];

                $a_pos = self::$alphabet_map[$a_letter];
                $b_pos = self::$alphabet_map[$b_letter];

                if($a_pos !== $b_pos ) {
                    if($a_pos <  $b_pos) { return -1; }
                    if($a_pos == $b_pos) { return  0; }
                    if($a_pos >  $b_pos) { return +1; }
                }
            }

            // Caso especial. Quando a cadeia menor bate com a maior.
            if($a_len <  $b_len) { return -1; }
            if($a_len == $b_len) { return  0; }
            if($a_len >  $b_len) { return +1; }
        });

        $vocabulary_list = array_unique($words_sorted);

        return $vocabulary_list;
    }

    private function get_number_from_word($word)
    {
        $word_number = str_split($word);

        $number = 0;
        $word_number_len = count($word_number);
        for($i = 0; $i < $word_number_len; $i++) {
            $word_number_letter = $word_number[$i];

            $number_pos = self::$alphabet_map[
                $word_number_letter
            ];

            $exp = $i; $base_20 = pow(20, $exp);

            $number += $number_pos * $base_20;
        }

        return $number;
    }

    private function is_pretty_number($number)
    {
        // a. É maior ou igual a 440566.
        $isGreater = (
            $number >= 440566
        );

        // b. É divisível por 3
        $isDivisible = (
            $number % 3 === 0
        );

        return $isGreater && $isDivisible;
    }

    public function get_pretty_numbers()
    {
        $text_exploded = explode(" ", $this->text);

        $numbers = array_map(function($word) {
            return $this->get_number_from_word($word);
        }, $text_exploded);
        
        $pretty_numbers = array_filter($numbers, function($number) {
            return $this->is_pretty_number($number);
        });

        $pretty_numbers = array_values($pretty_numbers);

        return $pretty_numbers;
    }
}