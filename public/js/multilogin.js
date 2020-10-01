
window.Multilogin = {
    /**
     * Обработчик успешного входа
     */
    onSuccess: false,

    searchStr: null,

    init() {
        this.searchStr = window.location.search.substr(1);

        if (this.searchStr) {
            var searchParts = this.searchStr.split('=');
            if (searchParts[0] === 'multilogin_token') {
                var token = searchParts[1];

                if (this.onSuccess) {
                    this.onSuccess(token);
                }
            }
        }
    },

    popupWindow(url, title, w, h) {
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    },

    doLogin(url, redirect) {
        if (!redirect) {
            var authWindow = this.popupWindow(url, 'Авторизация', 500, 500);
            var closedChecker = null;

            window.onmessage = function(e) {
                if (e.data.id && this.onSuccess) {
                    this.onSuccess(e.data.id);
                }
            }.bind(this);
        } else {
            location.href = url+'&redirect='+redirect;
        }
    }
};
