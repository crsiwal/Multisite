/* global moment, $app, echarts */

$(document).ready(function () {
    JSGraph = function JSGraph($app) {
        this.app = $app;
        this.color = [];
    };
    $.extend(JSGraph.prototype, {
        init: function () {
            this.default_colors();
        },
        default_colors: function () {
            this.color = ['#8c9ae6', '#ef769b', '#f8c04c', '#47aab8', '#b8ea83', '#ff825c', '#d486ff', '#9ecee9', '#fff298', '#ffadad', '#4ab1c0', '#ef769b', '#8c9ae6', '#f8c04c', '#ef769b', '#4ab1c0'];
        },
        pie: function (id, data, config, callback) {
            if ($app.isArray(data) === true && data.length > 0) {
                var options = this.pieChartOption($app.safeVar(config, []));
                this.render_chart(id, options, 'pie', data, callback);
            } else {
                this.empty_chart(id, 'pie');
            }
        },
        bar: function (id, data, config, callback) {
            if ($app.isArray(data.data) === true && data.data.length > 0) {
                var options = this.barChartOption($app.safeVar(config, []), data);
                this.render_chart(id, options, 'bar', data.data, callback);
            } else {
                this.empty_chart(id, 'bar');
            }
        },
        line: function (id, data, config, callback) {
            if ($app.isArray(data.data) === true && $app.getLength(data.data) > 0) {
                var options = this.line_chart_options($app.safeVar(config, []), data);
                this.render_chart(id, options, 'line', data, callback);
            } else {
                this.empty_chart(id, 'line');
            }
        },
        /**
         * ===============================================
         * Helping Function
         * ===============================================
         * @param {type} id
         * @param {type} graph
         * @param {type} contain
         * @param {type} loading
         * @returns {undefined}
         */
        empty_chart: function (id, graph, contain, loading) {
            let label = ($app.safeVar(loading, false) === true) ? 'Loading...' : 'There is no data available';
            let icon = 'doughnut-empty';
            let container = "empty-container-big";
            switch (graph) {
                case 'bar':
                    icon = 'bar-line-empty';
                    break;
                case 'pie':
                    container = "empty-container-small";
                    icon = 'doughnut-empty';
                    break;
            }
            $app.sethtml(id, `${(contain) ? '<div class="col col-12">' : ''} <div class="${container}"> <div class="no-data-container"> <div class="${icon} empty-image-container"></div> <div class="no-data-text">${label}</div></div></div> ${(contain) ? '</div>' : ''}`);
        },
        chart_long_axis: function (chart, axis, callback) {
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
        line_chart_options: function (config, data) {
            return {
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
        },
        bar_chart_options: function (config, data) {
            let options = {};
            if ($app.safeVar(config.format, 'vertical') === 'horizontal') {
                options['grid'] = {left: '1%', right: '3%', bottom: '1%', top: 25, containLabel: true};
                options['xAxis'] = {type: 'value', boundaryGap: [0, 0.01], splitLine: {show: false}, axisTick: {show: false}, axisLine: {lineStyle: {opacity: 0.2}}};
                options['yAxis'] = {type: 'category', data: $app.safeVar(data.keynames, []), axisTick: {show: false}, axisLine: {lineStyle: {opacity: 0.2}}};
                options['color'] = (($app.isUndefined(config.color) !== true && $app.isArray(config.color)) ? config.color : this.colorPie);
            } else {
                options['grid'] = {left: 50, right: 25, bottom: 25, top: 25};
                options['xAxis'] = {data: $app.safeVar(data.keynames, []), axisTick: {show: (($app.isUndefined(config.xaxisTick) === true) ? false : config.xaxisTick)}, axisLine: {lineStyle: {opacity: 0.2}}};
                options['yAxis'] = {
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
                options['color'] = (($app.isUndefined(config.color) !== true && $app.isArray(config.color)) ? config.color : this.color);
            }
            options['seriesconfig'] = {
                type: "bar",
                barGap: $app.safeVar(config.barWidth, "25%"),
                stack: $app.safeVar(config.stack, 'bl1'),
                barWidth: $app.safeVar(config.barWidth, '15%')
            };
            return {
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
                xAxis: options.xAxis,
                yAxis: options.yAxis,
                grid: options.grid,
                series: options.seriesconfig,
                color: options.color
            };
        },
        pie_chart_options: function (config) {
            return {
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
                series: [{
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
                    }],
                color: (($app.isUndefined(config.color) === false && $app.isArray(config.color) === true) ? config.color : this.colorPie)
            };
        },
        render_chart: function (element, chartOption, chartType, dataArray, callback) {
            this.distroy_chart(element);
            let chart = window.echarts.init($("#" + element)[0]);
            let option = (chartType === 'map') ? chartOption : JSON.parse(JSON.stringify(chartOption));
            callback = ($app.isUndefined(callback) === true) ? false : callback;
            try {
                if (chartType === 'bar') {
                    let dataSeries = [];
                    dataSeries.push({name: "", type: 'bar', data: dataArray, barWidth: option.series.barWidth});
                    option.series = dataSeries;
                } else if (chartType === 'line') {
                    let lineSeries = {
                        name: "Line Graph", data: $app.safeVar(dataArray.data, []), smooth: option.series.smoothLine,
                        showSymbol: option.series.showSymbol, type: 'line', symbol: "circle", symbolSize: 10, lineStyle: {width: 3.5, opacity: 1, type: "solid"}
                    };
                    if (option.series.areaStyleType !== false) {
                        lineSeries['areaStyle'] = {type: option.series.areaStyleType};
                    }
                    option.series = [lineSeries];
                } else if (chartType === 'pie') {
                    option.series[0].data = dataArray;
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
                if ($app.idExist($(this).attr('id')) === true) {
                    try {
                        window.echarts.getInstanceById($(this).attr('_echarts_instance_')).resize();
                    } catch (err) {
                        $app.debug(err.message);
                    }
                }
            });
        },
        distroy_chart: function (gid) {
            gid = $app.safeVar(gid, false);
            if (gid !== false && $app.idExist(gid) === true) {
                let id = $app.safeVar($(`#${gid}`).attr('_echarts_instance_'), false);
                if (id !== false) {
                    try {
                        window.echarts.getInstanceById(id).dispose();
                    } catch (err) {
                        $app.debug(err.message);
                    }
                }
            }
        },
        distroy_all: function () {
            $(".echarts-chart").each(function () {
                let id = $app.safeVar($(this).attr('_echarts_instance_'), false);
                if (id !== false) {
                    try {
                        window.echarts.getInstanceById(id).dispose();
                    } catch (err) {
                        $app.debug(err.message);
                    }
                }
            });
        }
    });
});