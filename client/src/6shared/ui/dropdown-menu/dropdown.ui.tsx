import {
  ReactNode,
  useEffect,
  useRef,
  createContext,
  useContext,
  useMemo,
} from 'react'
import { IoCaretDownCircleOutline, IoCloseCircleOutline } from 'react-icons/io5'
import styles from './dropdown.module.css'

type Store = {
  use: {
    isOpen(): boolean
  }
  getState(): {
    setOpen(isOpen: boolean): void
    toggle(): void
  }
}

type DropdownContextType = {
  store: Store
  menuType?: '' | 'expansive'
}

const DropdownContext = createContext<DropdownContextType | null>(null)

function Root({
  store,
  children,
  menuType = '',
}: {
  store: Store
  children: ReactNode
  menuType?: '' | 'expansive'
}) {
  const isOpen = store.use.isOpen()
  const contextValue = useMemo(
    () => ({
      store,
      menuType,
    }),
    [store, menuType],
  )
  return (
    <DropdownContext.Provider value={contextValue}>
      <div
        className={`${styles['dropdown-menu']} ${isOpen ? styles.open : ''} ${
          menuType === 'expansive' ? styles.expansive : ''
        }`}
      >
        {children}
      </div>
    </DropdownContext.Provider>
  )
}

function Trigger({
  children,
  split = false,
  disable = false,
}: {
  children: ReactNode
  split?: boolean
  disable?: boolean
}) {
  const { store, menuType } = useContext(DropdownContext)!
  const handleClick = () => store.getState().toggle()
  const isOpen = store.use.isOpen()
  if (split) {
    return (
      <div
        className={`${styles['dropdown-menu-toggle-split']} ${isOpen ? styles.open : ''} ${menuType === 'expansive' ? styles.expansive : ''}  ${disable ? 'disable' : ''}
        `}
      >
        {children}
        <button
          type="button"
          onClick={handleClick}
        >
          {isOpen ? (
            <IoCloseCircleOutline
              className={styles['dropdown-menu-toggle-icon']}
            />
          ) : (
            <IoCaretDownCircleOutline
              className={styles['dropdown-menu-toggle-icon']}
            />
          )}
        </button>
      </div>
    )
  }
  return (
    <div
      className={`${styles['dropdown-menu-toggle-split']} ${isOpen ? styles.open : ''} ${menuType === 'expansive' ? styles.expansive : ''}  ${disable ? 'disable' : ''}`}
    >
      <button
        type="button"
        onClick={handleClick}
      >
        <span> {children}</span>
        {isOpen ? (
          <IoCloseCircleOutline
            className={styles['dropdown-menu-toggle-icon']}
          />
        ) : (
          <IoCaretDownCircleOutline
            className={styles['dropdown-menu-toggle-icon']}
          />
        )}
      </button>
    </div>
  )
}

// Move the click outside handler from Root to Content
function Content({
  children,
  disable = false,
}: {
  children: ReactNode
  disable?: boolean
}) {
  const { store, menuType } = useContext(DropdownContext)!
  const isOpen = store.use.isOpen()
  const contentRef = useRef<HTMLDivElement>(null)

  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      if (
        contentRef.current &&
        !contentRef.current.contains(event.target as Node)
      ) {
        store.getState().setOpen(false)
      }
    }

    if (isOpen) {
      document.addEventListener('mousedown', handleClickOutside)
      // Add overlay to prevent clicks when dropdown is open
      document.body.style.pointerEvents = 'none'
      // Allow clicks only within dropdown content
      if (contentRef.current) {
        contentRef.current.style.pointerEvents = 'all'
      }
    }

    return () => {
      document.removeEventListener('mousedown', handleClickOutside)
      document.body.style.pointerEvents = 'all'
    }
  }, [isOpen, store])

  return (
    <div
      ref={contentRef}
      className={`${styles['dropdown-menu-content']} ${isOpen ? styles.open : ''} ${
        menuType === 'expansive' ? styles.expansive : ''
      } ${disable ? 'disable' : ''}`}
    >
      {children}
    </div>
  )
}

// Item component remains unchanged since it doesn't need the store
function Item({
  children,
  onClick,
  className,
  disable = false,
}: {
  children: ReactNode
  onClick?: () => void
  className?: string
  disable?: boolean
}) {
  return (
    <div
      className={`${styles['dropdown-menu-item']} ${className || ''} ${disable ? 'disable' : ''}`}
      onClick={onClick}
      role="button"
      tabIndex={0}
      onKeyDown={(e) => e.key === 'Enter' && onClick?.()}
    >
      {children}
    </div>
  )
}

export const DropdownMenu = { Root, Trigger, Content, Item }
