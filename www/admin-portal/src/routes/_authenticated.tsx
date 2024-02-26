import {Button, buttonVariants, cn} from '@breeze/ui';
import {createFileRoute, Link, Outlet, redirect} from '@tanstack/react-router'
import {authStore} from "~/store";
import HomeIcon from "~/assets/icons/HomeIcon.tsx";
import WalletIcon from "~/assets/icons/WalletIcon.tsx";
import VerifiedBadgeIcon from "~/assets/icons/VerifiedBadgeIcon.tsx";
import UserProfileIcon from "~/assets/icons/UserProfileIcon.tsx";
import Logo from '~/assets/icons/Logo';


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

function Auth() {

  const links = [
    {name: "Home", to: "/", icon: HomeIcon},
    {name: "Wallet", to: "/wallet", icon: WalletIcon},
    {name: "Verify", to: "/verify", icon: VerifiedBadgeIcon},
  ]
  return (
    <div className="w-full">
      <header className="flex flex-row justify-between w-full px-10 py-6 border-b">
        <Logo/>
        <div>
          <UserProfileIcon/>
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
