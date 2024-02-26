import Image from 'next/image'
import React from 'react'
import BreezeIcon from '@/app/assets/breeze_icon.svg'
import Link from 'next/link'
import DownloadButton from '@/components/DownloadButton'

const NavBar = () => {
  return (
    <div className="flex  items-center sticky top-0 z-50  justify-between bg-black   px-6 py-4 md:py-6  md:px-10">
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
