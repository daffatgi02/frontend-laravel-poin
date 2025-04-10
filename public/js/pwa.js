// Check if service worker is supported
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/sw.js')
        .then(registration => {
          console.log('Service Worker registered with scope:', registration.scope);
        })
        .catch(error => {
          console.error('Service Worker registration failed:', error);
        });
    });
  }

  // PWA installation prompt
  let deferredPrompt;
  const installButton = document.getElementById('pwa-install-button');

  // Hide the install button initially
  if (installButton) {
    installButton.style.display = 'none';
  }

  window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent Chrome 67 and earlier from automatically showing the prompt
    e.preventDefault();

    // Stash the event so it can be triggered later
    deferredPrompt = e;

    // Show the install button
    if (installButton) {
      installButton.style.display = 'block';

      installButton.addEventListener('click', () => {
        // Show the install prompt
        deferredPrompt.prompt();

        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === 'accepted') {
            console.log('User accepted the install prompt');
          } else {
            console.log('User dismissed the install prompt');
          }

          // We no longer need the prompt
          deferredPrompt = null;

          // Hide the install button
          installButton.style.display = 'none';
        });
      });
    }
  });
