
# Desafio Brasil Tecpar

Este repositório contem os scripts feitos para o desafio de recrutamento da Brasil Tecpar




## Instalação

É necessário ter uma base de dados em PostgreSQL instalado na máquina para isso recomendo subir um banco de dados seguindo o passo-a-passo de acordo com [esse repositório](https://github.com/rafaelmartines/docker-compose-databases) no Github.

Anotar o IP da máquina host a partir do comando abaixo no terminal

### Windows
```shell
ipconfig
```
### Linux
```bash
ifconfig
```

Dentro da pasta tecpar do projeto, criar um arquivo .env.local

```bash
cp .env .env.local
```

Descomentar e editar os dados necessários na linha 28

Subir o docker, executando o seguinte comando na pasta raiz do projeto:

```bash
docker-composer up -d
```

Executar o comando:

```bash
docker exec -it brasil_tecpar sh
```

Executar o composer, dentro das pasta tecpar:

```bash
composer install
```

E instalar os assets para o swagger, dentro da pasta tecpar

```bash
php bin/console assets:install
```

E executar o seguinte comando para criar a tabela no banco de dados:

```bash
php bin/console doctrine:migrations:migrate
```

Ao final do projeto acessar o projeto pelo link: http://localhost:8080/api/doc
