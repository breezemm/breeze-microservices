// Issue: https://github.com/firebase/firebase-js-sdk/issues/5403#issuecomment-908024147

importScripts(
  "https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"
);
importScripts(
  "https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js"
);

const firebaseConfig = {
  apiKey: "AIzaSyBVT2gFzOAjOJBPtOS4awmTuOsUjz2xr8M",
  authDomain: "breeze-8750e.firebaseapp.com",
  projectId: "breeze-8750e",
  storageBucket: "breeze-8750e.appspot.com",
  messagingSenderId: "707631451661",
  appId: "1:707631451661:web:9505cc3d0f13282bc04f44",
};

firebase.initializeApp(firebaseConfig);

const isSupported = firebase.messaging.isSupported();

if (isSupported) {
  const messaging = firebase.messaging();

  messaging.onBackgroundMessage(messaging, (payload) => {
    console.log(
      "[firebase-messaging-sw.js] Received background message ",
      payload
    );
    // Customize notification here
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
      body: "Background Message body.",
      icon: "/firebase-logo.png",
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
  });
} else {
  console.log("Firebase messaging is not supported");
}
