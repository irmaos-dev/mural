import { ReactNode } from 'react';
import { IoCloseCircleOutline } from 'react-icons/io5';
import { useModalStore } from './modal.model';
import styles from './modal.module.css';

type ModalProps = {
    children: ReactNode;
};

export function ModalRoot({ children }: ModalProps) {
    const { isOpen, setOpen } = useModalStore((state) => ({
        isOpen: state.isOpen,
        setOpen: state.setOpen,
    }));

    const closeModal = () => {
        setOpen(false);
    };

    return isOpen ? (
        <div
            className={styles.overlay}
            aria-hidden="true"
        >
            <div
                className={styles.modal}
                role="dialog"
                aria-labelledby="modal-title"
                tabIndex={-1}
            >
                <button
                    onClick={closeModal}
                    className={styles.closeButton}
                    aria-label="Close modal"
                    type="button"
                >
                    <IoCloseCircleOutline size={24} />
                </button>
                {children}
            </div>
        </div>
    ) : null;
}

export function ModalHeader({ children }: { children: ReactNode }) {
    return (
        <div className={styles.header}>
            <h2 id="modal-title">{children}</h2>
        </div>
    );
}

export function ModalContent({ children }: { children: ReactNode }) {
    return <div className={styles.content}>{children}</div>;
}

export function ModalFooter({ children }: { children: ReactNode }) {
    return <div className={styles.footer}>{children}</div>;
}
