## Como as ferramentas de execução funcionam

- Terminal
    - https://www.alura.com.br/artigos/cli-interface-linha-comandos
- Git
    - https://www.freecodecamp.org/portuguese/news/aprenda-o-basico-de-git-em-menos-de-10-minutos/

    como criar uma branch
        É possível criar uma branch no próprio projeto do Mural, porém é necessário que você já seja membro do projeto (eu costumo adicionar todo mundo interessado ao projeto, qualquer coisa me peça).
        Outra opção é criar um fork. Um fork é uma cópia do repositório para dentro da sua própria conta. Você então tem controle deste repositório criado.
        Para criar uma branch nova de fato, você pode utilizar o GitHub, o VSCode ou a linha de comando.
        No GitHub, clique em "Branches" na página inicial do repositório e então em "New Branch". Você então deve escolher o nome dessa branch e a base dela (geralmente a main, mas você pode criar a branch à partir de uma branch qualquer).
        No VSCode, clique no nome da branch ativa que fica no canto inferior esquerdo. Um menu irá aparecer onde você pode escolher a opção de criar nova branch (ou simplesmente trocar para uma outra branch existente - similar a fazer um "git checkout branch").
        Pela linha de comando, você pode executar o comando "git checkout -B nome-branch-nova".

    Como atualizar a branch com a main:
        Se você está pegou uma tarefa e está criando uma funcionalidade já há alguns dias, pode ser que uma outra pessoa tenha contribuído com alguma coisa, e portanto, a sua versão contém um código base desatualizado.
        Isso também pode acontecer caso você tenha clonado o repositório já há algum tempo e quando foi criar uma branch para sua tarefa não se atentou de atualizar a branch main. Portanto sua nova branch está fora de sincronia com a main.
        Para resolver isso, você deve mudar para a branch main (git checkout main), atualizá-la (git pull), voltar para a sua branch de origem (git checkout my-branch) e realizar o merge com a main (git merge main).
        Note que se seu projeto contém modificações que ainda não foram comitadas, você não conseguirá trocar para a main. Você tem duas opções: comitar essas modificações ou fazer um "stash". Basicamente o stash é um "armário" que você vai guardar as modificações para usá-las mais tarde.
        Ao realizar um merge, pode acontecer um "conflito". Essa é uma situação em que ambas as branches modificaram o código no mesmo lugar e, portanto, o Git não sabe qual o código ele deve realmente utilizar.
        TODO: copiar o link do vídeo falando sobre correção de conflitos para cá
        Vale mencionar, que é possível fazer esse procedimento com qualquer branch. Talvez você queira incluir as modificações de uma outra pessoa antes de enviar seu código para a main.

    Mas eu estou em um fork, como atualizo com a main?
        https://docs.github.com/pt/pull-requests/collaborating-with-pull-requests/working-with-forks/configuring-a-remote-repository-for-a-fork
        https://docs.github.com/pt/pull-requests/collaborating-with-pull-requests/working-with-forks/syncing-a-fork#syncing-a-fork-branch-from-the-command-line
    
    como fazer um stash para poder olhar alguma outra branch
        https://medium.com/wooza/git-stash-conhecendo-e-utilizando-um-dos-comandos-mais-pr%C3%A1ticos-para-o-versionamento-de-seu-c%C3%B3digo-a4dab3ac70da
        O VSCode tem na parte de "Controle de Código-Fonte" (Ctrl+Shift+G G) um conjunto de funcionalidades do Git, incluindo o Stash. É possível fazer todas as operações descritas no artigo acima sem precisar nem abrir o terminal. As funcionalidades mais usadas são "Apply Latest" e "Stash (Include Untracked)".

    pull request
        https://www.freecodecamp.org/portuguese/news/como-fazer-o-seu-primeiro-pull-request-no-github/


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
- Um adendo sobre gerenciadores de pacotes
    Essa seção serve para ambos NPM e Composer:
    O objetivo do arquivo "lock" é manter os pacotes do projeto em uma versão específica. E há uma discussão bem comum sobre comitar ou não esse arquivo. Particularmente, sou a favor de comitar.
    Porém por manter esse arquivo no Git, em alguns momentos temos conflitos ao adicionar novas dependências. Tome cuidado na resolução de um conflito como esse. Após resolver esse problema, certifique-se de instalar as dependências novamente para garantir que tudo está correto.
    Para reinstalar as dependências do projeto, você deve removar a pasta das dependências ("node_modules" para o NPM e "vendor" para o Composer).
    Ao fazer essa reinstalação, o gerenciador de pacotes vai usar as versões que estão no arquivo "lock" para baixar as dependências. Caso o arquivo não exista, o gerenciador vai buscar o conjunto de versões mais recentes dos pacotes para baixá-los e criar um novo arquivo "lock".
    Atenção! Se uma biblioteca em uma versão mais nova remover ou alterar uma funcionalidade dela que o projeto de fato está usando, podemos quebrar algo do projeto. E muitas vezes esse problema é silencioso, se manifestando apenas quando uma funcionalidade é executada dentro do sistema. Portanto cuidado ao atualizar as versões das dependências.
    Este é um grande motivo que usar muitas dependências em um projeto é uma prática malvista.
    A forma mais eficiente de identificar um problema desses é tendo testes automatizados, pois um teste irá resultar em falha se ele abordar uma funcionalidade que está gerando erros.
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
    - https://medium.com/hoppinger/type-driven-development-for-single-page-applications-bf8ee98d48e2
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

