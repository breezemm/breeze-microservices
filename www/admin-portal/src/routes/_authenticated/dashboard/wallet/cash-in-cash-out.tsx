import { createFileRoute } from '@tanstack/react-router'
import { Input } from '@breeze/ui'
import SearchIcon from '~/assets/icons/SearchIcon'
import ArrowIcon from '~/assets/icons/ArrowIcon'
import { useState } from 'react'
import { useQuery } from '@tanstack/react-query'
import useDebounce from './-hooks/useDebounce'
import { getUserProfileWithUsername } from './-auth/api'
import UserProfile from './-components/UserProfile'


export const Route = createFileRoute('/_authenticated/dashboard/wallet/cash-in-cash-out')({
  component: CashInCashOut
})

function CashInCashOut () {
  const [openCashInOutDetail, setOpenCashInOutDetail] = useState(false);
  const [searchUsername, setSearchUsername] = useState("");

  const debounceSearchName = useDebounce(searchUsername, 500)

  useQuery({
    queryKey: ["user-profile", debounceSearchName], 
    queryFn: () =>{
      return getUserProfileWithUsername(debounceSearchName)
    }
  })

  return (
    <div className="flex gap-12 w-full">
      <div> 
        <div className='my-10'>
          <h5 className="text-lg font-bold leading-6 px-2 mb-6">Search</h5>
          <div className="relative w-80">
              <Input
                type="text"
                placeholder="Username"
                onChange={(e)=> setSearchUsername(e.target.value)}
              />
            <div className="absolute inset-y-0 right-0 flex items-center justify-center pr-[3px]">
              <SearchIcon />
            </div>
          </div>
        </div>

        <div className="flex flex-col gap-4 py-1 w-80">
          <div className={`flex items-center gap-4 py-2 px-6 ${openCashInOutDetail ? 'border rounded-sm border-zinc-800' : ''}`} 
              onClick={()=> setOpenCashInOutDetail(!openCashInOutDetail) }>
            <div className="h-10 w-10 rounded-full">
              <img className="h-full w-full" src="https://thumbs.dreamstime.com/b/businessman-icon-vector-male-avatar-profile-image-profile-businessman-icon-vector-male-avatar-profile-image-182095609.jpg" alt="Avatar" />
            </div>
            <p className="text-base">Mya Zarni</p>
              {openCashInOutDetail && (
                <div className="ml-auto">
                  <ArrowIcon />
                </div>     
              )}
          </div>
   
        </div>
    </div>
    
    {
      openCashInOutDetail && (
        <UserProfile />
      )
    }

    </div>

  )
}