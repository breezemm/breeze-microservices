'use client'
import {requestPermission, requestToken, subscribeTokenToTopic} from '../lib/firebase'
import React, {useEffect} from 'react'
import {ToastContainer} from 'react-toastify'
import 'react-toastify/dist/ReactToastify.css'
import {Button} from "@breeze/ui/button";
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@breeze/ui/card";

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
      <ToastContainer/>
      <div>React Firebase Research</div>

      <Button variant={"destructive"}>Click me</Button>
      <Card>
        <CardHeader>
          <CardTitle>Card Title</CardTitle>
          <CardDescription>Card Description</CardDescription>
        </CardHeader>
        <CardContent>
          <p>Card Content</p>
        </CardContent>
        <CardFooter>
          <p>Card Footer</p>
        </CardFooter>
      </Card>
      Copy

    </main>
  )
}