- React Hook Form
    https://medium.com/@Bigscal-Technologies/why-is-react-hook-form-better-than-other-forms-497054a6b2fe
    https://dev.to/majiedo/using-zod-with-react-hook-form-using-typescript-1mgk
- Zod
    Zod é útil para validar tanto os dados que vão para o server quanto os dados que voltam do server.
    O servidor não deve receber dados em um formato que não é o correto. Mesmo que o servidor também faça a validação dos dados, identificar um problema nos dados ainda dentro do client previne o envio de requisições inválidas, gerando menos tráfego de rede.
    E também o client também não deve receber dados inválidos, pois um dado inválido pode desencadear um erro inesperado que pode confundir o usuário. Além disso, no relatório de erros, nós desenvolvedores, saberemos que o erro aconteceu porque o servidor enviou dados em um formato inválido, descartando imediatamente um problema no client.
    https://www.treinaweb.com.br/blog/o-que-e-o-zod
    https://dev.to/vitorrios1001/validacao-de-formularios-com-react-hook-form-e-zod-a6k
    https://dev.to/vitorrios1001/criando-validacoes-de-endpoints-com-zod-k28
- Zustand
    https://www.freecodecamp.org/news/zustand-vs-usestate-how-to-manage-state-in-react/
    https://dev.to/teyim/using-zustand-to-manage-state-in-react-app-2iia
    https://pietrobondioli.com.br/articles/how-to-keep-zustand-sync-with-storage
    https://www.gabrielmaestre.com/blog/using-zustand-with-redux-devtools
- TanStack
    https://medium.com/@abdulrafayn001/tanstack-query-improve-your-web-apps-performance-and-reduce-boilerplate-code-708e30aeced3
    https://tkdodo.eu/blog/practical-react-query
    https://medium.com/@seeusimong/rendering-paginated-data-in-react-with-useinfinitequery-ece9771ec3a3
    https://dev.to/androbro/simplifying-data-fetching-with-zustand-and-tanstack-query-one-line-to-rule-them-all-3k87
    https://www.youtube.com/watch?v=1UpZgXaKkcw
- cn
    https://github.com/JedWatson/classnames/blob/main/README.md#usage
- Feature-Sliced Design
    https://blog.meetbrackets.com/architectures-of-modern-front-end-applications-8859dfe6c12e
    https://dev.to/m_midas/feature-sliced-design-the-best-frontend-architecture-4noj

Por que uma pasta "app"?
Toda aplicação requer algum tipo de configuração dos componentes, bibliotecas e funções utilitárias. O propósito dessa pasta é abrigar esse tipo de código, que não está diretamente ligada a nenhuma página ou regra de negócio específica.

Por que uma pasta "pages"?
Imagine um site que todo o conteúdo dele está contido em um único arquivo. Rapidamente esse arquivo fica extenso demais e difícil de trabalhar. Para evitar isso, separamos o conteúdo do site em múltiplos arquivos. No nosso caso, cada página do sistema possui uma pasta dentro do "2pages" e essa pasta contém alguns arquivos (a utilidade de cada um dos arquivos está descrita na explicação do Router).
Agora imagine que todas as páginas possuem coisas que se repetem, como por exemplo uma visualização das informações básicas do usuário. Caso outro dia você queira adicionar uma nova informação ao componente do usuário, você precisará alterar todas as páginas do sistema. É por isso que nós quebramos as páginas em partes ainda menores. Essas partes menores estarão localizadas nas pastas abaixo: "widgets" e "features". Logo se você alterar alguma coisa de um componente do "widgets", todas as páginas serão alteradas também.
Além disso, não podemos importar uma página dentro de outra página.

