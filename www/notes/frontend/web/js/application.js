(function () {
    if ('notes' in window) {
        return;
    }

    /**
     * Управление виджетом заметок
     * @constructor
     */
    function Notes() {

        this.form = $('#form');
        this.note = $('#note');
        this.header = $('#header');
        this.body = $('#body');

        /**
         * Отобразить форму добавления/изменения заметки
         */
        this.showForm = function () {
            this.form.removeClass('d-none');
            this.note.addClass('d-none');
        };

        /**
         * Закрыть форму добавления/изменения заметки
         */
        this.hideForm = function () {
            this.form.addClass('d-none');
            this.note.removeClass('d-none');
        };

        /**
         * Установить данные заметки
         * @param title
         * @param body
         */
        this.set = function (id, title, body) {
            this.header.text(title);
            this.body.text(body);
            window.history.pushState({"html":body,"pageTitle":title},"", "note/view/" + id);
        };

        /**
         * Добавить заметку
         */
        this.create = function () {
            $.ajax({
                url: this.form.attr('action'),
                type: 'post',
                data: this.form.serialize(),
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        this.form[0].reset();
                        this.set(response.data.id, response.data.title, response.data.body);
                        this.hideForm();
                        //TODO: установить URL

                    } else {
                        alert(response.message);
                        console.log(response.errors);
                    }
                }.bind(this),
                error: function () {
                    alert('Ошибка в ходе создания заметки. Обратитесь в поддержку.');
                }
            });
        };

    }

    window.notes = new Notes();

    /**
     * Регистрация событий
     */
    $('#add-form-button').click(function () {
        notes.showForm();
    });

    $('#cancel-button').click(function (e) {
        e.preventDefault();
        notes.hideForm();
    });

    $('#form').submit(function (e) {
        e.preventDefault();
        notes.create();
    });

})();