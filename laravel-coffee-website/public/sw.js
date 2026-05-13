const preLoad = function () {
    return caches.open("offline").then(function (cache) {
        // caching index and important routes
        return cache.addAll(filesToCache);
    });
};

self.addEventListener("install", function (event) {
    event.waitUntil(preLoad());
});

const filesToCache = [
    '/',
    '/offline.html'
];

const checkResponse = function (request) {
    return new Promise(function (fulfill, reject) {
        fetch(request.clone()).then(function (response) {
            if (response.status !== 404) {
                fulfill(response);
            } else {
                reject();
            }
        }, reject);
    });
};

const addToCache = function (request) {
    // Only cache GET requests
    if (request.method === 'GET') {
        return caches.open("offline").then(function (cache) {
            return fetch(request.clone()).then(function (response) {
                // Only add to cache if the request is successful
                if (response.ok) {
                    return cache.put(request, response.clone());
                }
            });
        });
    }
    // Return a promise that resolves immediately for non-GET requests
    return Promise.resolve();
};

const returnFromCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return cache.match(request).then(function (matching) {
            if (!matching || matching.status === 404) {
                return cache.match("offline.html");
            } else {
                return matching;
            }
        });
    });
};

self.addEventListener("fetch", function (event) {
    event.respondWith(checkResponse(event.request).catch(function () {
        return returnFromCache(event.request);
    }));

    if (event.request.url.startsWith('http')) {
        event.waitUntil(addToCache(event.request));
    }
});
