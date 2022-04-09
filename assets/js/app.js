/* global custom_config, $app, FroalaEditor */

$(document).ready(function () {
    app = function () {
        this.page = false;
        this.db = new Database();
        this.cache = new JSCache(this);
        this.html = new JSHTML(this);
        this.graph = new JSGraph(this);
        this.image = new CropImage(this);
        this.script = new JSPageScript(this);
        this.pool = [];
        this.loading = 0;
        $configuration = [];
        this.session = [];
    };
    $.extend(app.prototype, {
        /* This function by default trigger like constructor and run many tasks */
        init: function () {
            this.setConfig();
            this.graph.init();
            this.script.init();
            this.page = this.getConfig('page_name');
        },
        clear_cache_keys: function (cachekey, extra) {
            extra = this.safeVar(extra, []);
            let cache_keys = {
                userrole: ["userroles_list"],
                access: ["access_list"],
                accessgroup: ["accessgroups_list"],
                uploads: [],
                adgroup: ["adgroup_list"],
                adsize: ["adsize_list"],
                category: ["category_list"],
                roleaccess: [],
                page: ["user_blog_pagelist", "user_blogslist", "summery_counts"],
                video: ["user_blog_videolist", "user_blogslist", "summery_counts"],
                post: ["user_blog_postlist", "user_blogslist", "summery_counts"]
            };
            if (this.isset(cache_keys, cachekey)) {
                let keys = cache_keys[cachekey];
                if (this.isArray(extra)) {
                    keys = keys.concat(extra);
                }
                this.manage_cache_keys(cachekey, keys);
            }
        },
        manage_cache_keys: function (cachekey, keys) {
            switch (cachekey) {
                case 'access':
                case 'accessgroup':
                    $app.cache.clearCache();
                    break;
                default:
                    $app.cache.removeKeys(keys);
            }
        },
        page_drawer: function () {
            return {
                summery: "page_summery",
                blog_add: "page_addblog",
                bloggrid: "page_bloggrid",
                postlist: "page_postlist",
                newpost: "page_newpost",
                editpost: "page_editpost",
                videolist: "page_videolist",
                newvideo: "page_newvideo",
                editvideo: "page_editvideo",
                pagelist: "page_pagelist",
                newpage: "page_newpage",
                editpage: "page_editpage",
                categorylist: "page_categorylist",
                adsizelist: "page_adsizelist",
                adgrouplist: "page_adgrouplist",
                uploads: "page_uploads",
                userroles: "page_userroles",
                accessgroup: "page_accessgroup",
                access: "page_access",
                roleaccess: "page_roleaccess"
            };
        },
        handler_edit: function () {
            return {
                posts: "post_edit",
                videos: "video_edit",
                pages: "page_edit",
                catrtable: "category_edit",
                adstable: "adsize_edit",
                adgtable: "adgroup_edit",
                uroletable: "userrole_edit",
                agrouptable: "accessgroup_edit",
                accesstable: "access_edit",
            };
        },
        handler_view: function () {
            return {

            };
        },
        handler_access: function () {
            return {
                uroletable: "userrole_access"
            };
        },
        handler_block: function () {
            return {

            };
        },
        handler_delete: function () {
            return {
                posts: "post_delete",
                videos: "video_delete",
                pages: "page_delete",
                catrtable: "category_delete",
                adstable: "adsize_delete",
                adgtable: "adgroup_delete",
                uroletable: "userrole_delete",
                agrouptable: "accessgroup_delete",
                accesstable: "access_delete",
            };
        },
        setConfig: function () {
            let that = this;
            $configuration = {
                debuging: false,
                jstrace: false,
                cache_enable: false,
                cache_clear_minutes: 60,
                base_url: window.location.protocol + "//" + window.location.hostname + "/",
                user_id: 0,
                blog_id: -1,
                page_name: 'unknown',
                table_max_row: 25
            };
            this.addConfig("icon_edit", this.icon_url('edit.svg'));
            this.addConfig("icon_view", this.icon_url('eye.svg'));
            this.addConfig("icon_delete", this.icon_url('delete.svg'));
            $.each($configuration, function ($key, $value) {
                $configuration[$key] = that.isUndefined(custom_config[$key]) ? $value : that.safeVar(custom_config[$key], $value);
            });
        },
        addConfig: function ($key, $value) {
            if ($key in $configuration) {
                return false;
            } else {
                $configuration[$key] = $value;
                return true;
            }
        },
        updateConfig: function ($key, $value) {
            if ($key in $configuration) {
                $configuration[$key] = $value;
                return true;
            } else {
                return false;
            }
        },
        setSession: function (key, value) {
            this.session[key] = value;
        },
        getSession: function (key) {
            if (this.isset(this.session, key)) {
                return this.session[key];
            }
            return null;
        },
        removeSession: function (key) {
            if (this.isset(this.session, key)) {
                return delete this.session[key];
            }
            return false;
        },
        updateSession: function (key, value) {
            if (this.isset(this.session, key)) {
                this.session[key] = value;
                return true;
            } else {
                return false;
            }
        },
        get_integer: function (number) {
            return isNaN(parseInt(number, 10)) ? 0 : parseInt(number, 10);
        },
        getConfig: function ($key) {
            return ($key in $configuration) ? $configuration[$key] : null;
        },
        base_url: function ($slug) {
            $url = this.safeVar(this.getConfig('base_url'), "") + this.safeVar($slug, "");
            return $url;
        },
        icon_url: function (icon) {
            return this.base_url("assets/icons/" + icon);
        },
        editor: function (editor_id, preview_id) {
            preview_id = this.safeVar(preview_id, false);
            if (FroalaEditor) {
                $app.sethtml(preview_id, $app.get(editor_id));
                new FroalaEditor(`#${editor_id}`, {
                    key: 'dinchak',
                    pluginsEnabled: null,
                    heightMin: 260,
                    heightMax: 450,
                    charCounterCount: true,
                    // Image Configurations
                    imageManagerLoadURL: this.base_url("api/editor/i"),
                    imageManagerPageSize: 10,
                    imageManagerScrollOffset: 10,
                    imageManagerToggleTags: false,
                    imageUploadRemoteUrls: false,
                    imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif', 'webp'],
                    imageDefaultAlign: 'left',
                    imageDefaultDisplay: 'inline',
                    imageDefaultMargin: 37,
                    imageDefaultWidth: 200,
                    imageEditButtons: ['imageAlign', 'imageDisplay', 'imageRemove', 'imageLink', '-', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageReplace', 'imageCaption', 'imageAlt'],
                    imageCORSProxy: 'https://cors-anywhere.herokuapp.com',
                    imageManagerPreloader: $app.icon_url("wait.gif"),
                    imageAddNewLine: true,
                    imagesLoadURL: this.base_url("list2"),

                    // Image Upload
                    imageUpload: true,
                    imageUploadURL: this.base_url("api/editor"),
                    imageUploadParam: 'clnfile',
                    maxImageSize: 1024 * 1024 * 1,

                    // Image Delete
                    imageManagerDeleteURL: this.base_url("api/editor"),
                    imageManagerDeleteMethod: 'DELETE',
                    pastedImagesUploadURL: this.base_url("paste-img-upload"),

                    // Video Configurations
                    videoAllowedTypes: ['mp4'],
                    videoInsertButtons: ['videoBack', '|', 'videoByURL'],
                    videoResponsive: false,
                    videoUpload: false,
                    videoUploadURL: this.base_url("video-upload"),

                    // File Config
                    fileUpload: true,
                    fileUploadURL: this.base_url("api/editor"),
                    fileUploadParam: 'clnfile',
                    fileAllowedTypes: ['application/pdf'],
                    fileMaxSize: 1024 * 1024 * 1,
                    events: {
                        contentChanged: function () {
                            $app.sethtml(preview_id, this.html.get())
                        }
                    }
                });
                return true;
            }
            return false;
        },
        callHttp: function (option, callback) {
            let that = this;
            let foundInLocalCache = false;
            let cacheKeyName = this.safeVar(option.cachekey, false);
            let checkdefault = this.safeVar(option.checkdefault, true);
            let callback_on_error = this.safeVar(option.callbackonerror, false);
            let decodeJson = this.safeVar(option.jsondecode, false);
            callback = (this.isUndefined(callback) === true) ? false : callback;
            if (that.getConfig("cache_enable") === true && cacheKeyName !== false) {
                if (callback !== false) {
                    response = that.cache.get(cacheKeyName, option);
                    if (response !== null) {
                        foundInLocalCache = true;
                        if (checkdefault === true) {
                            response = ((decodeJson === true) ? $app.jsonParse(response) : response)
                            if ($app.defaultCall(response) === true || callback_on_error === true) {
                                callback(response);
                            }
                        } else {
                            callback(response);
                        }
                        return false;
                    } else {
                        that.debug("Data not found in Local Cache. Connecting to server " + cacheKeyName);
                    }
                }
            }
            if (foundInLocalCache === false) {
                return this.callToHttp(option, callback);
            }
        },
        callToHttp: function (option, callback) {
            let that = this;
            let defaults = {
                async: true,
                type: 'GET',
                timeout: 180, // In Seconds
                url: "",
                data: '',
                xhrFields: {withCredentials: false},
                processData: true,
                //dataType: 'json',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8"
            };
            this.wait();
            let options = $.extend(defaults, option);
            let checkdefault = this.safeVar(option.checkdefault, true);
            let callback_on_error = this.safeVar(option.callbackonerror, false);
            let decodeJson = this.safeVar(option.jsondecode, false);
            $xhr = $.ajax({
                async: options.async,
                type: options.type,
                url: options.url,
                timeout: (options.timeout * 1000),
                data: options.data,
                xhrFields: options.xhrFields,
                processData: options.processData,
                contentType: options.contentType,
                //dataType: options.dataType,
                beforeSend: function (jxhr) {
                    that.debug("callHttp Ajax Before Send");
                    that.pool.push(jxhr);
                },
                success: function (response, status, xhr) {
                    let cont_type = xhr.getResponseHeader("content-type") || "";
                    if (callback !== false) {
                        if (cont_type === "application/json") {
                            let saveResponse = response;
                            if (checkdefault === true) {
                                response = ((decodeJson === true) ? $app.jsonParse(response) : response);
                                if ($app.defaultCall(response) === true || callback_on_error === true) {
                                    let cacheKeyName = that.safeVar(options.cachekey, false);
                                    if (that.getConfig("cache_enable") === true && cacheKeyName !== false) {
                                        that.debug("list-> " + cacheKeyName);
                                        that.cache.set(cacheKeyName, saveResponse);
                                    }
                                    callback(response);
                                }
                            } else {
                                callback(((decodeJson === true) ? $app.jsonParse(response) : response));
                            }
                        } else {
                            $app.toast("Unable to handle request. Please try again lator");
                            callback([]);
                        }
                    }
                },
                complete: function (jxhr) {
                    that.debug("callHttp Ajax Complete");
                    let poolIndex = that.pool.indexOf(jxhr);
                    (poolIndex > -1) ? that.pool.splice(poolIndex, 1) : false;
                    that.wait(true);
                },
                statusCode: {
                    404: function () {
                        that.debug("Page not found");
                    },
                    504: function () {
                        $app.toast("It's taking too much time. Unable to proceed now.");
                        if (callback !== false) {
                            callback([]);
                        }
                    }
                },
                error: function (req, status, xhr) {
                    if (status === 'timeout') {
                        $app.toast("Unable to connect to service. Please try again lator", "error");
                        if (callback !== false) {
                            callback({status: 'false', logout: 'false', msg: "Unable to proceed your request. Please try again.", data: {}});
                        }
                    }
                }
            });
            return $xhr;
        },
        abortAllHttp: function ($url) {
            let that = this;
            $url = this.safeVar($url);
            try {
                $(that.pool).each(function ($poolIndex, jxhr) {
                    try {
                        that.debug('xhrPool.abortAll ' + jxhr.requestURL);
                        if (!$url || $url === jxhr.requestURL) {
                            // Abort the connection and removes this connection from list by index
                            jxhr.abort();
                            that.pool.splice($poolIndex, 1);
                        }
                    } catch (err) {
                        $app.debug(err.message);
                    }
                });
            } catch (err) {
                $app.debug(err.message);

            }
        },
        /**
         * 
         * @param {type} resposne
         * @returns {Boolean}
         */
        defaultCall: function (response) {
            try {
                let status = $app.safeVar(response.status);
                if (status === 'true') {
                    return true;
                } else {
                    let logout = $app.safeVar(response.logout, false);
                    if (logout === 'true') {
                        $app.redirect('login');
                    } else {
                        $app.toast($app.safeVar(response.msg, ""), "error");
                    }
                }
            } catch (err) {
                $app.debug(err.message);
            }
        },
        inArray: function (value, array) {
            if (this.isArray(array) === true) {
                if ($.inArray(value, array) !== -1) {
                    return true;
                }
            }
            return false;
        },
        removeFromArray: function (arrayList, value) {
            try {
                let index = arrayList.indexOf(value);
                if (index > -1) {
                    arrayList.splice(index, 1);
                }
                return arrayList;
            } catch (err) {
                $app.debug(err.message);
            }
        },
        isArray: function (value) {
            return $.isArray(value);
        },
        isObject: function (value) {
            return (typeof value === 'object');
        },
        isMap: function (value) {
            return (this.isArray(value) || this.isObject(value)) ? true : false;
        },
        uniqueArray: function (list) {
            let result = [];
            $.each(list, function (i, e) {
                if ($.inArray(e, result) === -1)
                    result.push(e);
            });
            return result;
        },
        debug: function (content, debugthis) {
            debugthis = (this.safeVar(this.getConfig("debuging"), false) === true) ? true : this.safeVar(debugthis, false);
            if (debugthis === true) {
                if ((this.safeVar(this.getConfig("jstrace"), false)) === true) {
                    console.trace(content);
                } else {
                    console.trace(content);
                    //console.log(content);
                }
            }
        },
        error: function (content, debugthis) {
            debugthis = (this.safeVar(this.getConfig("debuging"), false) === true) ? true : this.safeVar(debugthis, false);
            if (debugthis === true) {
                console.error(content);
            }
        },
        redirect: function (target, external) {
            let url = "";
            target = this.safeVar(target, "");
            switch (target) {
                case 'home':
                    $url = this.base_url();
                    break;
                case 'login':
                    url = this.base_url('login');
                    break;
                default:
                    url = (external === true) ? target : this.base_url(target);
                    break;
            }
            try {
                this.abortAllHttp();
                window.location.href = url;
            } catch (err) {
                $app.debug(err.message);
            }
        },
        download: function (url) {
            const a = document.createElement("a");
            a.style.display = "none";
            document.body.appendChild(a);
            a.href = url;
            a.setAttribute("download", url.substring(url.lastIndexOf('/') + 1));
            a.click();
            window.URL.revokeObjectURL(a.href);
            document.body.removeChild(a);
        },
        randomString: function (length) {
            let result = '';
            length = this.safeVar(length, 8);
            let mask = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            for (let i = length; i > 0; --i)
                result += mask[Math.floor(Math.random() * mask.length)];
            return result;
        },
        getUrlString: function () {
            try {
                return window.location.pathname.split("/").pop().split(".")[0].substr(0, 36).replace(/-\s*$/, "");
            } catch (err) {
                $app.debug(err.message);
            }
        },
        getUrlParams: function (url) {
            try {
                url = this.safeVar(url, "");
                let fields = {};
                if (url !== "") {
                    url = new URL(url);
                    let searchParams = new URLSearchParams(url.search);
                    for (let pair of searchParams.entries()) {
                        fields[pair[0]] = pair[1];
                    }
                }
                return fields;
            } catch (err) {
                $app.debug(err.message, true);
            }
        },
        capitalize: function (word) {
            try {
                return word.charAt(0).toUpperCase() + word.slice(1);
            } catch (err) {
                $app.debug(err.message);
            }
        },
        lowercase: function (word) {
            return word.toLowerCase();
        },
        uppercase: function (word) {
            return word.toUpperCase();
        },
        isset: function (array, key) {
            return (key in array) ? true : false;
            //return (typeof array[key] === 'undefined') ? false : true;
        },
        isUndefined: function (variable) {
            return (typeof variable === 'undefined') ? true : false;
        },
        safeVar: function (variable, defaultValue) {
            try {
                return (this.isUndefined(variable) === false) ? variable : ((this.isUndefined(defaultValue) === false) ? defaultValue : null);
            } catch (err) {
                $app.debug(err.message);
                return defaultValue;
            }
        },
        hashCode: function (value) {
            try {
                return $().crypt({method: "md5", source: value});
            } catch (err) {
                $app.debug(err.message);
                return "";
            }
        },
        /* This function check the object exist on webpage and return the boolean  */
        idExist: function (id, isClass) {
            let eid = ((isClass === true) ? "." : "#") + id;
            return (this.isUndefined(id) !== true && $(eid).length > 0) ? true : false;
        },
        classExist: function (className) {
            return (this.isUndefined(className) !== true && $("." + className).length > 0) ? true : false;
        },
        elementLength: function (className) {
            return $("." + className).length;
        },
        json: function (objects) {
            try {
                return JSON.stringify(objects);
            } catch (err) {
                $app.debug(err.message);
            }
            return "{}";
        },
        jsonParse: function (json) {
            try {
                return JSON.parse(json);
            } catch (err) {
                $app.debug(err.message);
            }
            return {};
        },
        replace: function (string, oldvalue, newvalue) {
            try {
                let oldstring = new RegExp(oldvalue, 'g');
                return string.replace(oldstring, newvalue);
            } catch (err) {
                $app.debug(err.message, true);
            }
        },
        getLength: function (object, isObject) {
            try {
                if (this.isObject(object) === true) {
                    let length = 0;
                    for (let index in object) {
                        length++;
                    }
                    return length;
                } else if (this.isArray(object) === true) {
                    return object.length;
                } else {
                    if (!this.isBlank(object)) {
                        return object.length;
                    } else {
                        return 0;
                    }
                }
            } catch (err) {
                $app.debug(err.message, true);
            }
        },
        loadingCount: function (remove) {
            if (remove === true) {
                this.loading = this.loading - 1;
            } else {
                this.script.disableSelectOption(true);
                this.loading = this.loading + 1;
            }
            return this.loading;
        },
        isLoading: function () {
            if (this.loading > 0) {
                return true;
            } else {
                //this.script.disableSelectOption(false);
                return false;
            }
        },
        isBlank: function (value) {
            return (this.isNull(value) === true || value === "") ? true : false;
        },
        isNull: function (value) {
            return (value === null) ? true : false;
        },
        getDate: function ($request) {
            let d = new Date();
            switch ($request) {
                case 'yesterday':
                    d.setDate(d.getDate() - 1);
                    break;
                case '7thday':
                    d.setDate(d.getDate() - 6);
                    break;
            }
            let month = d.getMonth() + 1;
            let day = d.getDate();
            return d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
        },
        dateFormat: function (unFormatedDate) {
            let tmpdate = moment(unFormatedDate);
            return tmpdate.format("DD MMMM YYYY");
        },
        timeSince: function (date) {
            date = new Date(date);
            let seconds = Math.floor((new Date() - date) / 1000);
            let interval = Math.floor(seconds / 31536000);
            if (interval > 1) {
                return interval + " years ago";
            }
            interval = Math.floor(seconds / 2592000);
            if (interval > 1) {
                return interval + " months ago";
            }
            interval = Math.floor(seconds / 86400);
            if (interval > 1) {
                return interval + " days ago";
            }
            interval = Math.floor(seconds / 3600);
            if (interval > 1) {
                return interval + " hours ago";
            }
            interval = Math.floor(seconds / 60);
            if (interval > 1) {
                return interval + " minutes ago";
            }
            return Math.floor(seconds) + " seconds ago";
        },
        updateDropdownButton: function (btnid, btnValue, listid) {
            if (btnValue === false) {
                $('button#' + btnid + ' span:first-child').text($('#' + listid + ' a:first-child').text());
            } else {
                $('button#' + btnid + ' span:first-child').text(btnValue);
            }
        },
        setDropdownList: function (arrayList, listid, btnid, saveFirstElement, singleArray, nameIsId) {
            if (saveFirstElement === true) {
                $('#' + listid + ' a:not(:first-child)').remove();
            } else {
                $('#' + listid + ' a').remove();
            }
            if (this.isArray(arrayList) === true) {
                html = "";
                arrayList.forEach(function (row) {
                    let id = name = "";
                    if (singleArray === true) {
                        id = $app.safeVar(row, -1);
                        name = id;
                    } else {
                        id = $app.safeVar(row.id, -1);
                        name = (nameIsId === true) ? id : $.trim($app.safeVar(row.name, "Unknown"));
                    }
                    name = (name !== "") ? name : "Unknown";
                    html += '<a class="dropdown-item" data-id="' + id + '" href="#">' + name + '</a>';
                });
                $app.sethtml(listid, html, true);
            }
            this.updateDropdownButton(btnid, false, listid);
        },
        setSelectList: function (response, selectid, apikey, namekey, valuekey, saveFirstElement, defaultselect) {
            if (saveFirstElement === true) {
                $('#' + selectid + ' option:not(:first-child)').remove();
            } else {
                $('#' + selectid + ' option').remove();
            }
            let arrayList = this.safeVar(response.data[apikey], []);
            arrayList = (this.isset(arrayList, "list") === true) ? this.safeVar(arrayList.list, []) : arrayList;
            let html = "";
            if (this.isArray(arrayList) === true) {
                arrayList.forEach(function (row) {
                    let name = $.trim($app.safeVar(row[namekey], "Unknown"));
                    let value = $.trim($app.safeVar(row[valuekey], "Unknown"));
                    html += '<option class="text-capatilize" value="' + value + '" ' + ((name === defaultselect || value === defaultselect) ? 'selected="selected"' : '') + '>' + name + '</option>';
                });
                $app.sethtml(selectid, html, true);
                $app.disableBtn([selectid], false);
            }
            this.select2(selectid);
        },
        clearSelectList: function (idList, removeAll) {
            if ($app.isArray(idList) === true) {
                $.each(idList, function (key, selectid) {
                    if ($app.idExist(selectid) === true) {
                        if (removeAll === true) {
                            $('#' + selectid + ' option').remove();
                        } else {
                            $('#' + selectid + ' option:not(:first-child)').remove();
                        }
                    }
                });
            }
        },
        formatAsTime: function (seconds, format) {
            let days = Math.trunc(seconds / (24 * 60 * 60));
            seconds = seconds % (24 * 60 * 60);
            let hours = Math.trunc(seconds / (60 * 60));
            seconds = seconds % (60 * 60);
            let minutes = Math.trunc(seconds / 60);
            seconds = seconds % 60;
            let response = '';
            let that = this;
            switch (format) {
                case 'days':
                    response = that.padZero(days) + ':' + that.padZero(hours) + ':' + that.padZero(minutes) + ':' + that.padZero(seconds);
                    break;
                case 'hour':
                    response = that.padZero(hours) + ':' + that.padZero(minutes) + ':' + that.padZero(seconds);
                    break;
                case 'minute':
                    response = that.padZero(minutes) + ':' + that.padZero(seconds);
                    break;
                case 'second':
                    response = that.padZero(seconds);
                    break;
                default:
                    response = that.padZero(hours) + ':' + that.padZero(minutes) + ':' + that.padZero(seconds);
            }
            return response;
        },
        padZero: function (v) {
            v = Math.round(v);
            if (v < 10)
                return '0' + v;
            return v;
        },
        getDropDownListData: function (response, appkey) {
            if (this.isset(response.data, appkey) === true && this.isArray(response.data[appkey]) && this.getLength(response.data[appkey]) > 0) {
                return response.data[appkey];
            } else {
                return false;
            }
        },
        replaceDataByClass: function (classname, response, dataobj) {
            let dataList = $app.safeVar(response.data[dataobj], []);
            let that = this;
            console.log(dataList);
            if (this.isArray(dataList) === true || this.isObject(dataList) === true) {
                $(`.${classname}`).each(function (index) {
                    let expectKey = $(this).data("key");
                    if (that.isset(dataList, expectKey)) {
                        $(this).text(that.safeVar(dataList[expectKey]));
                    }
                });
            } else {
                this.toast("Unable to load Campaign details. Please try again lator");
            }
        },
        getTimeDiffrence: function ($start, $end) {
            return Math.floor(((Math.abs(new Date($end) - new Date($start))) / 1000) / 60);
        },
        set: function (id, value) {
            $(`#${id}`).val(value);
        },
        get: function (id) {
            return this.safeVar($(`#${id}`).val(), "");
        },
        set_attr: function (id, attribute, value) {
            $(`#${id}`).attr(attribute, value);
        },
        get_attr: function (id, attribute) {
            return $(`#${id}`).attr(attribute);
        },
        checked: function (id) {
            return (this.idExist(id) && $(`#` + id).prop("checked") === true) ? true : false;
        },
        setdata: function (id, key, value) {
            $(`#${id}`).data(key, value);
        },
        getdata: function (id, key) {
            return this.safeVar($(`#${id}`).data(key), "");
        },
        sethtml: function (id, value, append) {
            if (this.idExist(id) === true) {
                if (append === true) {
                    $(`#${id}`).append(value);
                } else {
                    $(`#${id}`).html(value);
                }
            }
        },
        gethtml: function (id) {
            if (this.idExist(id) === true) {
                return $(`#${id}`).html();
            } else {
                return "";
            }
        },
        getSelected: function (id, returnText) {
            if (returnText === true) {
                return this.gethtml(`${id} option:selected`);
            } else {
                return this.get(`${id} option:selected`);
            }
        },
        settext: function (id, value, append) {
            if (this.idExist(id) === true) {
                if (append === true) {
                    $(`#${id}`).append(value);
                } else {
                    $(`#${id}`).text(value);
                }
            }
        },
        gettext: function (id) {
            if (this.idExist(id) === true) {
                return $(`#${id}`).text();
            } else {
                return "";
            }
        },
        get_selected_radio: function (name) {
            return $(`input[name='${name}']:checked`).val();
        },
        mergeObject: function (obja, objb) {
            try {
                $.each(objb, function (index, obj) {
                    obja[index] = obj;
                });
                return obja;
            } catch (err) {
                $app.debug(err.message, true);
            }
        },

        show: function (id, isClass) {
            isClass = this.safeVar(isClass, false);
            let obj = (isClass === true) ? "." + id : `#${id}`;
            $(obj).removeClass('hidden');
        },
        showList: function (idList) {
            let that = this;
            if (this.isArray(idList) === true) {
                $.each(idList, function (index, elmid) {
                    that.show(elmid);
                });
            }
        },
        hide: function (id, isClass) {
            isClass = this.safeVar(isClass, false);
            let obj = (isClass === true) ? "." + id : `#${id}`;
            if (this.idExist(id, isClass)) {
                $(obj).addClass('hidden');
            }
        },
        hideList: function (idList) {
            let that = this;
            if (this.isArray(idList) === true) {
                $.each(idList, function (index, elmid) {
                    that.hide(elmid);
                });
            }
        },
        showModal: function (id) {
            if (this.idExist(id) === true) {
                $('#' + id).modal({backdrop: 'static', keyboard: false, show: true});
            }
        },
        hideModal: function (id) {
            if (this.idExist(id) === true) {
                $('#' + id).modal('hide');
            }
        },
        disableCheckBox: function (checkBoxList, disable, withAction) {
            let that = this;
            let action = (this.safeVar(disable, true) === true) ? false : true;
            withAction = (this.safeVar(withAction, false) === true) ? true : false;
            if (this.isArray(checkBoxList) === true) {
                $.each(checkBoxList, function (index, checkBoxid) {
                    if (that.idExist(checkBoxid) === true) {
                        if (withAction === true) {
                            if (($("#" + checkBoxid).prop("checked") === true && disable === true) || ($("#" + checkBoxid).prop("checked") === false && disable === false)) {
                                $("#" + checkBoxid).click();
                            }
                        } else {
                            $("#" + checkBoxid).prop('checked', action);
                        }
                    }
                });
            }
        },
        disableBtn: function (btnList, disable) {
            let that = this;
            let action = (this.safeVar(disable, true) === true) ? true : false;
            if (this.isArray(btnList) === true) {
                $.each(btnList, function (index, btnid) {
                    if (that.idExist(btnid) === true) {
                        $("#" + btnid).attr('readonly', action);
                    }
                });
            }
        },
        addClass: function (idList, className, addClass) {
            let that = this;
            addClass = (this.safeVar(addClass, true) === true) ? true : false;
            className = this.safeVar(className, "");
            if (this.isArray(idList) === true) {
                $.each(idList, function (index, objid) {
                    if (that.idExist(objid) === true) {
                        if (addClass === true) {
                            $("#" + objid).addClass(className);
                        } else {
                            $("#" + objid).removeClass(className);
                        }
                    }
                });
            }
        },
        addMultiClass: function (idList, classList, addClass) {
            let that = this;
            addClass = (this.safeVar(addClass, true) === true) ? true : false;
            if (this.isArray(idList) === true && this.isArray(classList) === true) {
                $.each(classList, function (index, classObj) {
                    that.addClass(idList, classObj, addClass);
                });
            }
        },
        isJson: function (jsonString) {
            try {
                return (/^[\],:{}\s]*$/.test(jsonString.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) ? true : false;
            } catch (err) {
                console.error(err.message);
                return false;
            }
        },
        message: function (response) {
            this.toast(this.safeVar(response.data, "Unable to process your request right now"), (response.status === "true") ? "success" : "error");
        },
        toast: function (message, type) {
            type = this.safeVar(type, 'info');
            message = this.safeVar(message, "");
            if (message === "remove") {
                this.sethtml("notice", "");
            } else if (message !== "") {
                switch (type) {
                    case 'info':
                        this.showMessage(message, 'Notification', 'info');
                        break;
                    case 'error':
                        this.showMessage(message, 'Error', 'danger');
                        break;
                    case 'success':
                        this.showMessage(message, 'Success', 'success');
                        break;
                    case 'warning':
                        this.showMessage(message, 'Warning', 'warning');
                        break;
                }
            }
        },
        showMessage: function (message, title, object) {
            let msgid = this.randomString(8);
            let html = '<div id="' + msgid + '" class="alert alert-' + object + '"><strong>' + title + '!</strong> <span>' + message + '</span></div>';
            this.sethtml("notice", html);
            $("#" + msgid).fadeTo(4500, 500).slideUp(500, function () {
                $("#" + msgid).slideUp(500);
            });
        },
        confirm: function (callback, message, btnLabel, action) {
            callback = (this.isUndefined(callback) === true) ? false : callback;
            message = this.safeVar(message, "Are you sure?");
            btnLabel = this.safeVar(btnLabel, "Yes");
            action = this.safeVar(action, "delete");
            btnLabelClass = (action === "delete") ? "btn-danger" : "btn-success";
            $app.sethtml("confirm_msg", message);
            $app.addClass(["confirm_yes"], "btn-danger", false);
            $app.addClass(["confirm_yes"], "btn-success", false);
            $app.addClass(["confirm_yes"], btnLabelClass);
            this.sethtml("confirm_yes", btnLabel);
            $('#confirm').unbind();
            $('#confirm').modal({
                backdrop: 'static',
                keyboard: false
            }).on('click', '#confirm_yes', function (e) {
                e.preventDefault();
                if (callback !== false) {
                    callback();
                }
            });
        },
        prompt: function (callback, message, btnLabel) {
            callback = (this.isUndefined(callback) === true) ? false : callback;
            message = this.safeVar(message, "Enter your text?");
            btnLabel = this.safeVar(btnLabel, "Submit");
            this.sethtml("prompt_msg", message);
            this.set("prompt_field", "");
            this.set_attr("prompt_field", "placeholder", message);
            this.sethtml("prompt_submit", btnLabel);
            let that = this;
            $('#prompt').unbind();
            $('#prompt').modal({
                backdrop: 'static',
                keyboard: false
            }).on('click', '#prompt_submit', function (e) {
                e.preventDefault();
                if (callback !== false) {
                    callback(that.get("prompt_field"));
                }
            });
        },
        sortArray: function (arraylist) {
            if (this.isArray(arraylist) === true) {
                arraylist.sort();
            }
            return arraylist;
        },
        sortArrayOfObject: function (arrayList, sortOnKey) {
            if (this.isArray(arrayList) === true) {
                arrayList.sort(function (a, b) {
                    let xvalue = ($app.isObject(a) === true) ? $app.safeVar(a[sortOnKey], "") : a;
                    let yvalue = ($app.isObject(b) === true) ? $app.safeVar(b[sortOnKey], "") : b;
                    var x = xvalue.toLowerCase(), y = yvalue.toLowerCase();
                    return x < y ? -1 : x > y ? 1 : 0;
                });
            }
            return arrayList;
        },
        numberFormat: function (count, insert, id) {
            let number = count.toLocaleString('en-IN');
            if (insert === true) {
                this.sethtml(id, number);
            } else {
                return number;
            }
        },
        percentage: function (num1, num2, type) {
            let percent = 0;
            if (type === 'increase') {
                percent = (num2 === 0) ? 0 : ((num1 - num2 / num2) * 100);
            } else if (type === 'decreased') {
                percent = (num1 === 0) ? 0 : ((num1 - num2 / num1) * 100);
            } else {
                percent = (num1 === 0) ? 0 : ((num2 / num1) * 100);
            }
            this.debug("Percentage: num1" + num1 + " :: num2" + num2 + " :: Type : " + type + " -> Percentage calculated" + percent);
            return percent.toFixed(2);
        },
        percentageValue: function (num1, percentage) {
            return (num1 === 0 || percentage === 0) ? 0 : ((percentage / 100) * num1);
        },
        setLoadingField: function () {
            if ($app.getSession("looadingstart") !== 'start') {
                return true;
            } else if ($app.getSession("looadingstart") !== 'running') {
                $app.setSession("looadingstart", 'start');
                return false;
            }
        },
        set_list_clear: function (list, removeAll) {
            if ($app.isArray(list) === true) {
                $.each(list, function (key, id) {
                    if ($app.idExist(id) === true) {
                        if (removeAll === true) {
                            $app.sethtml(id, "");
                        } else {
                            $(`#${id} a:not(:first-child)`).remove();
                            $app.set("crtcamp_pb", $app.get("crtcamp_pb option:first"));
                            if ($app.idExist(`btn_${id}`)) {
                                $app.sethtml(`btn_${id}`, $(`#${id} a:first-child`).text());
                            }
                        }
                    }
                });
            } else {
                if ($app.idExist(list) === true) {
                    if (removeAll === true) {
                        $app.sethtml(list, "");
                    } else {
                        $(`#${list} a:not(:first-child)`).remove();
                        $app.set("crtcamp_pb", $app.get("crtcamp_pb option:first"));
                        if ($app.idExist(`btn_${list}`)) {
                            $app.sethtml(`btn_${list}`, $(`#${list} a:first-child`).text());
                        }
                    }
                }
            }
        },
        chart_loading: function (list) {
            if ($app.isArray(list) === true) {
                $.each(list, function (key, id) {
                    ($app.idExist(id) === true) ? $app.graph.empty_chart(id, 'bar', false, true) : false;
                });
            } else {
                ($app.idExist(list) === true) ? $app.graph.empty_chart(list, 'bar', false, true) : false;
            }
        },
        pie_chart_loading: function (list) {
            if ($app.isArray(list) === true) {
                $.each(list, function (key, id) {
                    ($app.idExist(id) === true) ? $app.graph.empty_chart(id, 'pie', false, true) : false;
                });
            } else {
                ($app.idExist(id) === true) ? $app.graph.empty_chart(list, 'pie', false, true) : false;
            }
        },
        loading_now: function (list, symbol) {
            symbol = this.safeVar(symbol, "");
            if ($app.isArray(list) === true) {
                $.each(list, function (key, id) {
                    ($app.idExist(id) === true) ? $app.sethtml(id, symbol) : false;
                });
            }
        },
        loading_count: function (list) {
            this.loading_now(list, "---");
        },
        empty_chart: function (id) {
            $app.graph.empty_chart(id, 'bar', true);
        },
        slug: function (text, target, type) {
            let filter = this.get_slug_filter(type);
            try {
                text = text.toLowerCase().replace(/\s+/g, "-").replace(filter, "");
                if (this.idExist(target)) {
                    this.set(target, text);
                }
            } catch (err) {
                $app.debug(err.message);
            }
        },
        get_slug_filter: function (type) {
            switch (type) {
                case 'key':
                    return /(^\s+|[^a-zA-Z0-9 -]+|\s+$)/g;
                    break;
                case 'tags':
                    return /(^\s+|[^a-zA-Z0-9, -]+|\s+$)/g;
                    break;
                default:
                    return /(^\s+|[^a-zA-Z0-9 -]+|\s+$)/g;
            }
        },
        formData: function (id, extradata) {
            if (this.idExist(id) === true) {
                let myForm = document.getElementById(id);
                let formdata = new FormData(myForm);
                extradata = this.safeVar(extradata, {});
                if (this.isObject(extradata) === true && this.getLength(extradata, true) > 0) {
                    $.each(extradata, function (name, value) {
                        formdata.append(name, value);
                    });
                }
                return formdata;
            }
            return false;
        },
        setFormData: function (id, data, setdefaultkey) {
            let that = this;
            setdefaultkey = this.safeVar(setdefaultkey, []);
            if (this.idExist(id) === true) {
                this.clearForm(id);
                data = this.safeVar(data, {});
                if (this.isObject(data) === true && this.getLength(data, true) > 0) {
                    $.each(data, function (name, value) {
                        let eid = `${id} [name="${name}"]`;
                        if (id === "usrl_updateform" && name === "apps") {
                            eid = `${id} [name="${name}[]"]`;
                        }
                        (that.inArray(name, setdefaultkey) === true) ? that.setdata(eid, "default", value) : that.set(eid, value);
                        switch (name) {
                            case "subcategory":
                                let categoryid = $(`#${id} [name="category"]`).attr("id");
                                let subcatid = $(`#${eid}`).attr("id");
                                let category = that.safeVar(data['category']);
                                $app.script.setSubcategory(category, categoryid, subcatid);
                                break;
                            case "platform":
                                that.set("_apt", value);
                                break;
                        }
                    });
                }
            }
        },
        regex: function (test, value) {
            let result = false;
            switch (test) {
                case 'domain':
                    result = /(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/.test(value);
                    break;
                case 'url' :
                    result = /((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i.test(value);
                    break;
                case 'email' :
                    result = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
                    break;
            }
            return result;
        },
        getFormChildId: function (obj, elementName, byclass) {
            if (byclass === true) {
                return $(obj).closest("form").find(`.${elementName}`).attr("id");
            } else {
                return $(obj).closest("form").find(`[name="${elementName}"]`).attr("id");
            }
        },
        getClosestId: function (id, isClass) {
            let obj_id = (isClass === true) ? `.${id}` : `#${id}`;
            return $(obj_id).closest(".pane").attr("id");
        },
        clearForm: function (id) {
            if (this.idExist(id) === true) {
                $("form#" + id).trigger("reset");
                $("form#" + id + ' input[type="file"]').each(function (index) {
                    let placeholder = $(this).attr('placeholder');
                    placeholder = (placeholder === "") ? "Choose file .." : placeholder;
                    $(this).parent().find('span').text(placeholder);
                });
                $("form#" + id + ' select').each(function (index) {
                    $(this).removeData("default");
                });
            }
        },
        inputBlank: function (id, ishtml) {
            ishtml = ($app.safeVar(ishtml, false) === true) ? true : false;
            if (this.idExist(id)) {
                if (ishtml === true) {
                    $(`#${id}`).html("");
                } else {
                    $(`#${id}`).val("");
                }
            }
        },
        sub_string: function (text, length) {
            length = this.safeVar(length, 50);
            return text.length > length ? text.substr(0, text.lastIndexOf(' ', length)) + '...' : text;
        },
        wait: function (disable) {
            if (disable !== true) {
                $("#waiting").removeClass("hidden");
                $("#overlay").removeClass("hidden");
            } else {
                if ($app.pool.length <= 0) {
                    $("#waiting").addClass("hidden");
                    $("#overlay").addClass("hidden");
                }
            }
        },
        get_yt_video_id: function (url) {
            var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
            var match = url.match(regExp);
            return (match && match[7].length == 11) ? match[7] : url;
        },
        clipboard: function (id, value) {
            let text = (id && this.idExist(id)) ? this.gettext(id) : value;
            var input = document.createElement("input");
            document.body.appendChild(input);
            input.setAttribute("id", "_inpid");
            document.getElementById("_inpid").value = text;
            input.select();
            document.execCommand("copy");
            document.body.removeChild(input);
            this.toast("Text Copied to Clipboard", "success");
        },
        selectTextById: function (id) {
            if (this.idExist(id) === true) {
                let sel, range;
                let el = document.getElementById(id); //get element id
                if (window.getSelection && document.createRange) { //Browser compatibility
                    sel = window.getSelection();
                    if (sel.toString() === '') { //no text selection
                        window.setTimeout(function () {
                            range = document.createRange(); //range object
                            range.selectNodeContents(el); //sets Range
                            sel.removeAllRanges(); //remove all ranges from selection
                            sel.addRange(range);//add Range to a Selection.
                        }, 1);
                    }
                } else if (document.selection) { //older ie
                    sel = document.selection.createRange();
                    if (sel.text === '') { //no text selection
                        range = document.body.createTextRange();//Creates TextRange object
                        range.moveToElementText(el);//sets Range
                        range.select(); //make selection.
                    }
                }
                document.execCommand('copy');
            }
        },
        select2: function (selector, isclass, enableTag, maximum, cointer_id) {
            let that = this;
            enableTag = this.safeVar(enableTag, false);
            maximum = this.safeVar(maximum, 50);
            $selector2 = $(this.safeVar(((isclass === true) ? `.${selector}` : `#${selector}`), ".select2"));
            if (this.idExist(selector, isclass) === true) {
                let options = {
                    minimumResultsForSearch: -1,
                    containerCssClass: "scontain",
                    dropdownCssClass: "sdropdown"
                };
                if (enableTag === true) {
                    options["tags"] = true;
                    options["maximumSelectionLength"] = maximum;
                    options["tokenSeparators"] = [','];
                    options["containerCssClass"] = "edtag";
                    options["dropdownCssClass"] = "hidden";
                    options["createTag"] = function (params) {
                        let tag_count = that.set_tag_counter($selector2, cointer_id, maximum);
                        if (tag_count >= maximum) {
                            return null;
                        } else {
                            let term = $.trim(params.term);
                            return (term === '' || term === ',') ? null : {id: term, text: term, newTag: true};
                        }
                    };
                    that.set_tag_counter($selector2, cointer_id, maximum);
                }
                $selector2.select2(options);
            }
        },
        set_tag_counter: function ($selector2, cointer_id, maximum) {
            let tag_count = $selector2.map(function () {
                return $(this).val();
            }).get().length;
            this.sethtml(cointer_id, `${(tag_count > maximum) ? maximum : tag_count} / ${maximum}`);
            return tag_count;
        },
        discollapse: function (list_id, enable) {
            enable = (this.safeVar(enable, false) === true) ? true : false;
            if (this.idExist(list_id)) {
                this.addClass([list_id], "hidden", !enable);
                //this.addClass([list_id], "active", enable);
                let target = this.getdata(list_id, "target");
                //$(target).collapse((enable) ? 'show' : 'hide');
                let stab = this.getClosestId(list_id);
                if (enable) {
                    $(`#${stab} .collapsed`).removeClass("active");
                } else {
                    let previous = $(`#${list_id}`).prev().attr("id");
                    if (this.idExist(previous)) {
                        $(`#${previous}`).removeClass("collapsed");
                        this.addClass([previous], "active");
                        target = this.getdata(previous, "target");
                        $(target).collapse('show');
                        $(target).addClass("show");
                        this.select2("select2", true);
                    }
                }
            }
        },
        validate: function (id, type, title, validations, values, callback, isClass) {
            let that = this;
            callback = (this.isUndefined(callback) === true) ? false : callback;
            let isExist = (isClass === true) ? this.idExist(id, true) : this.idExist(id);
            if (isExist === true) {
                validations = this.safeVar(validations, []);
                values = this.safeVar(values, []);
                if (this.isArray(validations) === true) {
                    let message = true;
                    if (this.inArray(type, ["text", "select"])) {
                        let thisData = this.get(id);
                        $.each(validations, function (index, validation) {
                            switch (validation) {
                                case 'blank':
                                    if (thisData === "") {
                                        that.toast(title + " should not be blank", "error");
                                        message = false;
                                        return false;
                                    }
                                    break;
                                case 'length':
                                    let dataLength = that.getLength(thisData);
                                    let validLength = that.safeVar(values[validation], 1);
                                    if (dataLength < validLength) {
                                        that.toast(title + " should be " + validLength + " character long.", "error");
                                        message = false;
                                        return false;
                                    }
                                    break;
                                case 'maxlength':
                                    let thisLength = that.getLength(thisData);
                                    let maxLength = that.safeVar(values[validation], 1);
                                    if (thisLength > maxLength) {
                                        that.toast(`Maximum ${maxLength} ${title} are allowed.`, "error");
                                        message = false;
                                        return false;
                                    }
                                    break;
                                case 'selected':
                                    if (thisData === "" || thisData === null) {
                                        that.toast("Please select " + title + ".", "error");
                                        message = false;
                                        return false;
                                    }
                                    break;
                                case 'maximum':
                                    let maxValue = that.safeVar(values[validation], 0);
                                    if (thisData > maxValue) {
                                        that.toast(title + " should be less than" + maxValue + ".", "error");
                                        message = false;
                                        return false;
                                    }
                                    break;
                                case 'domain':
                                    if (that.regex("domain", thisData) === false) {
                                        that.toast("Please provide valid " + title + ".", "error");
                                        message = false;
                                        return false;
                                    }
                                    break;
                                case 'url':
                                    if (that.regex("url", thisData) === false) {
                                        that.toast("Please provide valid " + title + ".", "error");
                                        message = false;
                                        return false;
                                    }
                                    break;
                                case 'email':
                                    if (that.regex("email", thisData) === false) {
                                        that.toast("Please provide valid " + title + ".", "error");
                                        message = false;
                                        return false;
                                    }
                                    break;
                                case 'unique':
                                    let isUnique = true;
                                    let idList = [];
                                    if (isClass === true && type === "select") {
                                        $("." + id).each(function () {
                                            let value = $app.safeVar($(this).val(), "");
                                            if (value !== "") {
                                                if ($app.inArray(value, idList)) {
                                                    isUnique = false;
                                                    return false;
                                                } else {
                                                    idList.push(value);
                                                }
                                            }
                                        });
                                    }
                                    if (isUnique === false) {
                                        that.toast("Selected all " + title + " should be unique.", "error");
                                        message = false;
                                        return false;
                                    }
                                    break;
                            }
                        });
                    } else if (this.inArray(type, ["image"])) {
                        let file = document.getElementById(id);
                        file = file.files.item(0);
                        let fileName = $app.safeVar(file.name, 'No File Selected');
                        let extension = $app.lowercase(fileName.replace(/^.*\./, ''));
                        if ($app.inArray(extension, ["png", "jpg", "jpeg"]) === true) {
                            let fileType = file.type;
                            let fileSize = file.size;
                            fileSize = Math.round((fileSize / 1024));
                            let reader = new FileReader();
                            reader.onload = function (r) {
                                let img = new Image();
                                img.src = r.target.result;
                                img.onload = function () {
                                    let width = this.width;
                                    let height = this.height;
                                    $.each(validations, function (index, validation) {
                                        switch (validation) {
                                            case 'minwidth':
                                                let validMinWidth = that.safeVar(values[validation], 100);
                                                if (width < validMinWidth) {
                                                    that.toast(title + " width should be more than " + validMinWidth + " Pixel", "error");
                                                    return message = false;
                                                }
                                                break;
                                            case 'minheight':
                                                let validMinHeight = that.safeVar(values[validation], 100);
                                                if (height < validMinHeight) {
                                                    that.toast(title + " height should be more than " + validMinHeight + " Pixel", "error");
                                                    return message = false;
                                                }
                                                break;
                                            case 'maxwidth':
                                                let validMaxWidth = that.safeVar(values[validation], 500);
                                                if (width > validMaxWidth) {
                                                    that.toast(title + " width should be less than " + validMaxWidth + " Pixel", "error");
                                                    return message = false;
                                                }
                                                break;
                                            case 'maxheight':
                                                let validMaxHeight = that.safeVar(values[validation], 500);
                                                if (height > validMaxHeight) {
                                                    that.toast(title + " width should be less than " + validMaxHeight + " Pixel", "error");
                                                    return message = false;
                                                }
                                                break;
                                            case 'maxsize':
                                                let validMaxSize = that.safeVar(values[validation], 1);
                                                if (fileSize > validMaxSize) {
                                                    that.toast(title + " size should be less than " + validMaxSize + "KB", "error");
                                                    return message = false;
                                                }
                                                break;
                                        }
                                    });
                                    if (callback !== false) {
                                        callback(message);
                                    }
                                };
                            };
                            reader.readAsDataURL(file);
                        } else {
                            $app.toast("Select valid image for " + title + ". Example: PNG, JPG, JPEG, ", "warning");
                        }
                    }
                    return message;
                }
            }
            $app.error("it seens to be a invalid request. Please try again lator.", true);
            return false;
        }
    });
});