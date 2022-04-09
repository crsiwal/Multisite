$(document).ready(function () {
    CropImage = function CropImage($app) {
        this.croper = false;
        this.backup = false;
        this.file = "";
        this.type = "";
        this.mime = "";
    };

    /* Image Class Start */
    $.extend(CropImage.prototype, {
        get_data: function (extradata, callback) {
            callback = $app.safeVar(callback, false);
            let that = this;
            if (this.backup) {
                this.backup.toBlob(function (blob) {
                    var formdata = new FormData();
                    formdata.append("clnfile", blob, `test.${that.type}`);
                    extradata = $app.safeVar(extradata, {});
                    if ($app.isObject(extradata) === true && $app.getLength(extradata, true) > 0) {
                        $.each(extradata, function (name, value) {
                            formdata.append(name, value);
                        });
                    }
                    if (callback) {
                        callback(formdata);
                    }
                }, that.mime);
            }
        },
        /**
         * 
         * @param {type} imgid
         * @param {type} preview_container
         * @param {type} opt
         * @param {type} restart
         * @returns {Boolean}
         */
        crop: function (imgid, preview_container, opt, restart) {
            if (this.croper) {
                if (restart === true) {
                    this.tool("destroy");
                } else {
                    return false;
                }
            }
            $app.show(preview_container);
            opt = $app.safeVar(($app.isObject(opt) ? opt : {}), {});
            let options = {
                aspectRatio: 1.777777777,
                preview: '.img-preview',
                viewMode: 3,
                ready: function (e) {
                    //console.log("ready");
                }
            };
            options = $app.mergeObject(options, opt);
            let image = document.getElementById(imgid);
            let Cropper = window.Cropper;
            this.croper = new Cropper(image, options);
        },
        /**
         * 
         * @param {type} method
         * @param {type} obj
         * @returns {undefined}
         */
        tool: function (method, obj) {
            if (!$app.isBlank(method)) {
                obj = $app.safeVar(obj, false);
                let option = (obj) ? $app.safeVar($(obj).data("option"), "") : "";
                try {
                    switch (method) {
                        case 'reset':
                            this.croper.reset();
                            break;
                        case 'crop':
                            this.croper.crop();
                            let image = this.croper.getCroppedCanvas().toDataURL(this.mime);
                            this.croper.replace(image, false);
                            setTimeout(function () {
                                $app.image.tool("clear");
                            }, 10);
                            break;
                        case 'getCroppedCanvas':
                            let fixcanvas = this.croper.getCroppedCanvas(option).toDataURL(this.mime);
                            this.croper.replace(fixcanvas, false);
                            setTimeout(function () {
                                $app.image.tool("clear");
                            }, 10);
                            break;
                        case 'replace':
                            this.tool("clear");
                            this.backup = this.croper.getCroppedCanvas();
                            let imagesrc = this.backup.toDataURL(this.mime);
                            this.tool("destroy");
                            $("#canvas").attr("src", imagesrc);
                            break;
                        case 'clear':
                            this.croper.clear();
                            break;
                        case 'setDragMode':
                            this.croper.setDragMode(option);
                            break;
                        case 'scaleX':
                            this.croper.scale(-1, 1);
                            break;
                        case 'scaleY':
                            this.croper.scale(1, -1);
                            break;
                        case 'rotate':
                            this.croper.rotate(option);
                            break;
                        case 'zoom':
                            this.croper.zoom(option);
                            break;
                        case 'enable':
                            this.croper.enable();
                            break;
                        case 'disable':
                            this.croper.disable();
                            break;
                        case 'destroy':
                            this.croper.destroy();
                            break;
                        case 'move':
                            let option2 = $app.safeVar($(obj).data("second-option"), 0);
                            this.croper.move(option, option2);
                            break;
                        case 'setAspectRatio':
                            this.croper.setAspectRatio(option);
                            break;
                    }
                } catch (err) {
                    $app.debug(err.message, true);
                }
            }
        },
    });
});