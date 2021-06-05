# Teste de Lógica da F360

# Configuração da aplicação
Para executar essa aplicação você deve ter instalado em sua máquina o PHP e o
Composer. Caso esteja utilizando o ambiente Windows basta seguir esses passos:

1. Ir no site <windows.php.net/download> e baixar a versão mais recente do
PHP (arquivo .zip) e depois extrair o conteúdo em uma pasta e colocar essa pasta
na variável PATH de ambiente.

1. Depois iremos instalar o gerenciador de pacotes do PHP. Para isso vamos no site
<getcomposer.org> e basta baixar o instalador e seguir os passos na tela.

3. Após instalar os programas temos que pedir para que o Composer baixe
os pacotes necessários (se houver) através do comando `composer update` e depois
rodar o comando `composer dumpautoload` para gerar o mapeamento das classes.

E pronto. O seu projeto estará configurado!


## Execução da aplicação
Para executar a aplicação você deve rodar o seguinte comando na raiz do projeto:<br>
`php <nome do arquivo main> <tipo do texto>`.

Onde `<nome do arquivo>` é `source/Main` e `<tipo do texto>` deve ser `A` para
fazer o processamento do `texto` A ou `B` para fazer o processamento do `texto B`.


## Exemplo de uso da aplicação
O comando `php source/Main.php A` irá mostrar as métricas para o texto A.<br>
O comando `php source/Main.php B` irá mostrar as métricas para o texto B.


## Como faço para obter a vocabulário do texto B?
Ao rodar o seguinte comando o mesmo irá obter o vocabulário gerado:<br>
`php source\Main.php B --print-vocabulary`

Também é possível salvar o conteúdo gerado em um arquivo, através do seguinte 
comando se você estiver em um ambiente Unix (ou configurado o MSYS2 no Windows):<br>
`php source\Main.php B --print-vocabulary > output_files\klingon-textoB-ordenado.txt`