Por que uma pasta "widgets"?
Veja a subpasta "articles-feed". Ela define um componente que é usada de forma idêntica em duas páginas: "home" e "profile". Em vez de implementar exatamente a mesma lógica nas duas páginas, criamos um widget que pode ser usada em ambas páginas.
Um widget geralmente é composto de "features", localizados na pasta de baixo.
Contudo, o ideal é criar uma funcionalidade na feature primeiro e só movê-la para o "widgets" caso você precise violar alguma das restrições da feature.

Por que uma pasta "features"?
Os componentes "feature" são partes pequenas de funcionalidade. De forma geral, não viole as seguintes recomendações:
    - Ela deve fazer apenas uma coisa.
    - Ela não deve importar uma outra feature.
Caso você sinta necessidade de fazer alguma dessas coisas, chegou a hora de fazer um "widget".
Prefira fazer manipulações de dados nessa camada, ou seja, enviar requisições POST, PUT ou DELETE para o servidor.
È sempre mais fácil de trabalhar em aplicações onde é óbvio onde as mutações dos dados estão realmente acontecendo.

Por que uma pasta "entities"?
Para construir uma interface que consulte um servidor, nós precisaremos converter os dados que o servidor nos entrega em estruturas de dados convenientes para trabalhar com a interface em si.
Agora imagine que em todas as telas que utilizam algum dos conceitos da regra de negócio (por exemplo, usuários) precisarem criar essa mesma conversão na tela em questão. Teríamos rapidamente o códigos idênticos implementados em diferentes partes do sistema. E se você importasse a implementação de uma outra tela, você estaria criando uma dependência entre as telas e um desavisado teria grande dificuldade em encontrar onde estão essas definições.
Portanto, para evitar a dependência entre as telas e centralizar a definição dessas entidades, utilizamos essa pasta.
Se você ler os artigos sobre o "Feature-Sliced Design", vai ver que a pasta "entities" é considerada opcional.
Isso não quer dizer, que as coisas que estão lá dentro não são importantes. Mas no caso, os arquivos que estão nela poderiam estar na pasta "shared".
Então, por que não termos colocado essas entidades na pasta shared logo de cara? Essa separação é útil para deixar explicito que as coisas que estão nessa pasta não devem serem acessadas pelas outras coisas que estão na pasta de baixo (a pasta "shared").
Por outro lado, se você ler o conceito da pasta "shared", verá que não é o seu objetivo conter códigos que reflitam as regras de negócio. Infelizmente, no nosso projeto, temos essas definições de regras de negócio em ambas as pastas. Esse é um ponto em potencial de refatoração para o futuro.

Por que uma pasta "shared"?
Existem muitas coisas como utilitários para a integração com o backend ou um serviços externos, componentes de interface como buttons, inputs, etc, controle de estados e outras funções auxiliares que podem serem usadas em múltiplas partes de um sistema e que não possuem qualquer relacionamento com as regras de negócio, ou seja, a existência delas não interferem ou são criadas por um requisito dos dados ou pela forma que o sistema soluciona o nosso problema. São completamente genéricas.

Por que cada pasta contém mais outras pastas?
Dentro de cada uma das pastas principais (chamadas camadas), nós temos mais outras pastas que são chamas "slices". Os slices são agrupamentos de conceitos (ou domínios) da nossa regra de negócio. Por exemplo: articles, users, tags, etc.
Idealmente, um slice não deve chamar um outro slice. Caso você sinta a necessidade de fazer isso, pode ser que você esteja misturando responsabilidades do seu código. Uma saída para isso é abstrair o conceito sendo usado para uma camada inferior.

## Como as ferramentas do backend funcionam

https://medium.com/@rajvir.ahmed.shuvo/understanding-sync-attach-and-detach-in-laravel-managing-relationships-with-eloquent-394a7cf7fabd

- Outros
    - https://dev.to/guiselair/automatizando-formularios-com-devtools-2p9e
    - https://dev.to/guiselair/interceptando-requisicoes-no-devtools-39jl
    - https://dev.to/guiselair/usecallback-hook-entenda-quando-utiliza-lo-3n3k
    - https://vercel.com/guides/enhancing-security-for-redirects-and-rewrites
    - https://vercel.com/guides/understanding-xss-attacks
    - https://vercel.com/docs/edge-network/security-headers
    - https://vercel.com/blog/understanding-the-samesite-cookie-attribute
    - https://vercel.com/blog/understanding-csrf-attacks
    - https://jaimeneeves.medium.com/atualizando-seu-fork-do-github-1e2a78ee4cbf
