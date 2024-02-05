import { initializeApp } from "firebase/app";
import {
  getMessaging,
  isSupported,
  getToken,
  onMessage,
} from "firebase/messaging";

const firebaseConfig = {
  apiKey: "AIzaSyBVT2gFzOAjOJBPtOS4awmTuOsUjz2xr8M",
  authDomain: "breeze-8750e.firebaseapp.com",
  projectId: "breeze-8750e",
  storageBucket: "breeze-8750e.appspot.com",
  messagingSenderId: "707631451661",
  appId: "1:707631451661:web:9505cc3d0f13282bc04f44",
};

const vapidKey =
  "BGIYg-wT8WkxKYdeW9anN0nag7loHCaEQdu8R1Y_995YOlk7DUs09YATqKOLlbsXOK3FFPQ5Tz67LUa6uGVfDHM";

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

onMessage(messaging, (payload) => {
  console.log("Message received. ", payload);
});

export const requestToken = async (): Promise<string | void> => {
  if (await isSupported()) {
    try {
      const currentToken = await getToken(messaging, { vapidKey });
      if (currentToken) {
        return currentToken;
      } else {
      }
    } catch (err) {
      console.log("An error occurred while retrieving token. ", err);
    }
  }
};

export async function requestPermission() {
  console.log("Requesting permission...");
  const permission = await Notification.requestPermission();
  if (permission === "granted") {
    console.log("Notification permission granted.");
    return true;
  }
  alert("Notification permission granted.");
  return false;
}
