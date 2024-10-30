var cb_list = '';
var cb_edit = true;
var cb_snippetList = '#divSnippetList';
var cb_snippetPageSliding = false;
var oScripts = document.getElementsByTagName("script");
var sScriptPath;
var model;
for (var i = 0; i < oScripts.length; i++) {
    var sSrc = oScripts[i].src.toLowerCase();
    if (sSrc.indexOf("contentbuilder-src.js") != -1) sScriptPath = oScripts[i].src.replace(/contentbuilder-src.js/, "");
    if (sSrc.indexOf("contentbuilder.js") != -1) sScriptPath = oScripts[i].src.replace(/contentbuilder.js/, "")
}
var sScriptPathArray = sScriptPath.split("?");
sScriptPath = sScriptPathArray[0];
var sc = document.createElement('script');
sc.src = sScriptPath + 'load-image.all.min.js';
document.getElementsByTagName('head')[0].appendChild(sc);
(function (jQuery) {
    var $activeRow;
    jQuery.contentbuilder = function (element, options) {
        var defaults = {
            zoom: '1',
            selectable: "h1,h2,h3,h4,h5,h6,p,blockquote,ul,ol,small,.edit",
            editMode: 'default',
            onRender: function () {},
            onDrop: function () {},
            onImageBrowseClick: function () {},
            onImageSettingClick: function () {},
            snippetFile: 'assets/default/snippets.html',
            snippetPathReplace: ['', ''],
            hiquality: false,
            snippetTool: 'right',
            snippetOpen: false,
            snippetPageSliding: false,
            scrollHelper: false,
            snippetCategories: [
                [0, "Default"],
                [-1, "All"],
                [1, "Title"],
                [2, "Title, Subtitle"],
                [3, "Info, Title"],
                [4, "Info, Title, Subtitle"],
                [5, "Heading, Paragraph"],
                [6, "Paragraph"],
                [7, "Paragraph, Images + Caption"],
                [8, "Heading, Paragraph, Images + Caption"],
                [9, "Images + Caption"],
                [10, "Images + Long Caption"],
                [11, "Images"],
                [12, "Single Image"],
                [13, "Call to Action"],
                [14, "List"],
                [15, "Quotes"],
                [16, "Profile"],
                [17, "Map"],
                [20, "Video"],
                [18, "Social"],
                [19, "Separator"]
            ],
            imageselect: '',
            fileselect: '',
            onImageSelectClick: function () {},
            onFileSelectClick: function () {},
            imageEmbed: true,
            embedOriginalChecked: false,
            hideEmbedOriginal: false,
            sourceEditor: true,
            enableZoom: true,
            colors: ["#ffffc5", "#e9d4a7", "#ffd5d5", "#ffd4df", "#c5efff", "#b4fdff", "#c6f5c6", "#fcd1fe", "#ececec", "#f7e97a", "#d09f5e", "#ff8d8d", "#ff80aa", "#63d3ff", "#7eeaed", "#94dd95", "#ef97f3", "#d4d4d4", "#fed229", "#cc7f18", "#ff0e0e", "#fa4273", "#00b8ff", "#0edce2", "#35d037", "#d24fd7", "#888888", "#ff9c26", "#955705", "#c31313", "#f51f58", "#1b83df", "#0bbfc5", "#1aa71b", "#ae19b4", "#333333"],
            snippetList: '#divSnippetList',
            toolbar: 'top',
            toolbarDisplay: 'auto',
            axis: '',
            hideDragPreview: false,
			model: '',
        };
        this.settings = {};
        var $element = jQuery(element),
            element = element;
        this.init = function () {
            this.settings = jQuery.extend({}, defaults, options);
			model = this.settings.model;
            if ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
                this.settings.enableZoom = false
            }
            var is_edge = detectEdge();
            if (is_edge) {
                this.settings.enableZoom = false;
                this.settings.zoom = 1;
                localStorage.zoom = 1
            }
            if (!this.settings.enableZoom) {
                localStorage.removeItem("zoom")
            }
            if (localStorage.getItem("zoom") != null) {
                this.settings.zoom = localStorage.zoom
            } else {
                localStorage.zoom = this.settings.zoom
            }
            $element.css('zoom', this.settings.zoom);
            $element.css('-moz-transform', 'scale(' + this.settings.zoom + ')');
            $element.addClass('connectSortable');
            this.settings.zoom = this.settings.zoom + '';
            if (this.settings.zoom.indexOf('%') != -1) {
                this.settings.zoom = this.settings.zoom.replace('%', '') / 100;
                localStorage.zoom = this.settings.zoom
            }
            if (this.settings.zoom == 'NaN') {
                this.settings.zoom = 1;
                localStorage.zoom = 1
            }
            if (cb_list == '') {
                cb_list = '#' + $element.attr('id')
            } else {
                cb_list = cb_list + ',#' + $element.attr('id')
            }
            cb_snippetList = this.settings.snippetList;
            cb_snippetPageSliding = this.settings.snippetPageSliding;
            $element.css({
                'min-height': '50px'
            });
            if (jQuery('#divCb').length == 0) {
                jQuery('body').append('<div id="divCb"></div>')
            }
            if (jQuery('#divSnippets').length == 0) {
                jQuery('#divCb').append('<div id="divSnippets" style="display:none"></div>');
                var html_catselect = '';
                for (var i = 0; i < this.settings.snippetCategories.length; i++) {
                    html_catselect += '<option value="' + this.settings.snippetCategories[i][0] + '">' + this.settings.snippetCategories[i][1] + '</option>'
                }
                html_catselect = '<select id="selSnips" style="display:none;width:83%;margin:5px;padding:5px;margin:3px 0 13px 5px;font-size:12px;letter-spacing:1px;height:28px;line-height:1;color:#454545;border-radius:0px;border:none;background:#fff;box-shadow: 0 0 5px rgba(0, 0, 0,0.2);cursor:pointer;">' + html_catselect + '</select>';
                var s = '<div id="divTool">' + html_catselect;
                s += '<div id="divSnippetList"></div>';
                s += '';
                s += '<br><div id="divRange"><input type="range" id="inpZoom" min="80" max="100" value="100"></div>';
                s += '';
                s += '<a id="lnkToolOpen" href="#"><i class="cb-icon-left-open-big" style="font-size: 15px;"></i></a></div>';
                s += '<div id="divSnippetScrollUp" style="display:none;background:rgba(0,0,0,0.3);width:45px;height:45px;line-height:45px;color:#eee;position:fixed;z-index:100000;border-radius:8px;text-align:center;font-size:12px;cursor:pointer;font-family:sans-serif;">&#9650;</div>' + '<div id="divSnippetScrollDown" style="display:none;background:rgba(0,0,0,0.3);width:45px;height:45px;line-height:45px;color:#eee;position:fixed;z-index:100000;border-radius:8px;text-align:center;font-size:12px;cursor:pointer;font-family:sans-serif;">&#9660;</div>';
                jQuery('#divCb').append(s);
                jQuery('#inpZoom').val(this.settings.zoom * 100);
                jQuery('#divCb input[type="range"]').rangeslider({
                    onSlide: function (position, value) {},
                    polyfill: false
                });
                var val = jQuery('#inpZoom').val() / 100;
                this.zoom(val);
                jQuery('#inpZoom').on('change', function () {
                    if ($element.data('contentbuilder').settings.enableZoom == true) {
                        var val = jQuery('#inpZoom').val() / 100;
                        $element.data('contentbuilder').zoom(val)
                    }
                });
                if (!this.settings.enableZoom && cb_snippetList == '#divSnippetList') {
                    jQuery('#divRange').css('display', 'none');
                    jQuery('#divSnippetList').css('height', '100%')
                }
                jQuery.get(this.settings.snippetFile, function (data) {
                    var htmlData = '';
                    var htmlThumbs = '';
                    var i = 1;
                    var bUseSnippetsFilter = false;
                    jQuery('<div/>').html(data).children('div').each(function () {
                        var block = jQuery(this).html();
                        var blockEncoded = jQuery('<div/>').text(block).html();
                        htmlData += '<div id="snip' + i + '">' + blockEncoded + '</div>';
                        if (jQuery(this).data("cat") != null) bUseSnippetsFilter = true;
                        var thumb = jQuery(this).data("thumb");
                        if ($element.data('contentbuilder').settings.snippetPathReplace[0] != '') {
                            thumb = thumb.replace($element.data('contentbuilder').settings.snippetPathReplace[0], $element.data('contentbuilder').settings.snippetPathReplace[1])
                        }
                        if (bUseSnippetsFilter) {
                            htmlThumbs += '<div style="display:none" title="Snippet ' + i + '" data-snip="' + i + '" data-cat="' + jQuery(this).data("cat") + '"><img src="' + thumb + '" /></div>'
                        } else {
                            htmlThumbs += '<div title="Snippet ' + i + '" data-snip="' + i + '" data-cat="' + jQuery(this).data("cat") + '"><img src="' + thumb + '" /></div>'
                        }
                        i++
                    });
                    if ($element.data('contentbuilder').settings.snippetPathReplace[0] != '') {
                        var regex = new RegExp($element.data('contentbuilder').settings.snippetPathReplace[0], 'g');
                        htmlData = htmlData.replace(regex, $element.data('contentbuilder').settings.snippetPathReplace[1])
                    }
                    jQuery('#divSnippets').html(htmlData);
                    jQuery(cb_snippetList).html(htmlThumbs);
                    if (bUseSnippetsFilter) {
                        var cats = [];
                        var defaultExists = false;
                        jQuery(cb_snippetList + ' > div').each(function () {
                            for (var j = 0; j < jQuery(this).attr('data-cat').split(',').length; j++) {
                                var catid = jQuery(this).attr('data-cat').split(',')[j];
                                if (catid == 0) {
                                    jQuery(this).fadeIn(400);
                                    defaultExists = true
                                }
                                if (jQuery.inArray(catid, cats) == -1) {
                                    cats.push(catid)
                                }
                            }
                        });
                        jQuery('#selSnips option').each(function () {
                            var catid = jQuery(this).attr('value');
                            if (jQuery.inArray(catid, cats) == -1) {
                                if (catid != 0 && catid != -1) {
                                    jQuery("#selSnips option[value='" + catid + "']").remove()
                                }
                            }
                        });
                        if (!defaultExists) {
                            jQuery(cb_snippetList + ' > div').css('display', 'block');
                            jQuery("#selSnips option[value='0']").remove()
                        }
                        jQuery('#selSnips').css('display', 'block');
                        jQuery('#divSnippetList').css('height', '86%');
                        jQuery("#selSnips").on("change", function (e) {
                            var optionSelected = jQuery("option:selected", this);
                            var valueSelected = this.value;
                            if (valueSelected == '-1') {
                                jQuery(cb_snippetList + ' > div').fadeIn(200)
                            } else {
                                jQuery(cb_snippetList + ' > div').fadeOut(200, function () {
                                    for (var j = 0; j < jQuery(this).attr('data-cat').split(',').length; j++) {
                                        if (valueSelected == jQuery(this).attr('data-cat').split(',')[j]) {
                                            jQuery(this).fadeIn(400)
                                        }
                                    }
                                })
                            }
                        })
                    }
                    $element.data('contentbuilder').applyDraggable()
                })
            } else {
                this.applyDraggable()
            }
            var maxScroll = 100000000;
            jQuery('#divSnippetScrollUp').css('display', 'none');
            jQuery('#divSnippetScrollUp').bind("click touchup", function () {
                jQuery("#divSnippetList").animate({
                    scrollTop: (jQuery("#divSnippetList").scrollTop() - (jQuery("#divSnippetList").height() - 150)) + "px"
                }, 300, function () {
                    if (jQuery("#divSnippetList").scrollTop() != 0) {
                        jQuery('#divSnippetScrollUp').fadeIn(300)
                    } else {
                        jQuery('#divSnippetScrollUp').fadeOut(300)
                    }
                    if (jQuery("#divSnippetList").scrollTop() != maxScroll) {
                        jQuery('#divSnippetScrollDown').fadeIn(300)
                    } else {
                        jQuery('#divSnippetScrollDown').fadeOut(300)
                    }
                });
                e.preventDefault();
                e.stopImmediatePropagation();
                return false
            });
            jQuery('#divSnippetScrollDown').bind("click touchup", function () {
                jQuery("#divSnippetList").animate({
                    scrollTop: (jQuery("#divSnippetList").scrollTop() + (jQuery("#divSnippetList").height() - 150)) + "px"
                }, 300, function () {
                    if (jQuery("#divSnippetList").scrollTop() != 0) {
                        jQuery('#divSnippetScrollUp').fadeIn(300)
                    } else {
                        jQuery('#divSnippetScrollUp').fadeOut(300)
                    }
                    if (maxScroll == 100000000) {
                        maxScroll = jQuery('#divSnippetList').prop('scrollHeight') - jQuery('#divSnippetList').height() - 10
                    }
                    if (jQuery("#divSnippetList").scrollTop() != maxScroll) {
                        jQuery('#divSnippetScrollDown').fadeIn(300)
                    } else {
                        jQuery('#divSnippetScrollDown').fadeOut(300)
                    }
                });
                e.preventDefault();
                e.stopImmediatePropagation();
                return false
            });
            $element.children("*").wrap("<div class='ui-draggable teste'></div>");
            $element.children("*").append('<div class="row-tool">' + '<div class="row-handle"><i class="cb-icon-move"></i></div>' + '<div class="row-html"><i class="cb-icon-code"></i></div>' + '<div class="row-copy"><i class="cb-icon-plus"></i></div>' + '<div class="row-remove"><i class="cb-icon-cancel"></i></div>' + '</div>');
            if (jQuery('#temp-contentbuilder').length == 0) {
                jQuery('#divCb').append('<div id="temp-contentbuilder" style="display: none"></div>')
            }
            var $window = jQuery(window);
            var windowsize = $window.width();
            var toolwidth = 260;
            if (windowsize < 600) {
                toolwidth = 150
            }
            if (windowsize <= 320) {
                $element.css("margin-left", "35px");
                $element.css("margin-right", "35px");
                $element.css("width", "80%")
            }
            var bUseScrollHelper = this.settings.scrollHelper;
            if ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
                bUseScrollHelper = true
            }
            if (this.settings.snippetTool == 'right') {
                jQuery('#divSnippetScrollUp').css('right', '10px');
                jQuery('#divSnippetScrollDown').css('right', '10px');
                if (jQuery('#divTool').css('right') != '0px') {
                    jQuery('#divTool').css('width', toolwidth + 'px');
                    jQuery('#divTool').css('right', '-' + toolwidth + 'px')
                }
                jQuery("#lnkToolOpen").unbind('click');
                jQuery("#lnkToolOpen").click(function (e) {
                    jQuery('.row-tool').stop(true, true).fadeOut(0);
                    jQuery(".ui-draggable").removeClass('code');
                    jQuery(".ui-draggable").removeClass('ui-dragbox-outlined');
                    jQuery('#rte-toolbar').css('display', 'none');
                    if (cb_snippetPageSliding || ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)))) {
                        if (parseInt(jQuery('#divTool').css('right')) == 0) {
                            jQuery('#divTool').animate({
                                right: '-=' + toolwidth + 'px'
                            }, 200);
                            jQuery('body').animate({
                                marginRight: '-=' + toolwidth + 'px'
                            }, 250);
                            jQuery('#rte-toolbar').animate({
                                paddingRight: '-=' + toolwidth + 'px'
                            }, 250);
                            jQuery('#lnkToolOpen i').attr('class', 'cb-icon-left-open-big');
                            jQuery('#divSnippetScrollUp').fadeOut(300);
                            jQuery('#divSnippetScrollDown').fadeOut(300)
                        } else {
                            jQuery('#divTool').animate({
                                right: '+=' + toolwidth + 'px'
                            }, 200);
                            jQuery('body').animate({
                                marginRight: '+=' + toolwidth + 'px'
                            }, 250);
                            jQuery('#rte-toolbar').animate({
                                paddingRight: '+=' + toolwidth + 'px'
                            }, 250);
                            jQuery('#lnkToolOpen i').attr('class', 'cb-icon-right-open-big');
                            if (bUseScrollHelper) {
                                var ypos = jQuery('#divSnippetList').height() / 2 - 60;
                                jQuery('#divSnippetScrollUp').css('top', ypos);
                                jQuery('#divSnippetScrollDown').css('top', ypos + 60);
                                if (jQuery("#divSnippetList").scrollTop() != 0) {
                                    jQuery('#divSnippetScrollUp').fadeIn(300)
                                } else {
                                    jQuery('#divSnippetScrollUp').fadeOut(300)
                                }
                                jQuery('#divSnippetScrollDown').fadeIn(300)
                            }
                        }
                        jQuery('#rte-toolbar').css('display', 'none')
                    } else {
                        if (parseInt(jQuery('#divTool').css('right')) == 0) {
                            jQuery('#divTool').animate({
                                right: '-=' + toolwidth + 'px'
                            }, 200);
                            jQuery('#lnkToolOpen i').attr('class', 'cb-icon-left-open-big');
                            jQuery('#divSnippetScrollUp').css('display', 'none');
                            jQuery('#divSnippetScrollDown').css('display', 'none')
                        } else {
                            jQuery('#divTool').animate({
                                right: '+=' + toolwidth + 'px'
                            }, 200);
                            jQuery('#lnkToolOpen i').attr('class', 'cb-icon-right-open-big');
                            if (bUseScrollHelper) {
                                var ypos = jQuery('#divSnippetList').height() / 2 - 60;
                                jQuery('#divSnippetScrollUp').css('top', ypos);
                                jQuery('#divSnippetScrollDown').css('top', ypos + 60);
                                if (jQuery("#divSnippetList").scrollTop() != 0) {
                                    jQuery('#divSnippetScrollUp').fadeIn(300)
                                } else {
                                    jQuery('#divSnippetScrollUp').fadeOut(300)
                                }
                                jQuery('#divSnippetScrollDown').fadeIn(300)
                            }
                        }
                    }
                    e.preventDefault()
                });
                jQuery('.row-tool').css('right', 'auto');
                if (windowsize < 600) {
                    jQuery('.row-tool').css('left', '-30px')
                } else {
                    jQuery('.row-tool').css('left', '-37px')
                }
                if (this.settings.snippetOpen) {
                    if (jQuery('#divTool').attr('data-snip-open') != 1) {
                        jQuery('#divTool').attr('data-snip-open', 1);
                        jQuery('#divTool').animate({
                            right: '+=' + toolwidth + 'px'
                        }, 900);
                        jQuery("#lnkToolOpen i").attr('class', 'cb-icon-right-open-big')
                    }
                }
            } else {
                jQuery("#lnkToolOpen i").attr('class', 'cb-icon-right-open-big');
                jQuery('#divSnippetScrollUp').css('left', '10px');
                jQuery('#divSnippetScrollDown').css('left', '10px');
                jQuery('#divTool').css('width', toolwidth + 'px');
                jQuery('#divTool').css('left', '-' + toolwidth + 'px');
                jQuery('#lnkToolOpen').addClass('leftside');
                jQuery("#lnkToolOpen").unbind('click');
                jQuery("#lnkToolOpen").click(function (e) {
                    jQuery('.row-tool').stop(true, true).fadeOut(0);
                    jQuery(".ui-draggable").removeClass('code');
                    jQuery(".ui-draggable").removeClass('ui-dragbox-outlined');
                    jQuery('#rte-toolbar').css('display', 'none');
                    if (cb_snippetPageSliding || ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)))) {
                        if (parseInt(jQuery('#divTool').css('left')) == 0) {
                            jQuery('#divTool').animate({
                                left: '-=' + (toolwidth + 0) + 'px'
                            }, 200);
                            jQuery('body').animate({
                                marginLeft: '-=' + toolwidth + 'px'
                            }, 250);
                            jQuery('#rte-toolbar').animate({
                                paddingLeft: '-=' + toolwidth + 'px'
                            }, 250);
                            jQuery("#lnkToolOpen i").attr('class', 'cb-icon-right-open-big');
                            jQuery('#divSnippetScrollUp').fadeOut(300);
                            jQuery('#divSnippetScrollDown').fadeOut(300)
                        } else {
                            jQuery('#divTool').animate({
                                left: '+=' + (toolwidth + 0) + 'px'
                            }, 200);
                            jQuery('body').animate({
                                marginLeft: '+=' + toolwidth + 'px'
                            }, 250);
                            jQuery('#rte-toolbar').animate({
                                paddingLeft: '+=' + toolwidth + 'px'
                            }, 250);
                            jQuery("#lnkToolOpen i").attr('class', 'cb-icon-left-open-big');
                            if (bUseScrollHelper) {
                                var ypos = jQuery('#divSnippetList').height() / 2 - 60;
                                jQuery('#divSnippetScrollUp').css('top', ypos);
                                jQuery('#divSnippetScrollDown').css('top', ypos + 60);
                                if (jQuery("#divSnippetList").scrollTop() != 0) {
                                    jQuery('#divSnippetScrollUp').fadeIn(300)
                                } else {
                                    jQuery('#divSnippetScrollUp').fadeOut(300)
                                }
                                jQuery('#divSnippetScrollDown').fadeIn(300)
                            }
                        }
                        jQuery('#rte-toolbar').css('display', 'none')
                    } else {
                        if (parseInt(jQuery('#divTool').css('left')) == 0) {
                            jQuery('#divTool').animate({
                                left: '-=' + (toolwidth + 0) + 'px'
                            }, 200);
                            jQuery("#lnkToolOpen i").attr('class', 'cb-icon-right-open-big');
                            jQuery('#divSnippetScrollUp').css('display', 'none');
                            jQuery('#divSnippetScrollDown').css('display', 'none')
                        } else {
                            jQuery('#divTool').animate({
                                left: '+=' + (toolwidth + 0) + 'px'
                            }, 200);
                            jQuery("#lnkToolOpen i").attr('class', 'cb-icon-left-open-big');
                            if (bUseScrollHelper) {
                                var ypos = jQuery('#divSnippetList').height() / 2 - 60;
                                jQuery('#divSnippetScrollUp').css('top', ypos);
                                jQuery('#divSnippetScrollDown').css('top', ypos + 60);
                                if (jQuery("#divSnippetList").scrollTop() != 0) {
                                    jQuery('#divSnippetScrollUp').fadeIn(300)
                                } else {
                                    jQuery('#divSnippetScrollUp').fadeOut(300)
                                }
                                jQuery('#divSnippetScrollDown').fadeIn(300)
                            }
                        }
                    }
                    e.preventDefault()
                });
                jQuery('.row-tool').css('left', 'auto');
                if (windowsize < 600) {
                    jQuery('.row-tool').css('right', '-30px')
                } else {
                    jQuery('.row-tool').css('right', '-37px')
                }
                if (this.settings.snippetOpen) {
                    if (jQuery('#divTool').attr('data-snip-open') != 1) {
                        jQuery('#divTool').attr('data-snip-open', 1);
                        jQuery('#divTool').animate({
                            left: '+=' + toolwidth + 'px'
                        }, 900);
                        jQuery("#lnkToolOpen i").attr('class', 'cb-icon-left-open-big')
                    }
                }
            }
            this.applyBehavior();
            this.blockChanged();
            this.settings.onRender();
            $element.sortable({
                helper: function (event, ui) {
                    var $clone = jQuery(ui).clone();
                    $clone.css('position', 'absolute');
                    return $clone.get(0)
                },
                sort: function (event, ui) {
                    if ($element.data('contentbuilder').settings.hideDragPreview) {
                        ui.helper.css({
                            'display': 'none'
                        })
                    }
                },
                items: '.ui-draggable',
                connectWith: '.connectSortable',
                'distance': 5,
                axis: 'y',
                tolerance: 'pointer',
                handle: '.row-handle',
                delay: 200,
                cursor: 'move',
                placeholder: 'block-placeholder',
                start: function (e, ui) {
                    jQuery(ui.placeholder).slideUp(80);
                    cb_edit = false
                },
                change: function (e, ui) {
                    jQuery(ui.placeholder).hide().slideDown(80)
                },
                deactivate: function (event, ui) {
                    cb_edit = true;
                    var bDrop = false;
                    if (ui.item.find('.row-tool').length == 0) {
                        bDrop = true
                    }
                    if (ui.item.parent().attr('id') == $element.attr('id')) {
                        ui.item.replaceWith(ui.item.html());
                        $element.children("*").each(function () {
                            if (!jQuery(this).hasClass('ui-draggable')) {
                                jQuery(this).wrap("<div class='ui-draggable'></div>")
                            }
                        });
                        $element.children('.ui-draggable').each(function () {
                            if (jQuery(this).find('.row-tool').length == 0) {
                                jQuery(this).append('<div class="row-tool">' + '<div class="row-handle"><i class="cb-icon-move"></i></div>' + '<div class="row-html"><i class="cb-icon-code"></i></div>' + '<div class="row-copy"><i class="cb-icon-plus"></i></div>' + '<div class="row-remove"><i class="cb-icon-cancel"></i></div>' + '</div>')
                            }
                        });
                        $element.children('.ui-draggable').each(function () {
                            if (jQuery(this).children('*').length == 1) {
                                jQuery(this).remove()
                            }
                            if (jQuery(this).children('*').length == 2) {
                                if (jQuery(this).children(0).prop("tagName").toLowerCase() == 'img' && jQuery(this).children(0).attr('src').indexOf('thumbnails/') != -1) {
                                    jQuery(this).remove()
                                }
                            }
                        })
                    }
                    $element.data('contentbuilder').applyBehavior();
                    $element.data('contentbuilder').blockChanged();
                    $element.data('contentbuilder').settings.onRender();
                    $element.data('contentbuilder').settings.onDrop(event, ui)
                }
            });
            if (cb_list.indexOf(',') != -1) {
                jQuery(cb_list).sortable('option', 'axis', false)
            }
            if (this.settings.axis != '') {
                jQuery(cb_list).sortable('option', 'axis', this.settings.axis)
            }
            jQuery.ui.isOverAxis2 = function (x, reference, size) {
                return (x >= reference) && (x < (reference + size))
            };
            jQuery.ui.isOver = function (y, x, top, left, height, width) {
                return jQuery.ui.isOverAxis2(y, top, height) && jQuery.ui.isOverAxis(x, left, width)
            };
            $element.droppable({
                drop: function (event, ui) {
                    if (jQuery(ui.draggable).data('snip')) {
                        var snip = jQuery(ui.draggable).data('snip');
                        var snipHtml = jQuery('#snip' + snip).text();
                        jQuery(ui.draggable).data('snip', null);
                        return ui.draggable.html(snipHtml);
                        event.preventDefault()
                    }
                },
                tolerance: 'pointer',
                greedy: true,
                deactivate: function (event, ui) {
                    jQuery(cb_list).each(function () {
                        var $cb = jQuery(this);
                        $cb.children('.ui-draggable').each(function () {
                            if (jQuery(this).find('.row-tool').length == 0) {
                                jQuery(this).append('<div class="row-tool">' + '<div class="row-handle"><i class="cb-icon-move"></i></div>' + '<div class="row-html"><i class="cb-icon-code"></i></div>' + '<div class="row-copy"><i class="cb-icon-plus"></i></div>' + '<div class="row-remove"><i class="cb-icon-cancel"></i></div>' + '</div>')
                            }
                        });
                        $cb.data('contentbuilder').applyBehavior()
                    })
                }
            });
            jQuery(document).bind('mousedown', function (event) {
                var $active_element;
                if (jQuery(event.target).parents(".ui-draggable").length > 0) {
                    if (jQuery(event.target).parents(".ui-draggable").parent().data('contentbuilder')) {
                        $active_element = jQuery(event.target).parents(".ui-draggable").parent()
                    }
                }
                if (jQuery(event.target).attr("class") == 'ovl') {
                    jQuery(event.target).css('z-index', '-1')
                }
                if (jQuery(event.target).parents('.ui-draggable').length > 0 && jQuery(event.target).parents(cb_list).length > 0) {
                    var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
                    jQuery(".ui-draggable").removeClass('code');
                    if (jQuery(event.target).parents("[data-mode='code']").length > 0) {
                        jQuery(event.target).parents(".ui-draggable").addClass('code')
                    }
                    if (jQuery(event.target).parents("[data-mode='readonly']").length > 0) {
                        jQuery(event.target).parents(".ui-draggable").addClass('code')
                    }
                    jQuery(".ui-draggable").removeClass('ui-dragbox-outlined');
                    jQuery(event.target).parents(".ui-draggable").addClass('ui-dragbox-outlined');
                    if (is_firefox) jQuery(event.target).parents(".ui-draggable").addClass('firefox');
                    jQuery('.row-tool').stop(true, true).fadeOut(0);
                    if ($active_element) {
                        if (jQuery(event.target).parents(".ui-draggable").find("[data-html-edit='off']").length > 0 || !$active_element.data('contentbuilder').settings.sourceEditor) {
                            jQuery(event.target).parents(".ui-draggable").find('.row-tool .row-html').css({
                                display: 'none'
                            })
                        }
                    }
                    jQuery(event.target).parents(".ui-draggable").find('.row-tool').stop(true, true).css({
                        display: 'none'
                    }).fadeIn(300);
                    return
                }
                if (jQuery(event.target).parent().attr('id') == 'rte-toolbar' || jQuery(event.target).parent().parent().attr('id') == 'rte-toolbar') {
                    return
                }
                if (jQuery(event.target).is('[contenteditable]') || jQuery(event.target).css('position') == 'absolute' || jQuery(event.target).css('position') == 'fixed') {
                    return
                }
                jQuery(event.target).parents().each(function (e) {
                    if (jQuery(this).is('[contenteditable]') || jQuery(this).css('position') == 'absolute' || jQuery(this).css('position') == 'fixed') {
                        return
                    }
                });
                jQuery('.row-tool').stop(true, true).fadeOut(0);
                jQuery(".ui-draggable").removeClass('code');
                jQuery(".ui-draggable").removeClass('ui-dragbox-outlined');
                jQuery('#rte-toolbar').css('display', 'none')
            })
        };
        this.applyDraggable = function (obj) {
            var bJUIStable = false;
            if (jQuery.ui.version == '1.11.0') {
                bJUIStable = true
            }
            if (bJUIStable) {
                jQuery(cb_snippetList + ' > div').draggable({
                    cursor: 'move',
                    helper: function () {
                        return jQuery("<div class='dynamic'></div>")[0]
                    },
                    delay: 200,
                    connectToSortable: cb_list,
                    stop: function (event, ui) {
                        jQuery(cb_list).each(function () {
                            var $cb = jQuery(this);
                            $cb.children("div").each(function () {
                                if (jQuery(this).children("img").length == 1) {
                                    jQuery(this).remove()
                                }
                            })
                        })
                    }
                })
            } else {
                jQuery(cb_snippetList + ' > div').draggable({
                    cursor: 'move',
                    helper: "clone",
                    drag: function (event, ui) {
                        jQuery(ui.helper).css("overflow", "hidden");
                        jQuery(ui.helper).css("padding-top", "0px");
                        jQuery(ui.helper).css("box-sizing", "border-box");
                        jQuery(ui.helper).css("width", "150px");
                        jQuery(ui.helper).css("height", "auto");
                        jQuery(ui.helper).css("border", "rgba(225,225,225,0.9) 5px solid");
                        jQuery(ui.helper).css('position', 'absolute');
                        if (!ui.helper.parent().is('body')) {
                            ui.helper.appendTo(jQuery('body'))
                        }
                    },
                    connectToSortable: cb_list,
                    stop: function (event, ui) {
                        jQuery(cb_list).each(function () {
                            var $cb = jQuery(this);
                            $cb.children("div").each(function () {
                                if (jQuery(this).children("img").length == 1) {
                                    jQuery(this).remove()
                                }
                            })
                        })
                    }
                })
            }
        };
        this.html = function () {
            var selectable = this.settings.selectable;
            jQuery('#temp-contentbuilder').html($element.html());
            jQuery('#temp-contentbuilder').find('.row-tool').remove();
            jQuery('#temp-contentbuilder').find('.ovl').remove();
            jQuery('#temp-contentbuilder').find('[contenteditable]').removeAttr('contenteditable');
            jQuery('*[class=""]').removeAttr('class');
            jQuery('#temp-contentbuilder').find('.ui-draggable').replaceWith(function () {
                return jQuery(this).html()
            });
            jQuery("#temp-contentbuilder").find("[data-mode='code']").each(function () {
                if (jQuery(this).attr("data-html") != undefined) {
                    jQuery(this).html(decodeURIComponent(jQuery(this).attr("data-html")))
                }
            });
            var html = jQuery('#temp-contentbuilder').html().trim();
            html = html.replace(/<font/g, '<span').replace(/<\/font/g, '</span');
            return html
        };
        this.zoom = function (n) {
            this.settings.zoom = n;
            jQuery(cb_list).css('zoom', n);
            jQuery(cb_list).css('-moz-transform', 'scale(' + n + ')');
            localStorage.zoom = n;
            jQuery('.row-tool').stop(true, true).fadeOut(0);
            jQuery(".ui-draggable").removeClass('code');
            jQuery(".ui-draggable").removeClass('ui-dragbox-outlined');
            jQuery('#rte-toolbar').css('display', 'none')
        };
        this.clearControls = function () {
            jQuery('.row-tool').stop(true, true).fadeOut(0);
            jQuery(".ui-draggable").removeClass('code');
            jQuery(".ui-draggable").removeClass('ui-dragbox-outlined');
            var selectable = this.settings.selectable;
            $element.find(selectable).blur()
        };
        this.viewHtml = function () {
            jQuery('#md-html').css('width', '45%');
            jQuery('#md-html').simplemodal();
            jQuery('#md-html').data('simplemodal').show();
            jQuery('#txtHtml').val(this.html());
            jQuery('#btnHtmlOk').unbind('click');
            jQuery('#btnHtmlOk').bind('click', function (e) {
                $element.html(jQuery('#txtHtml').val());
                jQuery('#md-html').data('simplemodal').hide();
                $element.children("*").wrap("<div class='ui-draggable'></div>");
                $element.children("*").append('<div class="row-tool">' + '<div class="row-handle"><i class="cb-icon-move"></i></div>' + '<div class="row-html"><i class="cb-icon-code"></i></div>' + '<div class="row-copy"><i class="cb-icon-plus"></i></div>' + '<div class="row-remove"><i class="cb-icon-cancel"></i></div>' + '</div>');
                $element.data('contentbuilder').applyBehavior();
                $element.data('contentbuilder').blockChanged();
                $element.data('contentbuilder').settings.onRender()
            })
        };
        this.loadHTML = function (html) {
            $element.html(html);
            $element.children("*").wrap("<div class='ui-draggable'></div>");
            $element.children("*").append('<div class="row-tool">' + '<div class="row-handle"><i class="cb-icon-move"></i></div>' + '<div class="row-html"><i class="cb-icon-code"></i></div>' + '<div class="row-copy"><i class="cb-icon-plus"></i></div>' + '<div class="row-remove"><i class="cb-icon-cancel"></i></div>' + '</div>');
            $element.data('contentbuilder').applyBehavior();
            $element.data('contentbuilder').blockChanged();
            $element.data('contentbuilder').settings.onRender()
        };
        this.applyBehavior = function () {
            $element.find('a').click(function () {
                return false
            });
            $element.find("[data-mode='code']").each(function () {
                if (jQuery(this).attr("data-html") != undefined) {
                    jQuery(this).html(decodeURIComponent(jQuery(this).attr("data-html")))
                }
            });
            var selectable = this.settings.selectable;
            var hq = this.settings.hiquality;
            var imageEmbed = this.settings.imageEmbed;
            var embedOriginalChecked = this.settings.embedOriginalChecked;
            var hideEmbedOriginal = this.settings.hideEmbedOriginal;
            var colors = this.settings.colors;
            var editMode = this.settings.editMode;
            var toolbar = this.settings.toolbar;
            var toolbarDisplay = this.settings.toolbarDisplay;
            var onImageSelectClick = this.settings.onImageSelectClick;
            var onFileSelectClick = this.settings.onFileSelectClick;
            var onImageBrowseClick = this.settings.onImageBrowseClick;
            var onImageSettingClick = this.settings.onImageSettingClick;
            var imageselect = this.settings.imageselect;
            var fileselect = this.settings.fileselect;
            $element.contenteditor({
                fileselect: fileselect,
                editable: selectable,
                colors: colors,
                editMode: editMode,
                toolbar: toolbar,
                toolbarDisplay: toolbarDisplay
            });
            $element.data('contenteditor').render();
            $element.find('img').each(function () {
                if (jQuery(this).parents("[data-mode='code']").length > 0) return;
                if (jQuery(this).parents("[data-mode='readonly']").length > 0) return;
                jQuery(this).imageembed({
                    hiquality: hq,
                    imageselect: imageselect,
                    fileselect: fileselect,
                    imageEmbed: imageEmbed,
                    embedOriginalChecked: embedOriginalChecked,
                    hideEmbedOriginal: hideEmbedOriginal,
                    onImageBrowseClick: onImageBrowseClick,
                    onImageSettingClick: onImageSettingClick,
                    onImageSelectClick: onImageSelectClick,
                    onFileSelectClick: onFileSelectClick
                });
                if (jQuery(this).parents('figure').length != 0) {
                    if (jQuery(this).parents('figure').find('figcaption').css('position') == 'absolute') {
                        jQuery(this).parents('figure').imageembed({
                            hiquality: hq,
                            imageselect: imageselect,
                            fileselect: fileselect,
                            imageEmbed: imageEmbed,
                            embedOriginalChecked: embedOriginalChecked,
                            hideEmbedOriginal: hideEmbedOriginal,
                            onImageBrowseClick: onImageBrowseClick,
                            onImageSettingClick: onImageSettingClick,
                            onImageSelectClick: onImageSelectClick,
                            onFileSelectClick: onFileSelectClick
                        })
                    }
                }
            });
            $element.find(".embed-responsive").each(function () {
                if (jQuery(this).parents("[data-mode='code']").length > 0) return;
                if (jQuery(this).parents("[data-mode='readonly']").length > 0) return;
                if (jQuery(this).find('.ovl').length == 0) {
                    jQuery(this).append('<div class="ovl" style="position:absolute;background:#fff;opacity:0.2;cursor:pointer;top:0;left:0px;width:100%;height:100%;z-index:-1"></div>')
                }
            });
            $element.find(".embed-responsive").hover(function () {
                if (jQuery(this).parents("[data-mode='code']").length > 0) return;
                if (jQuery(this).parents("[data-mode='readonly']").length > 0) return;
                if (jQuery(this).parents(".ui-draggable").css('outline-style') == 'none') {
                    jQuery(this).find('.ovl').css('z-index', '1')
                }
            }, function () {
                jQuery(this).find('.ovl').css('z-index', '-1')
            });
            $element.find(selectable).unbind('focus');
            $element.find(selectable).focus(function () {
                var zoom = $element.data('contentbuilder').settings.zoom;
                var selectable = $element.data('contentbuilder').settings.selectable;
                var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
                jQuery(".ui-draggable").removeClass('code');
                if (jQuery(this).parents("[data-mode='code']").length > 0) {
                    jQuery(this).parents(".ui-draggable").addClass('code')
                }
                if (jQuery(this).parents("[data-mode='readonly']").length > 0) {
                    jQuery(this).parents(".ui-draggable").addClass('code')
                }
                jQuery(".ui-draggable").removeClass('ui-dragbox-outlined');
                jQuery(this).parents(".ui-draggable").addClass('ui-dragbox-outlined');
                if (is_firefox) jQuery(this).parents(".ui-draggable").addClass('firefox');
                jQuery('.row-tool').stop(true, true).fadeOut(0);
                if (jQuery(this).parents(".ui-draggable").find("[data-html-edit='off']").length > 0 || !$element.data('contentbuilder').settings.sourceEditor) {
                    jQuery(this).parents(".ui-draggable").find('.row-tool .row-html').css({
                        display: 'none'
                    })
                }
                jQuery(this).parents(".ui-draggable").find('.row-tool').stop(true, true).css({
                    display: 'none'
                }).fadeIn(300)
            });
            $element.children("div").find('.row-remove').unbind();
            $element.children("div").find('.row-remove').click(function () {
                jQuery('#md-delrowconfirm').css('max-width', '550px');
                jQuery('#md-delrowconfirm').simplemodal();
                jQuery('#md-delrowconfirm').data('simplemodal').show();
                $activeRow = jQuery(this).parents('.ui-draggable');
                jQuery('#btnDelRowOk').unbind('click');
                jQuery('#btnDelRowOk').bind('click', function (e) {
                    jQuery('#md-delrowconfirm').data('simplemodal').hide();
                    $activeRow.fadeOut(400, function () {
                        jQuery("#divToolImg").stop(true, true).fadeOut(0);
                        jQuery("#divToolImgSettings").stop(true, true).fadeOut(0);
                        jQuery("#divRteLink").stop(true, true).fadeOut(0);
                        jQuery("#divFrameLink").stop(true, true).fadeOut(0);
                        $activeRow.remove();
                        $element.data('contentbuilder').blockChanged();
                        $element.data('contentbuilder').settings.onRender()
                    })
                });
                jQuery('#btnDelRowCancel').unbind('click');
                jQuery('#btnDelRowCancel').bind('click', function (e) {
                    jQuery('#md-delrowconfirm').data('simplemodal').hide()
                })
            });
            $element.children("div").find('.row-copy').unbind();
            $element.children("div").find('.row-copy').click(function () {
                $activeRow = jQuery(this).parents('.ui-draggable');
                jQuery('#temp-contentbuilder').html($activeRow.html());
                jQuery('#temp-contentbuilder').find('[contenteditable]').removeAttr('contenteditable');
                jQuery('#temp-contentbuilder *[class=""]').removeAttr('class');
                jQuery('#temp-contentbuilder *[style=""]').removeAttr('style');
                jQuery('#temp-contentbuilder .ovl').remove();
                jQuery('#temp-contentbuilder .row-tool').remove();
                var html = jQuery('#temp-contentbuilder').html().trim();
                $activeRow.after(html);
                $element.children("*").each(function () {
                    if (!jQuery(this).hasClass('ui-draggable')) {
                        jQuery(this).wrap("<div class='ui-draggable'></div>")
                    }
                });
                $element.children('.ui-draggable').each(function () {
                    if (jQuery(this).find('.row-tool').length == 0) {
                        jQuery(this).append('<div class="row-tool">' + '<div class="row-handle"><i class="cb-icon-move"></i></div>' + '<div class="row-html"><i class="cb-icon-code"></i></div>' + '<div class="row-copy"><i class="cb-icon-plus"></i></div>' + '<div class="row-remove"><i class="cb-icon-cancel"></i></div>' + '</div>')
                    }
                });
                $element.children('.ui-draggable').each(function () {
                    if (jQuery(this).children('*').length == 1) {
                        jQuery(this).remove()
                    }
                });
                $element.data('contentbuilder').applyBehavior();
                $element.data('contentbuilder').blockChanged();
                $element.data('contentbuilder').settings.onRender()
            });
            $element.children("div").find('.row-html').unbind();
            $element.children("div").find('.row-html').click(function () {
                jQuery('#md-html').css('width', '45%');
                jQuery('#md-html').simplemodal();
                jQuery('#md-html').data('simplemodal').show();
                $activeRow = jQuery(this).parents('.ui-draggable').children('*').not('.row-tool');
                if ($activeRow.data('mode') == 'code' && $activeRow.attr('data-html') != undefined) {
                    jQuery('#txtHtml').val(decodeURIComponent($activeRow.attr('data-html')))
                } else {
                    jQuery('#temp-contentbuilder').html($activeRow.html());
                    jQuery('#temp-contentbuilder').find('[contenteditable]').removeAttr('contenteditable');
                    jQuery('#temp-contentbuilder *[class=""]').removeAttr('class');
                    jQuery('#temp-contentbuilder *[style=""]').removeAttr('style');
                    jQuery('#temp-contentbuilder .ovl').remove();
                    var html = jQuery('#temp-contentbuilder').html().trim();
                    html = html.replace(/<font/g, '<span').replace(/<\/font/g, '</span');
                    jQuery('#txtHtml').val(html)
                }
                jQuery('#btnHtmlOk').unbind('click');
                jQuery('#btnHtmlOk').bind('click', function (e) {
                    if ($activeRow.data('mode') == 'code') {
                        $activeRow.attr('data-html', encodeURIComponent(jQuery('#txtHtml').val()));
                        $activeRow.html('')
                    } else {
                        $activeRow.html(jQuery('#txtHtml').val())
                    }
                    jQuery('#md-html').data('simplemodal').hide();
                    $element.data('contentbuilder').applyBehavior();
                    $element.data('contentbuilder').blockChanged();
                    $element.data('contentbuilder').settings.onRender()
                })
            })
        };
        this.blockChanged = function () {
            if ($element.children().length == 0) {
                //$element.css('border', 'rgba(0, 0, 0, 0.25) 1px dashed');
                $element.append('<div style="height:250px"></div>');
                $element.children("*").each(function () {
                    if (!jQuery(this).hasClass('ui-draggable')) {
                        jQuery(this).wrap("<div id='empty-info' class='ui-draggable'  data-mode='readonly'></div>")
                    }
                })
            } else if ($element.children().length == 1 && jQuery("#empty-info").length == 1) {} else {
                $element.css('border', '');
                jQuery("#empty-info").remove()
            }
        };
        this.destroy = function () {
            if (!$element.data('contentbuilder')) return;
            var sHTML = $element.data('contentbuilder').html();
            $element.html(sHTML);
            $element.sortable("destroy");
            var cbarr = cb_list.split(","),
                newcbarr = [];
            for (var i = 0; i < cbarr.length; i++) {
                if (cbarr[i] != "#" + $element.attr("id")) {
                    newcbarr.push(cbarr[i])
                }
            }
            cb_list = newcbarr.join(",");
            $element.removeClass('connectSortable');
            $element.css({
                'min-height': ''
            });
            if (cb_list == "") {
                jQuery('#divCb').remove();
                jQuery(document).unbind('mousedown')
            }
            $element.removeData('contentbuilder');
            $element.removeData('contenteditor');
            $element.unbind()
        };
        this.init()
    };
    jQuery.fn.contentbuilder = function (options) {
        return this.each(function () {
            if (undefined == jQuery(this).data('contentbuilder')) {
                var plugin = new jQuery.contentbuilder(this, options);
                jQuery(this).data('contentbuilder', plugin)
            }
        })
    }
})(jQuery);
var ce_toolbarDisplay = 'auto';
var ce_outline = false;
(function (jQuery) {
    var $activeLink;
    var $activeElement;
    var $activeFrame;
    var instances = [];

    function instances_count() {};
    jQuery.fn.count = function () {};
    jQuery.contenteditor = function (element, options) {
        var defaults = {
            editable: "h1,h2,h3,h4,h5,h6,p,ul,ol,small,.edit",
            editMode: "default",
            hasChanged: false,
            onRender: function () {},
            outline: false,
            fileselect: '',
            toolbar: 'top',
            toolbarDisplay: 'auto',
            colors: ["#ffffc5", "#e9d4a7", "#ffd5d5", "#ffd4df", "#c5efff", "#b4fdff", "#c6f5c6", "#fcd1fe", "#ececec", "#f7e97a", "#d09f5e", "#ff8d8d", "#ff80aa", "#63d3ff", "#7eeaed", "#94dd95", "#ef97f3", "#d4d4d4", "#fed229", "#cc7f18", "#ff0e0e", "#fa4273", "#00b8ff", "#0edce2", "#35d037", "#d24fd7", "#888888", "#ff9c26", "#955705", "#c31313", "#f51f58", "#1b83df", "#0bbfc5", "#1aa71b", "#ae19b4", "#333333"]
        };
        this.settings = {};
        var $element = jQuery(element),
            element = element;
        this.init = function () {
            this.settings = jQuery.extend({}, defaults, options);
            var bUseCustomFileSelect = false;
            if (this.settings.fileselect != '') bUseCustomFileSelect = true;
            if (jQuery('#divCb').length == 0) {
                jQuery('body').append('<div id="divCb"></div>')
            }
            ce_toolbarDisplay = this.settings.toolbarDisplay;
            ce_outline = this.settings.outline;
            var toolbar_attr = '';
            if (this.settings.toolbar == 'left') toolbar_attr = ' class="rte-side"';
            if (this.settings.toolbar == 'right') toolbar_attr = ' class="rte-side right"';
            var html_rte = '<div id="rte-toolbar"' + toolbar_attr + '>' + '<a href="#" data-rte-cmd="bold" title="Bold"> <i class="cb-icon-bold"></i> </a>' + '<a href="#" data-rte-cmd="italic" title="Italic"> <i class="cb-icon-italic"></i> </a>' + '<a href="#" data-rte-cmd="underline" title="Underline"> <i class="cb-icon-underline"></i> </a>' + '<a href="#" data-rte-cmd="strikethrough" title="Strikethrough"> <i class="cb-icon-strike"></i> </a>' + '<a href="#" data-rte-cmd="color" title="Color"> <i class="cb-icon-color"></i> </a>' + '<a href="#" data-rte-cmd="fontsize" title="Font Size"> <i class="cb-icon-fontsize"></i> </a>' + '<a href="#" data-rte-cmd="removeFormat" title="Clean"> <i class="cb-icon-eraser"></i> </a>' + '<a href="#" data-rte-cmd="formatPara" title="Paragraph"> <i class="cb-icon-header"></i> </a>' + '<a href="#" data-rte-cmd="font" title="Font"> <i class="cb-icon-font"></i> </a>' + '<a href="#" data-rte-cmd="align" title="Alignment"> <i class="cb-icon-align-justify"></i> </a>' + '<a href="#" data-rte-cmd="list" title="List"> <i class="cb-icon-list-bullet" style="font-size:14px;line-height:1.3"></i> </a>' + '<a href="#" data-rte-cmd="createLink" title="Link"> <i class="cb-icon-link"></i> </a>' + '<a href="#" data-rte-cmd="unlink" title="Remove Link"> <i class="cb-icon-unlink"></i> </a>' + '<a href="#" data-rte-cmd="html" title="HTML"> <i class="cb-icon-code"></i> </a>' + '</div>' + '' + '<div id="divRteLink">' + '<i class="cb-icon-link"></i> Edit Link' + '</div>' + '' + '<div id="divFrameLink">' + '<i class="cb-icon-link"></i> Edit Link' + '</div>' + '' + '<div class="md-modal" id="md-createlink">' + '<div class="md-content">' + '<div class="md-body">' + '<div class="md-label">Link:</div>' + (bUseCustomFileSelect ? '<input type="text" id="txtLink" class="inptxt" style="float:left;width:50%;" value="http:/' + '/"></input><i class="cb-icon-link md-btnbrowse" id="btnLinkBrowse" style="width:10%;"></i>' : '<input type="text" id="txtLink" class="inptxt" value="http:/' + '/" style="float:left;width:60%"></input>') + '<br style="clear:both">' + '<div class="md-label">Text:</div>' + '<input type="text" id="txtLinkText" class="inptxt" style="float:right;width:60%"></input>' + '<br style="clear:both">' + '<div class="md-label">Target:</div>' + '<label style="float:left;" for="chkNewWindow" class="inpchk"><input type="checkbox" id="chkNewWindow"></input> New Window</label>' + '</div>' + '<div class="md-footer">' + '<button id="btnLinkOk"> Ok </button>' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-createsrc">' + '<div class="md-content">' + '<div class="md-body">' + '<input type="text" id="txtSrc" class="inptxt" value="http:/' + '/"></input>' + '</div>' + '<div class="md-footer">' + '<button id="btnSrcOk"> Ok </button>' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-align" style="background:#fff;padding:15px 0px 15px 15px;border-radius:12px">' + '<div class="md-content">' + '<div class="md-body">' + '<button class="md-pickalign" data-align="left" title="Left"> <i class="cb-icon-align-left"></i> <span>Left</span> </button>' + '<button class="md-pickalign" data-align="center" title="Center"> <i class="cb-icon-align-center"></i> <span>Center</span> </button>' + '<button class="md-pickalign" data-align="right" title="Right"> <i class="cb-icon-align-right"></i> <span>Right</span> </button>' + '<button class="md-pickalign" data-align="justify" title="Full"> <i class="cb-icon-align-justify"></i> <span>Full</span> </button>' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-list" style="background:#fff;padding:15px 0px 15px 15px;border-radius:12px">' + '<div class="md-content">' + '<div class="md-body">' + '<button class="md-picklist half" data-list="indent" title="Indent" style="margin-right:0px"> <i class="cb-icon-indent-left"></i> </button>' + '<button class="md-picklist half" data-list="outdent" title="Outdent"> <i class="cb-icon-indent-right"></i> </button>' + '<button class="md-picklist" data-list="insertUnorderedList" title="Bulleted List"> <i class="cb-icon-list-bullet"></i> <span>Bulleted</span> </button>' + '<button class="md-picklist" data-list="insertOrderedList" title="Numbered List"> <i class="cb-icon-list-numbered"></i> <span>Numbered</span> </button>' + '<button class="md-picklist" data-list="normal" title="Remove List"> <i class="cb-icon-cancel"></i> <span>Remove</span> </button>' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-fonts" style="border-radius:12px">' + '<div class="md-content" style="border-radius:12px">' + '<div class="md-body">' + '<iframe id="ifrFonts" style="width:100%;height:371px;border: none;display: block;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAFElEQVQYV2P8DwQMBADjqCKiggAAmZsj5vuXmnUAAAAASUVORK5CYII="></iframe>' + '<button class="md-pickfontfamily" data-font-family="" data-provider="" style="display:none"></button>' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-fontsize" style="border-radius:12px">' + '<div class="md-content" style="border-radius:12px">' + '<div class="md-body">' + '<iframe id="ifrFontSize" style="width:100%;height:319px;border: none;display: block;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAFElEQVQYV2P8DwQMBADjqCKiggAAmZsj5vuXmnUAAAAASUVORK5CYII="></iframe>' + '<button class="md-pickfontsize" data-font-size="" style="display:none"></button>' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-headings" style="border-radius:12px">' + '<div class="md-content" style="border-radius:12px">' + '<div class="md-body">' + '<iframe id="ifrHeadings" style="width:100%;height:335px;border: none;display: block;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAFElEQVQYV2P8DwQMBADjqCKiggAAmZsj5vuXmnUAAAAASUVORK5CYII="></iframe>' + '<button class="md-pickheading" data-heading="" style="display:none"></button>' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-color" style="background:#fff;padding:15px 0px 15px 15px;border-radius:12px">' + '<div class="md-content">' + '<div class="md-body">' + '<div style="width:100%">' + '<select id="selColorApplyTo" style="width:85%"><option value="1">Text Color</option><option value="2">Background</option><option value="3">Block Background</option></select>' + '<button id="btnCleanColor" style="cursor: pointer;background: #FFFFFF;border: none;margin: 0 0 0 10px;vertical-align: middle;"><i class="cb-icon-eraser" style="color:#555;font-size:25px"></i></button>' + '</div>' + '[COLORS]' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-html">' + '<div class="md-content">' + '<div class="md-body">' + '<textarea id="txtHtml" class="inptxt" style="height:350px;"></textarea>' + '</div>' + '<div class="md-footer">' + '<button id="btnHtmlOk"> Ok </button>' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-fileselect">' + '<div class="md-content">' + '<div class="md-body">' + (bUseCustomFileSelect ? '<iframe id="ifrFileBrowse" style="width:100%;height:400px;border: none;display: block;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAFElEQVQYV2P8DwQMBADjqCKiggAAmZsj5vuXmnUAAAAASUVORK5CYII="></iframe>' : '') + '</div>' + '</div>' + '</div>' + '<input type="hidden" id="active-input" />' + '' + '<div class="md-modal" id="md-delrowconfirm">' + '<div class="md-content">' + '<div class="md-body">' + '<div style="padding:12px 20px 25px;text-align:center;">' + '<p>Você tem certeza que deseja remover esse bloco?</p>' + '<button id="btnDelRowCancel"> NÃO </button>' + '<button id="btnDelRowOk" style="margin-left:12px"> SIM </button>' + '</div>' + '</div>' + '</div>' + '</div>' + '' + '<div id="temp-contenteditor"></div>' + '';
            var html_colors = '';
            for (var i = 0; i < this.settings.colors.length; i++) {
                if (this.settings.colors[i] == '#ececec') {
                    html_colors += '<button class="md-pick" style="background:' + this.settings.colors[i] + ';border:#e7e7e7 1px solid"></button>'
                } else {
                    html_colors += '<button class="md-pick" style="background:' + this.settings.colors[i] + ';border:' + this.settings.colors[i] + ' 1px solid"></button>'
                }
            }
            html_rte = html_rte.replace('[COLORS]', html_colors);
            if (jQuery('#rte-toolbar').length == 0) {
                jQuery('#divCb').append(html_rte);
                this.prepareRteCommand('bold');
                this.prepareRteCommand('italic');
                this.prepareRteCommand('underline');
                this.prepareRteCommand('strikethrough');
                this.prepareRteCommand('undo');
                this.prepareRteCommand('redo')
            }
            var isCtrl = false;
            $element.bind('keyup', function (e) {
                $element.data('contenteditor').realtime()
            });
            $element.bind('mouseup', function (e) {
                $element.data('contenteditor').realtime()
            });
            jQuery(document).on("paste", '#' + $element.attr('id'), function (e) {
                pasteContent($activeElement)
            });
            $element.bind('keydown', function (e) {
                if (e.which == 46 || e.which == 8) {
                    var el;
                    try {
                        if (window.getSelection) {
                            el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode
                        } else if (document.selection) {
                            el = document.selection.createRange().parentElement()
                        }
                        if (el.nodeName.toLowerCase() == 'p') {
                            var t = '';
                            if (window.getSelection) {
                                t = window.getSelection().toString()
                            } else if (document.getSelection) {
                                t = document.getSelection().toString()
                            } else if (document.selection) {
                                t = document.selection.createRange().text
                            }
                            if (t == el.innerText) {
                                jQuery(el).html('<br>');
                                return false
                            }
                        }
                    } catch (e) {}
                }
                if (e.which == 17) {
                    isCtrl = true;
                    return
                }
                if ((e.which == 86 && isCtrl == true) || (e.which == 86 && e.metaKey)) {
                    pasteContent($activeElement)
                }
                if (e.ctrlKey) {
                    if (e.keyCode == 65 || e.keyCode == 97) {
                        e.preventDefault();
                        var is_ie = detectIE();
                        var el;
                        try {
                            if (window.getSelection) {
                                el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode
                            } else if (document.selection) {
                                el = document.selection.createRange().parentElement()
                            }
                        } catch (e) {
                            return
                        }
                        if (is_ie) {
                            var range = document.body.createTextRange();
                            range.moveToElementText(el);
                            range.select()
                        } else {
                            var range = document.createRange();
                            range.selectNodeContents(el);
                            var oSel = window.getSelection();
                            oSel.removeAllRanges();
                            oSel.addRange(range)
                        }
                    }
                }
            }).keyup(function (e) {
                if (e.which == 17) {
                    isCtrl = false
                }
            });
            jQuery(document).on('mousedown', function (event) {
                var $active_element;
                if (jQuery(event.target).parents(".ui-draggable").length > 0) {
                    if (jQuery(event.target).parents(".ui-draggable").parent().data('contentbuilder')) {
                        $active_element = jQuery(event.target).parents(".ui-draggable").parent()
                    }
                }
                var bEditable = false;
                if (jQuery('#rte-toolbar').css('display') == 'none') return;
                var el = jQuery(event.target).prop("tagName").toLowerCase();
                jQuery(event.target).parents().each(function (e) {
                    if (jQuery(this).is('[contenteditable]') || jQuery(this).hasClass('md-modal') || jQuery(this).attr('id') == 'divCb') {
                        bEditable = true;
                        return
                    }
                });
                if (jQuery(event.target).is('[contenteditable]')) {
                    bEditable = true;
                    return
                }
                if (!bEditable) {
                    $activeElement = null;
                    if (ce_toolbarDisplay == 'auto') {
                        var el;
                        if (window.getSelection) {
                            el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode
                        } else if (document.selection) {
                            el = document.selection.createRange().parentElement()
                        }
                        var found = false;
                        jQuery(el).parents().each(function () {
                            if (jQuery(this).data('contentbuilder')) {
                                found = true
                            }
                        });
                        if (!found) jQuery('#rte-toolbar').css('display', 'none')
                    }
                    if (ce_outline) {
                        for (var i = 0; i < instances.length; i++) {
                            jQuery(instances[i]).css('outline', '');
                            jQuery(instances[i]).find('*').css('outline', '')
                        }
                    }
                    jQuery('.row-tool').stop(true, true).fadeOut(0);
                    jQuery(".ui-draggable").removeClass('code');
                    jQuery(".ui-draggable").removeClass('ui-dragbox-outlined');
                    jQuery('#rte-toolbar').css('display', 'none')
                }
            })
        };
        this.realtime = function () {
            var is_ie = detectIE();
            var el;
            try {
                if (window.getSelection) {
                    el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode
                } else if (document.selection) {
                    el = document.selection.createRange().parentElement()
                }
            } catch (e) {
                return
            }
            if (jQuery(el).parents("[data-mode='code']").length > 0) return;
            if (jQuery(el).parents("[data-mode='readonly']").length > 0) return;
            if (el.nodeName.toLowerCase() == 'a') {
                if (is_ie) {} else {}
                jQuery("#divRteLink").addClass('forceshow')
            } else {
                jQuery("#divRteLink").removeClass('forceshow')
            }
        };
        this.render = function () {
            var zoom;
            if (localStorage.getItem("zoom") != null) {
                zoom = localStorage.zoom
            } else {
                zoom = $element.css('zoom')
            }
            if (zoom == undefined) zoom = 1;
            localStorage.zoom = zoom;
            var editable = $element.data('contenteditor').settings.editable;
            if (editable == '') {
                $element.attr('contenteditable', 'true');
                $element.unbind('mousedown');
                $element.bind('mousedown', function (e) {
                    $activeElement = jQuery(this);
                    jQuery("#rte-toolbar").stop(true, true).fadeIn(200);
                    if (ce_outline) {
                        for (var i = 0; i < instances.length; i++) {
                            jQuery(instances[i]).css('outline', '');
                            jQuery(instances[i]).find('*').css('outline', '')
                        }
                        jQuery(this).css('outline', 'rgba(0, 0, 0, 0.43) dashed 1px')
                    }
                })
            } else {
                $element.find(editable).each(function () {
                    if (jQuery(this).parents("[data-mode='code']").length > 0) return;
                    if (jQuery(this).parents("[data-mode='readonly']").length > 0) return;
                    var editMode = $element.data('contenteditor').settings.editMode;
                    if (editMode == 'default') {} else {
                        var attr = jQuery(this).attr('contenteditable');
                        if (typeof attr !== typeof undefined && attr !== false) {} else {
                            jQuery(this).attr('contenteditable', 'true')
                        }
                    }
                });
                $element.find(editable).unbind('mousedown');
                $element.find(editable).bind('mousedown', function (e) {
                    $activeElement = jQuery(this);
                    jQuery("#rte-toolbar").stop(true, true).fadeIn(200);
                    if (ce_outline) {
                        for (var i = 0; i < instances.length; i++) {
                            jQuery(instances[i]).css('outline', '');
                            jQuery(instances[i]).find('*').css('outline', '')
                        }
                        jQuery(this).css('outline', 'rgba(0, 0, 0, 0.43) dashed 1px')
                    }
                });
                $element.find('.edit').find(editable).removeAttr('contenteditable')
            }
            $element.find('a').each(function () {
                if (jQuery(this).parents("[data-mode='code']").length > 0) return;
                if (jQuery(this).parents("[data-mode='readonly']").length > 0) return;
                jQuery(this).attr('contenteditable', 'true')
            });
            var editMode = $element.data('contenteditor').settings.editMode;
            if (editMode == 'default') {
                $element.find("h1,h2,h3,h4,h5,h6").unbind('keydown');
                $element.find("h1,h2,h3,h4,h5,h6").bind('keydown', function (e) {
                    if (e.keyCode == 13) {
                        var is_ie = detectIE();
                        if (is_ie && is_ie <= 10) {
                            var oSel = document.selection.createRange();
                            if (oSel.parentElement) {
                                oSel.pasteHTML('<br>');
                                e.cancelBubble = true;
                                e.returnValue = false;
                                oSel.select();
                                oSel.moveEnd("character", 1);
                                oSel.moveStart("character", 1);
                                oSel.collapse(false);
                                return false
                            }
                        } else {
                            var oSel = window.getSelection();
                            var range = oSel.getRangeAt(0);
                            range.extractContents();
                            range.collapse(true);
                            var docFrag = range.createContextualFragment('<br>');
                            var lastNode = docFrag.lastChild;
                            range.insertNode(docFrag);
                            range.setStartAfter(lastNode);
                            range.setEndAfter(lastNode);
                            if (range.endContainer.nodeType == 1) {
                                if (range.endOffset == range.endContainer.childNodes.length - 1) {
                                    range.insertNode(range.createContextualFragment("<br />"));
                                    range.setStartAfter(lastNode);
                                    range.setEndAfter(lastNode)
                                }
                            }
                            var comCon = range.commonAncestorContainer;
                            if (comCon && comCon.parentNode) {
                                try {
                                    comCon.parentNode.normalize()
                                } catch (e) {}
                            }
                            oSel.removeAllRanges();
                            oSel.addRange(range);
                            return false
                        }
                    }
                });
                $element.find("h1,h2,h3,h4,h5,h6,p,img").each(function () {
                    if (jQuery(this).parents("[data-mode='code']").length > 0) return;
                    if (jQuery(this).parents("[data-mode='readonly']").length > 0) return;
                    jQuery(this).parent().attr('contenteditable', true)
                });
                $element.find(".column").each(function () {
                    if (jQuery(this).parents("[data-mode='code']").length > 0) return;
                    if (jQuery(this).parents("[data-mode='readonly']").length > 0) return;
                    jQuery(this).attr('contenteditable', true)
                });
                $element.find("div").unbind('keyup');
                $element.find("div").bind('keyup', function (e) {
                    var el;
                    var curr;
                    if (window.getSelection) {
                        curr = window.getSelection().getRangeAt(0).commonAncestorContainer;
                        el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode
                    } else if (document.selection) {
                        curr = document.selection.createRange();
                        el = document.selection.createRange().parentElement()
                    }
                    if (e.keyCode == 13 && !event.shiftKey) {
                        var is_ie = detectIE();
                        if (is_ie > 0) {} else {
                            var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
                            var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
                            var isOpera = window.opera;
                            var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
                            if (isChrome || isOpera) {
                                if (jQuery(el).prop("tagName").toLowerCase() == 'p' || jQuery(el).prop("tagName").toLowerCase() == 'div') {
                                    document.execCommand('formatBlock', false, '<p>')
                                }
                            }
                            if (isFirefox) {
                                if (!jQuery(curr).html()) document.execCommand('formatBlock', false, '<p>')
                            }
                        }
                    }
                    if (e.keyCode == 8 || e.keyCode == 46) {
                        if (jQuery(el).prop("tagName").toLowerCase() == 'div') {
                            document.execCommand('formatBlock', false, '<p>')
                        }
                    }
                })
            } else {
                $element.find("p").unbind('keydown');
                $element.find("p").bind('keydown', function (e) {
                    if (e.keyCode == 13 && $element.find("li").length == 0) {
                        var UA = navigator.userAgent.toLowerCase();
                        var LiveEditor_isIE = (UA.indexOf('msie') >= 0) ? true : false;
                        if (LiveEditor_isIE) {
                            var oSel = document.selection.createRange();
                            if (oSel.parentElement) {
                                oSel.pasteHTML('<br>');
                                e.cancelBubble = true;
                                e.returnValue = false;
                                oSel.select();
                                oSel.moveEnd("character", 1);
                                oSel.moveStart("character", 1);
                                oSel.collapse(false);
                                return false
                            }
                        } else {
                            var oSel = window.getSelection();
                            var range = oSel.getRangeAt(0);
                            range.extractContents();
                            range.collapse(true);
                            var docFrag = range.createContextualFragment('<br>');
                            var lastNode = docFrag.lastChild;
                            range.insertNode(docFrag);
                            range.setStartAfter(lastNode);
                            range.setEndAfter(lastNode);
                            if (range.endContainer.nodeType == 1) {
                                if (range.endOffset == range.endContainer.childNodes.length - 1) {
                                    range.insertNode(range.createContextualFragment("<br />"));
                                    range.setStartAfter(lastNode);
                                    range.setEndAfter(lastNode)
                                }
                            }
                            var comCon = range.commonAncestorContainer;
                            if (comCon && comCon.parentNode) {
                                try {
                                    comCon.parentNode.normalize()
                                } catch (e) {}
                            }
                            oSel.removeAllRanges();
                            oSel.addRange(range);
                            return false
                        }
                    }
                })
            }
            jQuery('#rte-toolbar a[data-rte-cmd="removeElement"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="removeElement"]').click(function (e) {
                $activeElement.remove();
                $element.data('contenteditor').settings.hasChanged = true;
                $element.data('contenteditor').render();
                e.preventDefault()
            });
            jQuery('#rte-toolbar a[data-rte-cmd="color"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="color"]').click(function (e) {
                var savedSel = saveSelection();
                jQuery('#md-color').css('max-width', '465px');
                jQuery('#md-color').simplemodal();
                jQuery('#md-color').data('simplemodal').show();
                e.preventDefault();
                var text = getSelected();
                jQuery('.md-pick').unbind('click');
                jQuery('.md-pick').click(function () {
                    restoreSelection(savedSel);
                    var el;
                    var curr;
                    if (window.getSelection) {
                        curr = window.getSelection().getRangeAt(0).commonAncestorContainer;
                        el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode
                    } else if (document.selection) {
                        curr = document.selection.createRange();
                        el = document.selection.createRange().parentElement()
                    }
                    var selColMode = jQuery('#selColorApplyTo').val();
                    if (jQuery.trim(text) != '' && jQuery(curr).text() != text) {
                        if (selColMode == 1) {
                            document.execCommand("ForeColor", false, jQuery(this).css("background-color"))
                        }
                        if (selColMode == 2) {
                            document.execCommand("BackColor", false, jQuery(this).css("background-color"))
                        }
                        var fontElements = document.getElementsByTagName("font");
                        for (var i = 0, len = fontElements.length; i < len; ++i) {
                            var s = fontElements[i].color;
                            if (s != '') {
                                fontElements[i].removeAttribute("color");
                                fontElements[i].style.color = s
                            }
                        }
                        var is_ie = detectIE();
                        if (is_ie) {
                            $activeElement.find('span').each(function () {
                                if (jQuery(this).find('span').length == 1) {
                                    if (jQuery(this).text() == jQuery(this).find('span:first').text()) {
                                        var innerspanstyle = jQuery(this).find('span:first').attr('style');
                                        jQuery(this).html(jQuery(this).find('span:first').html());
                                        var newstyle = jQuery(this).attr('style') + ';' + innerspanstyle;
                                        jQuery(this).attr('style', newstyle)
                                    }
                                }
                            })
                        }
                    } else if (jQuery(curr).text() == text) {
                        if (selColMode == 1) {
                            if (jQuery(curr).html()) {
                                jQuery(curr).css('color', jQuery(this).css("background-color"))
                            } else {
                                jQuery(curr).parent().css('color', jQuery(this).css("background-color"))
                            }
                        }
                        if (selColMode == 2) {
                            if (jQuery(curr).html()) {
                                jQuery(curr).css('background-color', jQuery(this).css("background-color"))
                            } else {
                                jQuery(curr).parent().css('background-color', jQuery(this).css("background-color"))
                            }
                        }
                    } else {
                        if (selColMode == 1) {
                            jQuery(el).css('color', jQuery(this).css("background-color"))
                        }
                        if (selColMode == 2) {
                            jQuery(el).css('background-color', jQuery(this).css("background-color"))
                        }
                    };
                    if (selColMode == 3) {
                        jQuery(el).parents('.ui-draggable').children().first().css('background-color', jQuery(this).css("background-color"))
                    }
                    jQuery('#md-color').data('simplemodal').hide()
                });
                jQuery('#btnCleanColor').unbind('click');
                jQuery('#btnCleanColor').click(function () {
                    restoreSelection(savedSel);
                    var el;
                    var curr;
                    if (window.getSelection) {
                        curr = window.getSelection().getRangeAt(0).commonAncestorContainer;
                        el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode
                    } else if (document.selection) {
                        curr = document.selection.createRange();
                        el = document.selection.createRange().parentElement()
                    }
                    var selColMode = jQuery('#selColorApplyTo').val();
                    if (jQuery.trim(text) != '' && jQuery(curr).text() != text) {
                        if (selColMode == 1) {
                            document.execCommand("ForeColor", false, '')
                        }
                        if (selColMode == 2) {
                            document.execCommand("BackColor", false, '')
                        }
                        var fontElements = document.getElementsByTagName("font");
                        for (var i = 0, len = fontElements.length; i < len; ++i) {
                            var s = fontElements[i].color;
                            fontElements[i].removeAttribute("color");
                            fontElements[i].style.color = s
                        }
                    } else if (jQuery(curr).text() == text) {
                        if (selColMode == 1) {
                            if (jQuery(curr).html()) {
                                jQuery(curr).css('color', '')
                            } else {
                                jQuery(curr).parent().css('color', '')
                            }
                        }
                        if (selColMode == 2) {
                            if (jQuery(curr).html()) {
                                jQuery(curr).css('background-color', '')
                            } else {
                                jQuery(curr).parent().css('background-color', '')
                            }
                        }
                    } else {
                        if (selColMode == 1) {
                            jQuery(el).css('color', '')
                        }
                        if (selColMode == 2) {
                            jQuery(el).css('background-color', '')
                        }
                    };
                    if (selColMode == 3) {
                        jQuery(curr).parents('.ui-draggable').children().first().css('background-color', '')
                    }
                    jQuery('#md-color').data('simplemodal').hide()
                })
            });
            jQuery('#rte-toolbar a[data-rte-cmd="fontsize"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="fontsize"]').click(function (e) {
                var savedSel = saveSelection();
                jQuery('#md-fontsize').css('max-width', '190px');
                jQuery('#md-fontsize').simplemodal();
                jQuery('#md-fontsize').data('simplemodal').show();
                e.preventDefault();
                if (jQuery('#ifrFontSize').attr('src').indexOf('fontsize.html') == -1) {
                    jQuery('#ifrFontSize').attr('src', sScriptPath + 'fontsize.html')
                }
                var text = getSelected();
                jQuery('.md-pickfontsize').unbind('click');
                jQuery('.md-pickfontsize').click(function () {
                    restoreSelection(savedSel);
                    var el;
                    var curr;
                    if (window.getSelection) {
                        curr = window.getSelection().getRangeAt(0).commonAncestorContainer;
                        el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode
                    } else if (document.selection) {
                        curr = document.selection.createRange();
                        el = document.selection.createRange().parentElement()
                    }
                    var s = jQuery(this).attr('data-font-size');
                    if (jQuery.trim(text) != '' && jQuery(curr).text() != text) {
                        document.execCommand("fontSize", false, "7");
                        var fontElements = document.getElementsByTagName("font");
                        for (var i = 0, len = fontElements.length; i < len; ++i) {
                            if (fontElements[i].size == "7") {
                                fontElements[i].removeAttribute("size");
                                fontElements[i].style.fontSize = s
                            }
                        }
                    } else if (jQuery(curr).text() == text) {
                        if (jQuery(curr).html()) {
                            jQuery(curr).css('font-size', s)
                        } else {
                            jQuery(curr).parent().css('font-size', s)
                        }
                    } else {
                        jQuery(el).css('font-size', s)
                    };
                    jQuery(this).blur();
                    $element.data('contenteditor').settings.hasChanged = true;
                    e.preventDefault();
                    jQuery('#md-fontsize').data('simplemodal').hide()
                })
            });
            jQuery('#rte-toolbar a[data-rte-cmd="formatPara"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="formatPara"]').click(function (e) {
                var savedSel = saveSelection();
                jQuery('#md-headings').css('max-width', '225px');
                jQuery('#md-headings').simplemodal();
                jQuery('#md-headings').data('simplemodal').show();
                e.preventDefault();
                if (jQuery('#ifrHeadings').attr('src').indexOf('headings.html') == -1) {
                    jQuery('#ifrHeadings').attr('src', sScriptPath + 'headings.html')
                }
                jQuery('.md-pickheading').unbind('click');
                jQuery('.md-pickheading').click(function () {
                    restoreSelection(savedSel);
                    var s = jQuery(this).attr('data-heading');
                    $element.attr('contenteditable', true);
                    document.execCommand('formatBlock', false, '<' + s + '>');
                    $element.removeAttr('contenteditable');
                    $element.data('contenteditor').render();
                    jQuery(this).blur();
                    $element.data('contenteditor').settings.hasChanged = true;
                    e.preventDefault();
                    jQuery('#md-headings').data('simplemodal').hide()
                })
            });
            jQuery('#rte-toolbar a[data-rte-cmd="removeFormat"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="removeFormat"]').click(function (e) {
                document.execCommand('removeFormat', false, null);
                document.execCommand('removeFormat', false, null);
                jQuery(this).blur();
                $element.data('contenteditor').settings.hasChanged = true;
                e.preventDefault()
            });
            jQuery('#rte-toolbar a[data-rte-cmd="unlink"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="unlink"]').click(function (e) {
                document.execCommand('unlink', false, null);
                jQuery("#divRteLink").removeClass('forceshow');
                jQuery(this).blur();
                $element.data('contenteditor').settings.hasChanged = true;
                e.preventDefault()
            });
            var storedEl;
            jQuery('#rte-toolbar a[data-rte-cmd="html"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="html"]').click(function (e) {
                var el;
                if (window.getSelection) {
                    el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode
                } else if (document.selection) {
                    el = document.selection.createRange().parentElement()
                }
                var found = false;
                jQuery(el).parents().each(function () {
                    if (jQuery(this).data('contentbuilder')) {
                        jQuery(this).data('contentbuilder').viewHtml();
                        found = true;
                        storedEl = el
                    }
                });
                if (!found && storedEl) {
                    el = storedEl;
                    jQuery(el).parents().each(function () {
                        if (jQuery(this).data('contentbuilder')) {
                            jQuery(this).data('contentbuilder').viewHtml()
                        }
                    })
                }
                e.preventDefault()
            });
            jQuery('#rte-toolbar a[data-rte-cmd="font"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="font"]').click(function (e) {
                var savedSel = saveSelection();
                jQuery('#md-fonts').css('max-width', '300px');
                jQuery('#md-fonts').simplemodal();
                jQuery('#md-fonts').data('simplemodal').show();
                e.preventDefault();
                if (jQuery('#ifrFonts').attr('src').indexOf('fonts.html') == -1) {
                    jQuery('#ifrFonts').attr('src', sScriptPath + 'fonts.html')
                }
                var text = getSelected();
                jQuery('.md-pickfontfamily').unbind('click');
                jQuery('.md-pickfontfamily').click(function () {
                    restoreSelection(savedSel);
                    var el;
                    var curr;
                    if (window.getSelection) {
                        curr = window.getSelection().getRangeAt(0).commonAncestorContainer;
                        el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode;
                        if (el.nodeName != 'H1' && el.nodeName != 'H2' && el.nodeName != 'H3' && el.nodeName != 'H4' && el.nodeName != 'H5' && el.nodeName != 'H6' && el.nodeName != 'P') {
                            el = el.parentNode
                        }
                    } else if (document.selection) {
                        curr = document.selection.createRange();
                        el = document.selection.createRange().parentElement();
                        if (el.nodeName != 'H1' && el.nodeName != 'H2' && el.nodeName != 'H3' && el.nodeName != 'H4' && el.nodeName != 'H5' && el.nodeName != 'H6' && el.nodeName != 'P') {
                            el = el.parentElement()
                        }
                    }
                    var s = jQuery(this).attr('data-font-family');
                    if (jQuery.trim(text) != '' && jQuery(curr).text() != text) {
                        document.execCommand("fontName", false, s);
                        var fontElements = document.getElementsByTagName("font");
                        for (var i = 0, len = fontElements.length; i < len; ++i) {
                            if (fontElements[i].face == s) {
                                fontElements[i].removeAttribute("face");
                                fontElements[i].style.fontFamily = s
                            }
                        }
                    } else if (jQuery(curr).text() == text) {
                        if (jQuery(curr).html()) {
                            jQuery(curr).css('font-family', s)
                        } else {
                            jQuery(curr).parent().css('font-family', s)
                        }
                    } else {
                        jQuery(el).css('font-family', s)
                    };
                    var fontname = s.split(',')[0];
                    var provider = jQuery(this).attr('data-provider');
                    if (provider == 'google') {
                        var bExist = false;
                        var links = document.getElementsByTagName("link");
                        for (var i = 0; i < links.length; i++) {
                            var sSrc = links[i].href.toLowerCase();
                            sSrc = sSrc.replace(/\+/g, ' ').replace(/%20/g, ' ');
                            if (sSrc.indexOf(fontname.toLowerCase()) != -1) bExist = true
                        }
                        if (!bExist) {
                            jQuery(el).parents().each(function () {
                                if (jQuery(this).data('contentbuilder')) {
                                    jQuery(this).append('<link href="//fonts.googleapis.com/css?family=' + fontname + '" rel="stylesheet" property="stylesheet" type="text/css">')
                                }
                            })
                        }
                    }
                    jQuery(cb_list).each(function () {
                        var $cb = jQuery(this);
                        $cb.find('link').each(function () {
                            var sSrc = jQuery(this).attr('href').toLowerCase();
                            if (sSrc.indexOf('googleapis') != -1) {
                                sSrc = sSrc.replace(/\+/g, ' ').replace(/%20/g, ' ');
                                var fontname = sSrc.substr(sSrc.indexOf('family=') + 7);
                                if (fontname.indexOf(':') != -1) {
                                    fontname = fontname.split(':')[0]
                                }
                                if (fontname.indexOf('|') != -1) {
                                    fontname = fontname.split('|')[0]
                                }
                                var tmp = $cb.data('contentbuilder').html().toLowerCase();
                                var count = tmp.split(fontname).length;
                                if (count < 3) {
                                    jQuery(this).attr('rel', '_del')
                                }
                            }
                        })
                    });
                    $element.find('[rel="_del"]').remove();
                    jQuery(this).blur();
                    $element.data('contenteditor').settings.hasChanged = true;
                    e.preventDefault();
                    jQuery('#md-fonts').data('simplemodal').hide()
                })
            });
            jQuery('#rte-toolbar a[data-rte-cmd="align"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="align"]').click(function (e) {
                var savedSel = saveSelection();
                jQuery('#md-align').css('max-width', '185px');
                jQuery('#md-align').simplemodal();
                jQuery('#md-align').data('simplemodal').show();
                e.preventDefault();
                jQuery('.md-pickalign').unbind('click');
                jQuery('.md-pickalign').click(function () {
                    restoreSelection(savedSel);
                    var el;
                    if (window.getSelection) {
                        el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode;
                        if (el.nodeName != 'H1' && el.nodeName != 'H2' && el.nodeName != 'H3' && el.nodeName != 'H4' && el.nodeName != 'H5' && el.nodeName != 'H6' && el.nodeName != 'P') {
                            el = el.parentNode
                        }
                    } else if (document.selection) {
                        el = document.selection.createRange().parentElement();
                        if (el.nodeName != 'H1' && el.nodeName != 'H2' && el.nodeName != 'H3' && el.nodeName != 'H4' && el.nodeName != 'H5' && el.nodeName != 'H6' && el.nodeName != 'P') {
                            el = el.parentElement()
                        }
                    }
                    var s = jQuery(this).data('align');
                    el.style.textAlign = s;
                    jQuery(this).blur();
                    $element.data('contenteditor').settings.hasChanged = true;
                    e.preventDefault();
                    jQuery('#md-align').data('simplemodal').hide()
                })
            });
            jQuery('#rte-toolbar a[data-rte-cmd="list"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="list"]').click(function (e) {
                var savedSel = saveSelection();
                jQuery('#md-list').css('max-width', '185px');
                jQuery('#md-list').simplemodal();
                jQuery('#md-list').data('simplemodal').show();
                e.preventDefault();
                jQuery('.md-picklist').unbind('click');
                jQuery('.md-picklist').click(function () {
                    restoreSelection(savedSel);
                    var s = jQuery(this).data('list');
                    try {
                        if (s == 'normal') {
                            document.execCommand('outdent', false, null);
                            document.execCommand('outdent', false, null);
                            document.execCommand('outdent', false, null)
                        } else {
                            document.execCommand(s, false, null)
                        }
                    } catch (e) {
                        $activeElement.parents('div').addClass('edit');
                        var el;
                        if (window.getSelection) {
                            el = window.getSelection().getRangeAt(0).commonAncestorContainer.parentNode;
                            el = el.parentNode
                        } else if (document.selection) {
                            el = document.selection.createRange().parentElement();
                            el = el.parentElement()
                        }
                        el.setAttribute('contenteditable', true);
                        if (s == 'normal') {
                            document.execCommand('outdent', false, null);
                            document.execCommand('outdent', false, null);
                            document.execCommand('outdent', false, null)
                        } else {
                            document.execCommand(s, false, null)
                        }
                        el.removeAttribute('contenteditable');
                        $element.data('contenteditor').render()
                    }
                    jQuery(this).blur();
                    $element.data('contenteditor').settings.hasChanged = true;
                    e.preventDefault();
                    jQuery('#md-list').data('simplemodal').hide()
                })
            });
            jQuery('#rte-toolbar a[data-rte-cmd="createLink"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="createLink"]').click(function (e) {
                var html = "";
                if (typeof window.getSelection != "undefined") {
                    var sel = window.getSelection();
                    if (sel.rangeCount) {
                        var container = document.createElement("div");
                        for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                            container.appendChild(sel.getRangeAt(i).cloneContents())
                        }
                        html = container.innerHTML
                    }
                } else if (typeof document.selection != "undefined") {
                    if (document.selection.type == "Text") {
                        html = document.selection.createRange().htmlText
                    }
                }
                if (html == '') {
                    alert('Please select some text.');
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return
                }
                var el;
                if (window.getSelection) {
                    el = window.getSelection().getRangeAt(0).commonAncestorContainer
                } else if (document.selection) {
                    el = document.selection.createRange()
                }
                if (el.nodeName.toLowerCase() == 'a') {
                    $activeLink = jQuery(el)
                } else {
                    document.execCommand('createLink', false, 'http://dummy');
                    $activeLink = jQuery("a[href='http://dummy']").first();
                    $activeLink.attr('href', 'http://')
                }
                jQuery('#md-createlink').css('max-width', '800px');
                jQuery('#md-createlink').simplemodal({
                    onCancel: function () {
                        if ($activeLink.attr('href') == 'http://') $activeLink.replaceWith($activeLink.html())
                    }
                });
                jQuery('#md-createlink').data('simplemodal').show();
                jQuery('#txtLink').val($activeLink.attr('href'));
                jQuery('#txtLinkText').val($activeLink.html());
                if ($activeLink.attr('target') == '_blank') {
                    jQuery('#chkNewWindow').prop('checked', true)
                } else {
                    jQuery('#chkNewWindow').removeAttr('checked')
                }
                jQuery('#btnLinkOk').unbind('click');
                jQuery('#btnLinkOk').bind('click', function (e) {
                    $activeLink.attr('href', jQuery('#txtLink').val());
                    if (jQuery('#txtLink').val() == 'http://' || jQuery('#txtLink').val() == '') {
                        $activeLink.replaceWith($activeLink.html())
                    }
                    $activeLink.html(jQuery('#txtLinkText').val());
                    if (jQuery('#chkNewWindow').is(":checked")) {
                        $activeLink.attr('target', '_blank')
                    } else {
                        $activeLink.removeAttr('target')
                    }
                    jQuery('#md-createlink').data('simplemodal').hide();
                    for (var i = 0; i < instances.length; i++) {
                        jQuery(instances[i]).data('contenteditor').settings.hasChanged = true;
                        jQuery(instances[i]).data('contenteditor').render()
                    }
                });
                e.preventDefault()
            });
            $element.find(".embed-responsive").unbind('hover');
            $element.find(".embed-responsive").hover(function (e) {
                if (jQuery(this).parents("[data-mode='code']").length > 0) return;
                if (jQuery(this).parents("[data-mode='readonly']").length > 0) return;
                var zoom = localStorage.zoom;
                if (zoom == 'normal') zoom = 1;
                if (zoom == undefined) zoom = 1;
                zoom = zoom + '';
                if (zoom.indexOf('%') != -1) {
                    zoom = zoom.replace('%', '') / 100
                }
                if (zoom == 'NaN') {
                    zoom = 1
                }
                zoom = zoom * 1;
                var _top;
                var _left;
                var scrolltop = jQuery(window).scrollTop();
                var offsettop = jQuery(this).offset().top;
                var offsetleft = jQuery(this).offset().left;
                var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
                var is_ie = detectIE();
                var browserok = true;
                if (is_firefox || is_ie) browserok = false;
                if (browserok) {
                    _top = ((offsettop - 20) * zoom) + (scrolltop - scrolltop * zoom);
                    _left = offsetleft * zoom
                } else {
                    if (is_ie) {
                        var space = $element.getPos().top;
                        var adjy_val = (-space / 1.1) * zoom + space / 1.1;
                        var space2 = $element.getPos().left;
                        var adjx_val = -space2 * zoom + space2;
                        var p = jQuery(this).getPos();
                        _top = ((p.top - 20) * zoom) + adjy_val;
                        _left = (p.left * zoom) + adjx_val
                    }
                    if (is_firefox) {
                        _top = offsettop - 20;
                        _left = offsetleft
                    }
                }
                jQuery("#divFrameLink").css("top", _top + "px");
                jQuery("#divFrameLink").css("left", _left + "px");
                jQuery("#divFrameLink").stop(true, true).css({
                    display: 'none'
                }).fadeIn(20);
                $activeFrame = jQuery(this).find('iframe');
                jQuery("#divFrameLink").unbind('click');
                jQuery("#divFrameLink").bind('click', function (e) {
                    jQuery('#md-createsrc').css('max-width', '800px');
                    jQuery('#md-createsrc').simplemodal();
                    jQuery('#md-createsrc').data('simplemodal').show();
                    jQuery('#txtSrc').val($activeFrame.attr('src'));
                    jQuery('#btnSrcOk').unbind('click');
                    jQuery('#btnSrcOk').bind('click', function (e) {
                        var srcUrl = jQuery('#txtSrc').val();
                        var youRegex = /^http[s]?:\/\/(((www.youtube.com\/watch\?(feature=player_detailpage&)?)v=)|(youtu.be\/))([^#\&\?]*)/;
                        var vimeoRegex = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/)|(video\/))?([0-9]+)\/?/;
                        var youRegexMatches = youRegex.exec(srcUrl);
                        var vimeoRegexMatches = vimeoRegex.exec(srcUrl);
                        if (youRegexMatches != null || vimeoRegexMatches != null) {
                            if (youRegexMatches != null && youRegexMatches.length >= 7) {
                                var youMatch = youRegexMatches[6];
                                srcUrl = '//www.youtube.com/embed/' + youMatch + '?rel=0'
                            }
                            if (vimeoRegexMatches != null && vimeoRegexMatches.length >= 7) {
                                var vimeoMatch = vimeoRegexMatches[6];
                                srcUrl = '//player.vimeo.com/video/' + vimeoMatch
                            }
                        }
                        $activeFrame.attr('src', srcUrl);
                        if (jQuery('#txtSrc').val() == '') {
                            $activeFrame.attr('src', '')
                        }
                        jQuery('#md-createsrc').data('simplemodal').hide();
                        for (var i = 0; i < instances.length; i++) {
                            jQuery(instances[i]).data('contenteditor').settings.hasChanged = true;
                            jQuery(instances[i]).data('contenteditor').render()
                        }
                    })
                });
                jQuery("#divFrameLink").hover(function (e) {
                    jQuery(this).stop(true, true).css("display", "block")
                }, function () {
                    jQuery(this).stop(true, true).fadeOut(0)
                })
            }, function (e) {
                jQuery("#divFrameLink").stop(true, true).fadeOut(0)
            });
            $element.find('a').not('.not-a').unbind('hover');
            $element.find('a').not('.not-a').hover(function (e) {
                if (jQuery(this).parents("[data-mode='code']").length > 0) return;
                if (jQuery(this).parents("[data-mode='readonly']").length > 0) return;
                if (jQuery(this).children('img').length == 1 && jQuery(this).children().length == 1) return;
                var zoom = localStorage.zoom;
                if (zoom == 'normal') zoom = 1;
                if (zoom == undefined) zoom = 1;
                zoom = zoom + '';
                if (zoom.indexOf('%') != -1) {
                    zoom = zoom.replace('%', '') / 100
                }
                if (zoom == 'NaN') {
                    zoom = 1
                }
                zoom = zoom * 1;
                var _top;
                var _left;
                var scrolltop = jQuery(window).scrollTop();
                var offsettop = jQuery(this).offset().top;
                var offsetleft = jQuery(this).offset().left;
                var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
                var is_ie = detectIE();
                var browserok = true;
                if (is_firefox || is_ie) browserok = false;
                if (browserok) {
                    _top = ((offsettop - 23) * zoom) + (scrolltop - scrolltop * zoom);
                    _left = offsetleft * zoom
                } else {
                    if (is_ie) {
                        var space = $element.getPos().top;
                        var adjy_val = (-space / 1.1) * zoom + space / 1.1;
                        var space2 = $element.getPos().left;
                        var adjx_val = -space2 * zoom + space2;
                        var p = jQuery(this).getPos();
                        _top = ((p.top - 23) * zoom) + adjy_val;
                        _left = (p.left * zoom) + adjx_val
                    }
                    if (is_firefox) {
                        _top = offsettop - 23;
                        _left = offsetleft
                    }
                }
                jQuery("#divRteLink").css("top", _top + "px");
                jQuery("#divRteLink").css("left", _left + "px");
                jQuery("#divRteLink").stop(true, true).css({
                    display: 'none'
                }).fadeIn(20);
                $activeLink = jQuery(this);
                jQuery("#divRteLink").unbind('click');
                jQuery("#divRteLink").bind('click', function (e) {
                    jQuery('#md-createlink').css('max-width', '550px');
                    jQuery('#md-createlink').simplemodal({
                        onCancel: function () {
                            if ($activeLink.attr('href') == 'http://') $activeLink.replaceWith($activeLink.html())
                        }
                    });
                    jQuery('#md-createlink').data('simplemodal').show();
                    jQuery('#txtLink').val($activeLink.attr('href'));
                    jQuery('#txtLinkText').val($activeLink.html());
                    if ($activeLink.attr('target') == '_blank') {
                        jQuery('#chkNewWindow').prop('checked', true)
                    } else {
                        jQuery('#chkNewWindow').removeAttr('checked')
                    }
                    jQuery('#btnLinkOk').unbind('click');
                    jQuery('#btnLinkOk').bind('click', function (e) {
                        $activeLink.attr('href', jQuery('#txtLink').val());
                        if (jQuery('#txtLink').val() == 'http://' || jQuery('#txtLink').val() == '') {
                            $activeLink.replaceWith($activeLink.html())
                        }
                        $activeLink.html(jQuery('#txtLinkText').val());
                        if (jQuery('#chkNewWindow').is(":checked")) {
                            $activeLink.attr('target', '_blank')
                        } else {
                            $activeLink.removeAttr('target')
                        }
                        jQuery('#md-createlink').data('simplemodal').hide();
                        for (var i = 0; i < instances.length; i++) {
                            jQuery(instances[i]).data('contenteditor').settings.hasChanged = true;
                            jQuery(instances[i]).data('contenteditor').render()
                        }
                    })
                });
                jQuery("#divRteLink").hover(function (e) {
                    jQuery(this).stop(true, true).css("display", "block")
                }, function () {
                    jQuery(this).stop(true, true).fadeOut(0)
                })
            }, function (e) {
                jQuery("#divRteLink").stop(true, true).fadeOut(0)
            });
            jQuery("#btnLinkBrowse").unbind('click');
            jQuery("#btnLinkBrowse").bind('click', function (e) {
                jQuery('#ifrFileBrowse').attr('src', $element.data('contenteditor').settings.fileselect);
                jQuery("#divToolImg").stop(true, true).fadeOut(0);
                jQuery("#divToolImgSettings").stop(true, true).fadeOut(0);
                jQuery("#divRteLink").stop(true, true).fadeOut(0);
                jQuery("#divFrameLink").stop(true, true).fadeOut(0);
                jQuery('#active-input').val('txtLink');
                jQuery('#md-fileselect').css('width', '65%');
                jQuery('#md-fileselect').simplemodal();
                jQuery('#md-fileselect').data('simplemodal').show()
            });
            $element.data('contenteditor').settings.onRender()
        };
        this.prepareRteCommand = function (s) {
            jQuery('#rte-toolbar a[data-rte-cmd="' + s + '"]').unbind('click');
            jQuery('#rte-toolbar a[data-rte-cmd="' + s + '"]').click(function (e) {
                try {
                    document.execCommand(s, false, null)
                } catch (e) {
                    $element.attr('contenteditable', true);
                    document.execCommand(s, false, null);
                    $element.removeAttr('contenteditable');
                    $element.data('contenteditor').render()
                }
                jQuery(this).blur();
                $element.data('contenteditor').settings.hasChanged = true;
                e.preventDefault()
            })
        };
        this.init()
    };
    jQuery.fn.contenteditor = function (options) {
        return this.each(function () {
            instances.push(this);
            if (undefined == jQuery(this).data('contenteditor')) {
                var plugin = new jQuery.contenteditor(this, options);
                jQuery(this).data('contenteditor', plugin)
            }
        })
    }
})(jQuery);

