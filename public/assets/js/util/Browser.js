export const Browser = {

    isCanvasSupported () {
        var canvas = document.createElement('canvas');
        return !!(canvas.getContext && canvas.getContext('2d'));
    },

    executeOnWindowLoad (callback) {
        if (document.readyState === 'complete') {
            // The page is already loaded, execute the callback immediately
            callback();
        } else {
            // Add an event listener for the window load event
            window.addEventListener('load', function () {
                callback();
            }, false);
        }
    }
};