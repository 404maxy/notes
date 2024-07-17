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
        this.title = $('#title');
        this.body = $('#body');
        this.formTitle = $('#form-title');
        this.formBody = $('#form-body');

        this.currentId = 0;

        this.endpoints = {
            "list": "/note/list",
            "view": "/note/view/",
            "create": "/note/create",
            "delete": "/note/delete/",
            "update": "/note/update/"
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
        this.getAll = function (callback) {
            $.ajax({
                url: this.endpoints.list,
                type: 'get',
                success: function (response) {
                    if (response.status === 'success') {
                        this.renderList(response.data);
                        if(typeof callback === "function") {
                            callback(response.data);
                        }
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
        this.renderList = function (notes) {
            this.notes.empty();
            $.each(notes, function (index, note) {
                this.notes.append('<li class="list-group-item" data-id="' + note.id + '">' + note.title + '</li>');
            }.bind(this));
        };

        /**
         * Получить данные одной заметки
         */
        this.get = function (id) {
            $.ajax({
                url: this.endpoints.view + id,
                type: 'get',
                success: function (response) {
                    if (response.status === 'success') {
                        this.currentId = response.data.id;
                        this.set(response.data.id, response.data.title, response.data.body);
                    } else {
                        alert(response.message);
                        console.log(response.errors);
                    }
                }.bind(this),
                error: function () {
                    alert('Ошибка в ходе получения заметки. Обратитесь в поддержку.');
                }
            });
        };

        /**
         * Установить данные заметки
         * @param id
         * @param title
         * @param body
         */
        this.set = function (id, title, body) {
            this.title.text(title);
            this.body.text(body);
            this.formTitle.val(title);
            this.formBody.text(body);
            window.history.pushState({"html": body, "pageTitle": title}, "", "#" + id);
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

        /**
         * Удаление заметки
         * @param id
         */
        this.delete = function(id)
        {
            $.ajax({
                url: this.endpoints.delete + this.currentId,
                type: 'post',
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        this.getAll(function(notesList) {
                            notes.get(notesList[0].id)
                        });
                    } else {
                        alert(response.message);
                        console.log(response.errors);
                    }
                }.bind(this),
                error: function () {
                    alert('Ошибка в ходе удаления заметки. Обратитесь в поддержку.');
                }
            });
        }

    }

    window.notes = new Notes();
    notes.getAll(function(notesList) {
        if(typeof notesList[0] !== 'undefined' && typeof notesList[0].id !== 'undefined') {
            notes.get(id);
        } else {
            notes.notes.empty();
        }
    });

    let id = parseInt(window.location.hash.substring(1));
    if(!isNaN(id)) {
        notes.get(id);
    } else {
        //$('#controls').hide(); //TODO:
    }

    /**
     * Регистрация событий
     */
    $(document).ready(function () {
        $('#add-note-button').click(function () {
            notes.form.attr('action', notes.endpoints.create);
            notes.form[0].reset();
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

        $('#notes-list').on('click', 'li', function (e) {
            e.preventDefault();
            notes.get($(this).data('id'));
            notes.hideForm();
            $('#notes-list>li').removeClass('active');
            $(this).addClass('active');
        });

        $('#edit-button').click(function(e)
        {
            notes.form.attr('action', notes.endpoints.update + notes.currentId);
            notes.showForm();
        });

        $('#delete-button').click(function(e)
        {
            notes.delete(notes.currentId);
        });

    });

})();