function pasteContent($activeElement) {
    var savedSel = saveSelection();
    jQuery('#idContentWord').remove();
    var tmptop = $activeElement.offset().top;
    jQuery('#divCb').append("<div style='position:absolute;z-index:-1000;top:" + tmptop + "px;left:-1000px;width:1px;height:1px;overflow:auto;' name='idContentWord' id='idContentWord' contenteditable='true'></div>");
    var pasteFrame = document.getElementById("idContentWord");
    pasteFrame.focus();
    setTimeout(function () {
        try {
            restoreSelection(savedSel);
            var $node = jQuery(getSelectionStartNode());
            if (jQuery('#idContentWord').length == 0) return;
            var sPastedText = '';
            var bRichPaste = false;
            if (jQuery('#idContentWord table').length > 0 || jQuery('#idContentWord img').length > 0 || jQuery('#idContentWord p').length > 0 || jQuery('#idContentWord a').length > 0) {
                bRichPaste = true
            }
            if (bRichPaste) {
                sPastedText = jQuery('#idContentWord').html();
                sPastedText = cleanHTML(sPastedText);
                jQuery('#idContentWord').html(sPastedText);
                if (jQuery('#idContentWord').children('p,h1,h2,h3,h4,h5,h6,ul,li').length > 1) {
                    jQuery('#idContentWord').contents().filter(function () {
                        return (this.nodeType == 3 && jQuery.trim(this.nodeValue) != '')
                    }).wrap("<p></p>").end().filter("br").remove()
                }
                sPastedText = '<div class="edit">' + jQuery('#idContentWord').html() + '</div>'
            } else {
                jQuery('#idContentWord').find('p,h1,h2,h3,h4,h5,h6').each(function () {
                    jQuery(this).html(jQuery(this).html() + ' ')
                });
                sPastedText = jQuery('#idContentWord').text()
            }
            jQuery('#idContentWord').remove();
            var oSel = window.getSelection();
            var range = oSel.getRangeAt(0);
            range.extractContents();
            range.collapse(true);
            var docFrag = range.createContextualFragment(sPastedText);
            var lastNode = docFrag.lastChild;
            range.insertNode(docFrag);
            range.setStartAfter(lastNode);
            range.setEndAfter(lastNode);
            range.collapse(false);
            var comCon = range.commonAncestorContainer;
            if (comCon && comCon.parentNode) {
                try {
                    comCon.parentNode.normalize()
                } catch (e) {}
            }
            oSel.removeAllRanges();
            oSel.addRange(range)
        } catch (e) {
            jQuery('#idContentWord').remove()
        }
    }, 200)
}
var savedSel;

