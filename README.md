# Casafy Backend Test

#### Requerimentos
1. Docker(20.10.5) ou mais recente
2. Docker Compose(1.28.5) ou mais recente

#### Instalação
Suba os containers.
```sh
docker-compose up -d
```

Instale as dependências
```sh
docker exec -it php-fpm composer update
```

Rode as migrações de banco de dados
```sh
docker exec -it php-fpm php artisan migrate
```

#### Teste
Para exeutar
```sh
docker exec -it php-fpm php artisan test
```

#### Como usar
##### Users
[GET]
`seu ip`[/api/v1/users](#)
Retorna todos os usuários cadastrados

[POST]
`seu ip`[/api/v1/users](#)
Cria um novo usuário

[GET]
`seu ip`[/api/v1/users/{id}](#)
Retorna um usuário específico pelo id

[PUT]
`seu ip`[/api/v1/users/{id}](#)
Atualiza o usuário específico pelo id

[DELETE]
`seu ip`[/api/v1/users/{id}](#)
Apaga o usuário específico pelo id

[GET]
`seu ip`[/api/v1/users/{id}/properties](#)
Retorna o usuário específico pelo id e todas as suas propriedades

##### Properties
[GET]
`seu ip`[/api/v1/properties](#)
Retorna todos os propriedades cadastradas

[POST]
`seu ip`[/api/v1/properties](#)
Cria um novo propriedade

[GET]
`seu ip`[/api/v1/properties/{id}](#)
Retorna um propriedade específica pelo id

[PUT]
`seu ip`[/api/v1/properties/{id}](#)
Atualiza o propriedade específica pelo id

[DELETE]
`seu ip`[/api/v1/properties/{id}](#)
Apaga o propriedade específica pelo id

