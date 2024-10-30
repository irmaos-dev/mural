import { useNavigate } from 'react-router-dom'
import { pathKeys } from '~6shared/lib/react-router'
import { useLogoutMutation } from './logout.mutation'

interface LogoutButtonCustomizableProps {
  children?: React.ReactNode
  className?: string
}

export function LogoutButtonCustomizable({
  children,
  className,
}: LogoutButtonCustomizableProps) {
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
      className={className}
      type="button"
      onClick={handleClick}
    >
      {children || 'Or click here to logout.'}
    </button>
  )
}
