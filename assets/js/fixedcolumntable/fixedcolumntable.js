function setPLocation(url, setFocus) {
    if (setFocus) {
        window.opener.focus();
    }
    window.opener.location.href = url;
}

function setLocation(url) {
    window.location.href = url;
}

function setLocationRemove(url) {
    var abc = window.opener.jQuery("#btn_wishlist_footer");
    abc.trigger('initCompareList');
    return false
};
(function ($) {
    $.fn.scrollCompare = function (options) {
		/*
		 * jQuery 1.9 support. browser object has been removed in 1.9 
		 */
		var browser = $.browser;
		
		if (!browser) {
			function uaMatch( ua ) {
				ua = ua.toLowerCase();
	
				var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
					/(webkit)[ \/]([\w.]+)/.exec( ua ) ||
					/(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
					/(msie) ([\w.]+)/.exec( ua ) ||
					ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
					[];
	
				return {
					browser: match[ 1 ] || "",
					version: match[ 2 ] || "0"
				};
			};
	
			var matched = uaMatch( navigator.userAgent );
			browser = {};
	
			if ( matched.browser ) {
				browser[ matched.browser ] = true;
				browser.version = matched.version;
			}
	
			// Chrome is Webkit, but Webkit is also Safari.
			if ( browser.chrome ) {
				browser.webkit = true;
			} else if ( browser.webkit ) {
				browser.safari = true;
			}
		}
		
        var opts = $.extend({}, $.fn.scrollCompare.defaults, options);
        var heightArray = [];
        return this.each(function () {
            var $this = $(this);
            var o = $.meta ? $.extend({}, opts, $this.data()) : opts;
            init();
            if (browser.msie && parseInt(browser.version) <= 6) {
                lockPositionIE("#bg-labels", 120);
            } else {
                lockPosition("#bg-labels", 120);
            }
        });

        function init() {
            $('body').append('<div id="bg-labels"><div id="nameTableHldr"></div></div>');
            $('.compare-products').css({
                'text-align': 'left',
                'top': '0',
                'display': 'block'
            });
            $('#bg-labels').width(opts.bgLabelWidth + 2);
            scrollableWidth();
        }

        function scrollableWidth() {
            var compareTableOuter = $('.compare-products');
            var totalNumber = ($('#product_comparison tr:nth-child(' + 1 + ') td').length);
            var outerWidth = ((opts.tdWidth * totalNumber) - (opts.tdWidth)) * 2;
            $('#product_comparison td,#product_comparison th').width((opts.tdWidth));
            $('#product_comparison').width((opts.tdWidth * totalNumber) + opts.bgLabelWidth);
            $('.compare-products').width($(window).width() + (opts.tdWidth * (totalNumber - 1)));
            $(window).bind("resize", resizeWindow);

            function resizeWindow(e) {
                var newWindowWidth = $(window).width();
                $('.compare-products').width($(window).width() + (opts.tdWidth * (totalNumber - 1)));
            }
            $(window).bind("scroll", resizeScroll);

            function resizeScroll(e) {}
            stripFirstColumn();
        }

        function stripFirstColumn() {
			var bordercolor = $('#product_comparison').attr('bordercolor');
            var nameTable = $('<table id="nameTable" cellpadding="0" border="1" bordercolor="' + bordercolor + '" cellspacing="0"></table>');
            $('#product_comparison tr').each(function (i) {
                nameTable.append('<tr class="' + $(this).attr('class') + '"><td style="color:' + $(this).children('th:first').css('color') + '"><span class=" bold a-right">' + $(this).children('th:first').html() + '</span></td></tr>');
            });
            nameTable.appendTo('#nameTableHldr');
            $('#product_comparison tr').each(function (i) {
                $(this).children('th:first').css({
                    'width': opts.bgLabelWidth + 'px',
                    'display': 'table-cell'
                });
                $(this).children('th:first').find('div').css({
                    'width': opts.bgLabelWidth + 'px',
                    'display': 'block'
                });
            });
            fixHeights();
        }

        function fixHeights() {
            var curRow = 1;
            var comTable = $('#product_comparison tr');
            var nameTable = $('#nameTable');
            comTable.each(function (i) {
                var c1 = $('#nameTable tr:nth-child(' + curRow + ')').outerHeight();
                var c2 = $(this).outerHeight();
                var maxHeight = Math.max(c1, c2);
                heightArray.push(maxHeight);
                curRow++;
            });
            setHeight();
        }

        function setHeight() {
            var currrentRow = 1;
            for (i = 0; i < heightArray.length; i++) {
                $('#product_comparison tr:nth-child(' + currrentRow + ')').children('td:nth-child(2)').height(heightArray[i]);
                $('#nameTable tr:nth-child(' + currrentRow + ')').children('td:nth-child(1)').height(heightArray[i]);
                currrentRow++;
            }
        }

        function lockPosition(id, pixles) {
            var name = id;
            $(window).scroll(function () {
                var offset = (-$(document).scrollTop() + pixles) + "px";
                $(name).css({
                    top: offset
                }, {
                    duration: 0,
                    queue: true
                });
            });
        }

        function lockPositionIE(id, pixles) {
            var name = id;
            var menuYloc = null;
            menuYloc = parseInt($(name).css("top").substring(0, $(name).css("top").indexOf("px")));
            $(window).scroll(function () {
                var offset = menuYloc + $(document).scrollTop() + "px";
                var xoffset = ($(document).scrollLeft()) + "px";
                $(name).animate({
                    top: "60px"
                }, {
                    duration: 0,
                    queue: false
                });
                if (browser.msie && parseInt(browser.version) <= 6) {
                    $(name).animate({
                        top: "60px"
                    }, {
                        duration: 0,
                        queue: false
                    });
                } else {
                    $(name).animate({
                        top: "60px"
                    }, {
                        duration: 0,
                        queue: false
                    });
                }
                $(name).animate({
                    left: xoffset
                }, {
                    duration: 0,
                    queue: false
                });
            });
        }
    };
    $.fn.scrollCompare.defaults = {
        tdWidth: 240,
        bgLabelWidth: 225
    };
    $('.name, .icn-wishlist, .link-cart, .btn-cart').click(function (e) {
        setPLocation($(this).attr('href'), true);
        e.preventDefault();
        return false
    });
    $('#product_comparison').scrollCompare();
    $('#product_comparison td').hover(function () {
        $(this).parent('tr').find('td').addClass("row-hover");
    }, function () {
        $(this).parent('tr').find('td').removeClass("row-hover")
    });
    $('#print-compare').click(function (e) {
        window.print();
        e.preventDefault();
    });
})(jQuery);