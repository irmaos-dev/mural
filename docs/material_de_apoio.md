## Como as ferramentas de execução funcionam

- Terminal
    - https://www.alura.com.br/artigos/cli-interface-linha-comandos
- Git
    - https://www.freecodecamp.org/portuguese/news/aprenda-o-basico-de-git-em-menos-de-10-minutos/
    - https://www.freecodecamp.org/portuguese/news/como-fazer-o-seu-primeiro-pull-request-no-github/
- Docker Desktop / WSL
    - Por que usar o Docker Desktop? Porque de forma simplificada ele faz a instalação de tudo que é necessário para conseguirmos rodar os containers e o WSL.
    - https://medium.com/ipnet-growth-partner/wsl-2-rodando-linux-dentro-do-windows-f194e8b69496
- Docker / Docker Compose
    - https://medium.com/itautech/docker-uma-ferramenta-para-potencializar-o-desenvolvimento-de-softwares-534eabf18a4d
    - https://www.redhat.com/pt-br/topics/containers/what-is-docker
    - https://fullcycle.com.br/docker-vs-docker-compose/
    - https://blog.4linux.com.br/docker-compose-explicado/
- Make / Makefile
    - https://danielsaad.com/programacao-de-computadores-1-tai/assets/aulas/makefile.pdf
- prepare.sh
    - Esse arquivo é um script shell cuja finalidade é executar o comando "composer install" (que instala as dependências do projeto do backend) utilizando a imagem docker "laravelsail/php83-composer".
    A finalidade desse processo é simplificar o passos necessários para a instalação do backend. De outra forma, precisaríamos de instalar uma versão específica do PHP e o Composer e portanto, poderíamos criar um conflito de versões na máquina dos desenvolvedores que já possuissem outra versão desses softwares instalados.
- Composer / composer.json / lock
    - Não confunda "Composer" com "Docker Compose".
    - https://www.hostgator.com.br/blog/composer-o-que-e-como-usar/
    - https://kangaroohost.com.br/blog/composer-entendendo-o-que-e-como-funciona/#:~:text=lock%20.,para%20funcionar%20de%20maneira%20adequada.
- NPM / package.json
    - https://www.hostinger.com.br/tutoriais/o-que-e-npm
    - https://medium.com/@allangrds/tudo-que-voc%C3%AA-queria-saber-sobre-o-package-lock-json-mas-estava-com-vergonha-de-perguntar-e70589f2855f
- Sail
    - Sail é uma ferramenta do Laravel que simplifica o uso da Docker no projeto Laravel.
    - https://laravel.com/docs/11.x/sail
    - https://www.tonge.dev/tecnologia/um-guia-completo-para-o-laravel-sail
- PHPStan
    - https://medium.com/@viniciusmattosrj/phpstan-analisador-est%C3%A1tico-de-c%C3%B3digos-php-parte-i-c6856a10e56a
- Laravel Pint
    - Laravel Pint é um corretor de estilo de código PHP opinativo. Pint é construído em cima do PHP-CS-Fixer e simplifica o processo de garantir que seu estilo de código permaneça limpo e consistente.
    - https://imasters.com.br/back-end/padronizando-seu-codigo-com-php-cs-fixer
    - https://laravel.com/docs/11.x/pint
- Playwright
    - https://testingcompany.com.br/blog/playwright-conheca-essa-poderosa-ferramenta-para-automacao
    - Com uma ferramenta como o Playwright, você pode testar a aplicação como um todo, da forma que um usuário real utilizaria. Inclusive você pode simular cenários menos comuns como o uso de uma versão desatualizada do frontend com uma versão atualizada do backend.
- DBeaver
    - https://www.dio.me/articles/apresentando-o-dbeaver-community-administrando-varios-tipos-de-banco-de-dados-com-uma-unica-ferramenta
- Github Actions (CI)
    - https://zup.com.br/blog/github-actions-ci-cd

## Como as ferramentas do frontend funcionam

- React
    - https://react.dev/
- State Management
    - Utilizamos a biblioteca Zustand no projeto para o gerenciamento de estados. Exemplos de arquivos que usam a biblioteca: zustand.lib.ts, session.model.ts, filter-article.model.ts
    - https://awari.com.br/frontend-state-management-como-dominar-essa-habilidade-essencial-em-desenvolvimento-web/
- DTOs
    - Utilizamos a tipagem do Typescript e a biblioteca Zod para fazer os DTOs.
    Com o Zod, definimos a estrutura geral que um objeto deve ter, produzindo erros caso as regras dessa estrutura não sejam obedecidas.
    A partir dessa estrutura (schema), criamos um "type" do Typescript que chamamos de DTO.
    Exemplos de arquivos: 6shared/api/article/article.types.ts, 6shared/api/article/article.contracts.ts e 5entities/article/article.lib.ts
    - https://fischerafael.com/dtos-data-transfer-objects-simplificando-a-transferencia-de-dados/
