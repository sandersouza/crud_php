Basic CRUD Application

Este projeto inclui uma aplicação básica de CRUD (Create, Read, Update, Delete) utilizando Nginx, PHP e MySQL. O projeto é gerenciado usando docker-compose para facilitar o desenvolvimento e a implantação.

Estrutura do Projeto

- nginx/: Diretório contendo a configuração do Nginx.
- public/: Diretório contendo os arquivos PHP.
- dbdata/: Diretório para dados persistentes do MySQL.
- docker-compose.yml: Arquivo de configuração do Docker Compose.
- api.php: Script PHP para a API de backend.
- README.md: Este arquivo.

Pré-requisitos
---
Antes de iniciar, você precisa ter o Docker e o Docker Compose instalados em seu sistema. Você pode instalar estas ferramentas no site oficial do Docker.

Como Usar

Iniciar o Projeto
---
Para iniciar todos os serviços definidos no docker-compose.yml, execute o seguinte comando no diretório raiz do projeto:

$ docker-compose up -d

Acessar a Página
---
Após iniciar os serviços, você pode acessar a aplicação web navegando para:

http://localhost:8080

Usar a API
---
A API pode ser acessada através dos seguintes endpoints:

Listar Registros
---
curl -X GET http://localhost/api.php

Criar Registro
---
curl -X POST http://localhost/api.php \
-H 'Content-Type: application/json' \
-d '{"first_name": "Nome", "last_name": "Sobrenome", "phone": "999999999"}'

Atualizar Registro
---
curl -X PUT http://localhost/api.php \
-H 'Content-Type: application/json' \
-d 'id=1&first_name=Nome&last_name=Sobrenome&phone=888888888'

Deletar Registro
---
curl -X DELETE http://localhost/api.php \
-H 'Content-Type: application/json' \
-d 'id=1'

Limpeza
---
Para parar e remover todos os containers, networks e volumes criados pelo Docker Compose, use:

$ docker-compose down

Contribuições
---
Contribuições são bem-vindas! Por favor, crie um fork do projeto e envie um Pull Request com suas melhorias.

Licença
---
Este projeto está licenciado sob a Licença MIT. Veja o arquivo LICENSE para mais detalhes.