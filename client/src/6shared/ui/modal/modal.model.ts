// modal.model.ts
import create from 'zustand';

interface ModalStore {
    isOpen: boolean;
    setOpen: (isOpen: boolean) => void;
    toggle: () => void;
}

export const useModalStore = create<ModalStore>((set) => ({
    isOpen: false,
    setOpen: (isOpen) => set({ isOpen }),
    toggle: () => set((state) => ({ isOpen: !state.isOpen })),
}));
