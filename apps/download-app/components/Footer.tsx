import Breeze from '@/app/assets/water_mark.svg'

import Image from 'next/image'
import { ContactSection } from '@/app/components/ContactSection'
import { SocialSection } from '@/app/components/SocialSection'
import { ContactInfoData, SocialList, Stores } from '@/data/contact'

const Footer = () => {
  return (
    <div className="bg-neutral-10 text-neutral-1 px-5 py-10 md:px-16 md:py-10 ">
      <Image src={Breeze} alt="water mark" />
      <div className="mt-7 flex  flex-col gap-10 md:flex-row md:justify-between  ">
        <ContactSection ContactInfoData={ContactInfoData} />
        <SocialSection SocialList={SocialList} storesDownload={Stores} />
      </div>
    </div>
  )
}

export default Footer
