# Mural App

Mural App é um software de rede social criada pelo <u>Clube de Desenvolvimento dos IrmãosDev</u>.

Essa iniciativa tem como propósito fornecer uma experiência real de desenvolvimento de software em equipe para jovens programadores.

Para participar, [preencha o formulário: http://eepurl.com/iYwzu6](http://eepurl.com/iYwzu6)

## Escopo do Projeto

O sistema consiste em uma rede social onde usuários poderão postar mensagens em um mural. Este mural é público e tem tamanho limitado, ou seja, em caso dele estar cheio, novas mensagens deverão substituir mensagens antigas. Cada mensagem fica no mural por, pelo menos, 1 minuto. Depois desse tempo, uma nova mensagem pode substituí-la e tomar o seu lugar.

A ordem das mensagens é definida pelos usuários, então atributos como `texto`, `data de criação` ou qualquer outro aspecto da mensagem não são considerados para definir a ordem das mensagens no mural.

Para mais informações, leia o [OVERVIEW.md](https://github.com/irmaos-dev/mural/blob/main/docs/OVERVIEW.md) do projeto

[//]: # "Marcelo, seria bom se você colocasse um print daquele protótipo que você mostrou em live."

## Como Funciona?

- Todo código deve ser adicionado por meio de Pull Requests;
- A branch `main` é bloqueada para commits diretos, portanto faça o fork do projeto;
- Você deverá compartilhar o progresso de suas tarefas semanalmente;
- Um dos mentores irá disponibilizar 30 minutos diários para uma call a fim de auxiliar os membros (opcional);
- Os membros pode solicitar tarefas e terão 1 semana para completá-las;

## Requisitos Mínimos

- HTML, CSS e/ou Javascript;
- Lógica de programação;
- Arquitetura client-server (REST-like);
- Noções de frameworks back-end e front-end;
- Interesse em aprender a tech stack.

## Tech Stack

- Front-End: Javascript (React);
- Back-End: PHP (Laravel).

## Ferramentas utilizadas

- Windows 10+;
- Visual Studio Code;
- Docker Desktop;
- Windows Subsystem for Linux;
- Node.JS;

### Posso usar alguma outra ferramenta fora essas?

Sim! Essa é a lista de ferramentas que iremos considerar na criação dos guias de instalação, executação, etc. Mas sinta-se à vontade para utilizar alternativas.

## Documentação do Projeto Base

https://realworld-docs.netlify.app/introduction/

## Instalação do Projeto

Para ambos client e server, é sugerido que utilize Docker Desktop em conjunto com o WSL 2 (Subsistema Windows para Linux).

- Primeiramente, instale o Docker Desktop:

https://docs.docker.com/desktop/install/windows-install/

- Siga o passo a passo a seguir para instalar o WSL 2:

https://www.certificacaolinux.com.br/como-instalar-ubuntu-no-windows-usando-wsl/

- Execute o comando a seguir para atualizar os pacotes do Linux

```sudo apt update && sudo apt upgrade```

- Instale o Node com o comando abaixo

```sudo apt-get install -y curl && curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/master/install.sh | bash && nvm install 20```

- Instale a extensão do WSL dentro do Visual Studio Code.

- Abra o terminal do WSL (menu iniciar -> pesquisar por WSL) e rode o comando a seguir para baixar o código do projeto e abrí-lo no Visual Studio Code:

`git clone https://github.com/irmaos-dev/mural.git && code mural`

Neste momento, o projeto do Mural App estará aberto no seu Visual Studio Code.

### Dependências do Front-End (Client)

- Abra o terminal e entre na pasta do projeto: `cd client`.

- Para instalar as dependências do projeto, rode o comando: `npm install`.

- Para rodar o projeto, execute: `npm run dev`.

### Dependências do Back-End (Server)

- Abra o terminal e rode o comando para instalar tudo: `sudo apt install make && cd server && make`.

- Para rodar o projeto, execute apenas: "make up" dentro da pasta "server".

### Banco de Dados

- Baixe e instale o DBeaver Community

https://dbeaver.io/download/

- Configure uma conexão Postgres para conectar com o banco de dados do server.

- Verifique as credenciais do servidor no arquivo `.env`.

### Testes com Playwright

Playwright é uma ferramenta que simula a interação de um usuário com o site no navegador.
Você cria código em Javascript que executa comandos no navegador, como preencher um campo ou apertar um botão.

Para instalar e executar os testes:

- Abra o terminal e entre na pasta do Playwright: `cd playwright`.

- Para instalar as dependências do projeto, rode o comando: `npm install`.

- Para executar a suite de testes, primeiro garanta que ambos os server e client estejam rodando e execute: `npx playwright test`.

### Screenshot da aplicação base

Você deverá conseguir rodar o projeto, registrar um usuário e logar, criar um artigo e ver a lista de artigos pelo feed, como na foto a seguir:

![image](https://github.com/user-attachments/assets/799d67bf-150d-46e4-9543-ed5d8f266edf)
