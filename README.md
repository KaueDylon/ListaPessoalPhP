# Lista Pessoal PhP - Sistema de Gerenciamento
## Sobre o Projeto

Este projeto é um sistema simples de gerenciamento de usuários desenvolvido em PHP utilizando programação orientada a objetos (POO) e PostgreSQL.

A aplicação roda via terminal e permite realizar operações básicas de CRUD:

* Listar usuários
* Criar usuários
* Editar usuários
* Excluir usuários

O projeto utiliza:

* PDO para conexão com banco de dados
* Tratamento de exceções
* Paginação simples

---

# Tecnologias Utilizadas

* PHP 8.2
* PostgreSQL
* PDO (PHP Data Objects)

---

# Estrutura do Projeto

```bash
project/
├── entity/
│   └── UsuarioEntity.php
│
├── exceptions/
│   ├── PaginacaoException.php
│   └── IdNaoEncontradoException.php
│
├── repository/
│   └── UsuarioRepository.php
│
├── Database.php
├── Menu.php
└── Main.php
```
---

# Funcionalidades

## Usuários

O sistema permite:

* Criar novos usuários
* Buscar usuário por ID
* Atualizar usuário
* Excluir usuário
* Listar usuários com paginação

---

# Banco de Dados

## Banco utilizado

* PostgreSQL

---

## Schema do Banco

```sql
CREATE DATABASE phpbanco;
       
CREATE TABLE usuarios(
    id INT PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    nome VARCHAR(500) NOT NULL,
    email VARCHAR(500) NOT NULL UNIQUE,
    senha VARCHAR(20) NOT NULL
);
```

---

## Dados iniciais

```sql
INSERT INTO usuarios (nome, email, senha)
VALUES ('Gabriel', 'gab@email', 'gab123');
```

---

# Configuração do Ambiente

## 1. Instalar dependências

É necessário ter instalado:

* PHP 8 ou superior
* PostgreSQL

---