function saveSelection() {
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            var ranges = [];
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                ranges.push(sel.getRangeAt(i))
            }
            return ranges
        }
    } else if (document.selection && document.selection.createRange) {
        return document.selection.createRange()
    }
    return null
};

function restoreSelection(savedSel) {
    if (savedSel) {
        if (window.getSelection) {
            sel = window.getSelection();
            sel.removeAllRanges();
            for (var i = 0, len = savedSel.length; i < len; ++i) {
                sel.addRange(savedSel[i])
            }
        } else if (document.selection && savedSel.select) {
            savedSel.select()
        }
    }
};

function getSelectionStartNode() {
    var node, selection;
    if (window.getSelection) {
        selection = getSelection();
        node = selection.anchorNode
    }
    if (!node && document.selection) {
        selection = document.selection;
        var range = selection.getRangeAt ? selection.getRangeAt(0) : selection.createRange();
        node = range.commonAncestorContainer ? range.commonAncestorContainer : range.parentElement ? range.parentElement() : range.item(0)
    }
    if (node) {
        return (node.nodeName == "#text" ? node.parentNode : node)
    }
};
var getSelectedNode = function () {
        var node, selection;
        if (window.getSelection) {
            selection = getSelection();
            node = selection.anchorNode
        }
        if (!node && document.selection) {
            selection = document.selection;
            var range = selection.getRangeAt ? selection.getRangeAt(0) : selection.createRange();
            node = range.commonAncestorContainer ? range.commonAncestorContainer : range.parentElement ? range.parentElement() : range.item(0)
        }
        if (node) {
            return (node.nodeName == "#text" ? node.parentNode : node)
        }
    };

