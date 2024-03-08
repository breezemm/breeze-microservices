import {createFileRoute, redirect, useNavigate} from '@tanstack/react-router'
import {useSignInUser} from "~/lib/auth.ts";
import {
  Button,
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
  Input,
  Card,
  CardContent,
  CardTitle,
  CardHeader
} from "@breeze/ui";
import {authStore} from "~/store";
import {flushSync} from "react-dom";
import {useForm} from 'react-hook-form';
import {zodResolver} from '@hookform/resolvers/zod';
import {z} from 'zod';

// https://gist.github.com/mjbalcueva/b21f39a8787e558d4c536bf68e267398
export const Route = createFileRoute('/auth/login')({
  component: Login,
  beforeLoad: ({context: {auth}}) => {
    if (auth) {
      throw redirect({
        to: '/dashboard/home'
      })
    }
  }
})

const formSchema = z.object({
  email: z.string()
    .email("Invalid email address.")
    .min(1, {message: "This field has to be filled."}),
  password: z
    .string()
    .min(1, {message: "This field has to be filled."}),
})


function Login() {
  const navigate = useNavigate()

  useForm<z.infer<typeof formSchema>>({
    resolver: zodResolver(formSchema),
    defaultValues: {
      email: "",
      password: "",
    },
  })


  const signInUser = useSignInUser({
    onSuccess: (user) => {
      flushSync(() => {
        authStore.setState(state => {
          return {
            ...state,
            user,
          }
        })
        navigate({
          to: '/dashboard/home'
        })
      })
    }
  })


  const form = useForm<z.infer<typeof formSchema>>({
    resolver: zodResolver(formSchema),
    defaultValues: {
      email: "",
      password: "",
    },
  })

  async function onSubmit(data: z.infer<typeof formSchema>) {
    await signInUser.mutateAsync(data)
  }

  return (
    <div className="flex justify-center items-center h-screen">
      <Card className="w-[329px]">
        <CardHeader>
          <CardTitle>Login Page</CardTitle>
        </CardHeader>
        <CardContent>
          <Form {...form}>
            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-3">
              <FormField
                control={form.control}
                name="email"
                render={({field}) => (
                  <FormItem>
                    <FormLabel>Email</FormLabel>
                    <FormControl>
                      <Input {...field} />
                    </FormControl>
                    <FormMessage/>
                  </FormItem>
                )}
              />
              <FormField
                control={form.control}
                name="password"
                render={({field}) => (
                  <FormItem>
                    <FormLabel>Password</FormLabel>
                    <FormControl>
                      <Input type="password" {...field} />
                    </FormControl>
                    <FormMessage/>
                  </FormItem>
                )}
              />
              <Button type="submit" className="w-full">
                {signInUser.isPending ? 'Loading...' : 'Login'}
              </Button>
            </form>
          </Form>
        </CardContent>
      </Card>
    </div>
  )
}
