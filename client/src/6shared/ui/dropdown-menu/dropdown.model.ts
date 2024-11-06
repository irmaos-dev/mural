import { StateCreator, create } from 'zustand'
import { DevtoolsOptions, devtools } from 'zustand/middleware'
import { createSelectors } from '~6shared/lib/zustand'

export type DropdownMenuStore = ReturnType<typeof createDropdownMenuStore>
export function createDropdownMenuStore(config: {
  initialState: DropdownState
  devtoolsOptions: DevtoolsOptions
}) {
  const { initialState, devtoolsOptions } = config

  const slice = createDropdownSlice(initialState)
  const withDevtools = devtools(slice, devtoolsOptions)
  const store = create(withDevtools)
  const useDropdownStore = createSelectors(store)

  return useDropdownStore
}

function createDropdownSlice(initialState: DropdownState) {
  const dropdownSlice: StateCreator<
    DropdownState & Actions,
    [['zustand/devtools', never]],
    [],
    DropdownState & Actions
  > = (set) => ({
    ...initialState,

    setOpen(isOpen: boolean) {
      set({ isOpen }, false, `setOpen ${isOpen}`)
    },

    toggle() {
      set((state) => ({ isOpen: !state.isOpen }), false, 'toggle')
    },

    reset() {
      set({ ...initialState }, false, 'reset')
    },
  })

  return dropdownSlice
}

export type DropdownState = {
  isOpen: boolean
}

type Actions = {
  setOpen(isOpen: boolean): void
  toggle(): void
  reset(): void
}
