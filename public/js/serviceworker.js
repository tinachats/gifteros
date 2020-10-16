self.onsync = function(event) {
    if (event.tag == 'background-sync') {
        event.waitUntil(sendToServer());
    }
}

return new Promise(function(resolve, reject) {
    var db = indexedDB.open('newsletterSignup');
    db.onsuccess = function(event) {
        this.result.transaction("newsletterObjStore").objectStore("newsletterObjStore").getAll().onsuccess = function(event) {
            resolve(event.target.result);
        }
    }
    db.onerror = function(err) {
        reject(err);
    }
});