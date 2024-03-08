import {createFileRoute, useNavigate} from '@tanstack/react-router'
import {Card, CardContent, CardHeader, CardTitle,} from "@breeze/ui"
import UserIcon from "~/assets/icons/UserIcon.tsx";
import TicketIcon from "~/assets/icons/TicketIcon.tsx";

export const Route = createFileRoute('/_authenticated/dashboard/home/')({
  component: Home,
})


function Home() {
  const navigate = useNavigate()


  return (
    <div>
      <div className="flex gap-8">
        <Card className="w-52" onClick={() => navigate({
          to: '/dashboard/home/users'
        })}>
          <CardHeader>
            <CardTitle className="text-[18px]">User Base</CardTitle>
          </CardHeader>
          <CardContent className="flex items-center justify-end gap-2 text-normal">
            <p>0</p>
            <UserIcon className="w-10 h-10"/>
          </CardContent>
        </Card>

        <Card className="w-52" onClick={() => navigate({
          to: '/dashboard/home/events'
        })}>
          <CardHeader>
            <CardTitle className="text-[18px]">Events</CardTitle>
          </CardHeader>
          <CardContent className="flex items-center justify-end gap-2 text-normal">
            <p>0</p>
            <TicketIcon className="w-10 h-10"/>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}
