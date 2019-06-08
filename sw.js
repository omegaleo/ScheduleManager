self.addEventListener('sync', function(event) {
    if (event.tag == 'notify') {
      event.waitUntil(CheckNotifications());
    }
});