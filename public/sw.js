// Nama cache untuk aplikasi
const staticCacheName = "laravel-poin-cache-v1";

// Daftar aset yang ingin di-cache
const assets = [
    "/",
    "/offline",
    "/css/app.css",
    "/js/app.js",
    "/css/custom.css",
    "/manifest.json",
    "images/logo.png",
    // Include key Android icons
    "/icons/android/android-launchericon-48-48.png",
    "/icons/android/android-launchericon-72-72.png",
    "/icons/android/android-launchericon-96-96.png",
    "/icons/android/android-launchericon-144-144.png",
    "/icons/android/android-launchericon-192-192.png",
    "/icons/android/android-launchericon-512-512.png",
    // Include key iOS icons
    "/icons/ios/180.png",
    "/icons/ios/120.png",
    "/icons/ios/167.png",
    "https://fonts.googleapis.com/css?family=Nunito",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js",
];

// Instalasi service worker
self.addEventListener("install", (event) => {
    // Mempercepat proses aktivasi service worker baru
    self.skipWaiting();

    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            console.log("Caching app shell");
            return cache.addAll(assets);
        })
    );
});

// Aktivasi service worker
self.addEventListener("activate", (event) => {
    // Hapus cache lama
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Pada event fetch, tambahkan fallback ke halaman offline
self.addEventListener("fetch", (event) => {
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    event.respondWith(
        caches.match(event.request).then((cachedResponse) => {
            if (cachedResponse) {
                return cachedResponse;
            }

            return fetch(event.request)
                .then((response) => {
                    if (
                        !response ||
                        response.status !== 200 ||
                        response.type !== "basic"
                    ) {
                        return response;
                    }

                    const responseToCache = response.clone();

                    caches.open(staticCacheName).then((cache) => {
                        cache.put(event.request, responseToCache);
                    });

                    return response;
                })
                .catch(() => {
                    // Return the offline page for navigation requests if network fails
                    if (event.request.mode === "navigate") {
                        return caches.match("/offline");
                    }

                    // Return empty response for other types of requests
                    return new Response();
                });
        })
    );
});
