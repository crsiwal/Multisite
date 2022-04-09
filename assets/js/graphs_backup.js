/* global moment, $app, echarts */

$(document).ready(function () {
    JSGraph = function JSGraph($app) {
        this.app = $app;
        this.color = [];
        this.colorSwitched = [];
        this.colorPie = [];
    };
    /* JS On page Script started */
    $.extend(JSGraph.prototype, {
        /**
         * 
         * @returns {undefined}
         */
        init: function () {
            this.setDefaultColors();
        },
        userFlow: function (id, node, links, config, callback) {
            if ($app.isArray(node) === true && $app.isArray(links) === true && links.length > 0) {
                var options = this.userFlowChartOption($app.safeVar(config, []));
                this.renderChart(id, options, 'userflow', {pages: node, links: links}, callback);
            } else {
                this.setBarEmpty(id);
            }
        },
        map: function (id, data, config, callback) {
            var options = this.mapOption($app.safeVar(config, []));
            if ($app.isArray(data) === true && data.length > 0) {
                this.renderChart(id, options, 'map', data, callback);
            } else {
                this.renderChart(id, options, 'map', [], callback);
            }
        },
        /**
         * 
         * @param {type} id
         * @param {type} data
         * @param {type} config
         * @returns {undefined}
         */
        pieChart: function (id, data, config, callback) {
            if ($app.isArray(data) === true && data.length > 0) {
                var options = this.pieChartOption($app.safeVar(config, []));
                this.renderChart(id, options, 'pie', data, callback);
            } else {
                this.setPieEmpty(id);
            }
        },
        /**
         * 
         * @param {type} id
         * @param {type} data
         * @param {type} config
         * @returns {undefined}
         */
        barChart: function (id, data, config, callback) {
            if ($app.isArray(data.data) === true && data.data.length > 0) {
                var options = this.barChartOption($app.safeVar(config, []), data);
                this.renderChart(id, options, 'bar', data.data, callback);
            } else {
                this.setBarEmpty(id);
            }
        },
        /**
         * 
         * @param {type} id
         * @param {type} data
         * @param {type} config
         * @returns {undefined}
         */
        multiBarChart: function (id, data, config, callback) {
            if ($app.isArray(data.data) === true && data.data.length > 0) {
                var options = this.barChartOption($app.safeVar(config, []), data);
                this.renderChart(id, options, 'multibar', data.data, callback);
            } else {
                this.setBarEmpty(id);
            }
        },
        /**
         * 
         * @param {type} id
         * @param {type} data
         * @param {type} config
         * @returns {undefined}
         */
        barShadowChart: function (id, data, config, callback) {
            if ($app.isArray(data.data) === true && data.data.length > 0) {
                var options = this.barChartOption($app.safeVar(config, []), data);
                this.renderChart(id, options, 'bar-shadow', data, callback);
            } else {
                this.setBarEmpty(id);
            }
        },
        stackBarChart: function (id, data, config, callback) {
            if ($app.isArray(data.data) === true && $app.getLength(data.data, true) > 0) {
                var options = this.barChartOption($app.safeVar(config, []), data);
                this.renderChart(id, options, 'stackbar', data, callback);
            } else {
                this.setBarEmpty(id);
            }
        },
        stackBarLineChart: function (id, data, config, callback) {
            if ($app.isArray(data.data) === true && $app.getLength(data.data, true) > 0) {
                var options = this.barChartOption($app.safeVar(config, []), data);
                this.renderChart(id, options, 'stackbarline', data, callback);
            } else {
                this.setBarEmpty(id);
            }
        },
        /**
         * 
         * @param {type} id
         * @param {type} data
         * @param {type} config
         * @param {type} callback
         * @returns {undefined}
         */
        lineGraph: function (id, data, config, callback) {
            if ($app.isArray(data.data) === true && $app.getLength(data.data) > 0) {
                var options = this.lineChartOption($app.safeVar(config, []), data);
                this.renderChart(id, options, 'line', data, callback);
            } else {
                this.setBarEmpty(id);
            }
        },
        multiLineGraph: function (id, data, config, callback) {
            if ($app.isArray(data.data) === true && $app.getLength(data.data) > 0) {
                var options = this.lineChartOption($app.safeVar(config, []), data);
                this.renderChart(id, options, 'multiline', data, callback);
            } else {
                this.setBarEmpty(id);
            }
        },
        funnel: function (id, funneldataArray, config, callback) {
            $app.debug(funneldataArray, true);
            if ($app.isArray(funneldataArray) === true && $app.getLength(funneldataArray) > 0) {
                var options = this.funnelChartOption($app.safeVar(config, []), funneldataArray);
                this.renderChart(id, options, 'funnel', funneldataArray, callback);
            } else {
                this.setBarEmpty(id);
            }
        },
        funnelChartOption: function (config, data) {
            var funnelChartOption = {
                tooltip: {
                    trigger: 'item',
                    formatter: "Name: {b} <br> Count: {c}<br>Percentage: {d}%"
                },
                series: [
                    {
                        name: 'hoverlist',
                        type: 'funnel',
                        left: '10%',
                        width: '80%',
                        sort: 'none',
                        gap: 2,
                        label: {
                            show: false
                        },
                        labelLine: {
                            show: false
                        },
                        itemStyle: {
                            normal: {
                                opacity: 0.6
                            }
                        },
                        data: []
                    },
                    {
                        name: 'Conversion',
                        type: 'funnel',
                        left: '10%',
                        width: '80%',
                        maxSize: '80%',
                        sort: 'none',
                        gap: 2,
                        label: {
                            position: 'inside',
                            formatter: '{b}',
                            textStyle: {
                                color: '#fff'
                            },
                            fontWeight: 'bold'
                        },
                        emphasis: {
                            label: {
                                formatter: '{c}',
                                fontSize: 20
                            }
                        },
                        itemStyle: {
                            normal: {
                                opacity: 0.5,
                                borderColor: '#fff',
                                borderWidth: 2
                            }
                        },
                        data: []
                    }
                ],
                color: (($app.isUndefined(config.color) !== true && $app.isArray(config.color)) ? config.color : this.color)
            };
            return funnelChartOption;
        },
        lineChartOption: function (config, data) {
            var lineChartOption = {
                tooltip: {
                    show: (($app.isUndefined(config['showtooltip']) === true) ? true : config.showtooltip),
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(241, 241, 241, 0.3)'
                        }
                    },
                    formatter: (($app.isUndefined(config.formatter) === true) ? false : config.formatter),
                    padding: [5, 10],
                    textStyle: {
                        fontWeight: (($app.isUndefined(config.fontWeight) === true) ? 'normal' : config.fontWeight)
                    },
                    extraCssText: 'box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.3);border-radius: 1px;'
                },
                legend: {
                    show: (($app.isUndefined(config.legendshow) === true) ? true : config.legendshow),
                    borderColor: '#000000',
                    type: 'scroll',
                    padding: [0, 100]
                },
                xAxis: {
                    data: $app.safeVar(data.keynames, []),
                    show: (($app.isUndefined(config.xaxisshow) === true) ? true : config.xaxisshow),
                    axisTick: {
                        show: (($app.isUndefined(config.xaxisTick) === true) ? false : config.xaxisTick)
                    },
                    axisLine: {
                        lineStyle: {
                            opacity: (($app.isUndefined(config.xaxisLineopacity) === true) ? 0.05 : config.xaxisLineopacity)
                        }
                    }
                },
                yAxis: {
                    show: (($app.isUndefined(config.yaxisshow) === true) ? true : config.yaxisshow),
                    splitLine: {
                        show: (($app.isUndefined(config.ysplitLineshow) === true) ? true : config.ysplitLineshow),
                        lineStyle: {
                            opacity: 0.4
                        }
                    },
                    axisTick: {
                        show: (($app.isUndefined(config.yaxisTick) === true) ? false : config.yaxisTick)
                    },
                    axisLine: {
                        lineStyle: {
                            opacity: (($app.isUndefined(config.yaxisLineopacity) === true) ? 0 : config.yaxisLineopacity)
                        }
                    },
                    minInterval: 1
                },
                grid: {
                    left: (($app.isUndefined(config.grid_left) === true) ? 50 : config.grid_left),
                    top: (($app.isUndefined(config.grid_top) === true) ? 25 : config.grid_top),
                    right: (($app.isUndefined(config.grid_right) === true) ? 25 : config.grid_right),
                    bottom: (($app.isUndefined(config.grid_bottom) === true) ? 25 : config.grid_bottom),
                    containLabel: true
                },
                series: {
                    areaStyleType: (($app.isUndefined(config.areaStyleType) === true) ? false : config.areaStyleType),
                    smoothLine: (($app.isUndefined(config.smoothLine) === true) ? false : config.smoothLine),
                    showSymbol: (($app.isUndefined(config.showSymbol) === true) ? true : config.showSymbol)
                },
                color: (($app.isUndefined(config.color) !== true && $app.isArray(config.color)) ? config.color : this.color)
            };
            return lineChartOption;
        },
        /**
         * 
         * @param {type} config
         * @param {type} data
         * @returns {js_page_graphsL#3.js_page_graphsAnonym$0.barChartOption.barChartOption}
         */
        barChartOption: function (config, data) {
            var formatOption = {};
            if ($app.safeVar(config.format, 'vertical') === 'horizontal') {
                formatOption['grid'] = {left: '1%', right: '3%', bottom: '1%', top: 25, containLabel: true};
                formatOption['xAxis'] = {type: 'value', boundaryGap: [0, 0.01], splitLine: {show: false}, axisTick: {show: false}, axisLine: {lineStyle: {opacity: 0.2}}};
                formatOption['yAxis'] = {type: 'category', data: $app.safeVar(data.keynames, []), axisTick: {show: false}, axisLine: {lineStyle: {opacity: 0.2}}};
                formatOption['color'] = (($app.isUndefined(config.color) !== true && $app.isArray(config.color)) ? config.color : this.colorPie);
            } else {
                formatOption['grid'] = {left: 50, right: 25, bottom: 25, top: 25};
                formatOption['xAxis'] = {data: $app.safeVar(data.keynames, []), axisTick: {show: (($app.isUndefined(config.xaxisTick) === true) ? false : config.xaxisTick)}, axisLine: {lineStyle: {opacity: 0.2}}};
                formatOption['yAxis'] = {
                    axisLabel: {
                        formatter: (($app.isUndefined(config.yaxisformatter) === true) ? "{value}" : "{value}" + config.yaxisformatter)
                    },
                    splitLine: {
                        show: (($app.isUndefined(config.splitLine) === true) ? false : config.splitLine)
                    },
                    axisTick: {
                        show: (($app.isUndefined(config.yaxisTick) === true) ? false : config.yaxisTick)
                    },
                    axisLine: {
                        lineStyle: {
                            opacity: (($app.isUndefined(config.yaxislineStyle) === true) ? 0.2 : config.yaxislineStyle)
                        }
                    },
                    minInterval: 1
                };
                formatOption['color'] = (($app.isUndefined(config.color) !== true && $app.isArray(config.color)) ? config.color : this.color);
            }
            formatOption['seriesconfig'] = {
                type: "bar",
                barGap: $app.safeVar(config.barWidth, "25%"),
                stack: $app.safeVar(config.stack, 'bl1'),
                barWidth: $app.safeVar(config.barWidth, '15%')
            };
            var barChartOption = {
                tooltip: {
                    show: (($app.isUndefined(config['showtooltip']) === true) ? true : config.showtooltip),
                    trigger: (($app.isUndefined(config['showsingle']) === true) ? 'axis' : 'item'),
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(241, 241, 241, 0.3)'
                        }
                    },
                    formatter: (($app.isUndefined(config.formatter) === true) ? false : config.formatter),
                    padding: [5, 10],
                    textStyle: {
                        fontWeight: (($app.isUndefined(config.fontWeight) === true) ? 'normal' : config.fontWeight)
                    },
                    extraCssText: 'box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.3);border-radius: 1px;'
                },
                legend: (($app.isUndefined(config.showLegend) === true) ? {borderColor: '#fff', type: 'scroll', icon: "circle", padding: [0, 100]} : config.showLegend),
                xAxis: formatOption.xAxis,
                yAxis: formatOption.yAxis,
                grid: formatOption.grid,
                series: formatOption.seriesconfig,
                color: formatOption.color
            };
            return barChartOption;
        },
        /**
         * 
         * @param {type} config
         * @returns {js_page_graphsL#3.js_page_graphsAnonym$0.pieChartOption.pieChartOption}
         */
        pieChartOption: function (config) {
            var pieChartOption = {
                legend: {
                    show: (($app.isUndefined(config['showlegend']) === true) ? true : config.showlegend),
                    type: 'scroll',
                    icon: "circle",
                    orient: 'vertical',
                    borderColor: '#000000',
                    x: 'left',
                    y: 'center'
                },
                tooltip: {
                    show: (($app.isUndefined(config['showtooltip']) === true) ? true : config.showtooltip),
                    trigger: 'item',
                    formatter: (($app.isUndefined(config.formatter) === true) ? "{b}<br />{c}" : config.formatter),
                    extraCssText: 'box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.3);border-radius: 1px;'
                },
                series: [
                    {
                        name: 'piechart',
                        type: 'pie',
                        radius: ['55%', '80%'],
                        center: (($app.isUndefined(config['position']) === true) ? ['60%', '50%'] : config.position),
                        avoidLabelOverlap: false,
                        hoverAnimation: (($app.isUndefined(config['hoveranimation']) === true) ? true : config.showtooltip),
                        label: {
                            normal: {
                                show: false,
                                position: 'center'
                            },
                            emphasis: {
                                show: true,
                                formatter: '{d}{sub|%}',
                                textStyle: {
                                    fontSize: (($app.isUndefined(config['fontsize']) === true) ? "18" : config.fontsize),
                                    fontWeight: 'normal'
                                },
                                rich: {
                                    sub: {
                                        fontSize: '10'
                                    }
                                }
                            }
                        },
                        labelLine: {
                            normal: {
                                show: false
                            }
                        },
                        data: []
                    }
                ],
                color: (($app.isUndefined(config.color) === false && $app.isArray(config.color) === true) ? config.color : this.colorPie)
            };
            return pieChartOption;
        },
        /**
         * 
         * @param {type} config
         * @returns {js_page_graphsL#3.js_page_graphsAnonym$0.userFlowChartOption.userFlowChartOption}
         */
        userFlowChartOption: function (config) {
            var userFlowChartOption = {
                tooltip: {
                    show: true,
                    formatter: "{b}<br>{c}",
                    trigger: 'item',
                    triggerOn: 'mousemove',
                    padding: 15,
                    extraCssText: 'box-shadow: 0 2px 6px 0 #eee;border-radius: 5px;'
                },
                series: {
                    name: 'userflow',
                    type: 'sankey',
                    layout: 'none',
                    left: 35,
                    top: 25,
                    right: 150,
                    bottom: 25,
                    focusNodeAdjacency: true,
                    nodeWidth: 50,
                    itemStyle: {
                        normal: {
                            borderWidth: 0
                        }
                    },
                    lineStyle: {
                        normal: {
                            color: 'source',
                            opacity: 0.3,
                            curveness: 0.5
                        }
                    },
                    data: [],
                    links: []
                },
                color: (($app.isUndefined(config.color) !== false && $app.isArray(config.color) === true) ? config.color : this.colorPie)
            };
            return userFlowChartOption;
        },
        mapOption: function (config) {
            let scale = (($app.isUndefined(config['scale']) === true) ? "india" : config.scale);
            let mapdata = (scale === "world") ? world_data : india_data;
            this.addCountry(scale, mapdata);
            let mapOption = {
                tooltip: {
                    show: true,
                    trigger: 'item',
                    triggerOn: 'mousemove',
                    padding: 15,
                    extraCssText: 'box-shadow: 0 2px 6px 0 #eee;border-radius: 5px;',
                    formatter: function (params) {
                        let name = $app.safeVar(params.name, "");
                        let value = isNaN($app.safeVar(params.value, 0)) ? 0 : params.value;
                        if (value > 0) {
                            if (scale === "world") {
                                return `<center><p>${name}</p><p>${value}</p></center>`;
                            } else {
                                return `<center><p>${name}</p><p>${value}</p></center>`;
                            }
                        } else {
                            if (scale === "world") {
                                return `<center><p>${name}</p></center>`;
                            } else {
                                return `<center><p>${name}</p></center>`;
                            }
                        }
                    }
                },
                geo: {
                    aspectScale: 1
                },
                visualMap: {
                    show: false,
                    min: 0,
                    max: (($app.isUndefined(config['maxvalue']) === true) ? 1 : config.maxvalue),
                    left: "right",
                    top: 'bottom',
                    text: ['High', 'Low'],
                    calculable: true,
                    inRange: {color: ['#e8f0fc', '#d2e2f9', '#bbd3f6', '#a5c4f3', '#8eb5f0', '#78a7ed', '#6198ea', '#5a93ea', '#4a89e8', '#347be5', '#1d6ce2', '#1a61cb', '#1756b5', '#154c9e', '#124187', '#0f3671', '#0c2b5a']}
                },
                series: [
                    {
                        type: "map",
                        map: scale,
                        roam: true,
                        selectedMode: 'multiple',
                        left: (scale === "world") ? '1%' : '15%',
                        right: (scale === "world") ? '1%' : '15%',
                        top: 0,
                        bottom: 0,
                        data: []
                    }
                ]
            };
            return mapOption;
        },
        addCountry: function (name, data) {
            (function (root, factory) {
                if (typeof define === "function" && define.amd) {
                    // AMD. Register as an anonymous module.
                    define(["exports", "echarts"], factory);
                } else if (typeof exports === "object" && typeof exports.nodeName !== "string") {
                    // CommonJS
                    factory(exports, require("echarts"));
                } else {
                    // Browser globals
                    factory({}, window.echarts);
                }
            })(this, function (exports, echarts) {
                var log = function (msg) {
                    if (typeof console !== "undefined") {
                        console && console.error && console.error(msg);
                    }
                };
                if (!window.echarts) {
                    log("ECharts is not Loaded");
                    return;
                }
                if (!window.echarts.registerMap) {
                    log("ECharts Map is not loaded");
                    return;
                }
                window.echarts.registerMap(name, data);
            });
        },
        /**
         * Example of call this function
         * this.renderChart("element id", pieChartOption, 'pie', [
         *    {value: 335, name: 'WiFi'},
         *    {value: 310, name: '4G'},
         *    {value: 234, name: '3G'},
         *    {value: 135, name: '2G'}
         * ]);
         * 
         * @param {type} element
         * @param {type} chartOption
         * @param {type} chartType
         * @param {type} dataArray
         * @param {type} callback
         * @returns {undefined}
         */
        renderChart: function (element, chartOption, chartType, dataArray, callback) {
            this.distroyGraph(element);
            let chart = window.echarts.init($("#" + element)[0]);
            let option = (chartType === 'map') ? chartOption : JSON.parse(JSON.stringify(chartOption));
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            try {
                if (chartType === 'bar') {
                    let dataSeries = [];
                    dataSeries.push({
                        name: "",
                        type: 'bar',
                        data: dataArray,
                        barWidth: option.series.barWidth
                    });
                    option.series = dataSeries;
                } else if (chartType === 'multibar') {
                    let dataSeries = [];
                    if ($app.isArray(dataArray) === true) {
                        $.each(dataArray, function (inx, chartData) {
                            dataSeries.push({
                                name: $app.safeVar(chartData.name, "Unknown"),
                                type: 'bar',
                                //stack: option.series.stack,
                                barGap: option.series.barGap,
                                data: $app.safeVar(chartData.value, []),
                                barWidth: option.series.barWidth
                            });
                        });
                    }
                    option.series = dataSeries;
                } else if (chartType === 'line') {
                    let lineSeries = {
                        name: "Line Graph",
                        data: $app.safeVar(dataArray.data, []),
                        smooth: option.series.smoothLine,
                        showSymbol: option.series.showSymbol,
                        type: 'line',
                        symbol: "circle",
                        symbolSize: 10,
                        lineStyle: {
                            width: 3.5,
                            opacity: 1,
                            type: "solid"
                        }
                    };
                    if (option.series.areaStyleType !== false) {
                        lineSeries['areaStyle'] = {type: option.series.areaStyleType};
                    }
                    option.series = [lineSeries];
                } else if (chartType === 'multiline') {
                    let dataSeries = [];
                    if ($app.isArray(dataArray.data) === true) {
                        $.each(dataArray.data, function (inx, chartData) {
                            dataSeries.push({
                                name: $app.safeVar(chartData.name, "Unknown"),
                                data: $app.safeVar(chartData.value, []),
                                type: 'line',
                                smooth: true,
                                symbol: "circle",
                                symbolSize: 10,
                                lineStyle: {
                                    width: 3.5,
                                    opacity: 1,
                                    type: "solid"
                                }
                            });
                        });
                    }
                    option.series = dataSeries;
                } else if (chartType === 'bar-shadow') {
                    let datavalues = $app.safeVar(dataArray.data, []);
                    let maxvalue = $app.safeVar(Math.max.apply(null, datavalues), 1000);
                    if (maxvalue > 1000) {
                        maxvalue = (Math.round(maxvalue / 1000) * 1000) + 1000;
                    } else if (maxvalue > 100) {
                        maxvalue = (Math.round(maxvalue / 100) * 100) + 100;
                    } else {
                        maxvalue = 100;
                    }
                    var dataSeries = [];
                    dataSeries.push({
                        name: '',
                        type: 'bar',
                        barWidth: '15%',
                        barGap: '-100%',
                        data: $app.safeVar(Array(datavalues.length).fill(maxvalue), []),
                        silent: true,
                        itemStyle: {
                            normal: {color: '#dddddd'}
                        }
                    });
                    dataSeries.push({
                        name: '',
                        type: 'bar',
                        barWidth: '15%',
                        data: datavalues,
                        itemStyle: {
                            normal: {color: '#47aab8'}
                        }
                    });
                    option.series = dataSeries;
                } else if (chartType === 'stackbar') {
                    let barSeries = [];
                    let datavalues = $app.safeVar(dataArray.data, []);
                    for (var seriesname in datavalues) {
                        if (datavalues.hasOwnProperty(seriesname)) {
                            barSeries.push({
                                name: seriesname,
                                type: 'bar',
                                stack: option.series.stack,
                                barWidth: option.series.barWidth,
                                data: datavalues[seriesname]
                            });
                        }
                    }
                    option.series = barSeries;
                } else if (chartType === 'stackbarline') {
                    let barSeries = [];
                    let datavalues = $app.safeVar(dataArray.data, []);
                    let objectLength = $app.getLength(datavalues);
                    let loop = 0;
                    let totalArray = false;
                    for (var seriesname in datavalues) {
                        if (datavalues.hasOwnProperty(seriesname)) {
                            if ($app.lowercase(seriesname) === "total") {
                                totalArray = {
                                    name: seriesname,
                                    type: 'line',
                                    smooth: true,
                                    symbol: "circle",
                                    symbolSize: 10,
                                    lineStyle: {
                                        width: 2.5,
                                        opacity: 1,
                                        type: "solid"
                                    },
                                    data: datavalues[seriesname]
                                };
                            } else {
                                barSeries.push({
                                    name: seriesname,
                                    type: 'bar',
                                    stack: option.series.stack,
                                    barWidth: option.series.barWidth,
                                    data: datavalues[seriesname]
                                });
                            }
                            if (++loop === objectLength && totalArray !== false) {
                                barSeries.push(totalArray);
                            }
                        }
                    }
                    option.series = barSeries;
                } else if (chartType === 'pie') {
                    option.series[0].data = dataArray;
                } else if (chartType === 'shadow') {
                    option.series[1].name = dataArray.name;
                    option.series[1].data = dataArray.value;
                } else if (chartType === 'line-dashed') {
                    for (let index = 0; index <= dataArray.length; index = index + 2) {
                        if (index % 2 === 0 && index > 0) {
                            var dataIndex = index - 1;
                        } else {
                            var dataIndex = index;
                        }
                        option.series[index + 1].name = dataArray[dataIndex].name;
                        option.series[index + 1].data = dataArray[dataIndex].value;
                        option.series[index + 1].stack = dataArray[dataIndex].name;
                        option.series[index + 1].lineStyle.type = "dashed";
                        option.series[index].name = dataArray[dataIndex].name;
                        option.series[index].data = dataArray[dataIndex].value.pop();
                        option.series[index].stack = dataArray[dataIndex].name;
                    }
                } else if (chartType === 'userflow') {
                    option.series['data'] = $app.safeVar(dataArray.pages, []);
                    option.series['links'] = $app.safeVar(dataArray.links, []);
                } else if (chartType === 'funnel') {
                    let funnelData = $app.safeVar(dataArray, []);
                    option.series[0]['data'] = funnelData;
                    option.series[1]['data'] = funnelData;
                } else if (chartType === 'map') {
                    let mapData = $app.safeVar(dataArray, []);
                    option.series[0].data = mapData;
                }
                chart.setOption(option, true);
                if (callback !== false) {
                    callback(chart);
                }
            } catch (err) {
                console.error(err);
            }
        },
        resize: function () {
            $(".echarts-chart").each(function () {
                let graphid = $(this).attr('_echarts_instance_');
                let id = $(this).attr('id');
                if ($app.idExist(id) === true) {
                    try {
                        window.echarts.getInstanceById(graphid).resize();
                    } catch (err) {
                        $app.debug(err.message);
                    }
                }
            });
        },
        distroyGraph: function (gid) {
            gid = $app.safeVar(gid, false);
            if (gid !== false && $app.idExist(gid) === true) {
                let gobj = $("#" + gid);
                var id = gobj.attr('_echarts_instance_');
                id = $app.safeVar(id, false);
                if (id !== false) {
                    try {
                        window.echarts.getInstanceById(id).dispose();
                    } catch (err) {
                        $app.debug(err.message);
                    }
                }
            }
        },
        distroyAllGraphs: function () {
            var that = this;
            $(".echarts-chart").each(function () {
                var id = $(this).attr('_echarts_instance_');
                id = that.app.safeVar(id, false);
                if (id !== false) {
                    try {
                        window.echarts.getInstanceById(id).dispose();
                    } catch (err) {
                        $app.debug(err.message);
                    }
                }
            });
        },
        setDefaultColors: function () {
            this.color = ['#4ab1c0', '#ef769b', '#8c9ae6', '#f8c04c'];
            this.colorSwitched = ['#ef769b', '#4ab1c0'];
            this.colorPie = ['#8c9ae6', '#ef769b', '#f8c04c', '#47aab8', '#b8ea83', '#ff825c', '#d486ff', '#9ecee9', '#fff298', '#ffadad'];
        },
        callToDrawUserFlow(response, id, config, apikey) {
            if ($app.idExist(id) === true) {
                var node = $app.safeVar(response.data[apikey].nodes, []);
                var links = $app.safeVar(response.data[apikey].links, []);
                this.userFlow(id, node, links, config);
            }
        },
        setUserFlowNodeInList: function (response, id, apikey) {
            if ($app.idExist(id) === true) {
                var node = $app.safeVar(response.data[apikey].nodes, []);
                var list = [];
                $.each(node, function (ind, value) {
                    list.push(value.name);
                });
                node = $app.sortArray(list);
                $app.debug(node);
                this.setUFListFromArray(id, node);
            }
        },
        setUFListFromArray: function (id, node) {
            if (node.length > 0) {
                let html = '<a class="dropdown-item" data-page="-1" href="#">All Page</a>';
                $.each(node, function (ind, nodename) {
                    html += '<a class="dropdown-item" data-page="' + nodename + '" href="#">' + nodename + '</a>';
                });
                $app.sethtml(id, html);
            }
        },
        /**
         * 
         * @param {type} response
         * @param {type} id
         * @param {type} config
         * @param {type} apikey
         * @param {type} dataobj
         * @param {type} keyname
         * @param {type} key
         * @param {type} value
         * @returns {undefined}
         */
        callToDrawStackBarChart: function (response, id, config, apikey, dataobj, keyname, key, value, callback) {
            if ($app.idExist(id) === true) {
                let data = $app.safeVar(response.data[apikey][dataobj], []);
                let graphdata = this.filterForStackBarChart(data, config, keyname, key, value);
                this.stackBarChart(id, graphdata, config, callback);
            }
        },
        callToDrawStackBarWithLineChart: function (response, id, config, apikey, dataobj, keyname, key, value, callback) {
            if ($app.idExist(id) === true) {
                let data = $app.safeVar(response.data[apikey][dataobj], []);
                let graphdata = this.filterForStackBarChart(data, config, keyname, key, value);
                this.stackBarLineChart(id, graphdata, config, callback);
            }
        },
        callToDrawBarChart: function (response, id, config, apikey, dataobj, keyname, key, value, callback) {
            if ($app.idExist(id) === true) {
                let data = $app.safeVar(response.data[apikey][dataobj], []);
                let graphdata = this.filterForBarChart(data, config, keyname, key, value);
                this.barChart(id, graphdata, config, callback);
            }
        },
        /**
         * 
         * @param {type} response
         * @param {type} id
         * @param {type} config
         * @param {type} apikey
         * @param {type} dataobj
         * @param {type} key
         * @param {type} value
         * @returns {undefined}
         */
        callToDrawBarShadow: function (response, id, config, apikey, dataobj, key, value) {
            if ($app.idExist(id) === true) {
                let data = $app.safeVar(response.data[apikey][dataobj], []);
                let graphdata = this.filterForBarShadowChartData(data, config, key, value);
                this.barShadowChart(id, graphdata, config);
                $app.debug(graphdata, true);
            }
        },
        /**
         * 
         * @param {type} response
         * @param {type} id
         * @param {type} config
         * @param {type} apikey
         * @param {type} dataobj
         * @param {type} key
         * @param {type} value
         * @param {type} maxrecord
         * @returns {undefined}
         */
        callToDrawPieGraph(response, id, config, apikey, dataobj, key, value, maxrecord, callback) {
            if ($app.idExist(id) === true) {
                var tmpdata = $app.safeVar(response.data[apikey][dataobj], []);
                var data = this.filterForPieData(tmpdata, key, value, maxrecord);
                this.pieChart(id, data, config, callback);
            }
        },
        /**
         * 
         * @param {type} response
         * @param {type} id
         * @param {type} config
         * @param {type} apikey
         * @param {type} dataobj
         * @param {type} key
         * @param {type} value
         * @param {type} callback
         * @returns {undefined}
         */
        callToDrawLineGraph(response, id, config, apikey, dataobj, key, value, callback) {
            if ($app.idExist(id) === true) {
                var tmpdata = ($app.isset(response.data[apikey], 'series') === true && response.data[apikey]['series'] !== null) ? $app.safeVar(response.data[apikey]['series'][dataobj], []) : [];
                var data = this.filterForLineGraphData(tmpdata, key, value);
                this.lineGraph(id, data, config, callback);
            }
        },
        callToDrawMultiLineGraph: function (response, id, config, apikey, dataobj, key, value, callback) {
            var data = $app.safeVar(response.data[apikey][dataobj], []);
            var datakeys = $app.safeVar(config.keys);
            var dataname = $app.safeVar(config.name);
            var that = this;
            var count = 0;
            var chartData = {keynames: [], data: []};
            if ($app.isArray(datakeys) === true) {
                $.each(datakeys, function (index, keyname) {
                    var dataValue = that.app.safeVar(data[keyname]);
                    var tmpvalue = [];
                    $.each(dataValue, function (ind, row) {
                        if (count === 0) {
                            chartData.keynames.push($.trim(that.app.safeVar(row[key], 'unknown')));
                        }
                        tmpvalue.push($.trim(that.app.safeVar(row[value], 0)));
                    });
                    chartData.data.push({value: tmpvalue, name: dataname[index]});
                    count++;
                });
            }
            this.multiLineGraph(id, chartData, config, callback);
        },
        callToDrawMultiUserflow: function (response, id, config, apikey, dataobj, key, value, callback) {
            var funnelList = $app.safeVar(response.data[apikey][dataobj], []);
            var that = this;
            if ($app.isArray(funnelList) === true && $app.getLength(funnelList) > 0) {
                $("#funnelloading").addClass("hidden");
                $.each(funnelList, function (index, funnel) {
                    let funnelData = $app.safeVar(funnel.data);
                    if ($app.isArray(funnelData) === true && $app.getLength(funnelData) > 0) {
                        let funnelId = $app.safeVar(funnel.id);
                        let funnelName = $app.safeVar(funnel.name);
                        let htmlid = $app.randomString(8);
                        let graphData = that.filterFunnelData(funnelData, key, value);
                        let funnelHtml = $("#funnelhtml").html();
                        let funnelLayout = (index % 2 === 0) ? "right" : "left";
                        try {
                            funnelHtml = $app.replace(funnelHtml, "{funnel_name}", funnelName);
                            funnelHtml = $app.replace(funnelHtml, "{funnel_id}", funnelId);
                            funnelHtml = $app.replace(funnelHtml, "{funnel_layout}", funnelLayout);
                            funnelHtml = $app.replace(funnelHtml, "{funnel_html_id}", htmlid);
                        } catch (err) {
                            $app.debug(err.message, true);
                        }
                        $app.sethtml(id, funnelHtml, true);
                        that.funnel(htmlid, graphData, config, callback);
                    }
                });
            } else {
                $("#funnelloading").addClass("hidden");
                this.setUserFlowEmpty(id, true);
            }
            /*var data = this.filterForPieData(tmpdata, key, value, maxrecord);
             $app.debug(data);
             this.pieChart(id, data, config);*/
        },
        callToDrawHtmlBlock: function (response, id, apikey, htmldataid, dataKeyArray, viewmore, max) {
            let dataList = $app.safeVar(response.data[apikey], []);
            max = $app.safeVar(max, 20);
            dataKeyArray = $app.safeVar(dataKeyArray, []);
            if ($app.isArray(dataList) === true && $app.getLength(dataList) > 0) {
                $.each(dataList, function (index, row) {
                    if (index < max) {
                        let tmpHtml = $app.gethtml(htmldataid);
                        let layout = (index % 3 === 0) ? "gutter-right" : ((index % 3 === 1) ? "gutter-right gutter-left" : "gutter-left");
                        tmpHtml = $app.replace(tmpHtml, "{layout_class}", layout);
                        $.each(dataKeyArray, function (tmpkey, expression) {
                            let datavalue = ($app.isset(row, tmpkey) === true) ? $app.safeVar(row[tmpkey], false) : false;
                            switch (tmpkey) {
                                case 'date':
                                    datavalue = $app.dateFormat(datavalue);
                                    break;
                                case 'logo':
                                    datavalue = $.trim(datavalue);
                                    datavalue = (datavalue !== false && datavalue !== "") ? datavalue : $app.icon_url("blogger.png");
                                    break;
                                case 'time':
                                    datavalue = $app.formatAsTime(datavalue);
                                    break;
                            }
                            if (datavalue !== false) {
                                tmpHtml = $app.replace(tmpHtml, '{' + expression + '}', datavalue);
                            }
                        });
                        $app.sethtml(id, tmpHtml, true);
                    } else {
                        $app.show(viewmore);
                        return false;
                    }
                });
            } else {
                this.setUserFlowEmpty(id, true);
            }
        },
        /**
         * 
         * @param {type} respon
         * @param {type} countid
         * @param {type} capikey
         * @param {type} cdataobj
         * @param {type} defaultvalue
         * @returns {undefined}
         */
        callToSetFirstName(respon, countid, capikey, cdataobj, defaultvalue) {
            if ($app.idExist(countid) === true) {
                let tmpvalue = defaultvalue = $app.safeVar(defaultvalue, "Unknown");
                if ($app.isArray(respon.data[capikey].data) === true && $app.isset(respon.data[capikey].data, 0) === true) {
                    tmpvalue = $app.safeVar(respon.data[capikey].data[0][cdataobj], defaultvalue);
                    if ($app.lowercase(tmpvalue) === "other" && $app.isset(respon.data[capikey].data, 1) === true) {
                        tmpvalue = $app.safeVar(respon.data[capikey].data[1][cdataobj], defaultvalue);
                    }
                }
                $app.numberFormat(tmpvalue, true, countid);
            }
        },
        /**
         * 
         * @param {type} cres
         * @param {type} countid
         * @param {type} capikey
         * @param {type} cdataobj
         * @param {type} defaultvalue
         * @param {type} format
         * @returns {undefined}
         */
        callToSetNumberCount(cres, countid, capikey, cdataobj, defaultvalue, format) {
            if ($app.idExist(countid) === true) {
                defaultvalue = $app.safeVar(defaultvalue, 0);
                let countvalue = $app.safeVar(cres.data[capikey][cdataobj], defaultvalue);
                switch (format) {
                    case 'hour':
                        countvalue = $app.formatAsTime(countvalue, 'hour');
                        break;
                    case 'minute':
                        countvalue = $app.formatAsTime(countvalue, 'minute');
                        break;
                    case 'days':
                        countvalue = $app.formatAsTime(countvalue, 'days');
                        break;
                }
                $app.numberFormat(countvalue, true, countid);
            }
        },
        /**
         * 
         * @param {type} cres
         * @param {type} countid
         * @param {type} capikey
         * @param {type} cdataobj
         * @param {type} defaultvalue
         * @returns {undefined}
         */
        callToSetNumberChange(cres, htmlid, capikey, cdataobj) {
            if ($app.idExist(htmlid) === true) {
                $app.sethtml(htmlid, "");
                let changeValue = parseInt($app.safeVar(cres.data[capikey][cdataobj], 0), 10);
                let html = "";
                if (changeValue < 0) {
                    html = `<span class="pink">(<i class="fas fa-caret-down"></i> ${Math.abs(changeValue)}%)</span>`;
                } else if (changeValue > 0) {
                    html = `<span class="blue">(<i class="fas fa-caret-up"></i> ${Math.abs(changeValue)}%)</span>`;
                }
                $app.sethtml(htmlid, html);
            }
        },
        /**
         * 
         * @param {type} res
         * @param {type} objid
         * @param {type} thiskey
         * @param {type} thisobj
         * @param {type} comkey
         * @param {type} comobj
         * @param {type} dvalue
         * @param {type} template
         * @returns {undefined}
         */
        callToSetPercentage(res, objid, thiskey, thisobj, comkey, comobj, dvalue, template) {
            if ($app.idExist(objid) === true) {
                var thisvalue = $app.safeVar(res.data[thiskey][thisobj], dvalue);
                var comparevalue = $app.safeVar(res.data[comkey][comobj], dvalue);
                var compareresult = $app.percentage(comparevalue, thisvalue);
                var htmlstring = template.replace("----", compareresult);
                $app.debug(htmlstring, true);
                $app.sethtml(objid, htmlstring);
            }
        },
        setListClear: function (idList, removeAll) {
            if ($app.isArray(idList) === true) {
                $.each(idList, function (key, id) {
                    if ($app.idExist(id) === true) {
                        if (removeAll === true) {
                            $app.sethtml(id, "");
                        } else {
                            $('#' + id + ' a:not(:first-child)').remove();
                            $app.set("crtcamp_pb", $app.get("crtcamp_pb option:first"));
                            let btnId = "btn_" + id;
                            if ($app.idExist(btnId)) {
                                $app.sethtml("btn_" + id, $('#' + id + ' a:first-child').text());
                            }
                        }
                    }
                });
            }
        },
        setGraphLoding: function (idList) {
            if ($app.isArray(idList) === true) {
                var that = this;
                $.each(idList, function (key, id) {
                    if ($app.idExist(id) === true) {
                        that.setLoding(id);
                    }
                });
            }
        },
        setPieLoding: function (idList) {
            if ($app.isArray(idList) === true) {
                var that = this;
                $.each(idList, function (key, id) {
                    if ($app.idExist(id) === true) {
                        that.setLoding(id, 'pie');
                    }
                });
            }
        },
        setTableLoding: function (idList) {
            if ($app.isArray(idList) === true) {
                var that = this;
                $.each(idList, function (key, id) {
                    if ($app.idExist(id) === true) {
                        that.setLoding(id);
                    }
                });
            }
        },
        setCountLoding: function (idList) {
            if ($app.isArray(idList) === true) {
                $.each(idList, function (key, id) {
                    if ($app.idExist(id) === true) {
                        $app.sethtml(id, '---');
                    }
                });
            }
        },
        setLodingBlank: function (idList) {
            if ($app.isArray(idList) === true) {
                $.each(idList, function (key, id) {
                    if ($app.idExist(id) === true) {
                        $app.sethtml(id, "");
                    }
                });
            }
        },
        setPieEmpty: function (id) {
            this.setEmpty(id, 'pie');
        },
        setBarEmpty: function (id) {
            this.setEmpty(id, 'bar');
        },
        setUserFlowEmpty: function (id, container) {
            this.setEmpty(id, 'userflow', container);
        },
        setLoding: function (id, graph) {
            graph = $app.safeVar(graph, 'bar');
            this.setEmpty(id, graph, false, true);
        },
        setEmpty: function (id, graph, container, loading) {
            let isLoading = ($app.safeVar(loading, false) === true) ? true : false;
            let txtvalue = (isLoading === true) ? 'Loading...' : 'There is no data available';
            let graphclass = 'doughnut-empty';
            let containerClass = "empty-container-big";
            switch (graph) {
                case 'bar':
                    graphclass = 'bar-line-empty';
                    break;
                case 'userflow':
                    graphclass = 'bar-line-empty';
                    break;
                case 'pie':
                    containerClass = "empty-container-small";
                    graphclass = 'doughnut-empty';
                    break;
            }
            var html = '';
            html += (container === true) ? '<div class="col col-12">' : '';
            html += '<div class="' + containerClass + '">';
            html += '    <div class="no-data-container">';
            html += '         <div class="' + graphclass + ' empty-image-container"></div>';
            html += '         <div class="no-data-text">' + txtvalue + '</div>';
            html += '    </div>';
            html += '</div>';
            html += (container === true) ? '</div>' : '';
            $app.sethtml(id, html);
        },
        setTimeLegend: function (chart, format, callback) {
            format = $app.safeVar(format, "minute");
            callback = $app.safeVar(callback, false);
            chart.setOption({
                tooltip: {
                    trigger: 'axis',
                    formatter: function (params) {
                        if (callback !== false) {
                            return callback(params);
                        } else {
                            return $app.formatAsTime(params[0].value, format) + "<br>" + params[0].name;
                        }
                    }
                },
                yAxis: {
                    axisLabel: {
                        formatter: function (value) {
                            return $app.formatAsTime(value, 'minute');
                        }
                    }
                }
            });
        },
        formatNumberAxis: function (chart, axis, callback) {
            callback = $app.safeVar(callback, false);
            axis = $app.safeVar(axis, "xAxis");
            let chartOption = {};
            chartOption[axis] = {
                axisLabel: {
                    formatter: function (value) {
                        if (value > 999 && value < 999999) {
                            value = (value / 1000) + " K";
                        } else if (value > 999999) {
                            value = (value / 1000000) + " M";
                        }
                        return value;
                    }
                }
            };
            chart.setOption(chartOption);
        },
        setPieTimeLegend: function (chart, tooltip, format) {
            format = $app.safeVar(format, "minute");
            tooltip = $app.safeVar(tooltip, []);
            chart.setOption({
                tooltip: {
                    trigger: 'item',
                    formatter: function (params, ticket, callback) {
                        let name = $app.isset(tooltip, 'name') ? $app.safeVar(tooltip['name']) + ": " + params.name : params.name;
                        let value = $app.isset(tooltip, 'value') ? $app.safeVar(tooltip['value']) + ": " + $app.formatAsTime(params.value, format) : $app.formatAsTime(params.value, format);
                        let percent = $app.isset(tooltip, 'percent') ? $app.safeVar(tooltip['percent']) + ": " + params.percent : params.percent;
                        return  name + "<br>" + value + "<br>" + percent + "%";
                    }
                }
            });
        },
        setPercentageLegend: function (chart, format) {
            chart.setOption({
                yAxis: {
                    axisLabel: {
                        formatter: function (value) {
                            return $app.safeVar(value, 0) + "%";
                        }
                    }
                }
            });
        },
        filterForPieData: function (data, key, value, max) {
            var returndata = [];
            var that = this;
            if ($app.isArray(data)) {
                var tmpdata = [];
                $.each(data, function (index, row) {
                    var name = $.trim(that.app.safeVar(row[key], 'unknown'));
                    name = (name.toLowerCase() === 'unknown' || name.toLowerCase() === '') ? 'unknown' : name;
                    tmpdata[name] = that.app.safeVar(tmpdata[name], 0) + that.app.safeVar(row[value], 0);
                });
                var sortedData = that.sort(tmpdata, 'desc');
                returndata = that.pieChartDataFormat(sortedData, max);
            }
            return returndata;
        },
        callToDrawMultiBarChart: function (response, id, config, apikey, dataobj, key, value, returnData, callback) {
            var data = $app.safeVar(response.data[apikey][dataobj], []);
            var datakeys = $app.safeVar(config.keys);
            var dataname = $app.safeVar(config.name);
            var that = this;
            var count = 0;
            var chartData = {keynames: [], data: []};
            if ($app.isArray(datakeys) === true) {
                $.each(datakeys, function (index, keyname) {
                    var dataValue = that.app.safeVar(data[keyname]);
                    var tmpvalue = [];
                    $.each(dataValue, function (ind, row) {
                        if (count === 0) {
                            chartData.keynames.push($.trim(that.app.safeVar(row[key], 'unknown')));
                        }
                        tmpvalue.push($.trim(that.app.safeVar(row[value], 0)));
                    });
                    chartData.data.push({value: tmpvalue, name: dataname[index]});
                    count++;
                });
            }
            if (returnData === true) {
                return chartData;
            } else {
                this.multiBarChart(id, chartData, config, callback);
            }
        },
        filterForBarChart: function (data, config, keyname, key, value) {
            var response = {keynames: [], data: []};
            if ($app.isset(data, keyname) === true && $app.isArray(data[keyname]) === true && $app.getLength(data[keyname]) > 0) {
                let datalist = $app.safeVar(data[keyname]);
                $.each(datalist, function (ind, row) {
                    response.keynames.push($.trim($app.safeVar(row[key], 'unknown')));
                    response.data.push($.trim($app.safeVar(row[value], 0)));
                });
            }
            return response;
        },
        filterForStackBarChart: function (data, config, keyname, key, value) {
            var response = {keynames: [], data: []};
            if ($app.isArray(data)) {
                $.each(data, function (index, series) {
                    response.keynames.push($.trim($app.safeVar(series[keyname], 'unknown')));
                    let filendex = response.keynames.length - 1;
                    if ($app.isset(series, 'series') === true && $app.isArray(series['series']) === true) {
                        $.each(series['series'], function (ind, object) {
                            let objectname = $.trim($app.safeVar(object[key], 'unknown'));
                            objectname = (objectname.toLowerCase() === 'unknown') ? 'Unknown' : objectname;
                            objectname = $app.capitalize(objectname);
                            if ($app.isArray(response.data[objectname]) !== true) {
                                response.data[objectname] = [];
                            }
                            response.data[objectname][filendex] = $.trim($app.safeVar(object[value], 0));
                        });
                    }
                });
                let filendex = response.keynames.length - 1;
                for (var objectname in response.data) {
                    if (response.data.hasOwnProperty(objectname)) {
                        for (var i = 0; i <= filendex; i++) {
                            response.data[objectname][i] = $.trim($app.safeVar(response.data[objectname][i], 0));
                        }
                    }
                }
            }
            return response;
        },
        filterForBarShadowChartData: function (data, config, key, value) {
            var response = {keynames: [], data: []};
            if ($app.isArray(data)) {
                $.each(data, function (ind, row) {
                    let name = $.trim($app.safeVar(row[key], 'unknown'));
                    if ($app.inArray(name, ['-1']) === false) {
                        response.keynames.push(name);
                        response.data.push($.trim($app.safeVar(row[value], 0)));
                    }
                });
            }
            return response;
        },
        /**
         * 
         * @param {type} data
         * @param {type} key
         * @param {type} value
         * @returns {js_page_graphsL#3.js_page_graphsAnonym$0.filterForLineGraphData.response}
         */
        filterForLineGraphData: function (data, key, value) {
            var response = {keynames: [], data: []};
            if ($app.isArray(data)) {
                $.each(data, function (ind, row) {
                    let name = $.trim($app.safeVar(row[key], 'unknown'));
                    response.keynames.push(name);
                    response.data.push($.trim($app.safeVar(row[value], 0)));
                });
            }
            return response;
        },
        /**
         * 
         * @param {type} response
         * @param {type} page
         * @param {type} apikey
         * @returns {unresolved}
         */
        filterSingleUserFlow: function (response, page, apikey) {
            if (page !== -1) {
                let tmp = [];
                let tmpnode = [];
                var links = $app.safeVar(response.data[apikey].links, []);
                if ($app.isArray(links) === true) {
                    $.each(links, function (ind, row) {
                        if ($app.inArray(page, [row.source, row.target]) === true) {
                            tmp.push(row);
                            tmpnode.push(row.source);
                            tmpnode.push(row.target);
                        }
                    });
                    tmpnode = $app.uniqueArray(tmpnode);
                }
                var singlenode = [];
                $.each(tmpnode, function (ind, row) {
                    singlenode.push({name: row});
                });
                response.data[apikey]['links'] = tmp;
                response.data[apikey]['nodes'] = singlenode;
            }
            return response;
        },
        filterFunnelData: function (funnelData, key, value) {
            let response = [];
            $.each(funnelData, function (ind, row) {
                response.push({value: $app.safeVar(row[value]), name: $app.safeVar(row[key])});
            });
            return response;
        },
        pieChartDataFormat: function (data, max) {
            max = $app.safeVar(max, 0);
            var that = this;
            var returndata = [];
            var count = 1;
            var othercount = 0;
            var unknowncount = 0;
            $.each(data, function (index, value) {
                var key = value[0];
                var tmp = value[1];
                if ((max !== 0 && count > max) || that.app.inArray(key.toLowerCase(), ['other']) === true) {
                    othercount = othercount + tmp;
                } else if (that.app.inArray(key.toLowerCase(), ['unknown']) === true) {
                    unknowncount = unknowncount + tmp;
                } else {
                    count++;
                    returndata.push({name: key, value: tmp});
                }
            });
            if ((max !== 0 && count > max)) {
                if (othercount > 0 || unknowncount > 0) {
                    returndata.push({name: "Other", value: (othercount + unknowncount)});
                }
            } else {
                if (othercount > 0) {
                    returndata.push({name: "Other", value: othercount});
                }
                if (unknowncount > 0) {
                    returndata.push({name: "Unknown", value: unknowncount});
                }
            }
            return returndata;
        },
        sort: function (obj, order) {
            order = (order === 'desc') ? 'desc' : 'asc';
            if ($app.isArray(obj) === true) {
                var tuples = [];
                for (var key in obj) {
                    tuples.push([key, obj[key]]);
                }
                tuples.sort(function (a, b) {
                    return a[1] < b[1] ? -1 : (a[1] > b[1] ? 1 : 0);
                });
                if (order === 'desc') {
                    return tuples.reverse();
                } else {
                    return tuples;
                }
            }
            return false;
        }
    });
});