(function () {
    if ('route' in window) {
        return;
    }

    /**
     * Маршрутизация запросов
     * /1
     * /?search=keywords
     * /?page=1
     * /?tagId=1
     * /?sort=created_at&direction=desc
     * /1?search=keywords&page=1&tagId=1&sort=created_at&direction=desc
     * @constructor
     */
    function Route() {

        this.id = null;
        this.search = null;
        this.page = null;
        this.tagId = null;
        this.sort = null;
        this.direction = null;

        /**
         * Получение параметров из адресной строки
         */
        this.getParams = function () {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

            const queryParams = {};
            params.forEach((value, key) => {
                queryParams[key] = value;
            });

            const id = url.pathname.substring(1);

            this.id = id ? parseInt(id) : this.id;
            this.search = queryParams['search'] ?? this.search;
            this.page = queryParams['page'] ?? this.page;
            this.tagId = queryParams['tagId'] ?? this.tagId;
            this.sort = queryParams['sort'] ?? this.sort;
            this.direction = queryParams['direction'] ?? this.direction;
        }

        /**
         * Построение строки запроса
         */
        this.buildQuery = function () {
            let paramsStack = [];
            if (this.search) paramsStack.push('keywords=' + this.search);
            if (this.page) paramsStack.push('page=' + this.page);
            if (this.tagId) paramsStack.push('tagId=' + this.tagId);
            if (this.sort) paramsStack.push('sort=' + this.sort);
            if (this.direction) paramsStack.push('direction=' + this.direction);

            return paramsStack.length > 0 ? '?' + paramsStack.join('&') : '';
        };

        /**
         * Построение url
         * @returns {string}
         */
        this.buildUrl = function () {
            let url = '';
            if (this.id) url = url + '/' + this.id;

            //TODO: добавлять URL в адресную строку при измнении состояния класса

            return url + this.buildQuery();
        };

    }

    window.route = new Route();

})();