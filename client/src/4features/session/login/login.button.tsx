export const BtnGoogle = ()=> {

    const onSubmit = async() => {
        window.location.href= 'http://localhost:8081/api/auth/redirect'}

    return (
        <button className="btn btn-lg btn-primary"
          type="button"
          onClick={async()=> onSubmit()}>
            Google
          </button>
    )

}