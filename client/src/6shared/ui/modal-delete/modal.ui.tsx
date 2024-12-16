import {
    ReactNode,
    createContext,
    useContext,
    useMemo,
} from 'react';
import { IoCloseCircleOutline } from 'react-icons/io5';
import styles from './modal.module.css';

type Store = {
    use: {
        isOpen(): boolean;
    };
    getState(): {
        setOpen(isOpen: boolean): void;
        toggle(): void;
    };
};

type ModalContextType = {
    store: Store;
};

const ModalContext = createContext<ModalContextType | null>(null);

function Root({ store, children }: { store: Store; children: ReactNode }) {
    const isOpen = store.use.isOpen();
    const contextValue = useMemo(() => ({ store }), [store]);

    return (
        <ModalContext.Provider value={contextValue}>
            {isOpen && (
                <div className={styles.overlay}>
                    <div className={styles.modal}>{children}</div>
                </div>
            )}
        </ModalContext.Provider>
    );
}

function Header({ children }: { children: ReactNode }) {
    const { store } = useContext(ModalContext)!;

    return (
        <div className={styles.header}>
            <h2>{children}</h2>
            <button
                onClick={() => store.getState().setOpen(false)}
                aria-label="Fechar modal"
                type="button" // Tipo explícito
                className={styles.buttonClose}
            >
                <IoCloseCircleOutline size={24} />
            </button>
        </div>
    );
}

function Content({ children }: { children: ReactNode }) {
    return <div className={styles.content}>{children}</div>;
}

function Footer({ children }: { children: ReactNode }) {
    return <div className={styles.footer}>{children}</div>;
}

export const Modal = { Root, Header, Content, Footer };
