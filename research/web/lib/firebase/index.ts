import { initializeApp } from 'firebase/app'
import { getMessaging, isSupported, getToken, onMessage } from 'firebase/messaging'
import { toast } from 'react-toastify'

const firebaseConfig = {
  apiKey: 'AIzaSyBVT2gFzOAjOJBPtOS4awmTuOsUjz2xr8M',
  authDomain: 'breeze-8750e.firebaseapp.com',
  projectId: 'breeze-8750e',
  storageBucket: 'breeze-8750e.appspot.com',
  messagingSenderId: '707631451661',
  appId: '1:707631451661:web:9505cc3d0f13282bc04f44',
}

const vapidKey = 'BGIYg-wT8WkxKYdeW9anN0nag7loHCaEQdu8R1Y_995YOlk7DUs09YATqKOLlbsXOK3FFPQ5Tz67LUa6uGVfDHM'

const app = initializeApp(firebaseConfig)
const messaging = getMessaging(app)

onMessage(messaging, (payload) => {
  console.log('Message received. ', payload)
})

export const requestToken = async (): Promise<string | void> => {
  if (await isSupported()) {
    try {
      const currentToken = await getToken(messaging, { vapidKey })
      if (currentToken) {
        return currentToken
      } else {
      }
    } catch (err) {
      console.log('An error occurred while retrieving token. ', err)
    }
  }
}

export async function requestPermission() {
  console.log('Requesting permission...')
  const permission = await Notification.requestPermission()
  if (permission === 'granted') {
    console.log('Notification permission granted.')
    return true
  }
  alert('Notification permission granted.')
  return false
}

export function subscribeTokenToTopic(token: string, topic: string) {
  const FCM_SERVER_KEY: string =
    'AAAApMIfDg0:APA91bE4XKQ1bqNK1IpTd422GGtJ3yVqR1HTNbqdnCVz-B-TnGyxCgJW-1L2O3baVEFPri5xMV50zdfKgp3hzLt1CIppgRvvhNn1G6MP-39VCfZSh2DvZF6aLO3VnUlPqmdXNwO_2duk'
  fetch(`https://iid.googleapis.com/iid/v1/${token}/rel/topics/${topic}`, {
    method: 'POST',
    headers: new Headers({
      Authorization: `key=${FCM_SERVER_KEY}`,
    }),
  })
    .then((response) => {
      if (response.status < 200 || response.status >= 400) {
        console.log(response.status, response)
      }
      console.log(response)
      console.log(`"${topic}" is subscribed`)
      toast('Subscribed to ' + topic)
    })
    .catch((error) => {
      console.error(error.result)
    })
  return true
}
