const baseStyle = {
    height: '27.5px',
    width: '170px',
    border: 'none',
    textAlign: 'center',
    verticalAlign: 'center',
    boxShadow: '0 2px 4px 0 rgba(0,0,0,.25)',
    fontSize: '0.875rem',
    lineHeight: '27.5px',
    display: 'block',
    borderRadius: '0.2rem',
    transition: 'background-color .218s, border-color .218s, box-shadow .218s',
    fontFamily: 'Roboto,arial,sans-serif',
    cursor: 'pointer',
    userSelect: 'none'
  }
  
  export const darkStyle = {
    backgroundColor: '#4285f4',
    color: '#fff',
    ...baseStyle
  }
  
  export const lightStyle = {
    backgroundColor: '#fff',
    color: 'rgba(0,0,0,.54)',
    ...baseStyle
  }
  
  export const iconStyle = {
    width: '30px',
    height: '25.5px',
    textAlign: 'center',
    verticalAlign: 'center',
    display: 'block',
    marginTop: '1px',
    marginLeft: '1px',
    float: 'left',
    backgroundColor: '#fff',
    borderRadius: '0.2rem',
    whiteSpace: 'nowrap'
  }
  
  export const svgStyle = {
    width: '30px',
    height: '25.5px',
    display: 'block'
  }
  
  export const hoverStyle = {
    boxShadow: '0 0 3px 3px rgba(66,133,244,.3)',
    transition: 'background-color .218s, border-color .218s, box-shadow .218s'
  }
  
  // export const pressedStyle = {
  //   backgroundColor: '#3367D6'
  // }
  
  export const disabledStyle = {
    backgroundColor: 'rgba(37, 5, 5, .08)',
    color: 'rgba(0, 0, 0, .40)',
    cursor: 'not-allowed'
  }
  
  export const disabledIconStyle = {
    backgroundColor: 'transparent'
  }