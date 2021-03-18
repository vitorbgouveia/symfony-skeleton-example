# Symfony template API

Template to easily create API with Symfony.

- [Symfony template API](#symfony-template-api)
  - [List of functionalities](#list-of-functionalities)
  - [How to start](#how-to-start)
    - [Instalation steps](#instalation-steps)
    - [Running the tests](#running-the-tests)
  - [Template structure](#template-structure)
  - [How to contrib](#how-to-contrib)

## List of functionalities

- @Route("api/example" methods={POST} )           -> Create an entity example;
- @Route("api/example" methods={PUT} )            -> Edit an entity example;
- @Route("api/example" methods={PATCH} )          -> Update an entity example;
- @Route("api/example/:id" methods={DELETE} )     -> Delete an example;
- @Route("api/example/parameter" methods={GET} )  -> Show an example filtered by parameter;
- @Route("api/example/search" methods={GET} )     -> Return a list of example filtered by advanced search;
- @Route("api/example/props" methods={GET} )      -> Return a json with properties used to filter an example;

## How to start

> Note: This template assume that you use Docker and Docker Compose to create yours development environment.

### Instalation steps

- Clone the project

  ```bash
    git clone https://github.com/vicentimartins/symfony-skeleton-example.git <your-app-name>
  ```

- Run environment and install dependencies

  ```bash
    cd <your-app-name>

    docker-compose up -d --build

    docker-compose exec app bash

    composer install -o
  ```

- Create the application database

  - Copy and edit .env configuration

    > Note: You need to set your database credentials.

    ```bash
      cp .env.dist .env
    ```

  - Execute doctrine database creation command

    ```bash
      bin/console doctrine:database:create
    ```

### Running the tests

> Note: This template don't have tests to validate anything, tests was not applied for this template.

- Tests need to be added to `/tests` folder

- Run `bin/phpunit` to execute the tests.

## Template structure

```text
|-- .docker
|   |-- Dockerfile
|   |-- nginx
|   |   |-- Dockerfile
|   |   |-- default.conf
|   |   |-- swagger
|-- database
|   |-- data
|-- application -- The Symfony structure.
|   |-- bin
|   |-- config
|   |-- migrations
|   |-- public
|   |-- src
|   |-- tests
|   |-- var
|   |-- vendor
|-- .env.dist
|-- .gitignore
|-- docker-compose.yml
|-- README.md
```

## How to contrib

All contributions are welcome. If something works differently than you expected, open an issue.

Otherwise, PR are welcome.
