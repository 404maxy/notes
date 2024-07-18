(function () {
    if ('app' in window) {
        return;
    }

    /**
     * Запуск приложения
     * @constructor
     */
    function App() {

        this.run = function () {

            route.getParams();

            notes.getAll(function(notesList) {
                if(typeof notesList[0] !== 'undefined' && typeof notesList[0].id !== 'undefined') {
                    notes.get(route.id ? route.id : notesList[0].id);
                } else {
                    notes.notes.empty();
                }
            });

            tags.getAll();
        }

    }

    window.app = new App();
    app.run();

})();