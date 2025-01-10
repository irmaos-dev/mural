# Testes Playwright

## Introdução

O Mural contém testes automatizados de interface utilizando o Playwright, uma ferramenta E2E (End-to-End) para testes de interface de usuário que automatiza a interação do navegador.

## Instalação

- Atenção execute os comandos abaixo na pasta `playwright` do projeto. ( `cd playwright`)

1. Instale as dependências node do projeto:

```bash
npm install
```

2. Instale as dependências do Playwright:

```bash
npx playwright install
```

## Inicialização

- Para executar os testes, execute o comando abaixo:

```bash
npm run test
```

Ou

```bash
npx playwright test
```

- Para executar os testes em modo headless, execute o comando abaixo:

```bash
npm run test:headless
```

Ou

```bash
npx playwright test --headed
```

- Caso necessário, altere o arquivo `.env` para configurar o ambiente de teste, como explicado na seção [Configuração de Ambiente para Playwright](#configuração-de-ambiente-para-playwright).

### Links Úteis

- Documentação do Playwright [`clique aqui`](https://playwright.dev/docs/intro/).

## Configuração de Ambiente para Playwright

Este arquivo `.env.example` contém variáveis de ambiente necessárias para configurar o Playwright em seu projeto. Abaixo está uma explicação de cada variável:

### Como Instalar

#### Windows

Execute o comando abaixo no terminal na pasta do playwright:

```bash
 copy .env.example .env
```

#### Linux

Execute o comando abaixo no terminal na pasta do playwright:

```bash
 cp .env.example .env
```

### Variáveis de Ambiente

#### CI

- **Descrição**: Indica que o ambiente é de Integração Contínua (CI).
- **Valor Padrão**: `false`
- **Possíveis Valores**: `true` ou `false`

#### BASE_URL

- **Descrição**: URL base da aplicação a ser testada.
- **Valor Padrão**: `127.0.0.1`

#### PORT

- **Descrição**: Porta da aplicação testada.
- **Valor Padrão**: `3000`

#### TIMEOUT

- **Descrição**: Tempo de espera (em milissegundos) para operações do Playwright.
- **Valor Padrão**: `120000` (120 segundos)

#### RETRIES

- **Descrição**: Número de tentativas em caso de falha nos testes.
- **Valor Padrão**: `2`

#### WORKERS

- **Descrição**: Quantidade de workers (processos) utilizados para executar os testes.
- **Valor Padrão**: `1`

#### SERVER_AUTO_MANAGEMENT

- **Descrição**: Liga e desliga servidores (back-end e front-end) automaticamente durante os testes.
- **Valor Padrão**: `true`
- **Possíveis Valores**: `true` ou `false`

#### TESTE_IN_PREVIEW

- **Descrição**: Indica se o teste é realizado com o preview do front-end. Necessário dar build no front-end manualmente antes, melhora a performance do teste.
- **Valor Padrão**: `false`
- **Possíveis Valores**: `true` ou `false`