function getSelected() {
    if (window.getSelection) {
        return window.getSelection()
    } else if (document.getSelection) {
        return document.getSelection()
    } else {
        var selection = document.selection && document.selection.createRange();
        if (selection.text) {
            return selection.text
        }
        return false
    }
    return false
};
(function (jQuery) {
    var tmpCanvas;
    var nInitialWidth;
    var nInitialHeight;
    var $imgActive;
    jQuery.imageembed = function (element, options) {
        var defaults = {
            hiquality: false,
            imageselect: '',
            fileselect: '',
            imageEmbed: true,
            embedOriginalChecked: false,
            hideEmbedOriginal: false,
            linkDialog: true,
            zoom: 0,
            onChanged: function () {},
            onImageBrowseClick: function () {},
            onImageSettingClick: function () {},
            onImageSelectClick: function () {},
            onFileSelectClick: function () {}
        };
        this.settings = {};
        var $element = jQuery(element),
            element = element;
        this.init = function () {
            this.settings = jQuery.extend({}, defaults, options);
            if (jQuery('#divCb').length == 0) {
                jQuery('body').append('<div id="divCb"></div>')
            }
            var html_photo_file = '';
            var html_photo_file2 = '';
            if (navigator.appName.indexOf('Microsoft') != -1) {
                html_photo_file = '<div id="divToolImg"><div class="fileinputs"><input type="file" name="file" class="my-file" /><div class="fakefile"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAC+klEQVRoQ+2au24aQRSGz+ySkEvPA9AQubNEhXgCSogEShmZGkSQpTS8AjUNSAjXlCRNStpQ8QK8AI6UOLazM5lZvGRvswsz43hYz0iWZe3uzPnOf25rQOVymcAzWsgAZ1xto3DGBQajsFE4Yx4wIZ0xQSM4RmGjcMY8YEI6Y4LKFy0H/9TCJ7b1VsiOo0PaAAv5Wf4ho/CBPjQhneYokRyezWZQKpW4WzuOA71eD5bLZdrx++vahnSz2YRutwu5XC4RZrPZQL1eP33g4XAI1Wo1FeRYlbVQ+FA1U+kfblitVtBut2Nvf3LgQqEAk8kE2G9VC2MM4/EYRqNRZMsnBy4WizCdTiGfz6vidffhqaw98Ha7hU6nA+v1OuCQfr8PLBV46ySB/bAeoL8qJ0GfHLA/D8P9OOmap/jJAXvq1mq12NB1lW404LL/GVqtD5QTPfwwZEJz+DtcXHwEDPf0z3+f+2mbw17oxvZjhIBgGz71LqFSqcQ6xK8wgT+AyZ0L/t+AMflNz3MiNYZXpXkKI2SDhfKw3V67xYwXAdGQJhT6lj77SqgbHP3ywMLMITeB8GIn84C9PJ3P5/s+vYPdGbxYLGAwGABv3k4aPkSIBYAZMg0tfBs4L6kP+yvy7OoKzt6dg3+UTJrQtABmpOHQThs8PGjbeuMrSuDmbdLLhTbAYZXTgJmTEMrBj+sbbs6yPb1KzMIewOJOWiLh7Nog85UH/7vxobO0bb12QYJrV4jCxZA56OuXb26Oq1pSwOGwTgtPz2gLvaRqv9gzOORXpAiyiywN3jdagXtlwaWACbnf9UWBxdRjbWmnLA1l3qK92kYs79UsOeCYaq3GrOAuokNGnC1SwLRWg4NpT37kpREwHUIwzb9HXs8LWKccZsKK/Nv24IBwYdkIGm5jB+8QuVEyh+WA2XDBqjVygfyvheJAaU9KA6cdoNt1A6ybIqrtMQqr9qhu+xmFdVNEtT1GYdUe1W0/o7Buiqi2xyis2qO67WcU1k0R1fb8BZv85KDCNGIQAAAAAElFTkSuQmCC" /></div></div></div>';
                html_photo_file2 = ''
            } else {
                html_photo_file = '<div style="display:none"><input type="file" name="file" class="my-file"></div>';
                html_photo_file2 = '<div id="divToolImg">' + '<i id="lnkEditImage" class="cb-icon-camera"></i>' + '</div>'
            }
            var html_photo_tool = '<div id="divTempContent" style="display:none"></div>' + '<div class="overlay-bg" style="position:fixed;top:0;left:0;width:1;height:1;z-index:10000;zoom 1;background:#fff;opacity:0.8"></div>' + '<div id="divImageEdit" style="position:absolute;display:none;z-index:10000">' + '<div id="my-mask" style="width:200px;height:200px;overflow:hidden;">' + '<img id="my-image" src="" style="max-width:none" />' + '</div>' + '<div id="img-control" style="margin-top:1px;position:absolute;top:-27px;left:0px;width:170px;opacity:0.8">' + '<button id="btnImageCancel" type="button" value="Cancel" ><i class="cb-icon-back"></i></button>' + '<button id="btnZoomOut" type="button" value="-" ><i class="cb-icon-minus"></i></button>' + '<button id="btnZoomIn" type="button" value="+" ><i class="cb-icon-plus"></i></button>' + '<button id="btnChangeImage" type="button" value="Ok" ><i class="cb-icon-ok"></i> Ok</button>' + '</div>' + '</div>' + '<div style="display:none">' + '<canvas id="myCanvas"></canvas>' + '<canvas id="myTmpCanvas"></canvas>' + '</div>' + '<form id="canvasform" method="post" action="" target="canvasframe" enctype="multipart/form-data">' + html_photo_file + '<input id="hidImage" name="hidImage" type="hidden" />' + '<input id="hidPath" name="hidPath" type="hidden" />' + '<input id="hidFile" name="hidFile" type="hidden" />' + '<input id="hidRefId" name="hidRefId" type="hidden" />' + '<input id="hidImgType" name="hidImgType" type="hidden" />' + '</form>' + '<iframe id="canvasframe" name="canvasframe" style="width:1px;height:1px;border:none;visibility:hidden;position:absolute"></iframe>';
            var bUseCustomImageSelect = false;
            if (this.settings.imageselect != '') bUseCustomImageSelect = true;
            var sFunc = (this.settings.onImageSelectClick + '').replace(/\s/g, '');
            if (sFunc != 'function(){}') {
                bUseCustomImageSelect = true
            }
            var bUseCustomFileSelect = false;
            if (this.settings.fileselect != '') bUseCustomFileSelect = true;
            var sFunc = (this.settings.onFileSelectClick + '').replace(/\s/g, '');
            if (sFunc != 'function(){}') {
                bUseCustomFileSelect = true
            }
            var imageEmbed = this.settings.imageEmbed;
            var html_hover_icons = html_photo_file2 + '<div id="divToolImgSettings">' + '<i id="lnkImageSettings" class="cb-icon-link"></i>' + '</div>' + '<div id="divToolImgLoader">' + '<i id="lnkImageLoader" class="cb-icon-spin animate-spin"></i>' + '</div>' + '' + '<div class="md-modal" id="md-img">' + '<div class="md-content">' + '<div class="md-body">' + '<div style="background:#fff;border-bottom:#eee;font-family: sans-serif;color: #333;font-size:12px;letter-spacing: 2px;">' + '<div style="text-align:center;padding:15px;box-sizing:border-box;background:#f3f3f3;border-bottom:#ddd 1px solid;">' + '<span id="tabImgLnk" style="padding: 3px 20px;border-radius:30px;background:#515151;text-decoration:none;color:#fff;margin-right:15px">IMAGE</span>' + '<span id="tabImgPl" style="padding: 3px 20px;border-radius:30px;background:#fafafa;text-decoration:underline;color:#333;cursor:pointer">BLANK PLACEHOLDER</span>' + '</div>' + '</div>' + '<div id="divImgPl" style="overflow-y:auto;overflow-x:hidden;display:none;box-sizing:border-box;padding:10px 10px 10px">';
            html_hover_icons += '<div style="padding:12px 20px 20px;width:100%;text-align:center;">';
            html_hover_icons += 'DIMENSION (WxH): &nbsp; <select id="selImgW">';
            var valW = 50;
            for (var i = 0; i < 231; i++) {
                var selected = '';
                if (i == 90) selected = ' selected="selected"';
                html_hover_icons += '<option value="' + valW + '"' + selected + '>' + valW + 'px</option>';
                valW += 5
            }
            html_hover_icons += '</select> &nbsp; ';
            html_hover_icons += '<select id="selImgH">';
            var valH = 50;
            for (var i = 0; i < 111; i++) {
                var selected = '';
                if (i == 40) selected = ' selected="selected"';
                html_hover_icons += '<option value="' + valH + '"' + selected + '>' + valH + 'px</option>';
                valH += 5
            }
            html_hover_icons += '</select> &nbsp; ';
            html_hover_icons += '<select id="selImgStyle">';
            html_hover_icons += '<option value="square">Square</option>';
            html_hover_icons += '<option value="circle">Circle</option>';
            html_hover_icons += '</select>';
            html_hover_icons += '<button id="btnInsertPlh" style="margin-left:12px"> REPLACE </button>';
            html_hover_icons += '</div>' + '</div>' + '<div id="divImgLnk">' + '<div class="md-label">Source:</div>' + (bUseCustomImageSelect ? '<input type="text" id="txtImgUrl" class="inptxt" style="float:left;width:50%"></input><i class="cb-icon-link md-btnbrowse" id="btnImageBrowse" style="width:10%;"></i>' : '<input type="text" id="txtImgUrl" class="inptxt" style="float:left;width:60%"></input>') + '<br style="clear:both">' + '<div class="md-label">Title:</div>' + '<input type="text" id="txtAltText" class="inptxt" style="float:right;width:60%"></input>' + '<br style="clear:both">' + '<div class="md-label">Link:</div>' + (bUseCustomFileSelect ? '<input type="text" id="txtLinkUrl" class="inptxt" style="float:left;width:50%"></input><i class="cb-icon-link md-btnbrowse" id="btnFileBrowse" style="width:10%;"></i>' : '<input type="text" id="txtLinkUrl" class="inptxt" style="float:left;width:60%"></input>') + '<br style="clear:both">' + '<div id="divEmbedOriginal">' + '<div class="md-label">&nbsp;</div>' + '<label style="float:left;" for="chkEmbedOriginal" class="inpchk"><input type="checkbox" id="chkEmbedOriginal"></input> Embed original image</label>' + '</div>' + '</div>' + '</div>' + '<div id="divImgLnkOk" class="md-footer">' + '<button id="btnImgOk"> Ok </button>' + '</div>' + '</div>' + '</div>' + '' + '<div class="md-modal" id="md-imageselect">' + '<div class="md-content">' + '<div class="md-body">' + (bUseCustomImageSelect ? '<iframe id="ifrImageBrowse" style="width:100%;height:400px;border: none;display: block;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAFElEQVQYV2P8DwQMBADjqCKiggAAmZsj5vuXmnUAAAAASUVORK5CYII="></iframe>' : '') + '</div>' + '</div>' + '</div>' + '';
            if (jQuery('#md-fileselect').length == 0) {
                html_hover_icons += '<div class="md-modal" id="md-fileselect">' + '<div class="md-content">' + '<div class="md-body">' + (bUseCustomFileSelect ? '<iframe id="ifrFileBrowse" style="width:100%;height:400px;border: none;display: block;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAFElEQVQYV2P8DwQMBADjqCKiggAAmZsj5vuXmnUAAAAASUVORK5CYII="></iframe>' : '') + '</div>' + '</div>' + '</div>'
            }
            if (jQuery('#active-input').length == 0) {
                html_hover_icons += '<input type="hidden" id="active-input" />'
            }
            if (jQuery('#divToolImg').length == 0) {
                jQuery('#divCb').append(html_photo_tool);
                jQuery('#divCb').append(html_hover_icons)
            }
            tmpCanvas = document.getElementById('myTmpCanvas');
            $element.hover(function (e) {
                var zoom;
                if (localStorage.getItem("zoom") != null) {
                    zoom = localStorage.zoom
                } else {
                    zoom = $element.parents('[style*="zoom"]').css('zoom');
                    if (zoom == 'normal') zoom = 1;
                    if (zoom == undefined) zoom = 1
                }
                var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
                zoom = zoom + '';
                if (zoom.indexOf('%') != -1) {
                    zoom = zoom.replace('%', '') / 100
                }
                if (zoom == 'NaN') {
                    zoom = 1
                }
                localStorage.zoom = zoom;
                zoom = zoom * 1;
                if (cb_list == '') zoom = 1;
                if ($element.data("imageembed").settings.zoom == 1) {
                    zoom = 1
                }
                var _top;
                var _top2;
                var _left;
                var scrolltop = jQuery(window).scrollTop();
                var offsettop = jQuery(this).offset().top;
                var offsetleft = jQuery(this).offset().left;
                var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
                var is_ie = detectIE();
                var is_edge = detectEdge();
                var browserok = true;
                if (is_firefox || is_ie || is_edge) browserok = false;
                var _top_adj = !jQuery(this).data("imageembed").settings.imageEmbed ? 9 : -35;
                if (browserok) {
                    _top = ((offsettop + parseInt(jQuery(this).css('height')) / 2) - 15) * zoom + (scrolltop - scrolltop * zoom);
                    _left = ((offsetleft + parseInt(jQuery(this).css('width')) / 2) - 15) * zoom;
                    _top2 = _top + _top_adj
                } else {
                    if (is_edge) {}
                    if (is_ie) {
                        var space = 0;
                        var space2 = 0;
                        $element.parents().each(function () {
                            if (jQuery(this).data('contentbuilder')) {
                                space = jQuery(this).getPos().top;
                                space2 = jQuery(this).getPos().left
                            }
                        });
                        var adjy_val = -space * zoom + space;
                        var adjx_val = -space2 * zoom + space2;
                        var p = jQuery(this).getPos();
                        _top = ((p.top - 15 + parseInt(jQuery(this).css('height')) / 2)) * zoom + adjy_val;
                        _left = ((p.left - 15 + parseInt(jQuery(this).css('width')) / 2)) * zoom + adjx_val;
                        _top2 = _top + _top_adj
                    }
                    if (is_firefox) {
                        var imgwidth = parseInt(jQuery(this).css('width'));
                        var imgheight = parseInt(jQuery(this).css('height'));
                        _top = offsettop - 15 + imgheight * zoom / 2;
                        _left = offsetleft - 15 + imgwidth * zoom / 2;
                        _top2 = _top + _top_adj
                    }
                }
                var fixedimage = false;
                $imgActive = jQuery(this);
                if ($imgActive.attr('data-fixed') == 1) {
                    fixedimage = true
                }
                if (cb_edit && !fixedimage) {
                    jQuery("#divToolImg").css("top", _top + "px");
                    jQuery("#divToolImg").css("left", _left + "px");
                    if (jQuery(this).data("imageembed").settings.imageEmbed) {
                        jQuery("#divToolImg").stop(true, true).css({
                            display: 'none'
                        }).fadeIn(20)
                    }
                    if (jQuery(this).data("imageembed").settings.linkDialog) {
                        jQuery("#divToolImgSettings").css("top", _top2 + "px");
                        jQuery("#divToolImgSettings").css("left", _left + "px");
                        jQuery("#divToolImgSettings").stop(true, true).css({
                            display: 'none'
                        }).fadeIn(20)
                    } else {
                        jQuery("#divToolImgSettings").css("top", "-10000px")
                    }
                }
                if ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
                    jQuery("#lnkImageSettings").on('touchstart mouseenter focus', function (e) {
                        if (e.type == 'touchstart') {
                            e.stopImmediatePropagation();
                            e.preventDefault()
                        }
                        jQuery("#lnkImageSettings").click();
                        e.preventDefault();
                        e.stopImmediatePropagation()
                    })
                }
                jQuery("#divToolImg").unbind('click');
                jQuery("#divToolImg").bind('click', function (e) {
                    jQuery("#divToolImg").data('image', $imgActive);
                    var sFunc = ($element.data('imageembed').settings.onImageBrowseClick + '').replace(/\s/g, '');
                    if (sFunc != 'function(){}') {
                        $element.data('imageembed').settings.onImageBrowseClick()
                    } else {
                        jQuery('input.my-file[type=file]').click()
                    }
                    e.preventDefault();
                    e.stopImmediatePropagation()
                });
                jQuery("#divToolImg").unbind('hover');
                jQuery("#divToolImg").hover(function (e) {
                    if (imageEmbed) {
                        jQuery("#divToolImg").stop(true, true).css("display", "block")
                    }
                    jQuery("#divToolImgSettings").stop(true, true).css("display", "block")
                }, function () {
                    jQuery("#divToolImg").stop(true, true).fadeOut(0);
                    jQuery("#divToolImgSettings").stop(true, true).fadeOut(0)
                });
                $element.find('figcaption').unbind('hover');
                $element.find('figcaption').hover(function (e) {
                    if (imageEmbed) {
                        jQuery("#divToolImg").stop(true, true).css("display", "block")
                    }
                    jQuery("#divToolImgSettings").stop(true, true).css("display", "block")
                }, function () {
                    jQuery("#divToolImg").stop(true, true).fadeOut(0);
                    jQuery("#divToolImgSettings").stop(true, true).fadeOut(0)
                });
                jQuery("#divToolImgSettings").unbind('hover');
                jQuery("#divToolImgSettings").hover(function (e) {
                    if (imageEmbed) {
                        jQuery("#divToolImg").stop(true, true).css("display", "block")
                    }
                    jQuery("#divToolImgSettings").stop(true, true).css("display", "block")
                }, function () {
                    jQuery("#divToolImg").stop(true, true).fadeOut(0);
                    jQuery("#divToolImgSettings").stop(true, true).fadeOut(0)
                });
                jQuery("#lnkImageSettings").unbind('click');
                jQuery("#lnkImageSettings").bind('click', function (e) {
                    jQuery("#divToolImg").data('image', $imgActive);
                    jQuery("#divToolImg").stop(true, true).fadeOut(0);
                    jQuery("#divToolImgSettings").stop(true, true).fadeOut(0);
                    var sFunc = ($element.data('imageembed').settings.onImageSettingClick + '').replace(/\s/g, '');
                    if (sFunc != 'function(){}') {
                        $element.data('imageembed').settings.onImageSettingClick();
                        return
                    }
                    jQuery('#md-img').css('max-width', '800px');
                    jQuery('#md-img').simplemodal();
                    jQuery('#md-img').data('simplemodal').show();
                    var $img = $element;
                    if ($element.prop("tagName").toLowerCase() == 'figure') {
                        $img = $element.find('img:first')
                    }
                    jQuery('#txtImgUrl').val($img.attr('src'));
                    jQuery('#txtAltText').val($img.attr('alt'));
                    jQuery('#txtLinkUrl').val('');
                    if ($img.parents('a:first') != undefined) {
                        jQuery('#txtLinkUrl').val($img.parents('a:first').attr('href'))
                    }
                    jQuery('#chkEmbedOriginal').removeAttr('checked');
                    if ($element.data('imageembed').settings.hideEmbedOriginal) {
                        jQuery('#divEmbedOriginal').css("display", "none")
                    }
                    if ($element.data('imageembed').settings.embedOriginalChecked) {
                        jQuery('#chkEmbedOriginal').prop("checked", true)
                    }
                    if (!$element.data('imageembed').settings.imageEmbed) {
                        jQuery('#divEmbedOriginal').css("display", "none");
                        jQuery('#chkEmbedOriginal').prop("checked", true)
                    }
                    jQuery('#btnImgOk').unbind('click');
                    jQuery('#btnImgOk').bind('click', function (e) {
                        var builder;
                        $element.parents().each(function () {
                            if (jQuery(this).data('contentbuilder')) {
                                builder = jQuery(this).data('contentbuilder')
                            }
                        });
                        var insertOri = false;
                        if (jQuery('#chkEmbedOriginal').is(":checked")) {
                            insertOri = true
                        }
                        if (insertOri == false) {
                            if (jQuery('#txtImgUrl').val().indexOf("http") != -1) {
                                insertOri = true
                            }
                        }
                        if ($img.attr('src') != jQuery('#txtImgUrl').val()) {
                            if (insertOri) {
                                if ($img.attr('src').indexOf(sScriptPath + 'image.png') != -1 && jQuery('#txtImgUrl').val().indexOf(sScriptPath + 'image.png') == -1) {
                                    $img.css('width', '');
                                    $img.css('height', '')
                                }
                                $img.attr('src', jQuery('#txtImgUrl').val())
                            } else {
                                processImage(jQuery('#txtImgUrl').val())
                            }
                        }
                        $img.attr('alt', jQuery('#txtAltText').val());
                        if (jQuery('#txtLinkUrl').val() == 'http://' || jQuery('#txtLinkUrl').val() == '') {
                            $img.parents('a:first').replaceWith($img.parents('a:first').html())
                        } else {
                            if ($img.parents('a:first').length == 0) {
                                $img.wrap('<a href="' + jQuery('#txtLinkUrl').val() + '"></a>')
                            } else {
                                $img.parents('a:first').attr('href', jQuery('#txtLinkUrl').val())
                            }
                        }
                        if (builder) builder.applyBehavior();
                        jQuery('#md-img').data('simplemodal').hide()
                    });
                    var actualW = $img[0].naturalWidth;
                    var actualH = $img[0].naturalHeight;
                    if ($img.attr('src').indexOf(sScriptPath + 'image.png') != -1) {
                        for (var i = 0; i < $img.attr("style").split(";").length; i++) {
                            var cssval = $img.attr("style").split(";")[i];
                            if (jQuery.trim(cssval.split(":")[0]) == "width") {
                                actualW = parseInt(jQuery.trim(cssval.split(":")[1]))
                            }
                            if (jQuery.trim(cssval.split(":")[0]) == "height") {
                                actualH = parseInt(jQuery.trim(cssval.split(":")[1]))
                            }
                        }
                    }
                    var valW = 50;
                    for (var i = 0; i < 231; i++) {
                        if (valW >= actualW) {
                            i = 231;
                            jQuery('#selImgW').val(valW)
                        }
                        valW += 5
                    }
                    var valH = 50;
                    for (var i = 0; i < 111; i++) {
                        if (valH >= actualH) {
                            i = 111;
                            jQuery('#selImgH').val(valH)
                        }
                        valH += 5
                    }
                    if (parseInt($img.css('border-radius')) == 500) {
                        jQuery('#selImgStyle').val('circle');
                        jQuery('#selImgH').css('display', 'none')
                    } else {
                        jQuery('#selImgStyle').val('square');
                        jQuery('#selImgH').css('display', 'inline')
                    }
                    jQuery('#selImgStyle').unbind('change');
                    jQuery('#selImgStyle').bind('change', function (e) {
                        if (jQuery('#selImgStyle').val() == 'circle') {
                            jQuery('#selImgH').css('display', 'none');
                            jQuery('#selImgH').val(jQuery('#selImgW').val())
                        } else {
                            jQuery('#selImgH').css('display', 'inline');
                            jQuery('#selImgH').val(jQuery('#selImgW').val())
                        }
                    });
                    jQuery('#selImgW').unbind('change');
                    jQuery('#selImgW').bind('change', function (e) {
                        if (jQuery('#selImgStyle').val() == 'circle') {
                            jQuery('#selImgH').val(jQuery('#selImgW').val())
                        }
                    });
                    jQuery('#btnInsertPlh').unbind('click');
                    jQuery('#btnInsertPlh').bind('click', function (e) {
                        var builder;
                        $element.parents().each(function () {
                            if (jQuery(this).data('contentbuilder')) {
                                builder = jQuery(this).data('contentbuilder')
                            }
                        });
                        $img.attr('src', sScriptPath + 'image.png');
                        $img.attr('alt', jQuery('#txtAltText').val());
                        $img.css('width', jQuery('#selImgW').val() + 'px');
                        $img.css('height', jQuery('#selImgH').val() + 'px');
                        if (jQuery('#selImgStyle').val() == 'circle') {
                            $img.css('border-radius', '500px')
                        } else {
                            $img.css('border-radius', '');
                            $img.removeClass('circle')
                        }
                        if (builder) builder.applyBehavior();
                        jQuery('#md-img').data('simplemodal').hide()
                    });
                    e.preventDefault();
                    e.stopImmediatePropagation()
                });
                jQuery("#btnImageBrowse").unbind('click');
                jQuery("#btnImageBrowse").bind('click', function (e) {
                    jQuery("#divToolImg").stop(true, true).fadeOut(0);
                    jQuery("#divToolImgSettings").stop(true, true).fadeOut(0);
                    jQuery("#divRteLink").stop(true, true).fadeOut(0);
                    jQuery("#divFrameLink").stop(true, true).fadeOut(0);
                    var sFunc = ($element.data('imageembed').settings.onImageSelectClick + '').replace(/\s/g, '');
                    if (sFunc != 'function(){}') {
                        $element.data('imageembed').settings.onImageSelectClick({
                            targetInput: jQuery("#txtImgUrl").get(0),
                            theTrigger: jQuery("#btnImageBrowse").get(0)
                        })
                    } else {
                        jQuery('#ifrImageBrowse').attr('src', $element.data('imageembed').settings.imageselect);
                        jQuery('#active-input').val('txtImgUrl');
                        jQuery('#md-imageselect').css('width', '65%');
                        jQuery('#md-imageselect').simplemodal();
                        jQuery('#md-imageselect').data('simplemodal').show()
                    }
                });
                jQuery("#btnFileBrowse").unbind('click');
                jQuery("#btnFileBrowse").bind('click', function (e) {
                    jQuery("#divToolImg").stop(true, true).fadeOut(0);
                    jQuery("#divToolImgSettings").stop(true, true).fadeOut(0);
                    jQuery("#divRteLink").stop(true, true).fadeOut(0);
                    jQuery("#divFrameLink").stop(true, true).fadeOut(0);
                    var sFunc = ($element.data('imageembed').settings.onFileSelectClick + '').replace(/\s/g, '');
                    if (sFunc != 'function(){}') {
                        $element.data('imageembed').settings.onFileSelectClick({
                            targetInput: jQuery("#txtLinkUrl").get(0),
                            theTrigger: jQuery("#btnFileBrowse").get(0)
                        })
                    } else {
                        jQuery('#ifrFileBrowse').attr('src', $element.data('imageembed').settings.fileselect);
                        jQuery('#active-input').val('txtLinkUrl');
                        jQuery('#md-fileselect').css('width', '65%');
                        jQuery('#md-fileselect').simplemodal();
                        jQuery('#md-fileselect').data('simplemodal').show()
                    }
                });
                jQuery('.my-file[type=file]').unbind('change');
                jQuery('.my-file[type=file]').bind('change', function (e) {
                    changeImage(e);
                    jQuery('#my-image').attr('src', '');
                    if (!$imgActive.parent().attr('data-gal')) {
                        jQuery(this).clearInputs()
                    }
                });
                jQuery('#tabImgLnk').unbind('click');
                jQuery('#tabImgLnk').bind('click', function (e) {
                    jQuery('#tabImgLnk').css({
                        'text-decoration': '',
                        'cursor': '',
                        'background': '#515151',
                        'color': '#fff'
                    });
                    jQuery('#tabImgPl').css({
                        'text-decoration': 'underline',
                        'cursor': 'pointer',
                        'background': '#fafafa',
                        'color': '#333'
                    });
                    jQuery('#divImgPl').fadeOut(300, function () {
                        jQuery('#divImgLnk').fadeIn(0);
                        jQuery('#divImgLnkOk').fadeIn(0)
                    })
                });
                jQuery('#tabImgPl').unbind('click');
                jQuery('#tabImgPl').bind('click', function (e) {
                    jQuery('#tabImgLnk').css({
                        'text-decoration': 'underline',
                        'cursor': 'pointer',
                        'background': '#fafafa',
                        'color': '#333'
                    });
                    jQuery('#tabImgPl').css({
                        'text-decoration': '',
                        'cursor': '',
                        'background': '#515151',
                        'color': '#fff'
                    });
                    jQuery('#divImgLnk').fadeOut(0);
                    jQuery('#divImgLnkOk').fadeOut(0, function () {
                        jQuery('#divImgPl').fadeIn(300)
                    })
                })
            }, function (e) {
                jQuery("#divToolImg").stop(true, true).fadeOut(0);
                jQuery("#divToolImgSettings").stop(true, true).fadeOut(0)
            })
        };
        var changeImage = function (e) {
                if (typeof FileReader == "undefined") return true;
                var file = e.target.files[0];
                var extension = file.name.substr((file.name.lastIndexOf('.') + 1)).toLowerCase();
                if (extension != 'jpg' && extension != 'jpeg' && extension != 'png' && extension != 'gif' && extension != 'bmp') {
                    alert('Please select an image');
                    return
                }
                jQuery("#divToolImg").stop(true, true).fadeOut(0);
                jQuery("#divToolImgSettings").stop(true, true).fadeOut(0);
                jQuery('.overlay-bg').css('width', '100%');
                jQuery('.overlay-bg').css('height', '100%');
                jQuery("#divToolImgLoader").css('top', jQuery('#divToolImg').css('top'));
                jQuery("#divToolImgLoader").css('left', jQuery('#divToolImg').css('left'));
                jQuery("#divToolImgLoader").css('display', 'block');
                processImage(file)
            };
        var processImage = function (file) {
                var imgname, extension;
                if (!file.name) {
                    imgname = file.substr((file.lastIndexOf('/') + 1));
                    extension = file.substr((file.lastIndexOf('.') + 1)).toLowerCase()
                } else {
                    imgname = file.name;
                    extension = file.name.substr((file.name.lastIndexOf('.') + 1)).toLowerCase()
                }
                var hiquality = false;
                try {
                    hiquality = $element.data('imageembed').settings.hiquality
                } catch (e) {};
                var type, quality;
                if (hiquality == false) {
                    if (extension == 'jpg' || extension == 'jpeg') {
                        type = 'image/jpeg';
                        quality = 0.92
                    } else {
                        type = 'image/png';
                        quality = 1
                    }
                } else {
                    type = 'image/png';
                    quality = 1
                }
                loadImage.parseMetaData(file, function (data) {
                    var orientation_num;
                    if (data.exif) {
                        orientation_num = data.exif.get('Orientation')
                    }
                    loadImage(file, function (img) {
                        var cW, cH;
                        if (img.width > 3200 || img.height > 3200) {
                            cW = img.width / 2;
                            cH = img.height / 2
                        } else if (img.width > 2500 || img.height > 2500) {
                            cW = img.width / 1.25;
                            cH = img.height / 1.25
                        } else {
                            cW = img.width;
                            cH = img.height
                        }
                        if (orientation_num == 5 || orientation_num == 6 || orientation_num == 7 || orientation_num == 8) {
                            tmpCanvas.width = cH;
                            tmpCanvas.height = cW;
                            nInitialWidth = cH;
                            nInitialHeight = cW
                        } else {
                            tmpCanvas.width = cW;
                            tmpCanvas.height = cH;
                            nInitialWidth = cW;
                            nInitialHeight = cH
                        }
                        var context = tmpCanvas.getContext('2d');
                        if (orientation_num == 1) {
                            context.transform(1, 0, 0, 1, 0, 0)
                        } else if (orientation_num == 2) {
                            context.transform(-1, 0, 0, 1, cW, 0)
                        } else if (orientation_num == 3) {
                            context.transform(-1, 0, 0, -1, cW, cH)
                        } else if (orientation_num == 4) {
                            context.transform(1, 0, 0, -1, 0, cH)
                        } else if (orientation_num == 5) {
                            context.transform(0, 1, 1, 0, 0, 0)
                        } else if (orientation_num == 6) {
                            context.transform(0, 1, -1, 0, cH, 0)
                        } else if (orientation_num == 7) {
                            context.transform(0, -1, -1, 0, cH, cW)
                        } else if (orientation_num == 8) {
                            context.transform(0, -1, 1, 0, 0, cW)
                        } else {}
                        context.drawImage(img, 0, 0, cW, cH);
                        var image = tmpCanvas.toDataURL(type, quality);
                        $imgActive = jQuery("#divToolImg").data('image');
                        var zoom = localStorage.zoom;
                        if ($element.data('imageembed').settings.zoom == 1) {
                            zoom = 1
                        }
                        var enlarge;
                        if ($imgActive.prop("tagName").toLowerCase() == 'img') {
                            enlarge = $imgActive[0].naturalWidth / $imgActive.width()
                        } else if ($imgActive.prop("tagName").toLowerCase() == 'figure') {
                            enlarge = $imgActive.find('img')[0].naturalWidth / $imgActive.find('img').width()
                        }
                        var specifiedCssWidth = 0;
                        var specifiedCssHeight = 0;
                        if ($imgActive.prop("tagName").toLowerCase() == 'img') {
                            if ($imgActive.attr("src").indexOf(sScriptPath + "image.png") != -1) {
                                for (var i = 0; i < $imgActive.attr("style").split(";").length; i++) {
                                    var cssval = $imgActive.attr("style").split(";")[i];
                                    if (jQuery.trim(cssval.split(":")[0]) == "width") {
                                        specifiedCssWidth = parseInt(jQuery.trim(cssval.split(":")[1]));
                                        enlarge = specifiedCssWidth / $imgActive.width()
                                    }
                                    if (jQuery.trim(cssval.split(":")[0]) == "height") {
                                        specifiedCssHeight = parseInt(jQuery.trim(cssval.split(":")[1]))
                                    }
                                }
                            }
                        } else if ($imgActive.prop("tagName").toLowerCase() == 'figure') {
                            if ($imgActive.find('img').attr("src").indexOf(sScriptPath + "image.png") != -1) {
                                for (var i = 0; i < $imgActive.find('img').attr("style").split(";").length; i++) {
                                    var cssval = $imgActive.find('img').attr("style").split(";")[i];
                                    if (jQuery.trim(cssval.split(":")[0]) == "width") {
                                        specifiedCssWidth = parseInt(jQuery.trim(cssval.split(":")[1]));
                                        enlarge = specifiedCssWidth / $imgActive.find('img').width()
                                    }
                                    if (jQuery.trim(cssval.split(":")[0]) == "height") {
                                        specifiedCssHeight = parseInt(jQuery.trim(cssval.split(":")[1]))
                                    }
                                }
                            }
                        }
                        var maskAdj = 1.1;
                        if ($imgActive.prop("tagName").toLowerCase() == 'img') {
                            jQuery("#my-mask").css('width', ($imgActive.width() * enlarge) - maskAdj + 'px');
                            jQuery("#my-mask").css('height', ($imgActive.height() * enlarge) - maskAdj + 'px')
                        } else {
                            jQuery("#my-mask").css('width', ($imgActive.innerWidth() * enlarge) - maskAdj + 'px');
                            jQuery("#my-mask").css('height', ($imgActive.innerHeight() * enlarge) - maskAdj + 'px')
                        }
                        if (specifiedCssWidth != 0) jQuery("#my-mask").css('width', specifiedCssWidth + 'px');
                        if (specifiedCssHeight != 0) jQuery("#my-mask").css('height', specifiedCssHeight + 'px');
                        jQuery("#my-mask").css('zoom', zoom / enlarge);
                        jQuery("#my-mask").css('-moz-transform', 'scale(' + zoom / enlarge + ')');
                        var newW;
                        var newY;
                        var maskWidth = $imgActive.width();
                        var maskHeight = $imgActive.height();
                        var photoAspectRatio = nInitialWidth / nInitialHeight;
                        var canvasAspectRatio = maskWidth / maskHeight;
                        if (photoAspectRatio < canvasAspectRatio) {
                            newW = maskWidth;
                            newY = (nInitialHeight * maskWidth) / nInitialWidth
                        } else {
                            newW = (nInitialWidth * maskHeight) / nInitialHeight;
                            newY = maskHeight
                        }
                        newW = newW * enlarge;
                        newY = newY * enlarge;
                        jQuery('#my-image').attr('src', image);
                        jQuery('#my-image').on('load', function () {
                            jQuery('.overlay-bg').css('width', '100%');
                            jQuery('.overlay-bg').css('height', '100%');
                            $imgActive = jQuery("#divToolImg").data('image');
                            jQuery("#my-image").css('top', '0px');
                            jQuery("#my-image").css('left', '0px');
                            jQuery("#my-image").css('width', newW + 'px');
                            jQuery("#my-image").css('height', newY + 'px');
                            var zoom = localStorage.zoom;
                            zoom = zoom * 1;
                            if ($element.data('imageembed').settings.zoom == 1) {
                                zoom = 1
                            }
                            var _top;
                            var _left;
                            var _top_polaroid;
                            var _left_polaroid;
                            var scrolltop = jQuery(window).scrollTop();
                            var offsettop = $imgActive.offset().top;
                            var offsetleft = $imgActive.offset().left;
                            var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
                            var is_ie = detectIE();
                            var browserok = true;
                            if (is_firefox || is_ie) browserok = false;
                            if (browserok) {
                                _top = (offsettop * zoom) + (scrolltop - scrolltop * zoom);
                                _left = offsetleft * zoom;
                                _top_polaroid = ((offsettop + 5) * zoom) + (scrolltop - scrolltop * zoom);
                                _left_polaroid = (offsetleft + 5) * zoom
                            } else {
                                if (is_ie) {
                                    var space = 0;
                                    var space2 = 0;
                                    $element.parents().each(function () {
                                        if (jQuery(this).data('contentbuilder')) {
                                            space = jQuery(this).getPos().top;
                                            space2 = jQuery(this).getPos().left
                                        }
                                    });
                                    var adjy_val = -space * zoom + space;
                                    var adjx_val = -space2 * zoom + space2;
                                    var p = $imgActive.getPos();
                                    _top = (p.top * zoom) + adjy_val;
                                    _left = (p.left * zoom) + adjx_val;
                                    _top_polaroid = ((p.top + 5) * zoom) + adjy_val;
                                    _left_polaroid = ((p.left + 5) * zoom) + adjx_val
                                }
                                if (is_firefox) {
                                    var imgwidth = parseInt($imgActive.css('width'));
                                    var imgheight = parseInt($imgActive.css('height'));
                                    var adjx_val = imgwidth / 2 - (imgwidth / 2) * zoom;
                                    var adjy_val = imgheight / 2 - (imgheight / 2) * zoom;
                                    jQuery('#img-control').css('top', 5 + adjy_val + 'px');
                                    jQuery('#img-control').css('left', 7 + adjx_val + 'px');
                                    _top = offsettop - adjy_val;
                                    _left = offsetleft - adjx_val;
                                    _top_polaroid = offsettop - adjy_val + 5;
                                    _left_polaroid = offsetleft - adjx_val + 5
                                }
                            }
                            jQuery('#divImageEdit').css('display', 'inline-block');
                            if ($imgActive.attr('class') == 'img-polaroid') {
                                jQuery("#divImageEdit").css("top", _top_polaroid + "px");
                                jQuery("#divImageEdit").css("left", _left_polaroid + "px")
                            } else {
                                jQuery("#divImageEdit").css("top", _top + "px");
                                jQuery("#divImageEdit").css("left", _left + "px")
                            }
                            if (parseInt(jQuery("#divImageEdit").css("top")) < 25) {
                                jQuery('#img-control').css('top', 'auto');
                                jQuery('#img-control').css('bottom', "-24px")
                            }
                            panSetup();
                            tmpCanvas.width = newW;
                            tmpCanvas.height = newY;
                            var imageObj = jQuery("#my-image")[0];
                            var context = tmpCanvas.getContext('2d');
                            var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
                            if (is_firefox) sleep(700);
                            var tmp = new Image(),
                                canvas;
                            cW = nInitialWidth;
                            cH = nInitialHeight;
                            tmp.src = imageObj.src;
                            tmp.onload = function () {
                                cW /= 2;
                                cH /= 2;
                                if (cW < imageObj.width) cW = imageObj.width;
                                if (cH < imageObj.height) cH = imageObj.height;
                                tmpCanvas.width = cW;
                                tmpCanvas.height = cH;
                                context = tmpCanvas.getContext('2d');
                                context.drawImage(tmp, 0, 0, cW, cH);
                                if (cW <= imageObj.width || cH <= imageObj.height) {
                                    panSetup();
                                    crop();
                                    return
                                }
                                tmp.src = tmpCanvas.toDataURL(type, quality)
                            };
                            crop();
                            if ($imgActive.attr('class') == 'img-circle') {
                                jQuery('#my-mask').css('-webkit-border-radius', '500px');
                                jQuery('#my-mask').css('-moz-border-radius', '500px');
                                jQuery('#my-mask').css('border-radius', '500px')
                            } else {
                                jQuery('#my-mask').css('-webkit-border-radius', '0px');
                                jQuery('#my-mask').css('-moz-border-radius', '0px');
                                jQuery('#my-mask').css('border-radius', '0px')
                            }
                            jQuery('#my-image').unbind('load');
                            if ($imgActive.prop("tagName").toLowerCase() == 'img') {} else {
                                jQuery('#btnZoomIn').click();
                                jQuery('#btnZoomIn').click()
                            }
                            jQuery("#divToolImgLoader").css('display', 'none')
                        });
                        jQuery('#btnChangeImage').unbind('click');
                        jQuery('#btnChangeImage').bind('click', function () {
                            var canvas = document.getElementById('myCanvas');
                            $imgActive = jQuery("#divToolImg").data('image');
                            console.log($imgActive);
                            var image;
                            if (hiquality == false) {
                                if (extension == 'jpg' || extension == 'jpeg') {
                                    image = canvas.toDataURL("image/jpeg", 0.92)
                                } else {
                                    image = canvas.toDataURL("image/png", 1)
                                }
                            } else {
                                image = canvas.toDataURL("image/png", 1)
                            }

							$.ajaxNocache({
								url: baseUrl+'/site/base64upload',
								type: 'POST',
								dataType: "json",
								data:{
									model: model,
									img:image,
								},
								error : function(){
									alert('Não foi possível realizar a operação, contate a adminsitração');
								},
								success:function (data) {
									if(data.status){
										image = data.image;
										imgname = data.imgname;
                                        console.log($imgActive);
                                        $imgActive = jQuery("#divToolImg").data('image');
                                        console.log($imgActive);
										if ($imgActive.prop("tagName").toLowerCase() == 'img') {
											$imgActive.attr('src', image);
											$imgActive.data('filename', imgname)
										} else if ($imgActive.prop("tagName").toLowerCase() == 'figure') {
											$imgActive.find('img').attr('src', image);
											$imgActive.find('img').data('filename', imgname)
										} else {
											$imgActive.css('background-image', 'url(data:' + image + ')');
											$imgActive.data('filename', imgname)
										}
									}
								},
							});


                            jQuery('#divImageEdit').css('display', 'none');
                            jQuery('.overlay-bg').css('width', '1px');
                            jQuery('.overlay-bg').css('height', '1px');
                            jQuery('body').css('overflow', '');
                            if ($imgActive.prop("tagName").toLowerCase() == 'img') {
                                $imgActive.css('width', '');
                                $imgActive.css('height', '')
                            } else if ($imgActive.prop("tagName").toLowerCase() == 'figure') {
                                $imgActive.find('img').css('width', '');
                                $imgActive.find('img').css('height', '')
                            }
                            $element.data('imageembed').settings.onChanged()
                        });
                        jQuery('#btnImageCancel').unbind('click');
                        jQuery('#btnImageCancel').bind('click', function () {
                            var canvas = document.getElementById('myCanvas');
                            $imgActive = jQuery("#divToolImg").data('image');
                            jQuery('#divImageEdit').css('display', 'none');
                            jQuery('.overlay-bg').css('width', '1px');
                            jQuery('.overlay-bg').css('height', '1px');
                            jQuery('body').css('overflow', '')
                        });
                        jQuery('#btnZoomIn').unbind('click');
                        jQuery('#btnZoomIn').bind('click', function () {
                            var nCurrentWidth = parseInt(jQuery("#my-image").css('width'));
                            var nCurrentHeight = parseInt(jQuery("#my-image").css('height'));
                            jQuery("#my-image").css('width', (nCurrentWidth / 0.9) + 'px');
                            jQuery("#my-image").css('height', (nCurrentHeight / 0.9) + 'px');
                            panSetup();
                            tmpCanvas.width = (nCurrentWidth / 0.9);
                            tmpCanvas.height = (nCurrentHeight / 0.9);
                            var imageObj = jQuery("#my-image")[0];
                            var context = tmpCanvas.getContext('2d');
                            var tmp = new Image(),
                                context, cW, cH;
                            cW = nInitialWidth;
                            cH = nInitialHeight;
                            tmp.src = imageObj.src;
                            tmp.onload = function () {
                                cW /= 2;
                                cH /= 2;
                                if (cW < imageObj.width) cW = (nCurrentWidth / 0.9);
                                if (cH < imageObj.height) cH = (nCurrentHeight / 0.9);
                                tmpCanvas.width = cW;
                                tmpCanvas.height = cH;
                                context = tmpCanvas.getContext('2d');
                                context.drawImage(tmp, 0, 0, cW, cH);
                                if (cW <= (nCurrentWidth / 0.9) || cH <= (nCurrentHeight / 0.9)) {
                                    panSetup();
                                    crop();
                                    return
                                }
                                tmp.src = tmpCanvas.toDataURL(type, quality)
                            };
                            crop()
                        });
                        jQuery('#btnZoomOut').unbind('click');
                        jQuery('#btnZoomOut').bind('click', function () {
                            var nCurrentWidth = parseInt(jQuery("#my-image").css('width'));
                            var nCurrentHeight = parseInt(jQuery("#my-image").css('height'));
                            if ((nCurrentWidth / 1.1) < jQuery("#my-mask").width()) return;
                            if ((nCurrentHeight / 1.1) < jQuery("#my-mask").height()) return;
                            jQuery("#my-image").css('width', (nCurrentWidth / 1.1) + 'px');
                            jQuery("#my-image").css('height', (nCurrentHeight / 1.1) + 'px');
                            panSetup();
                            tmpCanvas.width = (nCurrentWidth / 1.1);
                            tmpCanvas.height = (nCurrentHeight / 1.1);
                            var imageObj = jQuery("#my-image")[0];
                            var context = tmpCanvas.getContext('2d');
                            var tmp = new Image(),
                                context, cW, cH;
                            cW = nInitialWidth;
                            cH = nInitialHeight;
                            tmp.src = imageObj.src;
                            tmp.onload = function () {
                                cW /= 2;
                                cH /= 2;
                                if (cW < imageObj.width) cW = (nCurrentWidth / 1.1);
                                if (cH < imageObj.height) cH = (nCurrentHeight / 1.1);
                                tmpCanvas.width = cW;
                                tmpCanvas.height = cH;
                                context = tmpCanvas.getContext('2d');
                                context.drawImage(tmp, 0, 0, cW, cH);
                                if (cW <= (nCurrentWidth / 1.1) || cH <= (nCurrentHeight / 1.1)) {
                                    panSetup();
                                    crop();
                                    return
                                }
                                tmp.src = tmpCanvas.toDataURL(type, quality)
                            };
                            crop()
                        })
                    }, {
                        canvas: false
                    })
                })
            };
        var crop = function () {
                var maskAdj = 1.1;
                var x = parseInt(jQuery("#my-image").css('left')) - maskAdj;
                var y = parseInt(jQuery("#my-image").css('top')) - maskAdj;
                var dw = parseInt(jQuery("#my-mask").css('width'));
                var dh = parseInt(jQuery("#my-mask").css('height'));
                var canvas = document.getElementById('myCanvas');
                var context = canvas.getContext('2d');
                canvas.width = dw;
                canvas.height = dh;
                var sourceX = -1 * x;
                var sourceY = -1 * y;
                if ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
                    var iosAdj = 0.7;
                    sourceX = -1 * x + (x - x / iosAdj);
                    sourceY = -1 * y + (y - y / iosAdj)
                }
                if (sourceY > (tmpCanvas.height - dh)) {
                    sourceY = tmpCanvas.height - dh
                }
                if (sourceX > (tmpCanvas.width - dw)) {
                    sourceX = tmpCanvas.width - dw
                }
                context.drawImage(tmpCanvas, sourceX, sourceY, dw, dh, 0, 0, dw, dh)
            };
        var panSetup = function () {
                jQuery("#my-image").css({
                    top: 0,
                    left: 0
                });
                var maskWidth = jQuery("#my-mask").width();
                var maskHeight = jQuery("#my-mask").height();
                var imgPos = jQuery("#my-image").offset();
                var imgWidth = jQuery("#my-image").width();
                var imgHeight = jQuery("#my-image").height();
                var x1 = (imgPos.left + maskWidth) - imgWidth;
                var y1 = (imgPos.top + maskHeight) - imgHeight;
                var x2 = imgPos.left;
                var y2 = imgPos.top;
                jQuery("#my-image").draggable({
                    revert: false,
                    containment: [x1, y1, x2, y2],
                    drag: function () {
                        crop()
                    }
                });
                jQuery("#my-image").css({
                    cursor: 'move'
                })
            };
        this.init()
    };
    jQuery.fn.imageembed = function (options) {
        return this.each(function () {
            if (undefined == jQuery(this).data('imageembed')) {
                var plugin = new jQuery.imageembed(this, options);
                jQuery(this).data('imageembed', plugin)
            }
        })
    }
})(jQuery);

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < 5; i++) text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text
}
function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break
        }
    }
}
jQuery.fn.clearFields = jQuery.fn.clearInputs = function (includeHidden) {
    var re = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;
    return this.each(function () {
        var t = this.type,
            tag = this.tagName.toLowerCase();
        if (re.test(t) || tag == 'textarea') {
            this.value = ''
        } else if (t == 'checkbox' || t == 'radio') {
            this.checked = false
        } else if (tag == 'select') {
            this.selectedIndex = -1
        } else if (t == "file") {
            if (/MSIE/.test(navigator.userAgent)) {
                jQuery(this).replaceWith(jQuery(this).clone(true))
            } else {
                jQuery(this).val('')
            }
        } else if (includeHidden) {
            if ((includeHidden === true && /hidden/.test(t)) || (typeof includeHidden == 'string' && jQuery(this).is(includeHidden))) this.value = ''
        }
    })
};
var zindex = 10000;
(function (jQuery) {
    jQuery.simplemodal = function (element, options) {
        var defaults = {
            onCancel: function () {}
        };
        this.settings = {};
        var $element = jQuery(element),
            element = element;
        var $ovlid;
        this.init = function () {
            this.settings = jQuery.extend({}, defaults, options);
            if (jQuery('#divCb').length == 0) {
                jQuery('body').append('<div id="divCb"></div>')
            }
        };
        this.hide = function () {
            $element.css('display', 'none');
            $element.removeClass('md-show');
            $ovlid.remove();
            zindex = zindex - 2
        };
        this.show = function () {
            zindex = zindex + 1;
            var rnd = makeid();
            var html_overlay = '<div id="md-overlay-' + rnd + '" class="md-overlay" style="z-index:' + zindex + '"></div>';
            jQuery('#divCb').append(html_overlay);
            $ovlid = jQuery('#md-overlay-' + rnd);
            zindex = zindex + 1;
            $element.css('z-index', zindex);
            $element.addClass('md-show');
            $element.stop(true, true).css('display', 'none').fadeIn(200);
            jQuery('#md-overlay-' + rnd).unbind();
            jQuery('#md-overlay-' + rnd).click(function () {
                $element.stop(true, true).fadeOut(100, function () {
                    $element.removeClass('md-show')
                });
                $ovlid.remove();
                zindex = zindex - 2;
                $element.data('simplemodal').settings.onCancel()
            })
        };
        this.init()
    };
    jQuery.fn.simplemodal = function (options) {
        return this.each(function () {
            if (undefined == jQuery(this).data('simplemodal')) {
                var plugin = new jQuery.simplemodal(this, options);
                jQuery(this).data('simplemodal', plugin)
            }
        })
    }
})(jQuery);
jQuery.fn.getPos = function () {
    var o = this[0];
    var left = 0,
        top = 0,
        parentNode = null,
        offsetParent = null;
    offsetParent = o.offsetParent;
    var original = o;
    var el = o;
    while (el.parentNode != null) {
        el = el.parentNode;
        if (el.offsetParent != null) {
            var considerScroll = true;
            if (window.opera) {
                if (el == original.parentNode || el.nodeName == "TR") {
                    considerScroll = false
                }
            }
            if (considerScroll) {
                if (el.scrollTop && el.scrollTop > 0) {
                    top -= el.scrollTop
                }
                if (el.scrollLeft && el.scrollLeft > 0) {
                    left -= el.scrollLeft
                }
            }
        }
        if (el == offsetParent) {
            left += o.offsetLeft;
            if (el.clientLeft && el.nodeName != "TABLE") {
                left += el.clientLeft
            }
            top += o.offsetTop;
            if (el.clientTop && el.nodeName != "TABLE") {
                top += el.clientTop
            }
            o = el;
            if (o.offsetParent == null) {
                if (o.offsetLeft) {
                    left += o.offsetLeft
                }
                if (o.offsetTop) {
                    top += o.offsetTop
                }
            }
            offsetParent = o.offsetParent
        }
    }
    return {
        left: left,
        top: top
    }
};

