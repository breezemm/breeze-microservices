import { Input } from '@breeze/ui'
import { createFileRoute } from '@tanstack/react-router'
import UserProfile from './_components/_userprofile'
import SearchIcon from '~/assets/icons/SearchIcon'

export const Route = createFileRoute('/_authenticated/dashboard/wallet/cashinout')({
  component: CashInOut
})


function CashInOut () {
  return (
    <div className="flex gap-10">
      <div> 
        <div className='my-10'>
          <h5 className="text-lg font-bold leading-6 px-2 mb-6">Search</h5>
          <div className="relative w-80">
              <Input
                type="text"
                placeholder="Username"
                className=""
              />
            <div className="absolute inset-y-0 right-0 flex items-center justify-center pr-[3px]">
              <SearchIcon />
            </div>
          </div>
        </div>

        <div className="flex flex-col gap-4 px-6 py-1 w-80">
          <div className="flex items-center gap-4 py-2">
            <div className="h-10 w-10 rounded-full">
              <img className="h-full w-full" src="https://thumbs.dreamstime.com/b/businessman-icon-vector-male-avatar-profile-image-profile-businessman-icon-vector-male-avatar-profile-image-182095609.jpg" alt="Avator" />
            </div>
            <p className="text-base">Mya Zarni</p>
          </div>
          <div className="flex items-center gap-4 py-2">
            <div className="h-10 w-10 rounded-full">
              <img className="h-full w-full" src="https://thumbs.dreamstime.com/b/businessman-icon-vector-male-avatar-profile-image-profile-businessman-icon-vector-male-avatar-profile-image-182095609.jpg" alt="Avator" />
            </div>
            <p className="text-base">Mya Zarni</p>
          </div>
        </div>
    </div>
    
    <UserProfile />


    </div>

  )
}