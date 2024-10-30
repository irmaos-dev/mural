import { ReactNode } from 'react'
import './styles.userDropdown.css'
import {
  IoCaretDownCircleOutline,
  IoCaretUpCircleOutline,
} from 'react-icons/io5'

interface UserDropdownProps {
  children: ReactNode
  isDropdownOpen: boolean
}

interface UserDropdownToggleSplitProps {
  toggleDropdown: () => void
  isDropdownOpen: boolean
  children: ReactNode
}

interface UserDropdownContentProps {
  isDropdownOpen: boolean
  children: ReactNode
}

interface UserDropdownItemProps {
  children: ReactNode
  className?: string
}

function UserDropdown({ children, isDropdownOpen }: UserDropdownProps) {
  return (
    <div className={`user-dropdown${isDropdownOpen ? ' open' : ''}`}>
      {children}
    </div>
  )
}

function UserDropdownToggleSplit({
  toggleDropdown,
  isDropdownOpen,
  children,
}: UserDropdownToggleSplitProps) {
  return (
    <div className="user-dropdown-toggle-split">
      {children}
      <button
        type="button"
        onClick={() => toggleDropdown()}
        className="dropdown-toggle-btn"
      >
        {isDropdownOpen ? (
          <IoCaretUpCircleOutline className="dropdown-toggle-icon" />
        ) : (
          <IoCaretDownCircleOutline className="dropdown-toggle-icon" />
        )}
      </button>
    </div>
  )
}

function UserDropdownContent({
  children,
  isDropdownOpen,
}: UserDropdownContentProps) {
  return (
    <div className={`dropdown-content${isDropdownOpen ? ' open' : ''}`}>
      {children}
    </div>
  )
}

function UserDropdownItem({ children, className }: UserDropdownItemProps) {
  return (
    <div className={`user-dropdown-item ${className && className}`}>
      {children}
    </div>
  )
}

export {
  UserDropdown,
  UserDropdownToggleSplit,
  UserDropdownContent,
  UserDropdownItem,
}
