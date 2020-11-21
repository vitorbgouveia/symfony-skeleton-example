DESCRIÇÃO PS-{---}-API
=========================

- Em PHP com Symfony 5 

 Lista de funcionalidades:

 * @Route("api/exemplo"                                    methods={POST} )   -> Inserir um ---;
 * @Route("api/exemplo"                                    methods={PUT} )    -> Alterar um ---l;
 * @Route("api/exemplo/:id"                                methods={DELETE} ) -> Deletar pelo id um ---;
 * @Route("api/exemplo/consultar-por-parametro"            methods={GET} )    -> Retorna um determinado --- de acordo com os parâmetros;
 * @Route("api/exemplo/pesquisar-avancado"                 methods={GET} )    -> Retorna lista de ---;
 * @Route("api/exemplo/props"                              methods={GET} )    -> Retorna um json de propriedades que é usado para pesquisar um ---;

## Sumário
* [Começando](#começando)
* [Pré-requisitos](#Pré-requisitos)
* [Instalando](#Instalando)
* [Testando o sistema](#Testando-o-sistema)
* [Estrutura de código](#Padronização-de-codigo)

## Começando

### Pré-requisitos

* Docker
* VSCode

### Instalando


Clonando o projeto:
```bash
 git clone https://github.com/vitorbgouveia/symfony-skeleton-example.git
```

Instalar dependências do symfony:
```bash
 1 - docker exec -it ps-{---}-api bash
 2 - composer install
```

Populando o banco de desenvolvimento
```bash
# ainda na pasta etc
 1 - docker exec -it ps-{---}-api bash
 2 - php bin/console doctrine:database:create
 3 - php bin/console doctrine:migrations:migrate
```

## Testando o sistema
Explicação de como rodar os testes, quais níveis de testes, e comandos para criar mais testes, se houver.

Obs: Implementar testes;

## Estrutura de código
```
|-- config
|   |-- packages
|   |   |-- doctrine.yaml
|   |-- routes.yaml
|-- etc
|   |-- Dockerfile
|   |-- docker-compose.yaml
|   |-- nginx
|   |   |-- default.confg
|   |   |-- Dockerfile
|   |   |-- swagger
|   |   |   | -- swagger.json
|-- src
|   |-- Kernel.php
|   |-- Controller
|   |   |-- AbstractCrudController.php
|   |   |-- ExemploController.php
|   |-- Entity
|   |   |-- AbstractEntity.php
|   |   |-- Exemplo.php
|   |-- Migrations
|   |   |-- 
|   |-- Repository
|   |   |-- PaginatorRepository.php
|   |   |-- ExemploRepository.php
|   |-- Service
|   |   |-- ExemploService.php
|   |   |-- ValidarCampoUnicoService.php
|-- .env
|-- compose.json
|-- README.md
|-- LICENSE
```

# Docker

Rodar a imagem `docker-compose up -d --build`

Abrir no navegador `http://localhost:5555`

Swagger no navegador `http://localhost:5555/api-docs/`
