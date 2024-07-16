(function () {
    if ('notes' in window) {
        return;
    }

    /**
     * Управление виджетом заметок
     * @constructor
     */
    function Notes() {

        this.notes = $('#notes-list');
        this.form = $('#form');
        this.note = $('#note');
        this.header = $('#header');
        this.body = $('#body');

        this.endpoints = {
            "list": "/note/list",
            "view": '/note/view/'
        };

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
         * Получить список заметок
         */
        this.getAll = function() {
            $.ajax({
                url: this.endpoints.list,
                type: 'get',
                success: function (response) {
                    console.log(response);
                    if (response.status === 'success') {
                        this.renderList(response.data)
                    } else {
                        alert(response.message);
                        console.log(response.errors);
                    }
                }.bind(this),
                error: function () {
                    alert('Ошибка в ходе получения списка заметок. Обратитесь в поддержку.');
                }
            });
        };

        /**
         * Добавить список заметок на страницу
         * @param notes
         */
        this.renderList = function(notes) {
            this.notes.empty();
            $.each(notes, function(index, note) {
                this.notes.append('<li class="list-group-item"><a href="/note/view/' + note.id + '">' + note.title + '</a></li>');
            }.bind(this));
        };

        /**
         * Установить данные заметки
         * @param id
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
                        this.getAll();
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
    notes.getAll();

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