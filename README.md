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
- DBeaver.

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

- Instale as dependências do projeto com o comando abaixo

```sudo apt-get install -y curl make && curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/master/install.sh | bash && nvm install 20```

- Instale a extensão do WSL dentro do Visual Studio Code.

- Abra o terminal do WSL (menu iniciar -> pesquisar por WSL) e rode o comando a seguir para baixar o código do projeto e abrí-lo no Visual Studio Code:

`git clone https://github.com/irmaos-dev/mural.git && code mural`

Neste momento, o projeto do Mural App estará aberto no seu Visual Studio Code.

### Instalação do Front-End (Client)

- Abra o terminal e entre na pasta do projeto: `cd client`.

- Para instalar as dependências do projeto, rode o comando: `npm install`.

- Para rodar o projeto, execute: `npm run dev`.

### Instalação do Back-End (Server)

- Altere a pasta atual do terminal com o comando `cd server` e rode o comando `make` que irá instalar o servidor.

- Configure o seu terminal segundo o passo a passo descrito no tópico [Configuring A Shell Alias](https://laravel.com/docs/11.x/sail#configuring-a-shell-alias)

- Para rodar o projeto, execute: `sail up` dentro da pasta "server".

- Para parar a execução, rode o comando: `sail down` dentro da pasta "server".

A ferramenta "Sail" facilita o uso dos containers do servidor. Para entender melhor, acesse a [documentação](https://laravel.com/docs/11.x/sail).

### Outras informações

[Instruções de como utilizar as outras ferramentas](https://github.com/irmaos-dev/mural/blob/main/docs/outras_ferramentas.md) usadas no projeto.

Veja nesse outro link, [problemas comuns](https://github.com/irmaos-dev/mural/blob/main/docs/problemas_comuns.md) que você pode encontrar no projeto.

### Screenshot da aplicação base

Você deverá conseguir rodar o projeto, registrar um usuário e logar, criar um artigo e ver a lista de artigos pelo feed, como na foto a seguir:

![image](https://github.com/user-attachments/assets/799d67bf-150d-46e4-9543-ed5d8f266edf)
