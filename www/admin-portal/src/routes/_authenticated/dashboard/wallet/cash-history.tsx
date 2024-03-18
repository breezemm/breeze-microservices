import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator } from '@breeze/ui'
import { Link, createFileRoute } from '@tanstack/react-router'
import WalletIcon from '~/assets/icons/WalletIcon'


export const Route = createFileRoute('/_authenticated/dashboard/wallet/cash-history')({
  component: CashHistory,
})




function CashHistory () {


    return (
        <div>
          {/* Navi bar for Wallet > cash history */}
        <Breadcrumb>
          <BreadcrumbList>
            <BreadcrumbItem>
              <BreadcrumbLink className="cursor-pointer">
                <Link to="/dashboard/wallet">
                  <div className="flex gap-2 items-center">
                    <WalletIcon className="w-5 h-5" /> Wallet
                  </div>
                </Link>
              </BreadcrumbLink>
            </BreadcrumbItem>
            <BreadcrumbSeparator  />
            <BreadcrumbItem>
              <BreadcrumbPage>Cash History</BreadcrumbPage>
            </BreadcrumbItem>
          </BreadcrumbList>
        </Breadcrumb>

        <h1>Hi this is Cash History!!</h1>
        </div>
    )
}