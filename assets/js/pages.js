/* global moment, $app */

$(document).ready(function () {
    JSPageScript = function JSPageScript($app) {};
    /* JS On page Script started */
    $.extend(JSPageScript.prototype, {
        init: function () {
            this.page = $app.getdata("app", "page");
            this.draw_page();
        },
        draw_page: function () {
            let drawer = $app.page_drawer();
            if ($app.classExist("_drawer") === true && $app.isset(drawer, this.page)) {
                $app.abortAllHttp();
                $app.setSession("looadingstart", 'end');
                let method = $app.safeVar(drawer[this.page], false);
                if (method && (typeof this[method] === 'function')) {
                    try {
                        this[method].call(this);
                    } catch (err) {
                        console.log(err.message);
                    }
                } else {
                    console.log(`${method} method not avilable`);
                }
            } else {
                $app.error("Drawer not found");
            }
        },
        /* Start Role Access Page */
        page_roleaccess: function () {
            let that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'roleaccess':
                        that.roleaccess_section();
                        break;
                }
            });
        },
        roleaccess_setup: function (formid) {
            let that = this;
            let formdata = $app.formData(formid);
            if (formdata !== false) {
                $app.toast("Please wait.. Request in prograss", "info");
                var options = {url: $app.base_url('api/roleaccess'), type: "POST", data: formdata, processData: false, contentType: false};
                $app.callHttp(options, function (response) {
                    $app.message(response);
                    if (response.status === "true") {
                        that.roleaccess_recache(formid, function () {
                            $app.redirect(`admin/userrole`);
                        });
                    }
                });
            }
        },
        roleaccess_recache: function (formid, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            let roleaccess_keys = [`roleaccess_list_${$app.get('roleaccess_rid')}`];
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            $app.clear_cache_keys("roleaccess", roleaccess_keys);
            if (callback !== false) {
                callback();
            }
        },
        roleaccess_section: function () {
            let role_id = $app.get("roleaccess_rid");
            let options = {url: $app.base_url(`api/roleaccess/${role_id}`), cachekey: `roleaccess_list_${role_id}`, checkdefault: true};
            $app.set_list_clear('accesstable', true);
            $app.callHttp(options, function (response) {
                $app.html.create_role_access_section("roleaccess", response, "roleaccess");
            });
        },
        /* Start Access Group Page */
        page_access: function () {
            let that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'accesstable':
                        that.access_table();
                        break;
                }
            });
        },
        access_setup: function (formid, update) {
            let that = this;
            this.access_validate(function (valid) {
                if (valid === true) {
                    let extra = (update === true) ? {id: $app.getSession("edit_access_id"), update: true} : {};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast("Please wait.. Request in prograss", "info");
                        var options = {url: $app.base_url('api/access'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            $app.message(response);
                            if (response.status === "true") {
                                that.access_recache(formid, update, function () {
                                    $app.hideModal('popup_access');
                                    that.draw_page();
                                });
                            }
                        });
                    }
                }
            });
        },
        access_edit: function (obj) {
            let access_id = $(obj).data("id");
            let options = {url: $app.base_url(`api/access/0/${access_id}`), checkdefault: true};
            $app.callHttp(options, function (response) {
                let access = $app.safeVar(response.data["access"].list, []);
                if ($app.isObject(access) && $app.getLength(access) > 0) {
                    $app.clearForm("access_addform");
                    $app.set("access_name", $app.safeVar(access.name, ""));
                    $app.set("access_slug", $app.safeVar(access.keyname, ""));
                    $app.set("access_desc", $app.safeVar(access.summery, ""));
                    $app.setdata("access_slug", "changed", true);
                    $app.setSession("edit_access_id", access_id);
                    $app.setdata("access_add", "update", true);
                    $app.settext("access_add", "Update");
                    $app.script.access_groups($app.safeVar(access.gid, 0), function (response, selectid) {
                        $app.showModal("popup_access");
                        $app.select2(selectid);
                    });
                } else {
                    $app.toast("Not allowed to edit this", "error");
                }
            });
        },
        access_delete: function (obj) {
            let that = this;
            $app.confirm(function () {
                let id = $(obj).data("id");
                $app.toast("Please wait.. Request in prograss", "info");
                let options = {url: $app.base_url('api/access'), type: "DELETE", data: {id: id}, checkdefault: true};
                $app.callHttp(options, function (response) {
                    $app.message(response);
                    switch (response.status) {
                        case "true" :
                            that.access_recache("", false, function () {
                                that.draw_page();
                            });
                            break;
                        case "false" :
                            $app.toast("Unable to process your request", "error");
                            break;
                        default:
                            $app.toast("Unable to handle your request this time. Please try again later", "error");
                    }
                });
            }, "Are you sure?", "Delete");
        },
        access_validate: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("access_name", "text", "Access Name", ["blank", "length", "maxlength"], {length: 8, maxlength: 32}) : false;
            valid = (valid === true) ? $app.validate("access_slug", "text", "Access Key", ["blank", "length", "maxlength"], {length: 8, maxlength: 32}) : false;
            valid = (valid === true) ? $app.validate("access_group", "select", "Access Group", ["selected"], {}) : false;
            valid = (valid === true) ? $app.validate("access_desc", "text", "Access Purpose", ["blank", "length", "maxlength"], {length: 10, maxlength: 252}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        access_groups(group_id, callback) {
            group_id = $app.safeVar(group_id, 0);
            let options = {url: $app.base_url('api/accessgroup/0/0'), cachekey: 'accessgroups_list'};
            $app.callHttp(options, function (response) {
                $app.setSelectList(response, "access_group", "agroup", "name", "id", true, group_id);
                if (callback !== false) {
                    callback(response, "access_group");
                }
            });
        },
        access_recache(formid, update, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            $app.clear_cache_keys("access");
            if (callback !== false) {
                callback();
            }
        },
        access_table: function (offset) {
            let limit = $app.getConfig("table_max_row");
            offset = $app.safeVar(offset, 0);
            let options = {url: $app.base_url(`api/access/${offset}`), cachekey: 'access_list', checkdefault: true};
            $app.set_list_clear('accesstable', true);
            $app.callHttp(options, function (response) {
                let header = ["Name", "Key", "Group", "Description", "Actions"];
                let key = ["name", "keyname", "gname", "summery", "action"];
                let actions = ["edit", "delete"];
                $app.html.createHtmlTable("accesstable", response, "access", header, key, actions);
            });
        },
        /* Start Access Group Page */
        page_accessgroup: function () {
            let that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'agrouptable':
                        that.accessgroup_table();
                        break;
                }
            });
        },
        accessgroup_setup: function (formid, update) {
            let that = this;
            this.accessgroup_validate(function (valid) {
                if (valid === true) {
                    let extra = (update === true) ? {id: $app.getSession("edit_accessgroup_id"), update: true} : {};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast("Please wait.. Request in prograss", "info");
                        var options = {url: $app.base_url('api/accessgroup'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            $app.message(response);
                            if (response.status === "true") {
                                that.accessgroup_recache(formid, update, function () {
                                    $app.hideModal('popup_agroup');
                                    that.draw_page();
                                });
                            }
                        });
                    }
                }
            });
        },
        accessgroup_edit: function (obj) {
            let agroup_id = $(obj).data("id");
            let options = {url: $app.base_url(`api/accessgroup/0/${agroup_id}`), checkdefault: true};
            $app.callHttp(options, function (response) {
                let agroup = $app.safeVar(response.data["agroup"].list, []);
                if ($app.isObject(agroup) && $app.getLength(agroup) > 0) {
                    $app.clearForm("agroup_addform");
                    $app.set("agroup_name", $app.safeVar(agroup.name, ""));
                    $app.set("agroup_slug", $app.safeVar(agroup.keyname, ""));
                    $app.set("agroup_desc", $app.safeVar(agroup.summery, ""));
                    $app.setSession("edit_accessgroup_id", agroup_id);
                    $app.setdata("agroup_slug", "changed", true);
                    $app.setdata("agroup_add", "update", true);
                    $app.settext("agroup_add", "Update");
                    $app.showModal("popup_agroup");
                } else {
                    $app.toast("Not allowed to edit this", "error");
                }
            });
        },
        accessgroup_delete: function (obj) {
            let that = this;
            $app.confirm(function () {
                let id = $(obj).data("id");
                $app.toast("Please wait.. Request in prograss", "info");
                let options = {url: $app.base_url('api/accessgroup'), type: "DELETE", data: {id: id}, checkdefault: true};
                $app.callHttp(options, function (response) {
                    $app.message(response);
                    switch (response.status) {
                        case "true" :
                            that.accessgroup_recache("", false, function () {
                                that.draw_page();
                            });
                            break;
                        case "false" :
                            $app.toast("Unable to process your request", "error");
                            break;
                        default:
                            $app.toast("Unable to handle your request this time. Please try again later", "error");
                    }
                });
            }, "Are you sure?", "Delete");
        },
        accessgroup_validate: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("agroup_name", "text", "Group Name", ["blank", "length"], {length: 3}) : false;
            valid = (valid === true) ? $app.validate("agroup_slug", "text", "Group Key", ["blank", "length"], {length: 3}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        accessgroup_recache(formid, update, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            $app.clear_cache_keys("accessgroup");
            if (callback !== false) {
                callback();
            }
        },
        accessgroup_table: function (offset) {
            let limit = $app.getConfig("table_max_row");
            offset = $app.safeVar(offset, 0);
            let options = {url: $app.base_url(`api/accessgroup/${offset}`), cachekey: 'accessgroups_list', checkdefault: true};
            $app.set_list_clear('agrouptable', true);
            $app.callHttp(options, function (response) {
                let header = ["Group", "Group Key", "Description", "Actions"];
                let key = ["name", "keyname", "summery", "action"];
                let actions = ["edit", "delete"];
                $app.html.createHtmlTable("agrouptable", response, "agroup", header, key, actions);
            });
        },
        /* Start User Role Page */
        page_userroles: function () {
            let that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'uroletable':
                        that.userrole_table();
                        break;
                }
            });
        },
        userrole_setup: function (formid, update) {
            let that = this;
            this.userrole_validate(function (valid) {
                if (valid === true) {
                    let extra = (update === true) ? {id: $app.getSession("edit_userrole_id"), update: true} : {};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast("Please wait.. Request in prograss", "info");
                        var options = {url: $app.base_url('api/userrole'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            $app.message(response);
                            if (response.status === "true") {
                                that.userrole_recache(formid, update, function () {
                                    $app.hideModal('popup_urole');
                                    that.draw_page();
                                });
                            }
                        });
                    }
                }
            });
        },
        userrole_edit: function (obj) {
            let urole_id = $(obj).data("id");
            let options = {url: $app.base_url(`api/userrole/0/${urole_id}`), checkdefault: true};
            $app.callHttp(options, function (response) {
                let userrole = $app.safeVar(response.data["userrole"].list, []);
                if ($app.isObject(userrole) && $app.getLength(userrole) > 0) {
                    $app.clearForm("urole_addform");
                    $app.set("urole_name", $app.safeVar(userrole.role, ""));
                    $app.set("urole_slug", $app.safeVar(userrole.rolekey, ""));
                    $app.setdata("urole_slug", "changed", true);
                    $app.set("urole_desc", $app.safeVar(userrole.summery, ""));
                    $app.setSession("edit_userrole_id", urole_id);
                    $app.setdata("urole_add", "update", true);
                    $app.settext("urole_add", "Update");
                    $app.showModal("popup_urole");
                } else {
                    $app.toast("Not allowed to edit this", "error");
                }
            });
        },
        userrole_delete: function (obj) {
            let that = this;
            $app.confirm(function () {
                let id = $(obj).data("id");
                $app.toast("Please wait.. Request in prograss", "info");
                let options = {url: $app.base_url('api/userrole'), type: "DELETE", data: {id: id}, checkdefault: true};
                $app.callHttp(options, function (response) {
                    $app.message(response);
                    switch (response.status) {
                        case "true" :
                            that.userrole_recache("", false, function () {
                                that.draw_page();
                            });
                            break;
                        case "false" :
                            $app.toast("Unable to process your request", "error");
                            break;
                        default:
                            $app.toast("Unable to handle your request this time. Please try again later", "error");
                    }
                });
            }, "Are you sure?", "Delete");
        },
        userrole_access: function (obj) {
            $app.redirect(`admin/roleaccess/${$(obj).data("id")}`);
        },
        userrole_validate: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("urole_name", "text", "Userrole Name", ["blank", "length"], {length: 3}) : false;
            valid = (valid === true) ? $app.validate("urole_slug", "text", "Userrole Key", ["blank", "length"], {length: 3}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        userrole_recache(formid, update, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            let keys = [];
            if (update) {
                keys.push(`roleaccess_list_${$app.getSession("edit_userrole_id")}`);
            }
            $app.clear_cache_keys("userrole", keys);
            if (callback !== false) {
                callback();
            }
        },
        userrole_table: function (offset) {
            let limit = $app.getConfig("table_max_row");
            offset = $app.safeVar(offset, 0);
            let options = {url: $app.base_url(`api/userrole/${offset}`), cachekey: 'userroles_list', checkdefault: true};
            $app.set_list_clear(['uroletable'], true);
            $app.callHttp(options, function (response) {
                let header = ["Role", "Key", "Description", "Actions"];
                let key = ["role", "rolekey", "summery", "action"];
                let actions = ["access", "edit", "delete"];
                $app.html.createHtmlTable("uroletable", response, "userrole", header, key, actions);
            });
        },
        /* Start Video Page */
        video_search: function (obj) {
            let that = this;
            let container = "vdo_list";
            let search_session = $app.getSession("video_search");
            clearTimeout(search_session);
            search_session = setTimeout(function () {
                let search_term = $(obj).val();
                if ($app.getLength(search_term) > 3) {
                    that.video_search_list(container, search_term);
                } else {
                    $app.show(container);
                    $app.sethtml(container, that.video_search_help("Type atleast 3 character for search.."));
                }
            }, 800);
            $app.setSession("video_search", search_session);
        },
        video_search_list: function (container, search) {
            let that = this;
            let platform = $app.get_selected_radio("platform");
            $app.show(container);
            $app.sethtml(container, this.video_search_help("Searching..."));
            this.video_platform_videos(platform, search, function (video_list) {
                if ($app.isArray(video_list) && $app.getLength(video_list) > 0) {
                    $app.sethtml(container, '');
                    video_list.forEach(function (video) {
                        $app.sethtml(container, that.video_list_card(video.id, $app.sub_string(video.title, 60), $app.sub_string(video.snippet, 120), video.thumbnail), true);
                    });
                } else {
                    $app.sethtml(container, that.video_search_help("No Video Available..."));
                }
            });
        },
        video_platform_videos: function (platform, search, callback) {
            switch (platform) {
                case 'yt':
                    search = $app.get_yt_video_id(search);
                    this.video_platform_youtube(platform, search, callback);
                    break;
            }
        },
        video_list_card: function (id, title, snippet, thumbnail) {
            return `<li class="list-group-item list-group-item-action" data-vid="${id}">
                            <div class="media">
                                <img class="mr-3" src="${thumbnail}" alt="${title}">
                                <div class="media-body">
                                    <h2 class="mt-3 mb-2 h3">${title}</h2>
                                    <div class="h4">${snippet}</div>
                                </div>
                            </div>
                    </li>`;
        },
        video_search_help: function (title) {
            return `<li class="list-group-item">
                        <h3 class="mt-3 mb-2 h4">${title}</h3>
                    </li>`;
        },
        video_platform_youtube: function (platform, search, callback) {
            callback = $app.safeVar(callback, false);
            let options = {url: $app.base_url(`api/youtube/${search}`), cachekey: `videos-${platform}-${search}`, checkdefault: true};
            $app.callHttp(options, function (response) {
                let video_list = [];
                try {
                    let list = $app.safeVar(response.data.list, []);
                    if ($app.isArray(list)) {
                        list.forEach(function (video) {
                            if ($app.isset(video.id, "videoId")) {
                                let data = {
                                    id: video.id.videoId,
                                    title: video.snippet.title,
                                    channel: video.snippet.channelTitle,
                                    channelid: video.snippet.channelId,
                                    snippet: video.snippet.description,
                                    publish: video.snippet.publishTime,
                                    thumbnail: video.snippet.thumbnails.default.url
                                };
                                if ($app.isset(video.snippet.thumbnails, 'high')) {
                                    data["thumbnail"] = video.snippet.thumbnails.high.url;
                                }
                                video_list.push(data);
                            }
                        });
                    }
                } catch (err) {
                    $app.debug(err.message, true);
                }
                if (callback) {
                    callback(video_list);
                }
            });
        },
        /* Start Uploads Page */
        page_uploads: function () {
            let that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'uploads':
                        that.uploads_show();
                        break;
                }
            });
        },
        uploads_search: function () {
            let that = this;
            let block_id = (($app.getdata("coltabs .edtctab.active", "target")).replace("#", "")) + " .row";
            let search_session = $app.getSession("upload_search");
            clearTimeout(search_session);
            $app.sethtml(block_id, '<div class="nohover">Searching...</div>');
            search_session = setTimeout(function () {
                that.uploads_show();
            }, 500);
            $app.setSession("upload_search", search_session);
        },
        uploads_copylink: function (obj) {
            let link = $(obj).data("url");
            $app.clipboard(false, link);
            $(obj).addClass("success");
            $(obj).text("Copied");
            setTimeout(function () {
                $(obj).removeClass("success");
                $(obj).text("Copy");
            }, 800);
        },
        uploads_show: function () {
            let that = this;
            let type = $app.safeVar($app.getdata("coltabs .edtctab.active", "type"), "i");
            let block_id = ($app.getdata("coltabs .edtctab.active", "target")).replace("#", "");
            let onlyme = $app.safeVar($app.checked("coluser"), true);
            let onlyblog = $app.safeVar($app.checked("colblog"), true);
            let offset = $app.get_integer($app.get("offset"));
            let search = $app.safeVar($app.get("colsearch"), "");
            let customurl = `${type}/${onlyme}/${onlyblog}/${offset}/${search}`;
            let options = {url: $app.base_url(`api/uploads/${customurl}`), cachekey: `uploads-${customurl}`, checkdefault: true};
            $app.callHttp(options, function (response) {
                that.uploads_insert(response, block_id + " .row", type);
            });
        },
        uploads_insert: function (response, block_id, type) {
            try {
                let that = this;
                $app.sethtml(block_id, "");
                let list = $app.safeVar(response.data.list, []);
                if ($app.isArray(list)) {
                    list.forEach(function (element) {
                        if (type == "i") {
                            that.uploads_image_grid(block_id, element);
                        } else {
                            that.uploads_doc_grid(block_id, element);
                        }
                    });
                }
            } catch (err) {
                $app.debug(err.message, true);
            }
        },
        uploads_image_grid: function (block_id, element) {
            let grid = `
                <figure class="col col-md-1 imglv">
                    <img class="img-fluid imgvl" alt="${element.name}" src="${element.url}">
                    <div class="imgsize">${element.width}*${element.height}</div>
                    <div class="imgcplnk cplink pointer" data-url="${element.url}">Copy</div>
                </figure>
                `;
            $app.sethtml(block_id, grid, true);
        },
        uploads_doc_grid: function (block_id, element) {
            console.log(element);
            let grid = `
                <figure class="col col-md-1 imglv">
                    <img class="img-fluid imgvl" alt="${element.name}" src="${$app.icon_url('reports.png')}">
                    <div class="imgcplnk cplink pointer" data-url="${element.url}">Copy</div>
                </figure>
                `;
            $app.sethtml(block_id, grid, true);
        },
        uploads_upload: function (formid) {
            let that = this;
            this.uploads_validate(function (valid) {
                if (valid === true) {
                    let formdata = false;
                    let extra = {
                        name: $app.get("upd_name"),
                        privacy: $app.get("upd_privacy"),
                        type: $app.image.file
                    };
                    if ($app.image.croper !== false && $app.image.file === "image") {
                        $app.image.get_data(extra, function (formdata) {
                            that.uploads_send(formid, formdata);
                        });
                    } else {
                        formdata = $app.formData(formid, extra);
                        that.uploads_send(formid, formdata);
                    }
                }
            });
        },
        uploads_send: function (formid, formdata) {
            let that = this;
            if (formdata !== false) {
                $app.toast("Please wait.. Processing your request", "info");
                let action = "upload";
                var options = {url: $app.base_url('api/uploads'), type: "POST", data: formdata, processData: false, contentType: false};
                $app.callHttp(options, function (response) {
                    $app.message(response);
                    if (response.status === "true") {
                        that.uploads_recache(formid, action, function () {
                            $app.hideModal('popup_cln');
                            that.draw_page();
                        });
                    }
                });
            }
        },
        uploads_validate: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("upd_file", "select", "Valid File for upload", ["selected"], {}) : false;
            valid = (valid === true) ? $app.validate("upd_name", "text", "File Name", ["blank", "length"], {length: 3}) : false;
            valid = (valid === true) ? $app.validate("upd_privacy", "select", "who can use this file?", ["selected"], {}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        uploads_preview: function (obj) {
            try {
                if (obj.files && obj.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        let filename = obj.files[0].name;
                        let mime = obj.files[0].type;
                        let extension = filename.split('.').pop().toLowerCase();
                        let preview = "";
                        if ($app.inArray(extension, ["jpg", "png", "jpeg"])) {
                            $app.image.file = "image";
                            $app.image.type = extension;
                            $app.image.mime = mime;
                            let imgurl = $app.safeVar(e.target.result, "");
                            if (!$app.isBlank(imgurl)) {
                                preview = `<div class="prev"><img id="canvas" class="img-fluid upd_previmg" src="${imgurl}" /></div>`;
                                $app.sncropper = false;
                                $app.discollapse("upd_cpedt", true);
                            }
                        } else if ($app.inArray(extension, ["pdf"])) {
                            $app.image.file = "doc";
                            let icon = "fa-folder-open";
                            switch (extension) {
                                case "pdf":
                                    icon = "fa-file-pdf-o";
                                    break;
                            }
                            preview = `<div class="drmsg">
                                        <p><i class="fa font-25 ${icon}" aria-hidden="true"></i></p>
                                        <p class="pt-4 font-18">${$app.uppercase(extension)} File</p>
                                        <p class="pt-3 font-12">${filename}</p>
                                    </div>`;
                            $app.discollapse("upd_cpedt", false);
                        }
                        if ($app.isBlank(preview)) {
                            $app.set("upd_name", "");
                            $app.toast("Please select valid file");
                        } else {
                            $app.set("upd_name", filename);
                            $app.show("upd_preview");
                            $app.hide("upd_uploadview");
                            $app.sethtml("upd_preview", preview);
                            $("#upd_tags").val(null).trigger('change');
                            $app.select2("upd_tags", false, true);
                        }
                    };
                    reader.readAsDataURL(obj.files[0]);
                }
            } catch (err) {
                $app.debug(err.message, true);
            }
        },
        uploads_popup: function (formid) {
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            $app.discollapse("upd_cpedt", false);
            $app.show("upd_uploadview");
            $app.hide("upd_preview");
            $app.hide("upd_crpprev");
            $app.showModal("popup_cln");
            $app.set("upd_privacy", "o");
            $app.select2("upd_privacy");
            $app.select2("tags.select2", true, true);
        },
        uploads_recache: function (formid, action, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            let type = $app.safeVar($app.getdata("coltabs .edtctab.active", "type"), "i");
            let onlyme = $app.safeVar($app.checked("coluser"), true);
            let onlyblog = $app.safeVar($app.checked("colblog"), true);
            let offset = $app.get_integer($app.get("offset"));
            let search = $app.safeVar($app.get("colsearch"), "");
            $app.clear_cache_keys("uploads", [`uploads-${type}/${onlyme}/${onlyblog}/${offset}/${search}`]);
            $app.set("upd_name", "");
            $("#upd_privacy").val("").trigger('change');
            $("#upd_tags").val(null).trigger('change');
            if (callback !== false) {
                callback();
            }
        },
        /* Start AdGroup Page */
        page_adgrouplist: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'adgtable':
                        that.adgroup_table();
                        break;
                }
            });
        },
        adgroup_setup: function (formid, update) {
            let that = this;
            this.validate_adgroupsetup(function (valid) {
                if (valid === true) {
                    let extra = (update == true) ? {id: $app.getSession("edit_adgroup_id"), update: true} : {};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast("Please wait.. Processing your request", "info");
                        var options = {url: $app.base_url('api/adgroup'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            $app.message(response);
                            if (response.status === "true") {
                                that.adgroup_recache(formid, update, function () {
                                    $app.hideModal('popup_adg');
                                    that.draw_page();
                                });
                            }
                        });
                    }
                }
            });
        },
        validate_adgroupsetup: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("adg_name", "text", "Name", ["blank", "length"], {length: 3}) : false;
            valid = (valid === true) ? $app.validate("adg_adsize", "select", "Adsize", ["selected"], {}) : false;
            valid = (valid === true) ? $app.validate("adg_desc", "text", "Description", ["blank"], {}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        adgroup_delete: function (obj) {
            let that = this;
            $app.confirm(function () {
                let id = $(obj).data("id");
                $app.toast("Please wait.. Processing your request.", "info");
                let options = {url: $app.base_url('api/adgroup'), type: "DELETE", data: {id: id}, checkdefault: true};
                $app.callHttp(options, function (response) {
                    $app.message(response);
                    switch (response.status) {
                        case "true" :
                            that.adgroup_recache("", false, function () {
                                that.draw_page();
                            });
                            break;
                        case "false" :
                            $app.toast("Unable to process your request", "error");
                            break;
                        default:
                            $app.toast("Unable to handle your request this time. Please try again later", "error");
                    }
                });
            }, "Are you sure?", "Discard");
        },
        adgroup_recache: function (formid, update, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            $app.clear_cache_keys("adgroup");
            if (callback !== false) {
                callback();
            }
        },
        adgroup_edit: function (obj) {
            let that = this;
            let id = $(obj).data("id");
            let options = {url: $app.base_url(`api/adgroup/0/${id}`), checkdefault: true};
            $app.callHttp(options, function (response) {
                let adgroup = $app.safeVar(response.data["adgroup"].list, []);
                if ($app.isObject(adgroup) && $app.getLength(adgroup) > 0) {
                    $app.set("adg_name", $app.safeVar(adgroup.name, ""));
                    $app.set("adg_desc", $app.safeVar(adgroup.meta, ""));
                    $app.set("adg_platform", $app.safeVar(adgroup.platform, "a"));
                    $app.setSession("edit_adgroup_id", id);
                    $app.setdata("adg_add", "update", true);
                    $app.settext("adg_add", "Update");
                    that.adgroup_popup("", adgroup.adsid);
                } else {
                    $app.toast("This AdSize can not be edit.", "error");
                }
            });
        },
        adgroup_popup: function (formid, adg_id) {
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            let options = {url: $app.base_url('api/adsize/0/0'), cachekey: 'adsize_list'};
            $app.callHttp(options, function (response) {
                $app.showModal("popup_adg");
                $app.select2("select2", true);
                $app.setSelectList(response, "adg_adsize", "adsize", "name", "id", true, adg_id);
            });
        },
        adgroup_table: function (offset) {
            let limit = $app.getConfig("table_max_row");
            offset = $app.safeVar(offset, 0);
            let options = {url: $app.base_url(`api/adgroup/${offset}`), cachekey: 'adgroup_list', checkdefault: true};
            $app.set_list_clear('adgtable', true);
            $app.callHttp(options, function (response) {
                let header = ["Name", "AdSize", "Size", "Platform", "Ads", "Actions"];
                let key = ["name", "adsize", "size", "device", "count", "action"];
                let actions = ["edit", "delete"];
                $app.html.createHtmlTable("adgtable", response, "adgroup", header, key, actions);
            });
        },
        /* Start AdSize Page */
        page_adsizelist: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'adstable':
                        that.adsize_table();
                        break;
                }
            });
        },
        adsize_setup: function (formid, update) {
            let that = this;
            this.validate_adsizesetup(function (valid) {
                if (valid === true) {
                    let extra = (update == true) ? {id: $app.getSession("edit_adsize_id"), update: true} : {};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast("Please wait.. Processing your request", "info");
                        var options = {url: $app.base_url('api/adsize'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            $app.message(response);
                            if (response.status === "true") {
                                that.adsize_recache(formid, update, function () {
                                    $app.hideModal('popup_ads');
                                    that.draw_page();
                                });
                            }
                        });
                    }
                }
            });
        },
        validate_adsizesetup: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("ads_name", "text", "Name", ["blank", "length"], {length: 3}) : false;
            valid = (valid === true) ? $app.validate("ads_sitekey", "text", "Site Key", ["blank", "length"], {length: 3}) : false;
            valid = (valid === true) ? $app.validate("ads_width", "select", "Ads Width", ["selected"], {}) : false;
            valid = (valid === true) ? $app.validate("ads_height", "select", "Ads Height", ["selected"], {}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        adsize_delete: function (obj) {
            let that = this;
            $app.confirm(function () {
                let id = $(obj).data("id");
                $app.toast("Please wait.. Processing your request.", "info");
                let options = {url: $app.base_url('api/adsize'), type: "DELETE", data: {id: id}, checkdefault: true};
                $app.callHttp(options, function (response) {
                    $app.message(response);
                    switch (response.status) {
                        case "true" :
                            that.adsize_recache("", false, function () {
                                that.draw_page();
                            });
                            break;
                        case "false" :
                            $app.toast("Unable to process your request", "error");
                            break;
                        default:
                            $app.toast("Unable to handle your request this time. Please try again later", "error");
                    }
                });
            }, "Are you sure?", "Discard");
        },
        adsize_recache(formid, update, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            $app.clear_cache_keys("adsize");
            if (callback !== false) {
                callback();
            }
        },
        adsize_edit: function (obj) {
            let that = this;
            let id = $(obj).data("id");
            let options = {url: $app.base_url(`api/adsize/0/${id}`), checkdefault: true};
            $app.callHttp(options, function (response) {
                let adsize = $app.safeVar(response.data["adsize"].list, []);
                if ($app.isObject(adsize) && $app.getLength(adsize) > 0) {
                    console.log(adsize);
                    $app.set("ads_name", $app.safeVar(adsize.name, ""));
                    $app.set("ads_width", $app.safeVar(adsize.width, 0));
                    $app.set("ads_height", $app.safeVar(adsize.height, 0));
                    $app.set("ads_sitekey", $app.safeVar(adsize.sitekey, ""));
                    $app.setSession("edit_adsize_id", id);
                    $app.setdata("ads_add", "update", true);
                    $app.settext("ads_add", "Update");
                    that.adsize_popup();
                } else {
                    $app.toast("This AdSize can not be edit.", "error");
                }
            });
        },
        adsize_popup: function (formid) {
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            $app.showModal("popup_ads");
            $app.select2("ads_width");
            $app.select2("ads_height");
        },
        adsize_table: function (offset) {
            let limit = $app.getConfig("table_max_row");
            offset = $app.safeVar(offset, 0);
            let options = {url: $app.base_url(`api/adsize/${offset}`), cachekey: 'adsize_list', checkdefault: true};
            $app.set_list_clear(['adstable'], true);
            $app.callHttp(options, function (response) {
                let header = ["Name", "Size", "Site Key", "Actions"];
                let key = ["name", "size", "sitekey", "action"];
                let actions = ["edit", "delete"];
                $app.html.createHtmlTable("adstable", response, "adsize", header, key, actions);
            });
        },
        /* Start Category Page */
        page_categorylist: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'catrtable':
                        that.category_table();
                        break;
                }
            });
        },
        category_setup: function (formid, update) {
            let that = this;
            this.validate_catsetup(function (valid) {
                if (valid === true) {
                    let extra = (update == true) ? {id: $app.getSession("edit_category_id"), update: true} : {};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast("Please wait.. Request in prograss", "info");
                        var options = {url: $app.base_url('api/category'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            $app.message(response);
                            if (response.status === "true") {
                                that.category_recache(formid, update, function () {
                                    $app.hideModal('popup_catr');
                                    that.draw_page();
                                });
                            }
                        });
                    }
                }
            });
        },
        validate_catsetup: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("catr_name", "text", "Category Name", ["blank", "length"], {length: 3}) : false;
            valid = (valid === true) ? $app.validate("catr_slug", "text", "Category Slug", ["blank", "length"], {length: 3}) : false;
            valid = (valid === true) ? $app.validate("catr_parent", "select", "Category Parrent", ["selected"], {}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        category_delete: function (obj) {
            let that = this;
            $app.confirm(function () {
                let id = $(obj).data("id");
                $app.toast("Please wait.. Deleting this category.", "info");
                let options = {url: $app.base_url('api/category'), type: "DELETE", data: {id: id}, checkdefault: true};
                $app.callHttp(options, function (response) {
                    $app.message(response);
                    switch (response.status) {
                        case "true" :
                            that.category_recache("", false, function () {
                                that.draw_page();
                            });
                            break;
                        case "false" :
                            $app.toast("Unable to process your request", "error");
                            break;
                        default:
                            $app.toast("Unable to handle your request this time. Please try again later", "error");
                    }
                });
            }, "Are you sure?", "Discard");
        },
        category_recache(formid, update, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            if (!$app.isBlank(formid)) {
                $app.clearForm(formid);
            }
            $app.clear_cache_keys("category");
            if (callback !== false) {
                callback();
            }
        },
        category_edit: function (obj) {
            let that = this;
            let cat_id = $(obj).data("id");
            let options = {url: $app.base_url(`api/category/0/0/${cat_id}`), checkdefault: true};
            $app.callHttp(options, function (response) {
                let category = $app.safeVar(response.data["category"].list, []);
                if ($app.isObject(category) && $app.getLength(category) > 0) {
                    $app.set("catr_name", $app.safeVar(category.name, ""));
                    $app.set("catr_slug", $app.safeVar(category.slug, ""));
                    $app.setSession("edit_category_id", cat_id);
                    $app.setdata("catr_add", "update", true);
                    $app.settext("catr_add", "Update");
                    that.category_popup($app.safeVar(category.pid, 0));
                } else {
                    $app.toast("Not allowed to edit this", "error");
                }
            });
        },
        category_popup: function (cat_id) {
            cat_id = $app.safeVar(cat_id, "");
            let options = {url: $app.base_url('api/category/0/0'), cachekey: 'category_list'};
            $app.callHttp(options, function (response) {
                $app.showModal("popup_catr");
                $app.setSelectList(response, "catr_parent", "category", "name", "id", true, cat_id);
            });
        },
        category_table: function (offset) {
            let limit = $app.getConfig("table_max_row");
            offset = $app.safeVar(offset, 0);
            let options = {url: $app.base_url('api/category'), cachekey: 'category_list', checkdefault: true};
            $app.set_list_clear('catrtable', true);
            $app.callHttp(options, function (response) {
                let header = ["Name", "Slug", "Parent Category", "Actions"];
                let key = ["name", "slug", "parent", "action"];
                let actions = ["edit", "delete"];
                $app.html.createHtmlTable("catrtable", response, "category", header, key, actions);
            });
        },
        /* Start Pages list */
        page_pagelist: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'pagestable':
                        that.pagelist_table();
                        break;
                }
            });
        },
        pagelist_table: function () {
            $options = {url: $app.base_url('api/pages'), cachekey: 'user_blog_pagelist', checkdefault: true};
            $app.set_list_clear(['pages'], true);
            $app.callHttp($options, function (response) {
                let options = {
                    id: "this_id",
                    title: "title",
                    desc: "description",
                    update_time: "update_time",
                    url: "url",
                    status: "status",
                };
                $app.html.callToDrawHtmlTable(response, 'pages', 'pages', 'pagelisthtml', options);
            });
        },
        /* Start edit video Page */
        page_editpage: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'editor':
                        that.open_editor("editor", "preview");
                        break;
                }
            });
        },
        /* Start new Page */
        page_newpage: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'editor':
                        that.page_editor("editor", "preview");
                        break;
                }
            });
        },
        page_save: function (formid, publish, page_id) {
            let that = this;
            publish = $app.safeVar(publish, false);
            this.page_validate(function (valid) {
                if (valid === true) {
                    let extra = (!page_id) ? {publish: publish, update: false} : {update: true, publish: publish, id: page_id};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast(`Please wait.. ${(!page_id) ? "Creating new" : "Updating this"} page`, "info");
                        let options = {url: $app.base_url('api/pages'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            try {
                                $app.toast($app.safeVar(response.data, "Unable to process your request right now"), (response.status === "true") ? "success" : "error");
                                if (response.status === "true" || response.saved === "true") {
                                    that.page_recache(false, function () {
                                        $app.redirect('pages');
                                    });
                                }
                            } catch (err) {
                                $app.debug(err.message, true);
                            }
                        });
                    }
                }
            });
        },
        page_validate: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("psttitle", "text", "title", ["blank", "length"], {length: 30}) : false;
            valid = (valid === true) ? $app.validate("editor", "text", "Content", ["blank", "length"], {length: 256}) : false;
            valid = (valid === true) ? $app.validate("edt_desc", "text", "Short Description", ["blank", "length"], {length: 100}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        page_editor: function (editor_id, preview_id) {
            $app.editor(editor_id, preview_id);
        },
        page_discard: function (obj) {
            $app.confirm(function () {
                $app.redirect("blog/pages");
            }, "Are you sure?", "Discard");
        },
        page_edit: function (obj) {
            $app.redirect(`pages/edit/${$(obj).data("id")}`);
        },
        page_delete: function (obj) {
            let that = this;
            $app.confirm(function () {
                let id = $(obj).data("id");
                $app.toast("Please wait.. Deleting this page.", "info");
                let options = {url: $app.base_url('api/pages'), type: "DELETE", data: {id: id}, checkdefault: true};
                $app.callHttp(options, function (response) {
                    $app.toast(response.data, (response.status === "true") ? "success" : "error");
                    switch (response.status) {
                        case "true" :
                            that.page_recache(false, function () {
                                that.draw_page();
                            });
                            break;
                        case "false" :
                            break;
                        default:
                            $app.toast("Unable to handle your request this time. Please try again later", "error");
                    }
                });
            }, "Are you sure?", "Discard");
        },
        page_recache(is_update, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            $app.clear_cache_keys("page");
            if (callback !== false) {
                callback();
            }
        },
        /* Start Videos List Page */
        page_videolist: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'videostable':
                        that.videolist_table();
                        break;
                }
            });
        },
        videolist_table: function () {
            $options = {url: $app.base_url('api/videos'), cachekey: 'user_blog_videolist', checkdefault: true};
            $app.set_list_clear('blogs', true);
            $app.callHttp($options, function (response) {
                let options = {
                    id: "this_id",
                    title: "title",
                    summery: "description",
                    thumbnail: "thumbnail",
                    category: "category",
                    update_time: "update_time",
                    url: "url",
                    status: "status",
                };
                $app.html.callToDrawHtmlTable(response, 'videos', 'videos', 'videolisthtml', options);
            });
        },
        /* Start edit video Page */
        page_editvideo: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'editor':
                        that.open_editor("editor", "preview");
                        break;
                }
            });
        },
        /*Start New Video Post Page*/
        page_newvideo: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'editor':
                        that.open_editor("editor", "preview");
                        break;
                }
            });
        },
        video_save: function (formid, publish, post_id) {
            let that = this;
            publish = $app.safeVar(publish, false);
            this.video_validate(function (valid) {
                if (valid === true) {
                    let extra = (!post_id) ? {publish: publish, update: false} : {update: true, publish: publish, id: post_id};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast(`Please wait.. ${(!post_id) ? "Creating new" : "Updating this"} video post`, "info");
                        let options = {url: $app.base_url('api/videos'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            try {
                                $app.toast($app.safeVar(response.data, "Unable to process your request right now"), (response.status === "true") ? "success" : "error");
                                if (response.status === "true" || response.saved === "true") {
                                    that.video_recache(false, function () {
                                        $app.redirect('blog/videos');
                                    });
                                }
                            } catch (err) {
                                $app.debug(err.message, true);
                            }
                        });
                    }
                }
            });
        },
        video_validate: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("psttitle", "text", "Title", ["blank", "length"], {length: 30}) : false;
            valid = (valid === true) ? $app.validate("editor", "text", "Content", ["blank", "length"], {length: 256}) : false;
            valid = (valid === true) ? $app.validate("edt_desc", "text", "Short Description", ["blank", "length"], {length: 100}) : false;
            valid = (valid === true) ? $app.validate("edt_category", "select", "Category", ["selected"], {}) : false;
            valid = (valid === true) ? $app.validate("edt_language", "select", "Language", ["selected"], {}) : false;
            valid = (valid === true) ? $app.validate("edt_tags", "select", "Tags", ["selected", "maxlength"], {maxlength: 8}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        video_editor: function (editor_id, preview_id) {
            $app.editor(editor_id, preview_id);
        },
        video_discard: function (obj) {
            $app.confirm(function () {
                $app.redirect("blog/videos");
            }, "Are you sure?", "Discard");
        },
        video_edit: function (obj) {
            $app.redirect(`videos/edit/${$(obj).data("id")}`);
        },
        video_delete: function (obj) {
            let that = this;
            $app.confirm(function () {
                let id = $(obj).data("id");
                $app.toast("Please wait.. Deleting this video.", "info");
                let options = {url: $app.base_url('api/videos'), type: "DELETE", data: {id: id}, checkdefault: true};
                $app.callHttp(options, function (response) {
                    $app.toast(response.data, (response.status === "true") ? "success" : "error");
                    switch (response.status) {
                        case "true" :
                            that.video_recache(false, function () {
                                that.draw_page();
                            });
                            break;
                        case "false" :
                            break;
                        default:
                            $app.toast("Unable to handle your request this time. Please try again later", "error");
                    }
                });
            }, "Are you sure?", "Discard");
        },
        video_recache(is_update, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            $app.clear_cache_keys("video");
            if (callback !== false) {
                callback();
            }
        },
        /* Start Posts list page */
        page_postlist: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'poststable':
                        that.postlist_table();
                        break;
                }
            });
        },
        postlist_table: function () {
            $options = {url: $app.base_url('api/posts'), cachekey: 'user_blog_postlist', checkdefault: true};
            $app.set_list_clear(['blogs'], true);
            $app.callHttp($options, function (response) {
                let options = {
                    id: "this_id",
                    title: "title",
                    summery: "description",
                    category: "category",
                    update_time: "update_time",
                    url: "url",
                    status: "status"
                };
                $app.html.callToDrawHtmlTable(response, 'posts', 'posts', 'postlisthtml', options);
            });
        },
        /* Start edit post Page */
        page_editpost: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'editor':
                        that.open_editor("editor", "preview");
                        break;
                }
            });
        },
        /* Start new post Page */
        page_newpost: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'editor':
                        that.open_editor("editor", "preview");
                        break;
                }
            });
        },
        post_save: function (formid, publish, post_id) {
            let that = this;
            publish = $app.safeVar(publish, false);
            this.post_validate(function (valid) {
                if (valid === true) {
                    let extra = (!post_id) ? {publish: publish, update: false} : {update: true, publish: publish, id: post_id};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast(`Please wait.. ${(!post_id) ? "Creating new" : "Updating this"} post`, "info");
                        let options = {url: $app.base_url('api/posts'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            try {
                                $app.toast($app.safeVar(response.data, "Unable to process your request right now"), (response.status === "true") ? "success" : "error");
                                if (response.status === "true" || response.saved === "true") {
                                    that.post_recache(false, function () {
                                        $app.redirect('posts');
                                    });
                                }
                            } catch (err) {
                                $app.debug(err.message, true);
                            }
                        });
                    }
                }
            });
        },
        post_validate: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("psttitle", "text", "title", ["blank", "length"], {length: 30}) : false;
            valid = (valid === true) ? $app.validate("editor", "text", "Content", ["blank", "length"], {length: 256}) : false;
            valid = (valid === true) ? $app.validate("edt_desc", "text", "Short Description", ["blank", "length"], {length: 100}) : false;
            valid = (valid === true) ? $app.validate("edt_category", "select", "category", ["selected"], {}) : false;
            valid = (valid === true) ? $app.validate("edt_language", "select", "Language", ["selected"], {}) : false;
            valid = (valid === true) ? $app.validate("edt_tags", "select", "Tags", ["selected", "maxlength"], {maxlength: 8}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        open_editor: function (editor_id, preview_id) {
            $app.editor(editor_id, preview_id);
        },
        post_discard: function (obj) {
            $app.confirm(function () {
                $app.redirect("blog/posts");
            }, "Are you sure?", "Discard");
        },
        post_edit: function (obj) {
            $app.redirect(`posts/edit/${$(obj).data("id")}`);
        },
        post_delete: function (obj) {
            let that = this;
            $app.confirm(function () {
                let id = $(obj).data("id");
                $app.toast("Please wait.. Deleting this post.", "info");
                let options = {url: $app.base_url('api/posts'), type: "DELETE", data: {id: id}, checkdefault: true};
                $app.callHttp(options, function (response) {
                    $app.toast(response.data, (response.status === "true") ? "success" : "error");
                    switch (response.status) {
                        case "true" :
                            that.post_recache(false, function () {
                                that.draw_page();
                            });
                            break;
                        case "false" :
                            break;
                        default:
                            $app.toast("Unable to handle your request this time. Please try again later", "error");
                    }
                });
            }, "Are you sure?", "Discard");
        },
        post_recache(is_update, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            $app.clear_cache_keys("post");
            if (callback !== false) {
                callback();
            }
        },
        /* End post new Page */
        /* Start Blog Grid View Page */
        page_bloggrid: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'blogs_grid':
                        that.blogs_grid();
                        break;
                }
            });
        },
        blogs_grid: function () {
            $options = {url: $app.base_url('api/blogs'), cachekey: 'user_blogslist', checkdefault: true};
            $app.set_list_clear('blogs', true);
            $app.callHttp($options, function (response) {
                let options = {
                    id: "this_id",
                    name: "blog_name",
                    url: "blog_url",
                    total: "total_posts",
                    today: "today_posts",
                    logo: "blog_logo",
                    desc: "blog_desc"
                };
                $app.html.callToDrawHtmlBlock(response, 'blogs', 'blogs', 'blogshtml', options, "", 300);
            });
        },
        /* Start Setting -> Password Page */
        change_pass: function (formid) {
            let that = this;
            this.password_validate(function (valid) {
                if (valid === true) {
                    let extra = {};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast("Please wait.. Request in prograss", "info");
                        var options = {url: $app.base_url('api/password'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            $app.toast(response.data, "success");
                            $app.redirect('blog');
                        });
                    }
                }
            });
        },
        password_validate: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("password", "text", "Password", ["blank", "length"], {length: 5}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        /* End Setting -> Password Page
         ==============================
         Start Blog Setup Page */
        page_addblog: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'theme':
                        that.load_blog_theme();
                        break;
                    case 'category':
                        that.load_blog_category();
                        break;
                }
            });
        },
        load_blog_theme: function () {
            let options = {url: $app.base_url('api/themes'), cachekey: 'theme_list'};
            $app.callHttp(options, function (response) {
                $app.setSelectList(response, "blog_new_theme", "themelist", "name", "id", true);
            });
        },
        load_blog_category: function () {
            let options = {url: $app.base_url('api/category/0/0'), cachekey: 'category_list'};
            $app.callHttp(options, function (response) {
                $app.setSelectList(response, "blog_new_category", "category", "name", "id", true);
            });
        },
        blog_url_validate: function (obj) {
            let that = this;
            let container = "vdo_list";
            let formid = "frm_newblog";
            $app.setSession("blog_address_available", false);
            let address = $(obj).val();
            if ($app.isBlank(address) || $app.getLength(address) <= 5) {
                that.blog_url_valid_status(false, true);
            } else {
                let search_session = $app.getSession("blog_url");
                clearTimeout(search_session);
                search_session = setTimeout(function () {
                    that.blog_check_url(container, formid);
                }, 800);
                $app.setSession("blog_url", search_session);
            }
        },
        blog_check_url: function (container, formid) {
            let that = this;
            $app.show(container);
            $app.sethtml(container, "");
            let extra = {};
            let formdata = $app.formData(formid, extra);
            if (formdata !== false) {
                $app.toast("Checking address availablility...", "info");
                let options = {url: $app.base_url('api/blogs'), type: "PUT", data: formdata, processData: false, contentType: false, callbackonerror: true};
                $app.callHttp(options, function (response) {
                    try {
                        let status = $app.safeVar(response.status);
                        if (status === 'true') {
                            that.blog_url_valid_status(true);
                            $app.toast(response.data, "success");
                        } else {
                            that.blog_url_valid_status(false);
                        }
                    } catch (err) {
                        $app.debug(err.message, true);
                    }
                });
            }
        },
        blog_url_valid_status: function (valid, clear) {
            $app.set_attr("blog_valid_icon", "class", "fa");
            clear = $app.safeVar(clear, false);
            let objId = "blog_valid_icon";
            if (clear) {
                $app.addMultiClass([objId], ["fa-search", "text-muted"]);
            } else {
                $app.addMultiClass([objId], (valid) ? ["fa-check", "text-success"] : ["fa-times", "text-danger"]);
            }
        },
        blog_create: function (formid) {
            let that = this;
            this.blog_validate_field(function (valid) {
                if (valid === true) {
                    let extra = {source: "first"};
                    let formdata = $app.formData(formid, extra);
                    if (formdata !== false) {
                        $app.toast("Please wait.. Work in prograss", "info");
                        var options = {url: $app.base_url('api/blogs'), type: "POST", data: formdata, processData: false, contentType: false};
                        $app.callHttp(options, function (response) {
                            $app.toast(response.data, "success");
                            that.blog_clear_cache(formid, function () {
                                $app.redirect('blog');
                            });
                        });
                    }
                }
            });
        },
        blog_validate_field: function (callback) {
            let valid = true;
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            valid = (valid === true) ? $app.validate("blog_new_name", "text", "Name", ["blank", "length", "maxlength"], {length: 5, maxlength: 64}) : false;
            valid = (valid === true) ? $app.validate("blog_new_url", "text", "Address", ["blank", "length", "maxlength"], {length: 5, maxlength: 32}) : false;
            valid = (valid === true) ? $app.validate("blog_new_category", "select", "Category", ["selected"], {}) : false;
            valid = (valid === true) ? $app.validate("blog_new_theme", "select", "Theme", ["selected"], {}) : false;
            if (callback !== false) {
                callback(valid);
            }
        },
        blog_clear_cache: function (formid, callback) {
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            let keys = ["user_blogslist"];
            $app.clearForm(formid);
            $app.cache.removeKeys(keys);
            if (callback !== false) {
                callback();
            }
        },
        /*  End Blog Setup Page
         ==============================
         Start Blog Summery Page */
        page_summery: function () {
            var that = this;
            $('._drawer').each(function (index, value) {
                let object = $app.safeVar($(this).data("key"));
                switch (object) {
                    case 'counts':
                        that.summery_counts();
                        break;
                    case 'dgraph':
                        //that.summery_dgraph();
                        break;
                }
            });
        },
        summery_dgraph: function () {
            $options = {url: $app.base_url('json/summarygraph'), cachekey: 'summarygraph', checkdefault: true};
            $app.chart_loading(['ovrnugraph', 'ovraugraph', 'ovrsegraph']);
            $app.callHttp($options, function (response) {
                /** This draw a new user graph **/
                let config = {
                    showtooltip: false,
                    legendshow: false,
                    ysplitLineshow: false,
                    yaxisshow: false,
                    xaxisshow: true,
                    grid_left: -25,
                    grid_right: 0,
                    grid_top: 0,
                    grid_bottom: -17,
                    areaStyleType: 'default',
                    smoothLine: true,
                    showSymbol: false
                };
                $app.graph.callToDrawLineGraph(response, 'ovrnugraph', $app.mergeObject(config, {color: ["#8c9ae6"]}), 'newuserbydate', 'data', 'time', 'value');
                /** This draw a active user graph **/
                $app.graph.callToDrawLineGraph(response, 'ovraugraph', $app.mergeObject(config, {color: ["#ef769b"]}), 'activeuserbydate', 'data', 'time', 'value');
                /** This draw a user session graph **/
                $app.graph.callToDrawLineGraph(response, 'ovrsegraph', $app.mergeObject(config, {color: ["#4ab1c0"]}), 'sessioncountbydate', 'data', 'time', 'value');
            });
        },
        summery_counts: function () {
            $options = {url: $app.base_url('graph/smry_count'), cachekey: 'summery_counts', checkdefault: true};
            $app.loading_count(['smrctl_post']);
            $app.callHttp($options, function (response) {
                /** Set the Post Counts **/
                $app.html.set_number_count(response, 'smrctl_post', 'totalpost', 'count', 10);
                $app.html.set_number_count(response, 'smrdrf_post', 'draftpost', 'count', 10);
                $app.html.set_number_count(response, 'smrpub_post', 'publishpost', 'count', 10);

                /** Set the Video Counts **/
                $app.html.set_number_count(response, 'smrctl_vdo', 'totalvideo', 'count', 10);
                $app.html.set_number_count(response, 'smrdrf_vdo', 'draftvideo', 'count', 10);
                $app.html.set_number_count(response, 'smrpub_vdo', 'publishvideo', 'count', 10);

                /** Set the Page Counts **/
                $app.html.set_number_count(response, 'smrctl_page', 'totalpage', 'count', 10);
                $app.html.set_number_count(response, 'smrdrf_page', 'draftpage', 'count', 10);
                $app.html.set_number_count(response, 'smrpub_page', 'publishpage', 'count', 10);
            });
        }
    });
});