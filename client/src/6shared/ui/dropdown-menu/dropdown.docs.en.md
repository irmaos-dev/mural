# DropdownMenu

> **Technical Choice Note:** This component was developed as a custom solution instead of using libraries like Shadcn/ui, Radix/ui, or Bootstrap for the following reasons:
>
> - [Shadcn/ui](https://ui.shadcn.com/docs/): Being a library with predefined styles, it would limit our customization flexibility.
> - [Radix/ui](https://www.radix-ui.com/themes/docs): It caused issues in various parts of the project during testing.
> - [Bootstrap 4.6](https://getbootstrap.com/docs/4.6): The project uses Bootstrap 4.0.0-alpha, which doesn’t include the scripts for dropdowns, and attempts to update to Bootstrap 4.6 resulted in critical breaks in the project due to significant differences between versions.

Dropdown menu component composed of subcomponents for greater flexibility.

## Structure

- `Root`: Main container of the dropdown
- `Trigger`: Button/element that activates the dropdown
- `Content`: Container for the dropdown content
- `Item`: Individual dropdown item

## Usage

### 1. Create dropdown store

```typescript
const useExampleDropdown = createDropdownMenuStore({
  initialState: { isOpen: false },
  devtoolsOptions: { name: 'Example Dropdown' },
})
```

### 2. Create a DropdownMenu.Root adding previously created storage in the store attribute

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

#### Visual Example

![Default UI Exemple](https://github.com/user-attachments/assets/d4ab391e-337b-4774-a386-9fceae86c794)

#### Code Example

![Default Code Exemple](https://github.com/user-attachments/assets/b9716029-f631-4528-9d87-82fcd856833d)

### Expansive

#### Visual Example

![Expansive UI Exemple](https://github.com/user-attachments/assets/dc626766-825b-492a-8c38-c06d1b950178)

#### Code Example

![Expansive Code Example)](https://github.com/user-attachments/assets/7d6f3ab4-3443-4640-87fa-bc0403c15722)

## Atributes

### Split Mode

Split mode divides the dropdown trigger into two clickable areas:

1. Main area: executes a direct action
2. Arrow: opens the dropdown menu

#### Split Example

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

The disable attribute disables subcomponents of the dropdown menu.

#### Disable Example

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

## State Management with Zustand

The DropdownMenu uses Zustand for efficient and powerful state management. Here’s how it works:

### Creating the Store

```typescript
// Basic store creation
const useDropdownStore = createDropdownMenuStore({
  initialState: {
    isOpen: false,
  },
  devtoolsOptions: { name: 'Dropdown State' },
})

// Accessing store values
const isOpen = useDropdownStore((state) => state.isOpen)
const setIsOpen = useDropdownStore((state) => state.setIsOpen)
```

### Store Features

- Automatic state persistence
- Native TypeScript support
- DevTools integration for debugging
- Minimal re-renders
- Small bundle size

## Practical Usage Examples

### Example 1: Category Selection Dropdown

```typescript
const useCategoryDropdown = createDropdownMenuStore({
  initialState: { isOpen: false },
  devtoolsOptions: { name: 'Category Dropdown' },
})

<DropdownMenu.Root store={useCategoryDropdown}>
  <DropdownMenu.Trigger>
    <span>Select Category</span>
  </DropdownMenu.Trigger>
  <DropdownMenu.Content >
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

### Example 2: User Options Dropdown

```typescript
const useProfileDropdown = createDropdownMenuStore({
  initialState: { isOpen: false },
  devtoolsOptions: { name: 'Profile Dropdown' },
})

<DropdownMenu.Root store={useProfileDropdown}>
  <DropdownMenu.Trigger>
    <Avatar />
  </DropdownMenu.Trigger>
  <DropdownMenu.Content >
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

### Example 3: Message Action Dropdown

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
