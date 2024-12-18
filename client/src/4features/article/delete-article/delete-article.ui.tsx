import { IoTrash } from 'react-icons/io5';
import { useNavigate } from 'react-router-dom';
import { pathKeys } from '~6shared/lib/react-router';
import { ModalContent, ModalFooter, ModalHeader, ModalRoot } from '~6shared/ui/modal';
import { useModalStore } from '~6shared/ui/modal';
import { spinnerModel } from '~6shared/ui/spinner';
import { useDeleteArticleMutation } from './delete-article.mutation';


type DeleteArticleButtonProps = { slug: string };

export function DeleteArticleButton(props: DeleteArticleButtonProps) {
  const { slug } = props;
  const navigate = useNavigate();

  // Usando a store do modal para controlar o estado do modal
  const { setOpen } = useModalStore(state => ({
    isOpen: state.isOpen,
    setOpen: state.setOpen,
  }));

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

  const handleDeleteConfirmation = () => {
    mutate(slug);
    setOpen(false);
  };

  const handleClick = () => {
    setOpen(true);
  };

  const handleCloseModal = () => {
    setOpen(false);
  };

  return (
    <>
      <button
        onClick={handleClick}
        className="btn btn-outline-danger btn-sm"
        type="button"
        disabled={isPending}
      >
        <IoTrash size={16} />
        &nbsp;Delete Article
      </button>
      <ModalRoot>
        <ModalHeader>Confirmação de Exclusão</ModalHeader>
        <ModalContent>
          Tem certeza que deseja deletar este artigo?
        </ModalContent>
        <ModalFooter>
          <button
            onClick={handleCloseModal}
            className="btn btn-secondary"
            type="button"
          >
            Cancelar
          </button>
          <button
            onClick={handleDeleteConfirmation}
            className="btn btn-danger"
            type="button"
          >
            Confirmar
          </button>
        </ModalFooter>
      </ModalRoot>
    </>
  );
}
