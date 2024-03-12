import { createFileRoute } from '@tanstack/react-router'
import { Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,} from "@breeze/ui";
import { Link } from "@tanstack/react-router";
import HomeIcon from "~/assets/icons/HomeIcon";
import UserBaseTable from './-component/-userbasetable/data-table';
import { columns } from './-component/-userbasetable/columns';
import { UserData } from './-component/user';


export const Route = createFileRoute('/_authenticated/dashboard/home/users')({
  component: User
})

function User() {
  return (
    <div>
      <div className=" flex gap-2 w-28 h-10 px-4 py-2 top-36 left-64 ">
        <Breadcrumb>
        <BreadcrumbList>
            <BreadcrumbItem>
                <BreadcrumbLink className="cursor-pointer">
                    <Link to="/dashboard/home">
                        <div className="flex gap-2 items-center">
                            <HomeIcon className="w-5 h-5"/> 
                                Home
                        </div>
                    </Link>
                </BreadcrumbLink>
            <BreadcrumbSeparator />
                <BreadcrumbPage className="cursor-pointer">
                    <Link to="/dashboard/home/users">
                         Userbase
                    </Link>
                </BreadcrumbPage>
            </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
        </div>
      <UserBaseTable columns={columns} data={UserData}/>
    </div>
  )
}
