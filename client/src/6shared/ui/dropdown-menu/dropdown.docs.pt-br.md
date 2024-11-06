# DropdownMenu

> **Nota sobre escolha técnica:** Este componente foi desenvolvido como uma solução customizada ao invés de utilizar bibliotecas como Shadcn/ui, Radix/ui ou Bootstrap pelos seguintes motivos:
>
> - [Shadcn/ui](https://ui.shadcn.com/docs/): Por ser uma biblioteca com estilos predefinidos, limitaria nossa flexibilidade de customização
> - [Radix/ui](https://www.radix-ui.com/themes/docs): Causava quebras em várias partes do projeto durante os testes
> - [Bootstrap 4.6](https://getbootstrap.com/docs/4.6): O projeto utiliza Bootstrap 4.0.0-alpha, que não possui os scripts para o dropdown, e tentativas de atualização para o Bootstrap 4.6 resultavam em quebras críticas do projeto devido à grande diferença entre as versões

Componente de menu dropdown composto por subcomponentes para maior flexibilidade.

## Estrutura

- `Root`: Container principal do dropdown
- `Trigger`: Botão/elemento que ativa o dropdown
- `Content`: Container do conteúdo do dropdown
- `Item`: Item individual do dropdown

## Uso

### 1. Criar store do dropdown

```typescript
const useExampleDropdown = createDropdownMenuStore({
  initialState: { isOpen: false },
  devtoolsOptions: { name: 'Example Dropdown' },
})
```

### 2. Crie um DropdownMenu.Root adicionando o armazenamento criado anteriormente no atributo store

```typescript
<DropdownMenu.Root store={useExampleDropdown}>
    <DropdownMenu.Trigger>
        <span>Menu</span>
    </DropdownMenu.Trigger>
    <DropdownMenu.Content>
        <DropdownMenu.Item onClick={() => console.log('clicked')}>
            Option 1
        </DropdownMenu.Item>
        <DropdownMenu.Item onClick={() => console.log('clicked')}>
            Option 2
        </DropdownMenu.Item>
    </DropdownMenu.Content>
</DropdownMenu.Root>
```

## Tipos de Dropdown

### Default

#### Exemplo Visual

![Default UI Exemple](https://github.com/user-attachments/assets/d4ab391e-337b-4774-a386-9fceae86c794)

#### Exemplo em Código

![Default Code Exemple](https://github.com/user-attachments/assets/b9716029-f631-4528-9d87-82fcd856833d)

### Expansível

#### Exemplo Visual

![Expansive UI Exemple](https://github.com/user-attachments/assets/dc626766-825b-492a-8c38-c06d1b950178)

#### Exemplo de Código

![Expansive Code Example)](https://github.com/user-attachments/assets/7d6f3ab4-3443-4640-87fa-bc0403c15722)

## Atributos

### Split Mode

O modo split divide o trigger do dropdown em duas áreas clicáveis:

1. Área principal: executa uma ação direta
2. Seta: abre o menu dropdown

#### Exemplo de Split

```typescript
const useExampleDropdown = createDropdownMenuStore({
  initialState: { isOpen: false },
  devtoolsOptions: { name: 'Split Dropdown' }
})


<DropdownMenu.Root store={useExampleDropdown}>
  <DropdownMenu.Trigger split>
    {/* Main area - executes direct action */}
    <Button onClick={() => console.log('Direct Action')}>
      Publish Message
    </Button>
    {/* Arrow - opens menu with additional options */}
  </DropdownMenu.Trigger>
  <DropdownMenu.Content>
    <DropdownMenu.Item>Schedule post</DropdownMenu.Item>
    <DropdownMenu.Item>Save draft</DropdownMenu.Item>
  </DropdownMenu.Content>
</DropdownMenu.Root>
```

### Disable

O atributo disable desativa os subcomponentes do dropdown menu.

#### Exemplo de Disable

```typescript
const useExampleDropdown = createDropdownMenuStore({
  initialState: { isOpen: false },
  devtoolsOptions: { name: 'ExemploDropdown' }
})


<DropdownMenu.Root store={useExampleDropdown}>
  <DropdownMenu.Trigger disable>
    {/* Main area - executes direct action */}
    <Button onClick={() => console.log('Direct Action')}>
      Publish Message
    </Button>
    {/* Arrow - opens menu with additional options */}
  </DropdownMenu.Trigger>
  <DropdownMenu.Content >
    <DropdownMenu.Item disable>Schedule post</DropdownMenu.Item>
    <DropdownMenu.Item>Save draft</DropdownMenu.Item>
  </DropdownMenu.Content>
</DropdownMenu.Root>
```

## Gerenciamento de Estado com Zustand

O DropdownMenu utiliza Zustand para um gerenciamento de estado eficiente e poderoso. Veja como funciona:

### Criação da Store

```typescript
// Criação básica da store
const useDropdownStore = createDropdownMenuStore({
  initialState: {
    isOpen: false,
  },
  devtoolsOptions: { name: 'Estado do Dropdown' },
})

// Acessando valores da store
const isOpen = useDropdownStore((state) => state.isOpen)
const setIsOpen = useDropdownStore((state) => state.setIsOpen)
```

### Recursos da Store

- Persistência automática de estado
- Suporte nativo a TypeScript
- Integração com DevTools para depuração
- Renderizações mínimas
- Tamanho pequeno do bundle

## Exemplos Práticos de Uso

### Exemplo 1: Dropdown para Seleção de Categoria

```typescript
const useCategoryDropdown = createDropdownMenuStore({
  initialState: { isOpen: false },
  devtoolsOptions: { name: 'Category Dropdown' },
})

<DropdownMenu.Root store={useCategoryDropdown}>
  <DropdownMenu.Trigger >
    <span>Select Category</span>
  </DropdownMenu.Trigger>
  <DropdownMenu.Content>
    <DropdownMenu.Item onClick={() => handleCategorySelect('tech')}>
      Technology
    </DropdownMenu.Item>
    <DropdownMenu.Item onClick={() => handleCategorySelect('art')}>
      Art
    </DropdownMenu.Item>
    <DropdownMenu.Item onClick={() => handleCategorySelect('music')}>
      Music
    </DropdownMenu.Item>
  </DropdownMenu.Content>
</DropdownMenu.Root>

```

### Exemplo 2: Dropdown de Opções de Usuário

```typescript
const useProfileDropdown = createDropdownMenuStore({
  initialState: { isOpen: false },
  devtoolsOptions: { name: 'Profile Dropdown' },
})

<DropdownMenu.Root store={useProfileDropdown}>
  <DropdownMenu.Trigger>
    <Avatar />
  </DropdownMenu.Trigger>
  <DropdownMenu.Content>
    <DropdownMenu.Item onClick={() => navigateToProfile()}>
      View Profile
    </DropdownMenu.Item>
    <DropdownMenu.Item onClick={() => openSettings()}>
      Settings
    </DropdownMenu.Item>
    <DropdownMenu.Item onClick={() => handleLogout()} className="text-red-500">
      Logout
    </DropdownMenu.Item>
  </DropdownMenu.Content>
</DropdownMenu.Root>

```

### Exemplo 3: Dropdown de Ações de Mensagem

```typescript
const useMessageActionsDropdown = createDropdownMenuStore({
  initialState: { isOpen: false },
  devtoolsOptions: { name: 'Message Actions' },
})

<DropdownMenu.Root store={useMessageActionsDropdown}>
  <DropdownMenu.Trigger split>
    <span>Actions</span>
  </DropdownMenu.Trigger>
  <DropdownMenu.Content>
    <DropdownMenu.Item onClick={() => handleLike(messageId)}>
      Like Message
    </DropdownMenu.Item>
    <DropdownMenu.Item onClick={() => handleComment(messageId)}>
      Add Comment
    </DropdownMenu.Item>
    <DropdownMenu.Item onClick={() => handleShare(messageId)}>
      Share Message
    </DropdownMenu.Item>
  </DropdownMenu.Content>
</DropdownMenu.Root>

```
