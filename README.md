## Documentação 
* Ferramenta: Laravel 8 e VueJS

### Guia de instalaçao 
#### Pré-requisitos 
* PHP: * Versão >= 7.2.0
* OpenSSL PHP Extension 
* PDO PHP Extension 
* Mbstring PHP Extension 
* Tokenizer PHP Extension 
* XML PHP Extension 
* Ctype PHP Extension 
* JSON PHP Extension + Banco de dados (MySQL, SQLite) + Servidor web (Apache)
* Composer. 

##### Passo a passo 

1. Clone o repositório para seu computador; 

2. Dentro da pasta principal do projeto crie um arquivo com o nome: **.env**;

3. Copie o conteúdo do arquivo **.env.example** para o arquivo **.env** recém criado; 

4. Acesse o repositório com um terminal e execute o comando: **composer install**; 

5. Ainda no terminal, gere uma application key com o comando: **php artisan key:generate**; 

6. Configure o arquivo **.env** com as configurações do banco de dados local; 

**Exemplo:**

````

DB_DATABASE=nome_do_seu_banco_de_dados

DB_USERNAME=seu_username

DB_PASSWORD=sua_password

````
 
7. No terminal, execute as migrations com o comando: **php artisan migrate**; 

8. execute o comando: **npm install** para instalar as dependencias necessarias; 

9. Para executar o projeto, use o comando: **php artisan serve**;

10. Acesse a URL indicada no terminal;