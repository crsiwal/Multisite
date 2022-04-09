/* global $app */

$(document).ready(function () {
    JSHTML = function JSHTML($app) {};

    $.extend(JSHTML.prototype, {
        set_number_count(cres, countid, capikey, cdataobj, defaultvalue, format) {
            if ($app.idExist(countid) === true) {
                defaultvalue = $app.safeVar(defaultvalue, 0);
                try {
                    let value = cres.data[capikey][cdataobj];
                    let countvalue = $app.safeVar(value, defaultvalue);
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
                } catch (err) {
                    console.log(err.message);
                }

            }
        },
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
        create_role_access_section: function (obj_id, response, apikey) {
            let data = [];
            let that = this;
            try {
                let name = $app.safeVar(response.data[apikey].name, "User Role");
                let desc = $app.safeVar(response.data[apikey].desc, "");
                data = $app.safeVar(response.data[apikey].list, []);
                let group_name = '';
                let pane = [];
                $app.sethtml("roleaccess_role", name);
                $app.sethtml("roleaccess_desc", desc);
                $app.sethtml(obj_id, "");
                if ($app.isArray(data) === true && $app.getLength(data) > 0) {
                    $.each(data, function (index, access) {
                        let group_changed = (group_name === access.gname) ? false : true;
                        if (group_changed) {
                            if ($app.getLength(pane) > 0) {
                                that.create_new_section(obj_id, pane);
                            }
                            group_name = access.gname;
                            pane = [access];
                        } else {
                            pane.push(access);
                        }
                    });
                    if ($app.getLength(pane) > 0) {
                        that.create_new_section(obj_id, pane);
                    }
                    $app.show("roleaccess_action");
                }
            } catch (err) {
                $app.debug(err.message, true);
            }
        },
        create_new_section: function (obj_id, pane) {
            let that = this;
            let html = '';
            let objects = $app.getLength(pane);
            $.each(pane, function (index, access) {
                //console.log(access);
                if (index === 0) {
                    html += `
                    <div class="access-group card-shadow-2 mt-3 mb-3 p-0 pb-5">
                        <div class="acg-name pl-4">${access.gname}</div>
                        <div class="acg-desc lh-2">${access.summery}</div>
                        <div class="access-list mt-3">
                    `;
                }
                html += that.get_section_child(access);
                if ((index + 1) === (objects)) {
                    html += `
                        </div>
                    </div>
                `;
                }
            });
            $app.sethtml(obj_id, html, true);
        },
        get_section_child: function (access) {
            return `
                    <label class="access-child d-flex">
                        <p class="acc-input pr-3"><input type="checkbox" name="access[]" value="${access.id}" ${(access.active === "1") ? `checked="checked"` : ''}/></p>
                        <p class="acc-label d-flex flex-row">
                            <span class="text-capitalize">${access.name}</span>
                            <span class="font-10 pl-2">(${access.keyname})</span>
                        </p>
                    </label>
            `;
        },
        createTableBody: function (tableid, response, apikey, headerKey, sequenceKey, calculatePercentage, calculateOn, skipCalculate) {
            $app.chart_loading(tableid);
            let that = this;
            let max = [0, 0];
            let min = [0, 0];
            let maxVal = 0;
            let minVal = 99999999;
            let tmpArray = [];
            let data = [];
            try {
                data = $app.safeVar(response.data[apikey].data, []);
            } catch (err) {
                $app.debug(err.message, true);
            }
            sequenceKey = $app.safeVar(sequenceKey, []);
            if ($app.isArray(data) === true && $app.isArray(sequenceKey) === true && sequenceKey.length > 0) {
                $.each(data, function (index, row) {
                    let tmpvalue = [];
                    $.each(sequenceKey, function (ind, key) {
                        let tmplist = {"value": 0, "percentage": 0};
                        tmplist.value = $.trim($app.safeVar(row[key], ""));
                        if (calculatePercentage === true && ($app.inArray(key, skipCalculate) !== true)) {
                            let calculateValue = $.trim($app.safeVar(row[calculateOn], 0));
                            let thisValue = $.trim($app.safeVar(row[key], 0));
                            tmplist.percentage = $app.percentage(calculateValue, thisValue);
                            if (parseInt(maxVal, 10) < parseInt(thisValue, 10)) {
                                console.log(`maxVal ${maxVal}  thisValue ${thisValue}`);
                                max = [index, ind];
                                maxVal = thisValue;
                            }
                            if (parseInt(thisValue, 10) < parseInt(minVal, 10)) {
                                min = [index, ind];
                                minVal = thisValue;
                            }
                        }
                        tmpvalue.push(tmplist);
                    });
                    tmpArray.push(tmpvalue);
                });
            }
            let html = "";
            html += '<thead><tr class="bg-lightgray">';
            $.each(headerKey, function (hindx, headName) {
                html += `<th scope="col" class="font-13 text-darkgray-5">${$app.safeVar(headName, "")}</th>`;
            });
            html += '</tr></thead><tbody>';
            if ($app.isArray(tmpArray) === true && tmpArray.length > 0) {
                $.each(tmpArray, function (index, row) {
                    html += "<tr>";
                    $.each(row, function (ind, col) {
                        if (ind === 0) {
                            html += `<th scope="row">${$app.safeVar(col.value, "")}</th>`;
                        } else {
                            let percent = $app.safeVar(col.percentage, 0);
                            let colorClass = (min[0] === index && min[1] === ind) ? "chart-purple" : ((max[0] === index && max[1] === ind) ? "chart-red" : "");
                            html += `<td class="${colorClass}"><div><p>${$app.safeVar(col.value, "")}</p>${(percent !== 0) ? "<p>" + percent + "%</p>" : ""}</div></td>`;
                        }
                    });
                    html += "</tr>";
                });
            }
            html += '</tbody>';
            $app.sethtml(tableid, html);
        },
        createHtmlTable: function (tableid, response, appkey, header, sequenceKey, actions) {
            let tablenavid = $(`#${tableid}`).parent().find("nav ul").attr("id");
            $app.chart_loading(tableid);
            this.setTableNavHtml(tablenavid, 0);
            try {
                let table_data = $app.safeVar((($app.isset(response.data[appkey], "list"))) ? response.data[appkey].list : response.data[appkey].data, []);
                if (header === true && this.getLength(table_data) > 0) {
                    header = [];
                    sequenceKey = [];
                    let first_row = table_data[0];
                    $.each(first_row, function (index, name) {
                        sequenceKey.push(index);
                        header.push(index);
                    });
                }
                let maxrows = $app.safeVar(response.data[appkey].rows, 0);
                let tableArray = this.getTableArrayFromResponse(table_data, sequenceKey, header);
                let htmldata = this.getHtmlTable(tableArray, true, actions, tableid);
                if ($app.isBlank(htmldata)) {
                    $app.empty_chart(tableid);
                } else {
                    $app.sethtml(tableid, htmldata);
                    $(`#${tableid}`).dataTable();
                }
            } catch (err) {
                console.log(err.message);
            }
        },
        getTableArrayFromResponse: function (data, sequenceKey, headerValue) {
            let response = [];
            data = $app.safeVar(data, []);
            sequenceKey = $app.safeVar(sequenceKey, []);
            headerValue = $app.safeVar(headerValue, []);
            if ($app.isArray(data) === true && $app.isArray(sequenceKey) === true && sequenceKey.length > 0) {
                if ($app.isArray(headerValue) === true && headerValue.length === sequenceKey.length) {
                    response.push(headerValue);
                }
                $.each(data, function (index, row) {
                    let tmpvalue = [];
                    $.each(sequenceKey, function (ind, key) {
                        if (key !== "action") {
                            tmpvalue.push($.trim($app.safeVar(row[key], "")));
                        } else {
                            tmpvalue.push(`xgadgyd-${$app.safeVar(row['id'], "")}`);
                        }
                    });
                    response.push(tmpvalue);
                });
            }
            $app.debug(response);
            return response;
        },
        getHtmlTable: function (data, withheader, actions, tableid, getSingleRow) {
            let response = "";
            let that = this;
            data = $app.safeVar(data, []);
            actions = $app.safeVar(actions, []);
            withheader = $app.safeVar(withheader, true);
            getSingleRow = $app.safeVar(getSingleRow, false);
            if ($app.isArray(data) === true && data.length > 0) {
                $.each(data, function (index, row) {
                    response += (index === 0 && getSingleRow !== true) ? ((withheader === true) ? "<thead>" : "<tbody>") : "";
                    response += (index === 1) ? ((withheader === true) ? "<tbody>" : "") : "";
                    response += (index === 0) ? ((withheader === true) ? '<tr class="bg-lightgray">' : "<tr>") : "";
                    $.each(row, function (ind, col) {
                        if (withheader === true && index === 0) {
                            response += '<th scope="col" class="font-13 text-darkgray-5">' + col + '</td>';
                        } else {
                            if (ind === 0) {
                                response += '<th scope="row">' + col + '</th>';
                            } else {
                                if (col.startsWith("xgadgyd") === true) {
                                    let this_action = col.split("-");
                                    if ($app.isArray(this_action) === true && $app.getLength(this_action) > 1 && this_action[0] !== "action") {
                                        let this_id = this_action[1];
                                        response += '<td class="table-row-action">';
                                        if ($app.isArray(actions) && $app.getLength(actions) > 0) {
                                            $.each(actions, function (inde, action) {
                                                switch (action) {
                                                    case 'edit':
                                                        response += `<span class="act-edit actimg pointer edit aicon fa fa-pencil" data-object="${tableid}" data-id="${this_id}"></span>`;
                                                        break;
                                                    case 'block':
                                                        response += `<span class="act-block actimg pointer block aicon fa fa-ban" data-object="${tableid}" data-id="${this_id}"></span>`;
                                                        break;
                                                    case 'access':
                                                        response += `<span class="act-access actimg pointer access aicon fa fa-key" data-object="${tableid}" data-id="${this_id}"></span>`;
                                                        break;
                                                    case 'view':
                                                        response += `<span class="act-view actimg pointer view aicon fa fa-eye" data-object="${tableid}" data-id="${this_id}"></span>`;
                                                        break;
                                                    case 'delete':
                                                        response += `<span class="act-delete actimg pointer delete aicon fa fa-trash-o" data-object="${tableid}" data-id="${this_id}"></span>`;
                                                        break;
                                                }
                                            });
                                        }
                                        response += '</td>';
                                    } else {
                                        response += '<td>' + col + '</td>';
                                    }
                                } else {
                                    response += '<td>' + col + '</td>';
                                }
                            }
                        }
                    });
                    response += "</tr>";
                    response += (index === 0) ? ((withheader === true) ? "</thead>" : "") : "";
                });
            }
            if (response !== "") {
                response += (getSingleRow !== true) ? "</tbody>" : "";
            }
            return response;
        },
        insertRowInTable: function (tableid, rowData, actions) {
            let rowHtml = $app.getHtmlTable([rowData], false, actions, tableid, true);
            $app.sethtml(tableid, rowHtml, true);
        },
        setTableNavHtml: function (id, totalItems) {
            totalItems = ($app.isObject(totalItems) === true) ? $app.safeVar(totalItems.count, 0) : $app.safeVar(totalItems, 0);
            $('#' + id + ' li:not(:first-child):not(:last-child)').remove();
            let html = "";
            if (totalItems > 0) {
                let nav = this.getTableNav(totalItems);
                if (nav.pages.length > 0) {
                    $.each(nav.pages, function (ind, row) {
                        html += '<li data-status="this" class="page-item ' + ((row === nav.currentPage) ? "active" : "") + '"><a class="page-link" data-current="' + ((row === nav.currentPage) ? "yes" : "no") + '" data-page="' + row + '" href="#">' + row + '</a></li>';
                    });
                    $('#' + id + ' li:last-child').before(html);
                }
            }
        },
        callToDrawHtmlTable: function (response, table_id, apikey, htmldataid, dataKeyArray) {
            let id = `${table_id}`;
            let tablenavid = $(`#${id}`).parent().find("nav ul").attr("id");
            let that = this;
            $app.chart_loading(id);
            this.setTableNavHtml(tablenavid, 0);
            try {
                let dataList = $app.safeVar(response.data[apikey].list, []);
                //let maxrows = $app.safeVar(response.data[appkey].rows, 0);
                dataKeyArray = $app.safeVar(dataKeyArray, []);
                $app.sethtml(id, "");
                if ($app.isArray(dataList) === true && $app.getLength(dataList) > 0) {
                    $.each(dataList, function (index, row) {
                        let tmpHtml = $app.gethtml(`${htmldataid}`);
                        let layout = (index % 2 === 0) ? "active" : "";
                        tmpHtml = $app.replace(tmpHtml, "{layout_class}", layout);
                        tmpHtml = $app.replace(tmpHtml, "{tableid}", table_id);
                        $.each(dataKeyArray, function (tmpkey, expression) {
                            let datavalue = ($app.isset(row, tmpkey) === true) ? $app.safeVar(row[tmpkey], false) : false;
                            switch (tmpkey) {
                                case 'date':
                                    datavalue = $app.dateFormat(datavalue);
                                    break;
                                case 'update_time':
                                    datavalue = $app.timeSince(datavalue);
                                    break;
                                case 'status':
                                    datavalue = $app.capitalize(datavalue);
                                    break;
                            }
                            if (datavalue !== false) {
                                tmpHtml = $app.replace(tmpHtml, '{' + expression + '}', datavalue);
                            }
                        });
                        $app.sethtml(id, tmpHtml, true);

                    });
                    //this.setTableNavHtml(tablenavid, $app.safeVar(maxrows, 0));
                } else {
                    $app.empty_chart(id);
                }
            } catch (err) {
                console.log(err.message);
            }
        },
        getTableNav: function (totalItems) {
            let pageSize = $app.getConfig("table_max_row");
            let totalPages = Math.ceil(totalItems / pageSize);
            let currentPage = $app.safeVar($app.getSession('cptablecurrentpage'), 1);
            // ensure current page isn't out of range
            if (currentPage < 1) {
                currentPage = 1;
            } else if (currentPage > totalPages) {
                currentPage = totalPages;
            }
            let maxPages = 10;
            let startPage = 1;
            let endPage = 10;
            if (totalPages <= maxPages) {
                // total pages less than max so show all pages
                startPage = 1;
                endPage = totalPages;
            } else {
                // total pages more than max so calculate start and end pages
                let maxPagesBeforeCurrentPage = Math.floor(maxPages / 2);
                let maxPagesAfterCurrentPage = Math.ceil(maxPages / 2) - 1;
                if (currentPage <= maxPagesBeforeCurrentPage) {
                    // current page near the start
                    startPage = 1;
                    endPage = maxPages;
                } else if (currentPage + maxPagesAfterCurrentPage >= totalPages) {
                    // current page near the end
                    startPage = totalPages - maxPages + 1;
                    endPage = totalPages;
                } else {
                    // current page somewhere in the middle
                    startPage = currentPage - maxPagesBeforeCurrentPage;
                    endPage = currentPage + maxPagesAfterCurrentPage;
                }
            }

            // calculate start and end item indexes
            let startIndex = (currentPage - 1) * pageSize;
            let endIndex = Math.min(startIndex + pageSize - 1, totalItems - 1);
            // create an array of pages to ng-repeat in the pager control
            let pages = Array.from(Array((endPage + 1) - startPage).keys()).map(i => startPage + i);
            // return object with all pager properties required by the view
            return {
                totalItems: totalItems,
                currentPage: currentPage,
                pageSize: pageSize,
                totalPages: totalPages,
                startPage: startPage,
                endPage: endPage,
                startIndex: startIndex,
                endIndex: endIndex,
                pages: pages
            };
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
                $app.empty_chart(id);
            }
        }
    });
});