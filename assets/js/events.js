/* global echarts */

$(document).ready(function () {
    $app = new app();
    $app.init();

    let events = {
        "act-edit": "handler_edit",
        "act-delete": "handler_delete",
        "act-view": "handler_view",
        "act-access": "handler_access",
        "act-block": "handler_block"
    };

    $.each(events, function (action, handler) {
        $('body').on('click', `.${action}`, function () {
            try {
                let handler_list = $app[handler](this);
                let object = $(this).data("object");
                if ($app.isset(handler_list, object)) {
                    let method = $app.safeVar(handler_list[object], false);
                    (method) ? $app.script[method](this) : $app.error(`Function not found: action: ${action} :: object: ${object} :: Method: ${method}`);
                }
            } catch (err) {
                $app.debug(err.message);
            }
        });
    });

    /** Enable tooltip for all */
    $(".infotip").tooltip({html: true, delay: 200});

    /** This will clear all Ajax Request when user will try to reload page **/
    $(window).bind('beforeunload', function () {
        $app.abortAllHttp();
    });

    window.onresize = function () {
        $app.graph.resize();
    };

    /** This Handler is useful for bound user to enter specific information in input field */
    $('body').on('input keydown keyup mousedown mouseup select contextmenu drop', ".adtext", function (e) {
        $value = $(this).val();
        $format = (typeof $(this).data('format') !== 'undefined') ? $(this).data('format') : "anum";
        $length = (typeof $(this).data('length') !== 'undefined') ? $(this).data('length') : 9999;
        $maximum = (typeof $(this).data('max') !== 'undefined') ? $(this).data('max') : 9999;
        $filter = false;
        switch ($format) {
            case "numr": // Only allowed numbers with fixed length
                $tmp = ($value !== "") ? $value : 0;
                $filter = (/^[0-9]+$/i.test($tmp) && $tmp <= $maximum);
                break;
            case "alph": // only allowed English Characters A - Z or a-z
                $filter = (/^[a-zA-Z]+$/i.test($value) && $value.length <= $length) || $value === "";
                break;
            case "scalp": // Only Allowed small case Characters a-z
                $filter = (/^[a-z]+$/.test($value) && $value.length <= $length) || $value === "";
                break;
            case "anum": // Only allowed alpha numeric value
                $filter = (/^[a-z0-9]+$/i.test($value) && $value.length <= $length) || $value === "";
                break;
            case "anumd": // Only allowed alpha numeric value with dot
                $filter = (/^[A-Za-z0-9.]+$/i.test($value) && $value.length <= $length) || $value === "";
                break;
            case "anspc": // Only allowed alpha numeric value with space
                $filter = (/^[a-z0-9 ]+$/i.test($value) && $value.length <= $length) || $value === "";
                break;
            case "anundr": // Only allowed alpha numeric value with underscore
                $filter = (/^(?!.*__.*)[A-Za-z0-9_]+$/.test($value) && $value.length <= $length) || $value === "";
                break;
            case "anundrdt": // Only allowed alpha numeric value with underscore with Dot
                $filter = (/^(?!.*__.*)[A-Za-z0-9_.]+$/.test($value) && $value.length <= $length) || $value === "";
                break;
            case "ansundr": // Only allowed alpha numeric value with underscore and space
                $filter = (/^(?!.*__.*)(?!.*  .*)[A-Za-z0-9_ ]+$/.test($value) && $value.length <= $length) || $value === "";
                break;
            case "anundh": // Only allowed alpha numeric value with underscore and hyphon
                $filter = (/^(?!.*__.*)(?!.*--.*)[A-Za-z0-9_-]+$/.test($value) && $value.length <= $length) || $value === "";
                break;
            case "anudh": // Only allowed alpha numeric value with underscore, dot and hyphon
                $filter = (/^(?!.*__.*)(?!.*--.*)[A-Za-z0-9_.-]+$/.test($value) && $value.length <= $length) || $value === "";
                break;
            case "anwdh": // Only allowed alpha numeric with dash
                $filter = (/^(?!.*--.*)[A-Za-z0-9-]+$/.test($value) && $value.length <= $length) || $value === "";
                break;
            case "ansdh": // Only allowed alpha numeric with forword slash and dot
                $filter = (/^(?!.*--.*)[A-Za-z0-9./]+$/.test($value) && $value.length <= $length) || $value === "";
                break;
            case "anatdh": // Only allowed alpha numeric with forword slash and dot
                $filter = (/^(?!.*--.*)[A-Za-z0-9.@]+$/.test($value) && $value.length <= $length) || $value === "";
                break;
            default: // Allowed any character but length will be restricted
                $filter = $value.length <= $length;
                break;
        }
        if ($filter) {
            $(this).data("old", $value);
            return true;
        } else {
            let oldvalue = $app.safeVar($(this).data("old"), "");
            $(this).val(oldvalue);
            return false;
        }
    });

    $('body').on('click', '.copytext', function () {
        let id = $(this).attr("id");
        $app.selectTextById(id);
    });

    $('.slugify').bind('keyup keypress blur', function () {
        let flag = true;
        let id = $(this).attr("id");
        let text = $(this).val();
        let target = $app.getdata(id, "target");
        if (target === id) {
            if ($(this).data("onchange") === false) {
                if ($(this).data("changed") !== true) {
                    $(this).data("changed", true);
                }
            }
        } else {
            if ($app.getdata(target, "onchange") === false) {
                if ($app.getdata(target, "changed") === true) {
                    flag = false;
                }
            }
        }
        if (flag) {
            $app.slug(text, target, "key");
        }
    });

    /* Blog Setup page Start */
    $('body').on('input', '#blog_new_url', function () {
        $app.script.blog_url_validate(this);
    });

    $('body').on('click', '#blog_new_btn', function () {
        $app.script.blog_create("frm_newblog");
    });

    /* Setting - Password page Start */
    $('body').on('click', '#psd_change', function () {
        $app.script.change_pass("frm_pass");
    });

    /* New post page start */
    /* Add the active class in the editor tabs */
    $('body').on("click", ".edtctab", function () {
        if ($(this).hasClass("active")) {
            return false;
        } else {
            $(this).closest("ul").find(".edtctab").removeClass("active");
            $(this).addClass('active');
        }
    });

    $('body').on('click', '#edt_btn_sad', function () {
        let post_id = $(this).data("postid");
        $app.script.post_save("frm_edtr", false, (($app.isBlank(post_id)) ? false : post_id));
    });

    $('body').on('click', '#edt_btn_dsd', function () {
        $app.script.post_discard(this);
    });

    $('body').on('click', '#edt_btn_plh', function () {
        let post_id = $(this).data("postid");
        $app.script.post_save("frm_edtr", true, (($app.isBlank(post_id)) ? false : post_id));
    });

    $("#edbasic.collapse").on('shown.bs.collapse', function () {
        $app.select2("select2.basic", true);
        $app.select2("select2.tags", true, true, 7, "etag_count");
        if ($app.isBlank($app.get("edt_vcusthumnail"))) {
            let thumbnail_url = $("#preview").find("img").attr("src");
            $app.set("edt_vcusthumnail", thumbnail_url);
            $app.set_attr("edt_icusthumnail", "src", thumbnail_url);
        }
    });

    $('body').on('click', '#edt_custhumnail', function () {
        $app.prompt(function (thumbnail_url) {
            if ($app.validate("prompt_field", "text", "Thumbnail Url", ["blank", "url"])) {
                $app.set("edt_vcusthumnail", thumbnail_url);
                $app.set_attr("edt_icusthumnail", "src", thumbnail_url);
            }
        }, "Custom Thumbnail url", "Set Thumbnail");
    });

    /* Search Video Page Start */
    $('body').on('input', '#vdo_search', function () {
        $app.script.video_search(this);
    });

    /** Hide Video List Box when click outside list box **/
    $(document).on('click', function (e) {
        if (!$(e.target).is('#vdo_list *')) {
            $app.hide("vdo_list");
        }
    });

    $('body').on('click', '#vdo_list .list-group-item', function () {
        let platform = $app.get_selected_radio("platform");
        let vid = $(this).data("vid");
        $app.hide("vdo_list");
        $app.redirect(`videos/new/${platform}-${vid}`);
    });

    /* New Video Post Page Start */
    $('body').on('click', '#edt_btn_vsad', function () {
        let post_id = $(this).data("postid");
        $app.script.video_save("frm_edtr", false, (($app.isBlank(post_id)) ? false : post_id));
    });

    $('body').on('click', '#edt_btn_vdsd', function () {
        $app.script.video_discard(this);
    });

    $('body').on('click', '#edt_btn_vplh', function () {
        let post_id = $(this).data("postid");
        $app.script.video_save("frm_edtr", true, (($app.isBlank(post_id)) ? false : post_id));
    });

    /* New Page Script Start */
    $('body').on('click', '#edt_btn_psad', function () {
        let page_id = $(this).data("postid");
        $app.script.page_save("frm_edtr", false, (($app.isBlank(page_id)) ? false : page_id));
    });

    $('body').on('click', '#edt_btn_pdsd', function () {
        $app.script.page_discard(this);
    });

    $('body').on('click', '#edt_btn_pplh', function () {
        let page_id = $(this).data("postid");
        $app.script.page_save("frm_edtr", true, (($app.isBlank(page_id)) ? false : page_id));
    });

    /* Category Page Start */
    $('body').on('click', '#catr_crtbtn', function () {
        $app.setdata("catr_add", "update", false);
        $app.settext("catr_add", "Add");
        $app.script.category_popup();
    });

    $('body').on('click', '#catr_add', function () {
        let update = ($(this).data("update") === true) ? true : false;
        $app.script.category_setup("crt_addform", update);
    });

    /* AdSize Page Start */
    $('body').on('click', '#ads_crtbtn', function () {
        $app.setdata("ads_add", "update", false);
        $app.settext("ads_add", "Add");
        $app.script.adsize_popup("ads_addform");
    });

    $('body').on('click', '#ads_add', function () {
        let update = ($(this).data("update") === true) ? true : false;
        $app.script.adsize_setup("ads_addform", update);
    });

    /*  AdGroup Page Start */
    $('body').on('click', '#adg_crtbtn', function () {
        $app.setdata("adg_add", "update", false);
        $app.script.adgroup_popup("adg_addform");
    });

    $('body').on('click', '#adg_add', function () {
        let update = ($(this).data("update") === true) ? true : false;
        $app.script.adgroup_setup("adg_addform", update);
    });

    /* Uploads Page Start */
    $('body').on('click', '#upd_upload', function () {
        $app.script.uploads_popup("upd_addform");
    });

    $('body').on('click', '.sncbtn', function (e) {
        e.preventDefault();
        let method = $app.safeVar($(this).data("method"), "");
        $app.image.tool(method, this);
    });

    $('body').on('change', '#upd_file', function () {
        $app.script.uploads_preview(this);
    });

    $('body').on('click', '#upd_file', function () {
        $(this).val(null);
    });

    $('body').on('click', '#upd_submit', function () {
        $app.script.uploads_upload("upd_addform");
    });

    $("#colimgcrop.collapse").on('shown.bs.collapse', function () {
        $app.image.crop("canvas", "upd_crpprev", {}, true);
        $app.show("upd_crpprev");
    });

    $("#coloptions.collapse").on('shown.bs.collapse', function () {
        $app.image.tool("replace");
        $app.hide("upd_crpprev");
    });

    $('body').on('click', '.cplink', function () {
        $app.script.uploads_copylink(this);
    });

    $("#colimg.collapse").on('shown.bs.collapse', function () {
        $app.script.uploads_show();
    });

    $("#coldocs.collapse").on('shown.bs.collapse', function () {
        $app.script.uploads_show();
    });

    $('body').on('click', '#upd_search', function () {
        $app.script.uploads_show();
    });

    $('body').on('input', '#colsearch', function (e) {
        $app.script.uploads_search();
    });

    /* User Role Page Start */
    $('body').on('click', '#urole_crtbtn', function () {
        $app.clearForm("urole_addform");
        $app.setdata("urole_slug", "changed", false);
        $app.setdata("urole_add", "update", false);
        $app.settext("urole_add", "Add");
        $app.showModal("popup_urole");
    });

    $('body').on('click', '#urole_add', function () {
        let update = ($(this).data("update") === true) ? true : false;
        $app.script.userrole_setup("urole_addform", update);
    });

    /* Access Group Page Start */
    $('body').on('click', '#agroup_crtbtn', function () {
        $app.clearForm("agroup_addform");
        $app.setdata("agroup_add", "update", false);
        $app.setdata("agroup_slug", "changed", false);
        $app.settext("agroup_add", "Add");
        $app.showModal("popup_agroup");
    });

    $('body').on('click', '#agroup_add', function () {
        let update = ($(this).data("update") === true) ? true : false;
        $app.script.accessgroup_setup("agroup_addform", update);
    });

    /* Access List Page Start */
    $('body').on('click', '#access_crtbtn', function () {
        $app.clearForm("access_addform");
        $app.setdata("access_slug", "changed", false);
        $app.setdata("access_add", "update", false);
        $app.settext("access_add", "Add");
        $app.script.access_groups(0, function (response, selectid) {
            $app.showModal("popup_access");
            $app.select2(selectid);
        });
    });

    $('body').on('click', '#access_add', function () {
        let update = ($(this).data("update") === true) ? true : false;
        $app.script.access_setup("access_addform", update);
    });

    /* Role Access Page Start */
    $('body').on('click', '#roleaccess_update_btn', function () {
        $app.script.roleaccess_setup("roleaccess_form");
    });

    $('body').on('click', '#roleaccess_cancel_btn', function () {
        $app.redirect(`admin/userrole`);
    });

    /* Temporary Code for testing */
    $('body').on('click', '.header-action-notification.header-action-item', function () {
        let formdata = $app.formData("roleaccess_form");
        if (formdata !== false) {
            let options = {
                url: $app.base_url('open/test'),
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false
            };
            $app.callHttp(options, function (response) {
                console.log(response);
            });
        }
    });
}); // Close Jquery