function cleanHTML(input) {
    var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
    var output = input.replace(stringStripper, ' ');
    var commentSripper = new RegExp('<!--(.*?)-->', 'g');
    var output = output.replace(commentSripper, '');
    var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>', 'gi');
    output = output.replace(tagStripper, '');
    var badTags = ['style', 'script', 'applet', 'embed', 'noframes', 'noscript'];
    for (var i = 0; i < badTags.length; i++) {
        tagStripper = new RegExp('<' + badTags[i] + '.*?' + badTags[i] + '(.*?)>', 'gi');
        output = output.replace(tagStripper, '')
    }
    var badAttributes = ['style', 'start'];
    for (var i = 0; i < badAttributes.length; i++) {
        var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"', 'gi');
        output = output.replace(attributeStripper, '')
    }
    return output
}
function detectIE() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf('MSIE ');
    var trident = ua.indexOf('Trident/');
    var edge = ua.indexOf('Edge/');
    if (msie > 0) {
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10)
    }
    if (edge > 0) {
        return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10)
    }
    if (trident > 0) {
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10)
    }
    return false
}
function detectEdge() {
    var ua = window.navigator.userAgent;
    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
        return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10)
    }
    return false
}

function gerarHTML() {
    $('#contentarea').makeCssInline();
    $("#html-gerado").val( $('#contentarea').html());

}

