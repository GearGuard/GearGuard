export const Debugger= {
    log (message) {
        try {
            console.log(message);
        } catch (exception) {
            // Ignore any errors
        }
    }
};