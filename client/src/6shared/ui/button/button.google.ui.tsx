import GoogleButton from 'react-google-button'

export function ButtonGoogle() {
    
      const onSubmit = async () => {
        window.location.href = 'http://localhost:8081/api/auth/redirect'
      }

    return (<GoogleButton
        label='Entrar com Google'
        onClick= { onSubmit }
    />)
}
