# Mural

O Mural é um software de rede social criada pelo Clube de Desenvolvimento dos Irmãos.Dev.
Essa iniciativa tem como propósito te fornecer uma experiência real de desenvolvimento em equipe que você pode colocar no seu currículo.

Para participar, preencha o formulário:
https://forms.gle/mxC9LdM4ckJThFno9

## Escopo do projeto

O sistema consiste em uma rede social onde usuários poderão postar mensagens em um mural. Este mural é público e tem tamanho limitado, ou seja, em caso dele estar cheio, novas mensagens deverão substituir mensagens antigas. Cada mensagem fica no mural por, pelo menos, 1 minuto. Depois desse tempo, uma nova mensagem pode substituí-la e tomar o seu lugar.

A ordem das mensagens é definida pelos usuários, então atributos como `texto`, `data de criação` ou qualquer outro aspecto da mensagem não são considerados para definir a ordem das mensagens no mural.

Para mais informações, leia o [OVERVIEW.md](https://github.com/irmaos-dev/mural/blob/main/OVERVIEW.md) do projeto

[//]: # "Marcelo, seria bom se você colocasse um print daquele protótipo que você mostrou em live."

## Processos

- Todo código deve ser adicionado por meio de Pull requests. A branch `main` é bloqueada para commits diretos
- Você deve compartilhar o progresso de suas tarefas, pelo menos, a cada 7 dias
- Um dos mentor irá disponibilizar 30 minutos diários para uma call para ajudar os membros (opcional)
- Um membro pode requisitar uma task e terá cerca de 7 dias para completá-la

## Requisitos Mínimos

- HTML e CSS
- Lógica de programação
- Arquitetura client-server (REST-like)
- Testes Automatizados

## Tech Stack

- React no front-end
- Laravel no back-end

## Instalação

Para ambos client e server, é sugerido que utilize o WSL 2.

Primeiramente, instale o Docker Desktop:

https://docs.docker.com/desktop/install/windows-install/

Depois, siga o passo a passo a seguir:

https://www.certificacaolinux.com.br/como-instalar-ubuntu-no-windows-usando-wsl/

Abra o terminal do WSL e rode o comando a seguir:

`git clone https://github.com/irmaos-dev/mural.git && code mural`

Neste momento, o projeto do Mural estará aberto no seu Visual Studio Code.

### Client

Para instalar, abra o terminal e rode o comando:

```
cd client
npm install
```

Para rodar o client, rode:

`npm run dev`

### Server

Para instalar, abra um novo terminal e rode o comando:

```
cd server
composer install
php artisan migrate
```

Para rodar o server, rode:

```
vendor/bin/sail up
```

### Banco de Dados

Baixe e instale o DBeaver Community

https://dbeaver.io/download/

Configure uma conexão Postgres para conectar com o banco de dados do server.
Verifique as credenciais do servidor no arquivo .env