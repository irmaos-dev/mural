import { useState } from 'react';
import { IoTrash } from 'react-icons/io5'; // Ícone para botão
import { useNavigate } from 'react-router-dom'; // Navegação
import { pathKeys } from '~6shared/lib/react-router';
import { Modal } from '~6shared/ui/modal-delete'; // Importação do modal
import { spinnerModel } from '~6shared/ui/spinner';
import { useDeleteArticleMutation } from './delete-article.mutation';

type DeleteArticleButtonProps = { slug: string };

export function DeleteArticleButton(props: DeleteArticleButtonProps) {
  const { slug } = props;
  const navigate = useNavigate();

  // Estado para controle do modal
  const [isModalOpen, setIsModalOpen] = useState(false);

  const { mutate, isPending } = useDeleteArticleMutation({
    mutationKey: [slug],
    onMutate: () => {
      spinnerModel.globalSpinner.getState().show();
    },
    onSuccess: () => {
      navigate(pathKeys.home(), { replace: true });
    },
    onSettled: () => {
      spinnerModel.globalSpinner.getState().hide();
    },
  });

  // Função para confirmar a exclusão
  const handleDeleteConfirmation = () => {
    mutate(slug);
    setIsModalOpen(false); // Fecha o modal após a confirmação
  };

  // Função para abrir o modal
  const handleClick = () => {
    setIsModalOpen(true);
  };

  // Função para fechar o modal
  const handleCloseModal = () => {
    setIsModalOpen(false);
  };

  return (
    <>
      <button
        onClick={handleClick}
        className="btn btn-outline-danger btn-sm"
        type="button" // Adicionado tipo explícito
        disabled={isPending}
      >
        <IoTrash size={16} />
        &nbsp;Delete Article
      </button>

      {/* Modal de Confirmação */}
      <Modal.Root
        store={{
          use: { isOpen: () => isModalOpen },
          getState: () => ({
            setOpen: setIsModalOpen,
            toggle: () => setIsModalOpen((prev) => !prev),
          }),
        }}
      >
        <Modal.Header>Confirmação de Exclusão</Modal.Header>
        <Modal.Content>
          Tem certeza que deseja deletar este artigo?
        </Modal.Content>
        <Modal.Footer>
          <button
            onClick={handleCloseModal}
            className="btn btn-secondary"
            type="button" // Adicionado tipo explícito
          >
            Cancelar
          </button>
          <button
            onClick={handleDeleteConfirmation}
            className="btn btn-danger"
            type="button" // Adicionado tipo explícito
          >
            Confirmar
          </button>
        </Modal.Footer>
      </Modal.Root>
    </>
  );
}
