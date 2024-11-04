import { ReactNode, useEffect, useRef, createContext, useContext } from 'react'
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

const DropdownContext = createContext<Store | null>(null)

function Root({ store, children }: { store: Store; children: ReactNode }) {
  const isOpen = store.use.isOpen()

  return (
    <DropdownContext.Provider value={store}>
      <div
        className={`${styles['dropdown-menu']} ${isOpen ? styles.open : ''}`}
      >
        {children}
      </div>
    </DropdownContext.Provider>
  )
}

function Trigger({
  children,
  split = false,
}: {
  children: ReactNode
  split?: boolean
}) {
  const store = useContext(DropdownContext)!
  const handleClick = () => store.getState().toggle()
  const isOpen = store.use.isOpen()
  if (split) {
    return (
      <div className={styles['dropdown-menu-toggle-split']}>
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
}

// Move the click outside handler from Root to Content
function Content({ children }: { children: ReactNode }) {
  const store = useContext(DropdownContext)!
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
      className={`${styles['dropdown-menu-content']} ${isOpen ? styles.open : ''}`}
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
}: {
  children: ReactNode
  onClick?: () => void
  className?: string
}) {
  return (
    <div
      className={`${styles['dropdown-menu-item']} ${className || ''}`}
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
