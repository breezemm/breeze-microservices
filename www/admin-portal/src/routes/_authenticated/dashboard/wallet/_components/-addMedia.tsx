// import { createFileRoute } from '@tanstack/react-router'
import AddMediaIcon from '~/assets/icons/AddMediaIcon'


// export const Route = createFileRoute('/_authenticated/dashboard/wallet/_components/-addMedia')({
//   component: AddMedia
// })

export function AddMedia () {
    return ( 
        <label className="flex flex-col  justify-center items-center  border-dashed border-2 border-zinc-800 h-80 w-40 rounded-lg" >
            <span className="flex flex-col justify-center items-center gap-2">
                <AddMediaIcon />
                <p>Add Media</p>
            </span>
            <input type="file" name="file_upload" className="hidden" />  
        </label>              
    )
}