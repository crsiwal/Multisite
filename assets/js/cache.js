$(document).ready(function () {
    JSCache = function JSCache($app) {};
    $.extend(JSCache.prototype, {
        /**
         * 
         * @param {type} key
         * @param {type} response
         * @returns {unresolved}
         */
        set: function (key, response) {
            let cacheKey = this.getCacheKey(key);
            let storageData = {time: new Date(), res: response};
            $app.debug("Set Hash Cache Key: " + cacheKey);
            return $app.db.setTempNode(cacheKey, storageData);
        },
        /**
         * 
         * @param {type} key
         * @param {type} option
         * @returns {unresolved}
         */
        get: function (key, option) {
            let response = null;
            let cacheKey = this.getCacheKey(key);
            $app.debug("Get Hash Cache Key: " + cacheKey);
            let data = $app.db.getTempNode(cacheKey);
            if (data !== null) {
                let saveTime = $app.safeVar(data['time'], new Date());
                let timediffrence = $app.getTimeDiffrence(saveTime, new Date());
                let clearTime = ($app.isset(option, "cachetime") === true) ? option.cachetime : $app.getConfig("cache_clear_minutes");
                if (timediffrence < clearTime) {
                    response = $app.safeVar(data['res'], null);
                }
            }
            return response;
        },
        /**
         * 
         * @param {type} key
         * @returns {undefined}
         */
        remove: function (key) {
            let cacheKey = this.getCacheKey(key);
            $app.db.removeTempNode(cacheKey);
        },
        /**
         * 
         * @param {type} keys
         * @returns {undefined}
         */
        removeKeys: function (keys) {
            let that = this;
            if ($app.isArray(keys) === true) {
                $.each(keys, function (ind, key) {
                    that.remove(key);
                });
            }
        },
        /**
         * 
         * @returns {undefined}
         */
        clear: function () {
            $app.db.clearAllTempNodes();
        },
        /**
         * 
         * @param {type} key
         * @returns {String}
         */
        getCacheKey: function (key) {
            /**
             Key ->      "sitecache - Today Date - User Id - Blog Id"
             Example ->  "sitecache-2019-05-06-659-5248"
             **/
            let keyArray = [];
            let customkey = [];
            switch (key) {
                case 'user_blogslist':
                    customkey = ['date', 'user_id'];
                    break;
                default:
                    customkey = ['date', 'user_id', 'blog_id'];
                    break;
            }
            keyArray = this.getKeyValues(customkey, key);
            let mainKey = this.getJoinKey(keyArray);
            let cacheKey = 'cache-' + $app.hashCode(mainKey);
            $app.debug("Main Cache Key: " + mainKey + "  ---- Cache Key : " + cacheKey);
            return cacheKey;
        },
        /**
         * 
         * @returns {Array|cacheL#1.cacheAnonym$0.getConfigs.config}
         */
        getConfigs: function () {
            var config = [];
            config['user_id'] = $app.safeVar($app.getConfig('user_id'), -1);
            config['blog_id'] = $app.safeVar($app.getConfig('blog_id'), -1);
            return config;
        },
        /**
         * 
         * @param {type} keyArray
         * @returns {unresolved}
         */
        getJoinKey(keyArray) {
            return keyArray.join("-");
        },
        /**
         * 
         * @returns {Boolean}
         */
        clearCache: function () {
            let reserveKeys = this.getReserveKeys();
            let reservedData = {};
            let that = this;
            $.each(reserveKeys, function (index, keyname) {
                reservedData[keyname] = that.get(keyname);
            });
            this.clear();
            $.each(reservedData, function (key, value) {
                $app.db.setTempNode(key, value);
            });
            return true;
        },
        /**
         * 
         * @returns {Array}
         */
        getReserveKeys: function () {
            let reserveKey = ["testing"];
            return reserveKey;
        },
        /**
         * 
         * @param {type} customkey
         * @param {type} key
         * @returns {Array}
         */
        getKeyValues: function (customkey, key) {
            let config = this.getConfigs();
            let keyArray = [];
            $.each(customkey, function (i, keyname) {
                switch (keyname) {
                    case 'date':
                        keyArray.push($app.getDate());
                        break;
                    case 'user_id':
                        keyArray.push(config['user_id']);
                        break;
                    case 'blog_id':
                        keyArray.push(config['blog_id']);
                        break;
                }
            });
            keyArray.push(key);
            return keyArray;
        }
    });
});