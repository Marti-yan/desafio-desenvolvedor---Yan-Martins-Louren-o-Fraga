

<h1> Yan Martins Lourenço Fraga</h1> 
<p>yan@martinscoders.com</p>
<h3>Deselvolvedor fullStack Jr.</h3>
<hr>

<p>Tem poucos commit pois fiz em outro repositorio, depois que deu um Fork no repositorio certo.</p>
<a href="https://github.com/Marti-yan/api-arquivos">https://github.com/Marti-yan/api-arquivos</a>

<hr>
<h4>Metodologia de desenvolvimento aplicada: 'Scrum'</h4>
<p>Técnica basiada em Scrum, mas voltada para implementação individual.</p>
<hr>
<br>

<b>$-VISÃO DO PROJETO</b>
<h1>O Desafio</h1>

<p> A API precisa ter no mínimo 3 endpoints, com as seguintes funcionalidades: </p>
<ul>
    <li>Upload de arquivo</li>
    <li>Histórico de upload de arquivo</li>
    <li>Buscar conteúdo do arquivo</li>
</ul>

<h3>As Regras de négocio:</h3>

<ul>
    <li> 
        <b>Upload de Arquivo:</b>
        <ol>-Deve ser possível enviar arquivos no formato Excel e CSV</ol>
        <ol>-Não é permitido enviar o mesmo arquivo 2x</ol>
    </li>
    <li> 
        <b>Histórico de upload de arquivo:</b>
        <ol>-Deve ser possível buscar um envio especifico por nome do arquivo ou data referência</ol>
    </li>
    <li> 
        <b>Buscar conteúdo do arquivo:</b>
        <ol>-Neste endpoint é opcional o envio de parâmetros mas deve ser possível enviar no mínimo 2 informações para busca, que seriam os campos <b>"TckrSymb" e "RptDt"</b>.</ol>
        <ol>-Se não enviar nenhum parâmetro o resultado deve ser apresentado páginado.</ol>
        <ol>
        -O retorno esperado deve conter no mínimo essas informações: <br>
            {                                                       <br>
                 "RptDt": "2024-08-22",                             <br>
                "TckrSymb": "AMZO34",                               <br>
                "MktNm": "EQUITY-CASH",                             <br>
                "SctyCtgyNm": "BDR",                                <br>
                "ISIN": "BRAMZOBDR002",                             <br>
                "CrpnNm": "AMAZON.COM, INC"                         <br>
            }                             
        </ol>
    </li>
</ul>

<hr>
<br>
<b>$-BACKLOG</b>
<h3>Solução:</h3>
<h5>"Quebrar o problema em problemas menores."</h5>
<h4> problema: montar a API</h4>
<ol> 
    <li>
        <b>PLANEJAMENTO</b> 
        <ul>
            <li>Recursos da API: quais entidades você vai expor (arquivos, linhas dos arquivos, e pesquisa de dados/linhas).</li>
            <li>
                <b># Endpoints</b><br>    
                -Upload de arquivo;<br>
                -Historico de upload de arquivo;<br>
                -buscar conteúdo do arquivo;<br>
            </li>
            <li>
                <b># Validações</b><br>
                -validação do tipo de arquivo de entrada;<br>
                -verificação de arquivo duplicado;<br>
                -importar apenas linhas especificas;<br>
                -filtros de pesquisas (arquivo/linha);<br>
            </li>
            <li>Formato de resposta: tratamento com middleware pra sempre retornar JSON, JSON tratados pra paginar e mostrar amigavelmente possiveis erros</li>
        </ul>
    </li>
    <li>
        <b>UPLOAD do arquivo</b>
        <ul>
            <li>
            <p>Pensando em uma futura aplicação com interface grafica, implementos o upload em 2° plano. </p>
            <p>Para facilitar a aparecencia da aplicação, não ficando presa processando o arquivo, e retornando rapidamente uma mensagem, enquanto a API termina de importar.</p>
            </li>
            <li>
              <b> # Requisição do arquivo, via POST</b><br>
                -Receber o arquivo;<br>
                -Salvar o nome original do arquivo;<br>
                -Criar um Hash do arquivo com md5;<br>
                -validar o tipo do arquivo;<br>
                -verificar se o arquivo não esta duplicado;<br>
            </li>
            <li>
            <b># IMPORT</b><br>
                - importar o arquivo pro banco de dados (maatwebsite);<br>
                - fillable com colunas especificas do arquivo;<br>
                - retonar JSON com resposta (sucesso ou erro);<br>
                - 
            </li>
            <li>
                <b># Historico de upload</b><br>
                - Criar uma data do upload do arquivo no BD;<br>
                - Listar os arquivos, principalmente por data;<br>
            </li>
        </ul>
    </li>
    <li>
        <b> BUSCAS </b><br>
        <ul>
            <b># metodos de buscar</b>
            <li>
                - Opção de retorno com ou sem o envio de paramentros; <br>
                - Se não tiver nenhum parametro, retornar paginado; <br>
                - Retorno esperado, minimo: (colunas principais); <br>
            </li>
        </ul>
    </li>
</ol>

