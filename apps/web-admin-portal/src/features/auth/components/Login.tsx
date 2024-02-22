import {useAuthUser, useSignInUser} from "~/lib/auth";

const Login = () => {
  const login = useSignInUser({
    onSuccess: (data) => {
      console.log("Login Success", data);
    }
  });

  const auth = useAuthUser();


  return (
    <div>
      {auth.isLoading && <div>Loading...</div>}
      {auth.isSuccess && <div>Logged in as {auth.data.email}</div>}

      <form action="" onSubmit={(e) => {
        e.preventDefault();
        login.mutate({
          email: "admin@breeze.com",
          password: "password",
        })
      }}>
        <input type="text" placeholder="Email"/>
        <input type="password" placeholder="Password"/>
        <button type="submit">Login
        </button>
      </form>
    </div>
  );
};

export default Login;
