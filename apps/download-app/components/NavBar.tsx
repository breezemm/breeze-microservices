import Image from 'next/image'
import React from 'react'
import BreezeIcon from '@/app/assets/breeze_icon.svg'
import Link from 'next/link'
import DownloadButton from '@/components/DownloadButton'

const NavBar = () => {
  return (
    <div className="flex  items-center  justify-between bg-black  p-4 md:px-7 md:py-5">
      <Link href="/">
        <div className="h-10 w-10  md:h-14 md:w-14">
          <Image src={BreezeIcon} alt="breezicon" />
        </div>
      </Link>

      <Link href="/">
        <DownloadButton />
      </Link>
    </div>
  )
}

export default NavBar
