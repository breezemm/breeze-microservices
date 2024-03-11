import { createFileRoute } from '@tanstack/react-router'
import EventNavigate from './-component/-routes/EventNavigate'

export const Route = createFileRoute('/_authenticated/dashboard/home/events')({
  component: Event
})

function Event() {
  return (
    <div>
      <EventNavigate />
    <p>This is Event page with table.</p>
    </div>
    
  )
}