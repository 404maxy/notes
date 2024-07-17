(function () {
    if ('tags' in window) {
        return;
    }

    /**
     * Управление виджетом тэгов
     * @constructor
     */
    function Tags() {

        this.tags = $('#tags-list');
        this.form = $('#tags-form');
        this.select = $('#tags-select');

        this.endpoints = {
            "list": "/tag/list",
            "create": "/tag/create",
            "delete": "/tag/delete/",
        };

        /**
         * Отобразить/скрыть форму добавления тэга
         */
        this.showForm = function () {
            this.form.toggleClass('d-none');
        };

        /**
         * Получить список тэгов
         */
        this.getAll = function () {
            $.ajax({
                url: this.endpoints.list,
                type: 'get',
                success: function (response) {
                    if (response.status === 'success') {
                        this.renderList(response.data);
                        this.renderSelect(response.data);
                        //TODO: отправить событие
                    } else {
                        alert(response.message);
                        console.log(response.errors);
                    }
                }.bind(this),
                error: function () {
                    alert('Ошибка в ходе получения списка тэгов. Обратитесь в поддержку.');
                }
            });
        };

        /**
         * Добавить список тэгов на страницу
         * @param tags
         */
        this.renderList = function (tags) {
            this.tags.empty();
            $.each(tags, function (index, tag) {
                this.tags.append('<li class="list-group-item" data-id="'
                    + tag.id + '">'
                    + tag.name
                    + '<button class="badge text-bg-danger rounded-pill float-end" data-id="' + tag.id + '">&times;</button></li>');
            }.bind(this));
        };

        /**
         * Добавить список тэгов в список множественного выбора
         * @param tags
         */
        this.renderSelect = function (tags) {
            this.select.empty();
            $.each(tags, function (index, tag) {
                this.select.append('<option value="'+ tag.id + '">' + tag.name + '</option>');
            }.bind(this));
        };

        /**
         * Добавить тэг
         */
        this.create = function () {
            $.ajax({
                url: this.endpoints.create,
                type: 'post',
                data: this.form.serialize(),
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        this.form[0].reset();
                        this.getAll(); //TODO: достаточно добавить один элемент, нет необходимости загружать весь список
                    } else {
                        alert(response.message);
                        console.log(response.errors);
                    }
                }.bind(this),
                error: function () {
                    alert('Ошибка в ходе создания тэга. Обратитесь в поддержку.');
                }
            });
        };

        /**
         * Удаление тэга
         * @param id
         */
        this.delete = function(id)
        {
            //TODO: вызвать окно с подтверждением
            $.ajax({
                url: this.endpoints.delete + id,
                type: 'post',
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        this.getAll();
                        //TODO: убрать из $('#note-tags')
                    } else {
                        alert(response.message);
                        console.log(response.errors);
                    }
                }.bind(this),
                error: function () {
                    alert('Ошибка в ходе удаления тэга. Обратитесь в поддержку.');
                }
            });
        }

    }

    window.tags = new Tags();
    tags.getAll();
    // let id = parseInt(window.location.hash.substring(1));
    // notes.currentId = id > 0 ? id : 0;
    // notes.get(notes.currentId);

    //TODO: получать идентификатор последней заметки при загрузке без переданного идентификатора заметки

    /**
     * Регистрация событий
     */
    $(document).ready(function () {

        $('#tags-form').submit(function (e) {
            e.preventDefault();
            tags.create();
        });

        $('#tags-list').on('click', 'li', function (e) {
            e.preventDefault();
            $('#tags-list>li').removeClass('active');
            $(this).addClass('active');
        });

        $('#tags-list').on('click', 'li>button', function()
        {
            tags.delete($(this).data('id'));
        });

    });

})();