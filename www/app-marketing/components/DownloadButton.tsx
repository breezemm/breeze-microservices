import React from 'react'
import { LuDownload } from 'react-icons/lu'
const DownloadButton = () => {
  return (
    <div>
      <button className="bg-neutral-9 font-semibold  text-neutral-1 hidden h-11 w-40 rounded-md  text-center  md:block ">
        Download Free
      </button>

      <div className="bg-green-6 flex h-10 w-10 items-center justify-center rounded-md md:hidden">
        <LuDownload className="text-white" />
      </div>
    </div>
  )
}

export default DownloadButton
