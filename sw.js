// Chrome's currently missing some useful cache methods,
// this polyfill adds them.
//importScripts('serviceworker-cache-polyfill.js');

var CACHE_SHELTER = 'cache_shelter_v08';
self.addEventListener('install', function(event) {
  // We pass a promise to event.waitUntil to signal how 
  // long install takes, and if it failed
  event.waitUntil(
    // We open a cache…
    caches.open(CACHE_SHELTER).then(function(cache) {
		console.log(CACHE_SHELTER+' INSTALLED');
      // And add resources to it
	  
var offline_pages = ['/shelter/offline/index.html'];
		console.log(offline_pages.length+" FILES WOULD BE CACHED");
      return cache.addAll(offline_pages)
	  .then(function(){self.skipWaiting();})
	  .catch(function(){console.log("COULD NOT ADD FILES TO THE CACHE")});
    })
  );
});

self.addEventListener('fetch', function(event) {
	
 event.respondWith(
  //if there is cache
	caches.match(event.request).then(function(response){
	  if(response){
		  	  return response;
	  } 
	  return fetch(event.request).then(function(response){
		  if(response.status !== 200){
			  return caches.match('/offline/index.html');	
		  }
			 return response;   
	  }).catch(function(error){ return caches.match('/offline/index.html');
	  });	
	  
	})
		);
	});
	
self.addEventListener('activate',function(event){
	event.waitUntil(
	caches.keys().then(function(cacheNames){
		cacheNames.map(function(cacheName){
			if(cacheName !== CACHE_SHELTER){
			console.log("OLD CACHES DELETING...");
				return caches.delete(cacheName);
			
	});
	})
	);
});
