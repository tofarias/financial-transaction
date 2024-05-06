# financial-transaction
financial transaction

##  To run the project locally

- run:
```sh
  git clone https://github.com/tofarias/financial-transaction.git
```
  ```sh
  cp .env.example .env
 ```

 ```sh
  docker run --rm \                                                   
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
 ```
- Create a 'sail' alias:
 ```sh
  alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
 ```
```sh
  sail up -d
 ```

 - In MySql create a database 'financ_transac', and then run:
 ```sh
  sail artisan migrate:refresh --seed
 ```
 - Access the endpoint:
```sh
http://localhost/api/v1
```

## Diagrama ER
![Captura de tela de 2024-05-05 11-27-05](https://github.com/tofarias/financial-transaction/assets/7261216/bd19f271-37fb-4e00-b566-296b351309b3)

## Documentação da API
- [http://localhost/docs/api](http://localhost/docs/api#/)
![Captura de tela de 2024-05-04 23-01-22](https://github.com/tofarias/financial-transaction/assets/7261216/bbab9226-c334-44a4-9671-d17bbd0901b1)

## Serviço de Mensageria
- [http://localhost:15672](http://localhost:15672)
    - username: guest
    - password: guest
![Captura de tela de 2024-05-05 06-59-19](https://github.com/tofarias/financial-transaction/assets/7261216/a1d903e6-7943-4402-9e99-8347c25c5f45)

