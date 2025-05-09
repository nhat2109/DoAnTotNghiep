importScripts("https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/11.4.0/firebase-messaging.js");

// Khởi tạo Firebase
firebase.initializeApp({
  apiKey: "AIzaSyBZh0EIxg2PSumDCxUExJg2_hURkk_Ptm0",
  authDomain: "socdo-vn.firebaseapp.com",
  projectId: "socdo-vn",
  storageBucket: "socdo-vn.firebasestorage.app",
  messagingSenderId: "630972180925",
  appId: "1:630972180925:web:5c4d69aa41153f5699cad4",
  measurementId: "G-PPRCG9HRR7"
});

const messaging = firebase.messaging();

// Nhận thông báo khi web đóng
messaging.onBackgroundMessage((payload) => {
  console.log("📩 [Service Worker] Nhận tin nhắn:", payload);
  self.registration.showNotification(payload.notification.title, {
    body: payload.notification.body,
    icon: payload.notification.icon,
  });
});