var arr = [];

//arr.push("animation");
//arr.push("background-blend-mode");
arr.push("border");
arr.push("border-radius");
//arr.push("border-collapse");
//arr.push("border-image-outset");
//arr.push("border-image-repeat");
//arr.push("border-image-slice");
//arr.push("border-image-source");
//arr.push("border-image-width");
arr.push("bottom");
//arr.push("box-shadow");
//arr.push("box-sizing");
//arr.push("caption-side");
arr.push("clear");
arr.push("clip");
arr.push("color");
arr.push("cursor");
//arr.push("direction");
arr.push("display");
//arr.push("empty-cells");
arr.push("float");
arr.push("font-family");
//arr.push("font-kerning");
arr.push("font-size");
//arr.push("font-stretch");
arr.push("font-style");
//arr.push("font-variant");
//arr.push("font-variant-ligatures");
arr.push("font-weight");
arr.push("height");
//arr.push("image-rendering");
//arr.push("isolation");
arr.push("left");
//arr.push("letter-spacing");
arr.push("line-height");
arr.push("list-style");
arr.push("margin");
arr.push("max-height");
arr.push("max-width");
arr.push("min-height");
arr.push("min-width");
///arr.push("mix-blend-mode");
//arr.push("motion");
//arr.push("object-fit");
//arr.push("object-position");
arr.push("opacity");
//arr.push("orphans");
//arr.push("outline");
//arr.push("outline-offset");
//arr.push("overflow-wrap");
arr.push("overflow");
arr.push("padding");
//arr.push("page-break-after");
//arr.push("page-break-before");
//arr.push("page-break-inside");
//arr.push("pointer-events");
arr.push("position");
//arr.push("resize");
arr.push("right");
//arr.push("speak");
//arr.push("table-layout");
//arr.push("tab-size");
arr.push("text-align");
//arr.push("text-align-last");
arr.push("text-decoration");
//arr.push("text-indent");
//arr.push("text-rendering");
//arr.push("text-shadow");
//arr.push("text-overflow");
arr.push("text-transform");
arr.push("top");
//arr.push("touch-action");
//arr.push("transition");
//arr.push("unicode-bidi");
arr.push("vertical-align");
arr.push("visibility");
//arr.push("white-space");
//arr.push("widows");
//arr.push("width");
//arr.push("word-break");
//arr.push("word-spacing");
//arr.push("word-wrap");
arr.push("z-index");
//arr.push("zoom");
//arr.push("-webkit-appearance");
//arr.push("backface-visibility");
//arr.push("-webkit-background-clip");
//arr.push("-webkit-background-composite");
//arr.push("-webkit-background-origin");
//arr.push("border-spacing");
//arr.push("-webkit-border-image");
//arr.push("-webkit-box-align");
//arr.push("-webkit-box-decoration-break");
//arr.push("-webkit-box-direction");
//arr.push("-webkit-box-flex");
//arr.push("-webkit-box-flex-group");
//arr.push("-webkit-box-lines");
//arr.push("-webkit-box-ordinal-group");
//arr.push("-webkit-box-orient");
//arr.push("-webkit-box-pack");
//arr.push("-webkit-box-reflect");
//arr.push("-webkit-clip-path");
//arr.push("-webkit-column-break-after");
//arr.push("-webkit-column-break-before");
//arr.push("-webkit-column-break-inside");
//arr.push("-webkit-column-count");
//arr.push("-webkit-column-gap");
//arr.push("-webkit-column-rule-color");
//arr.push("-webkit-column-rule-style");
//arr.push("-webkit-column-rule-width");
//arr.push("-webkit-column-span");
//arr.push("-webkit-column-width");
//arr.push("-webkit-filter");
//arr.push("align-content");
//arr.push("align-items");
//arr.push("align-self");
//arr.push("flex");
//arr.push("flex-flow");
//arr.push("justify-content");
//arr.push("-webkit-font-smoothing");
//arr.push("-webkit-highlight");
//arr.push("-webkit-hyphenate-character");
//arr.push("-webkit-line-break");
//arr.push("-webkit-locale");
//arr.push("-webkit-margin-before-collapse");
//arr.push("-webkit-margin-after-collapse");
//arr.push("-webkit-mask-box-image-outset");
//arr.push("-webkit-mask-box-image-repeat");
//arr.push("-webkit-mask-box-image-slice");
//arr.push("-webkit-mask-box-image-source");
//arr.push("-webkit-mask-box-image-width");
//arr.push("-webkit-mask");
//arr.push("-webkit-mask-composite");
//arr.push("-webkit-mask-size");
//arr.push("order");
//arr.push("perspective");
//arr.push("perspective-origin");
//arr.push("-webkit-print-color-adjust");
//arr.push("-webkit-rtl-ordering");
//arr.push("shape-outside");
//arr.push("shape-image-threshold");
//arr.push("shape-margin");
//arr.push("-webkit-tap-highlight-color");
//arr.push("-webkit-text-combine");
//arr.push("-webkit-text-decorations-in-effect");
//arr.push("-webkit-text-emphasis-color");
//arr.push("-webkit-text-emphasis-position");
//arr.push("-webkit-text-emphasis-style");
//arr.push("-webkit-text-fill-color");
//arr.push("-webkit-text-orientation");
//arr.push("-webkit-text-security");
//arr.push("-webkit-text-stroke-color");
//arr.push("-webkit-text-stroke-width");
//arr.push("transform");
//arr.push("transform-origin");
//arr.push("transform-style");
//arr.push("-webkit-user-drag");
//arr.push("-webkit-user-modify");
//arr.push("-webkit-user-select");
//arr.push("-webkit-writing-mode");
//arr.push("-webkit-app-region");
//arr.push("buffered-rendering");
//arr.push("clip-path");
//arr.push("clip-rule");
//arr.push("mask");
//arr.push("filter");
//arr.push("flood-color");
//arr.push("flood-opacity");
//arr.push("lighting-color");
//arr.push("stop-color");
//arr.push("stop-opacity");
//arr.push("color-interpolation");
//arr.push("color-interpolation-filters");
//arr.push("color-rendering");
//arr.push("fill");
//arr.push("fill-opacity");
//arr.push("fill-rule");
//arr.push("marker-end");
//arr.push("marker-mid");
//arr.push("marker-start");
//arr.push("mask-type");
//arr.push("shape-rendering");
//arr.push("stroke");
//arr.push("stroke-dasharray");
//arr.push("stroke-dashoffset");
//arr.push("stroke-linecap");
//arr.push("stroke-linejoin");
//arr.push("stroke-miterlimit");
//arr.push("stroke-opacity");
//arr.push("stroke-width");
//arr.push("alignment-baseline");
//arr.push("baseline-shift");
//arr.push("dominant-baseline");
//arr.push("text-anchor");
//arr.push("writing-mode");
//arr.push("vector-effect");
//arr.push("paint-order");
//arr.push("cx");
//arr.push("cy");
//arr.push("x");
//arr.push("y");
//arr.push("r");
//arr.push("rx");
//arr.push("ry");
arr.push("background");
arr.push("margin-left");
arr.push("margin-right");
arr.push("margin-top");
arr.push("margin-bottom");
arr.push("padding-left");
arr.push("padding-right");
arr.push("padding-top");
arr.push("padding-bottom");




