import { Input } from '@breeze/ui'
import { createFileRoute } from '@tanstack/react-router'

export const Route = createFileRoute('/_authenticated/dashboard/wallet/_components/_userprofile')({
  component: () => UserProfile
})


export default function UserProfile () {
  return (
    <div>      
      <div className="flex w-full flex-col items-end gap-10">
        <div className="w-full">
          <div className="mb-8 px-2 pt-2 text-center">
            <h4 className="text-lg font-bold leading-6">Mya Than Tint</h4>
          </div>
          <div className="flex justify-between gap-8">
            <div className="h-16 w-16 rounded-full">
              <img className="h-full w-full" src="https://thumbs.dreamstime.com/b/businessman-icon-vector-male-avatar-profile-image-profile-businessman-icon-vector-male-avatar-profile-image-182095609.jpg" alt="Avator" />
            </div>
            <div className="flex gap-3 text-base tracking-tight">
              <div className="flex flex-col items-center gap-1 py-2">
                <p className="font-semibold">100</p>
                <p className="font-normal">events</p>
              </div>
              <div className="flex flex-col items-center gap-1 py-2">
                <p className="font-semibold">100</p>
                <p className="font-normal">events</p>
              </div>
              <div className="flex flex-col items-center gap-1 py-2">
                <p className="font-semibold">100</p>
                <p className="font-normal">events</p>
              </div>
            </div>
          </div>
        </div>

        <div className="flex w-4/5 flex-col items-center gap-4 text-base font-semibold tracking-tight">
          <div className="flex gap-4">
            <p>WalletID:</p>
            <p>00126293</p>
          </div>
          <div className="flex gap-4">
            <p>Balance:</p>
            <p>100,00</p>
          </div>
        </div>
        <div className="w-4/5">
          <div className="flex items-center justify-end gap-5 py-2">
           
            <div className="flex items-center">
              <input type="radio" id="cash-in" name="transaction-type" className="radio-input mr-2 h-5 w-5 accent-zinc-800" />
              <label htmlFor="cash-in" className="radio-label cursor-pointer text-base tracking-tight">Cash In</label>
            </div>

            
            <div className="flex items-center">
              <input type="radio" id="cash-out" name="transaction-type" className="radio-input ml-4 mr-2 h-5 w-5 accent-zinc-800" />
              <label htmlFor="cash-out" className="radio-label cursor-pointer text-base tracking-tight">Cash Out</label>
            </div>
          </div>
        </div>
        <div className="w-4/5">
          <Input type="number" placeholder='Enter amount' />
        </div>
      </div>
    </div>
  )
}