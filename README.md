# Customer-API

API desenvolvida utlizando a linguagem PHP, é uma ferramenta para gerenciamento de contatos que oferece recursos como adição, listagem, edição e exclusão de contatos, além de funcionalidades para registro e login de usuários. Com ela, é possível criar e manter uma base de dados de contatos de forma eficiente e segura. Além disso, a API pode ser facilmente integrada em outras aplicações, permitindo a criação de soluções personalizadas para diferentes necessidades.

## Pré-requisitos

- PHP 7.0 ou superior
- MySQL
- Apache

## Instalação

1. Clone este repositório para o seu computador:

   git clone https://github.com/renatormsilva/customer-api


2. Importe o arquivo customer-form.sql da pasta database para o seu banco de dados.

3. Abra o arquivo config.example.php, mude o nome para "config.php" e configure as seguintes variáveis com as informações do seu banco de dados:

    "<?php
    
        $host = "seu host";

        $user = "seu-usuario";

        $pass = "sua-senha";

        $dbname = "nome-do-banco-de-dados";

        $port = "sua-porta";
    ?>"


4. Inicie o servidor Apache.

5. Acesse a API através do navegador ou de um cliente HTTP (por exemplo, o Postman, Insomnia) utilizando a URL:

    http://localhost/customer-project/api


## Uso

A API possui os seguintes endpoints:

- `GET /api/customers/readCustomers` - retorna todos os clientes cadastrados 
- `GET /api/customers/getOnecustomer/{id}` - retorna um cliente específico pelo ID
- `POST /api/customers/createCustomer` - cria um novo cliente
- `PUT /api/customers/updateCustomer` - atualiza os dados de um cliente passando o ID na requisição
- `DELETE /api/customers/deleteCustomer/{id}` - exclui um cliente específico pelo ID
- `POST /api/users/createUser.php` - cria um novo usuário
- `POST /api/users/userLogin.php` - faz login de um usuário existente
- `GET /api/users/logout.php` - faz logout do usuário logado atualmente
- `GET /api/users/loggedVerigy.php` - faz avalidação se o usuário está logado
- `GET /api/users/checkUser` - Valida se o usuário já está cadastrado na plataforma

## Contribuição

Se você deseja contribuir para este projeto, por favor:

1. Faça um fork deste repositório.
2. Crie uma nova branch com suas alterações:

git checkout -b minha-feature


3. Faça commit das suas alterações:


4. Faça push para a branch criada:


5. Abra um pull request com suas alterações.
