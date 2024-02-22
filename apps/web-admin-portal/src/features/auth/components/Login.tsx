import {signInWithEmailAndPassword} from "~/features/auth/api/login.ts";

const Login = () => {

  const login = async () => {
    const response = await signInWithEmailAndPassword({
      email: 'admin@breeze.com',
      password: 'password',
    })
    console.log(responseΩ)
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
