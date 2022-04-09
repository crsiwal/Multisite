/* global Storage */

$(document).ready(function () {
    Database = function Database() {};

    /* Database Class Start */
    $.extend(Database.prototype, {
        storage: (typeof (Storage) !== "undefined") ? 'local' : 'cookie',
        setNode: function ($key, $value) {
            $value = this.safe($value);
            if (this.storage === 'local') {
                localStorage.setItem($key, $value);
            } else {
                $.cookie($key, $value, {expires: 365});
            }
        },
        getNode: function ($key) {
            if (this.storage === 'local') {
                $value = localStorage.getItem($key);
            } else {
                $value = $.cookie($key);
            }
            if (typeof ($value) === 'undefined' || $value === 'undefined' || $value === null || $value === 'null' || $value === '') {
                return null;
            } else {
                return this.safe($value, true);
            }
        },
        removeNode: function ($key) {
            if (this.storage === 'local') {
                localStorage.removeItem($key);
            } else {
                $.cookie($key, null);
            }
        },
        clearAllNodes: function () {
            if (this.storage === 'local') {
                localStorage.clear();
            } else {
                this.clearAllCookies();
            }
        },
        setTempNode: function ($key, $value) {
            $value = this.safe($value);
            if (this.storage === 'local') {
                sessionStorage.setItem($key, $value);
            } else {
                $.cookie($key, $value, {expires: 0});
            }
        },
        getTempNode: function ($key) {
            if (this.storage === 'local') {
                $value = sessionStorage.getItem($key);
            } else {
                $value = $.cookie($key);
            }
            if (typeof ($value) === 'undefined' || $value === null || $value === 'null' || $value === '') {
                return null;
            } else {
                return this.safe($value, true);
            }
        },
        removeTempNode: function ($key) {
            if (this.storage === 'local') {
                sessionStorage.removeItem($key);
            } else {
                $.cookie($key, null);
            }
        },
        setCookie: function (key, value) {
            $.cookie(key, value, {expires: 365, path: '/'});
        },
        getCookie: function (key) {
            let value = $.cookie(key);
            return this.safe(value, true);
        },
        removeCookie: function (key) {
            $.cookie(key, null);
        },
        clearAllTempNodes: function () {
            if (this.storage === 'local') {
                sessionStorage.clear();
            } else {
                this.clearAllCookies();
            }
        },
        clearAllCookies: function () {
            var cookies = $.cookie();
            for (var cookie in cookies) {
                $.removeCookie(cookie);
            }
        },
        safe: function ($value, $return) {
            return ($return === true) ? JSON.parse($value) : JSON.stringify($value);
        }
    });
});