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

### Como abrir a documentação da API

- run `php artisan l5-swagger:generate` para construir o JSON Swagger à partir das annotations;
- Um arquivo vai ser gerado em `/storage/api-docs/api-docs.json`;
- Então, navegue para `http://localhost:8081/api/documentation`.