(function($) {
    $.extend($.fn, {
        makeCssInline: function() {
            this.each(function(idx, el) {
                var style = el.style;
                var properties = [];
                for(var property in style) {
                    if($(this).css(property)) {
                        if(jQuery.inArray( property, arr ) != -1)
                        properties.push(property + ':' + $(this).css(property));
                    }
                }
                this.style.cssText = properties.join(';');
                $(this).children().makeCssInline();
            });
        }
    });
}(jQuery));




//Download
 $("#newsletter-builder-sidebar-buttons-abutton").click(function(){

	$("#newsletter-preloaded-export").html($("#contentarea").html());
	$("#newsletter-preloaded-export .sim-row-delete").remove();
	$("#newsletter-preloaded-export .sim-row").removeClass("ui-draggable");
	$("#newsletter-preloaded-export .sim-row-edit").removeAttr("data-type");
	$("#newsletter-preloaded-export .sim-row-edit").removeClass("sim-row-edit");

	export_content = $("#newsletter-preloaded-export").html();

	$("#export-textarea").val(export_content)
	$( "#export-form" ).submit();
	$("#export-textarea").val(' ');

});

//Download
 $("#newsletter-builder-sidebar-buttons-abutton").click(function(){
	$("#newsletter-preloaded-export").html($("#contentarea").html());
	$("#newsletter-preloaded-export .sim-row-delete").remove();
	$("#newsletter-preloaded-export .sim-row").removeClass("ui-draggable");
	$("#newsletter-preloaded-export .sim-row-edit").removeAttr("data-type");
	$("#newsletter-preloaded-export .sim-row-edit").removeClass("sim-row-edit");

	export_content = $("#newsletter-preloaded-export").html();

	$("#export-textarea").val(export_content)
	$( "#export-form" ).submit();
	$("#export-textarea").val(' ');

});

//Export
$("#newsletter-builder-sidebar-buttons-bbutton").click(function(){

	$("#sim-edit-export").fadeIn(500);
	$("#sim-edit-export .sim-edit-box").slideDown(500);

	$("#newsletter-preloaded-export").html($("#contentarea").html());
	$("#newsletter-preloaded-export .sim-row-delete").remove();
	$("#newsletter-preloaded-export .sim-row").removeClass("ui-draggable");
	$("#newsletter-preloaded-export .sim-row-edit").removeAttr("data-type");
	$("#newsletter-preloaded-export .sim-row-edit").removeClass("sim-row-edit");

	preload_export_html = $("#newsletter-preloaded-export").html();

		export_content = '<div>'+preload_export_html+'</div>';
		$("#sim-edit-export .text").val(export_content);

	$("#newsletter-preloaded-export").html(' ');
});

//close edit
$(".sim-edit-box-buttons-cancel").click(function() {
  $(this).parent().parent().parent().fadeOut(500)
   $(this).parent().parent().slideUp(500)
});
