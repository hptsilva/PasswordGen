# PasswordGen

PasswordGen é uma aplicação de linha de comando (CLI) para gerar, armazenar, listar, atualizar e excluir senhas em um banco de dados MySQL. Ele utiliza o Symfony Console para gerenciar comandos e o PDO para interagir com o banco de dados.

## Funcionalidades

- **Gerar Senhas**: Crie senhas seguras para diferentes sites.
- **Armazenar Senhas**: Salve as senhas geradas no banco de dados.
- **Listar Senhas**: Exiba todas as senhas armazenadas.
- **Atualizar Site**: Atualize o nome do site associado a uma senha.
- **Excluir Senhas**: Remova senhas do banco de dados.
- **Migração de Banco de Dados**: Configure automaticamente o banco de dados e as tabelas necessárias.

## Requisitos

- PHP 8.0 ou superior
- Composer
- MySQL/MariaDB
- Extensão PDO habilitada

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/hptsilva/PasswordGen.git
   cd PasswordGen

2. Instale as dependências com o Composer:
    ```bash
   composer install

3. Configure o arquivo .env: Copie o arquivo .env.example para .env e preencha as informações do banco de dados:
    ```bash
   cp src/.env.example src/.env

4. Faça as migrações usando o comando:
    ```bash
   php password migrate

## Uso
Comandos disponíveis:
```php
# Mostre todas as senhas salvas no registro
php password show
```
```php
# Gerar a senha. Defina o tamanho da senha <length> e o nome do site para essa senha <site>
php password generate <length> <site>
```
```php
# Altere o site da senha inserindo o ID correspondente. 
php password update <id>
```
```php
# Apagar do registro a senha a partir do ID fornecido.
php password delete <id>
```

