'use client'
import { requestPermission, requestToken, subscribeTokenToTopic } from '../lib/firebase'
import { useEffect } from 'react'
import { ToastContainer } from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'
import { Button } from '@breeze/ui/src/components/ui/button'

export default function Page() {
  useEffect(() => {
    const init = async () => {
      const isGranted = await requestPermission()
      if (isGranted) {
        const token = await requestToken()
        if (token) {
          subscribeTokenToTopic(token, 'all')
          console.table({
            token,
          })
        }
      } else {
        console.log('Permission not granted')
      }
    }
    init()
  }, [])
  return (
    <main>
      <ToastContainer />
      <div>React Firebase Research</div>

      <Button>Click Me!</Button>
    </main>
  )
}