- types
    - https://www.typescriptlang.org/docs/handbook/2/everyday-types.html
    - https://www.typescriptlang.org/docs/handbook/2/types-from-types.html
- Axios
    - Você provavalmente conhece a função "fetch" do Javascript. O propósito do Axios é bem similar: enviar requisições. Contudo, ele te fornece mais opções de uso como os interceptadores.
    Exemplos de arquivos: 1app/index.tsx, 6shared/lib/axios/AxiosContracts.ts
    - https://axios-http.com/docs/intro
- Router
    Usamos essa biblioteca "react-router-dom" para organizar as páginas do sistema.
    Exemplos de arquivos: 1app/providers/RouterProvider.tsx (veja a função createBrowserRouter), 6shared/lib/react-router/config.ts (que estão as definições das páginas existentes), 
    - https://www.freecodecamp.org/portuguese/news/um-guia-completo-de-react-router-para-iniciantes-incluindo-router-hooks/
    - https://medium.com/@younusraza909/loaders-in-react-router-71558c2988eb

    O início do uso do React Router Dom acontece no arquivo "RouteProvider.tsx", que chama os arquivo.route.tsx.
    O arquivo.route.ts é responsável por definir um objeto "RouteObject". No projeto, passamos ao RouteObject os parâmetros:
            "path" que é o caminho da página na URL
            "loader" que é definido no arquivo.model.tsx
            "element" que é definido no arquivo.ui.tsx
                (note que o elemento vindo do "ui" é transformado com a função "enhance" que basicamente associa o arquivo.skeleton.tsx a esse elemento)
    Para ver todas as declarações de rotas, pesquise em todos os arquivos pela string "RouteObject ="
    Note que todos os arquivos.route.ts cumprem propósito similar de apenas indicar qual o "loader" e "element" serão usados na página.
    "home-page.route.ts" é um exemplo do caso mais simples, enquanto "editor-page.route.tsc" define um comportamento diferente no caminho raiz (modo de criação) do caminho com um ":slug" (modo de edição).

    arquivos.model.ts são responsáveis por buscar os dados necessários para renderizar a página associada a ela (no backend ou no local storage, por exemplo) e também lida com alterações ao "mundo externo" (local storage, API, etc)
    Veja o arquivo "home-page.model.ts". A classe "HomeLoader" possui o método "homePage" executa classes "Queries" (vide TanStack) que são abstrações da API e então retorna uma série de Promises. Quando todas as Promises finalizarem com sucesso, o Router entende que os dados já foram obtidos e pode remover o Skeleton (mais sobre abaixo) em favor da interface real. Caso as Promises falhem, o elemento de erro padrão será exibido.
    Ainda no mesmo arquivo, vemos a classe "HomeModel" que possui métodos que alteram os dados da nossa memória (vide Zustand) e que consequentemente altera como a interface se parece.

    arquivos.ui.tsx são mais declarativos, como se fosse o HTML, e devem conter apenas lógica de exibição.
    
    arquivos.skeleton.tsx são a definido da Interface que você quer que seja exibida enquanto os dados daquela página não terminaram de ser carregados.
    Leia mais sobre isso: https://anshita0705.medium.com/engaging-users-with-progressive-loading-in-skeleton-screen-335a4e287a55
    Note que declaramos os skeletons através do método "enhance" que utilizam os auxiliares "compose" e "withSuspense". Não há necessidade de compreender o funcionamento destes, apenas note como usar.

- Zod
- Zustand
- TanStack
    https://dev.to/androbro/simplifying-data-fetching-with-zustand-and-tanstack-query-one-line-to-rule-them-all-3k87
    https://www.youtube.com/watch?v=1UpZgXaKkcw
- cn
- Feature-Sliced Design

Por que uma pasta "widgets"?
Veja a subpasta "articles-feed". Ela define um componente que é usada de forma idêntica em duas páginas: "home" e "profile". Em vez de implementar exatamente a mesma lógica nas duas páginas, criamos um widget que pode ser usada em ambas páginas. Além disso, não devemos importar uma página dentro de outra página.

Por que uma pasta "features"?
Estes são componentes que realmente realizam alguma mudança persistente.
Uma vantagem de separá-los para essa camada é que mudanças que afetem apenas a aparência de uma página não chegam perto desses componentes que realizam modificações nos dados, evitando bugs com informações dos usuários.
Isso também nos permite utilizá-los em múltiplos widgets e pages.
Por último, é sempre mais fácil de trabalhar em aplicações onde é óbvio onde as mutações dos dados estão realmente acontecendo.
