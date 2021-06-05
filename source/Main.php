<?php

require __DIR__ . "/../vendor/autoload.php";

use F360\Language\Support as LanguageSupport;
use F360\Language\Klingon as KlingonLanguage;


// Faz a leitura do texto A e realiza o processamento do mesmo pela classe.
if($argc < 2) {
    echo("Informe o texto a ser lido: 'A' ou 'B' como parâmetro.\n");
    echo("Ex.: 'php source/Main.php A' (p/ leitura do texto A).\n");
    return;
}

$text_type = $argv[1];

$to_print_vocabulary = false;
if($argc === 3) {
    $print_vocabulary = $argv[2];
    
    if($print_vocabulary === "--print-vocabulary") {
        $to_print_vocabulary = true;
    }
}


if($text_type === "A") {
    $text_to_read = "klingon-textoA.txt";
} else if($text_type === "B") {
    $text_to_read = "klingon-textoB.txt";
} else {
    echo("Parâmetro '{$text_type}' desconhecido. Use 'A' OU 'B'\n");
    return;
}

$text = LanguageSupport::read_test_data($text_to_read);
$klingon_language = new KlingonLanguage($text);

// Recolhe as preposições, verbos e verbos em primeira pessoa.
$prepositions = $klingon_language->get_prepositions();
$verbs = $klingon_language->get_verbs();
$verbs_in_first_person = $klingon_language->get_verbs_in_first_person();


$qtd__prepositions = count($prepositions);
$qtd__verbs = count($verbs);
$qtd__verbs_in_first_person = count($verbs_in_first_person);


// Recolhe o vocabulário.
$vocabulary_list = $klingon_language->get_vocabulary_list();


// Teste para verificar se o texto gerado é equivalente ao solicitado.
$text_A_ordenado = LanguageSupport::read_test_data("klingon-textoA-ordenado.txt");
$vocabulary_list_imploded = implode(" ", $vocabulary_list);

$is_vocabulary_right = $text_A_ordenado === $vocabulary_list_imploded;
$is_vocabulary_right__output = $is_vocabulary_right ? 'true' : 'false';

/*
echo "<textarea>";
echo $vocabulary_list;
echo "</textarea>";

echo "<textarea>";
echo $text_A_ordenado;
echo "</textarea>";

var_dump(
    "Vocabulário gerado = ao texto A ordenado? : {$is_vocabulary_right__output}"
);
*/


$pretty_numbers =  $klingon_language->get_pretty_numbers();
$qtd__pretty_numbers = count($pretty_numbers);

// Respostas para os problemas solicitados no enunciado do teste.
if(!$to_print_vocabulary) {
    echo("Qtd. de preposições: {$qtd__prepositions}\n");
    echo("Qtd. de  verbos: {$qtd__verbs}\n");
    echo("Qtd. de verbos em primeira pessoa: {$qtd__verbs_in_first_person}\n");
    echo("Qtd. de números bonitos: {$qtd__pretty_numbers}");
}

if($to_print_vocabulary) {
    echo($vocabulary_list_imploded);
}
