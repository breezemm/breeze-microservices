import { Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,} from "@breeze/ui";
import { useNavigate } from "@tanstack/react-router";
import HomeIcon from "~/assets/icons/HomeIcon";
  
export default function EventNavigate() {
    const navigate = useNavigate();
    return (
        <div className=" flex gap-2 w-28 h-10 px-4 py-2 top-36 left-64 ">
        <Breadcrumb>
        <BreadcrumbList>
            <BreadcrumbItem>
                <BreadcrumbLink className="cursor-pointer" onClick={() => navigate({ to: '/dashboard/home' })}>
                <div className="flex gap-2 items-center">
                    <HomeIcon className="w-5 h-5"/> 
                    Home
                </div>
                </BreadcrumbLink>
                <BreadcrumbSeparator />
                <BreadcrumbPage className="cursor-pointer" onClick={() => navigate({ to: '/dashboard/home/events' })}>
                        Events
                </BreadcrumbPage>
            </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
        </div>
        
      )
  }