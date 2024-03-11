import { Breadcrumb,
    BreadcrumbItem,
    BreadcrumbList,
    BreadcrumbPage,} from "@breeze/ui";
import { useNavigate } from "@tanstack/react-router";
import HomeIcon from "~/assets/icons/HomeIcon";
  
export default function HomeNavigate() {
    const navigate = useNavigate();
  return (
    <div className=" flex gap-2 w-28 h-10 px-4 py-2 top-36 left-64 ">
      <Breadcrumb>
      <BreadcrumbList>
            <BreadcrumbItem >
            <BreadcrumbPage className="cursor-pointer" onClick={() => navigate({ to: '/dashboard/home' })}>
              <div className=" flex gap-2 items-center">
                <HomeIcon className="w-5 h-5"/> 
                Home
              </div>
            </BreadcrumbPage>
        </BreadcrumbItem>
        </BreadcrumbList>
      </Breadcrumb>
    </div>
    
   
      )
  }