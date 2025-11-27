var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/jquery-3.7.1.min.js',
    '/manifest.json',
    '/offline',
    '/css/common.css',
    '/css/layout.css',
    '/images/default-avatar.svg',
    '/images/nawi-icon-96.png',
    '/images/nawi-icon-192.png',
    '/images/nawi-icon-512.png',
];

// Cache on install
self.addEventListener("install", event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        }).then(function(){
            return self.clients.claim();
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('/offline');
            })
    )
});
