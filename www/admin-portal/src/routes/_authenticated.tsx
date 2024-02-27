import {
  Button,
  buttonVariants,
  cn,
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuLabel,
  DropdownMenuTrigger
} from '@breeze/ui';
import {createFileRoute, Link, Outlet, redirect} from '@tanstack/react-router'
import {authStore} from "~/store";
import HomeIcon from "~/assets/icons/HomeIcon.tsx";
import WalletIcon from "~/assets/icons/WalletIcon.tsx";
import VerifiedBadgeIcon from "~/assets/icons/VerifiedBadgeIcon.tsx";
import UserProfileIcon from "~/assets/icons/UserProfileIcon.tsx";
import Logo from '~/assets/icons/Logo';
import LogoutIcon from "~/assets/icons/LogoutIcon.tsx";
import {useAuthUser, useSignOutUser} from "~/lib/auth.ts";


export const Route = createFileRoute('/_authenticated')({
  component: Auth,
  beforeLoad: () => {
    const auth = authStore.state.user
    if (!auth) {
      throw redirect({
        to: '/auth/login',
      })
    }
  }
})


const links = [
  {name: "Home", to: "/", icon: HomeIcon},
  {name: "Wallet", to: "/wallet", icon: WalletIcon},
  {name: "Verify", to: "/verify", icon: VerifiedBadgeIcon},
]

function Auth() {
  const auth = useAuthUser()

  const signOutUser = useSignOutUser({})

  const onLogout = () => {
    signOutUser.mutate({})
  }

  return (
    <div className="w-full">
      <header className="flex flex-row justify-between w-full px-10 py-6 border-b">
        <Logo/>
        <div>
          <DropdownMenu>
            <DropdownMenuTrigger>
              <UserProfileIcon/>
            </DropdownMenuTrigger>
            <DropdownMenuContent className="w-48 absolute right-0 top-1">
              <DropdownMenuLabel className="w-full text-6 ">
                {auth.isLoading && "Loading..."}
                {auth.isSuccess && auth.data?.name}
              </DropdownMenuLabel>
              <DropdownMenuLabel>
                <Button variant={"default"}
                        className="w-full flex justify-start items-center w-full text-left gap-4 py-2">
                  <UserProfileIcon className="w-7 h-8"/> My Account</Button>
              </DropdownMenuLabel>
              <DropdownMenuLabel>
                <Button
                  onClick={onLogout}
                  variant={"link"}
                  className="w-full flex justify-start items-center w-full text-destructive text-left gap-4 py-2 hover:no-underline	">
                  <LogoutIcon/> Logout</Button>
              </DropdownMenuLabel>

            </DropdownMenuContent>
          </DropdownMenu>
        </div>
      </header>

      <div className="flex min-h-screen">
        <nav className="flex flex-col p-10 gap-y-6 border-r">
          {links.map((link, index) => {
            return (
              <Button variant="ghost" className="flex justify-start items-center w-full text-left gap-4 py-2" asChild
                      key={index}>
                <Link
                  to={link.to}
                  activeProps={{
                    className: cn(
                      buttonVariants({variant: "default"}),
                      "hover:text-white flex justify-start items-center w-full text-left gap-4 py-2"
                    )
                  }}>
                  <link.icon className="fill-white"/>
                  {link.name}
                </Link>
              </Button>
            )
          })}
        </nav>
        <section className="p-10">
          <Outlet/>
        </section>
      </div>
    </div>
  )
}
