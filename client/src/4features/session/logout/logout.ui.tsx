import { ButtonHTMLAttributes } from 'react'
import { useNavigate } from 'react-router-dom'
import { pathKeys } from '~6shared/lib/react-router'
import { useLogoutMutation } from './logout.mutation'

type ButtonProps = Omit<ButtonHTMLAttributes<HTMLButtonElement>, 'onClick'>

interface LogoutButtonProps extends ButtonProps {
  children?: React.ReactNode
}

export function LogoutButton({
  children = 'Or click here to logout.',
  className = 'btn btn-outline-danger',
  ...buttonProps
}: LogoutButtonProps) {
  const navigate = useNavigate()

  const { mutate } = useLogoutMutation({
    onSuccess: () => {
      navigate(pathKeys.home())
    },
  })

  const handleClick = () => {
    mutate()
  }

  return (
    <button
      {...buttonProps}
      className={className}
      type="button"
      onClick={handleClick}
    >
      {children || 'Or click here to logout.'}
    </button>
  )
}
