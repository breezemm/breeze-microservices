import Axios from 'axios'

const Login = () => {

  const login = () => {
    Axios.get("http://admin-portal.test/oauth/authorize",
      {
      headers: {
        'Accept': '',
        "Content-Type": "application/x-www-form-urlencoded",
      },
      params:{
        client_id: '9b651022-6a58-4b32-a221-703582137b59',
        redirect_uri: 'http://localhost:5173/auth/callback',
        response_type: 'code',
        scope: '',
        state: 'MVQz47OmXRhHw4PcZk61STO3ZtImPKaw4wJr01wm'
      }
    })
      .then(response => {

        window.location.href = response.request.url;
      })
    Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

    Axios.defaults.withCredentials = true;
  }
  return (
    <div>
      Login Component
      <button onClick={login}
              className="bg-indigo-500 px-4 py-2 text-white"
      >Login</button>
    </div>
  );
};

export default Login;
