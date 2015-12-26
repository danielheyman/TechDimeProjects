<?php include 'header.php'; ?>
<div id="scrollingbg">&nbsp;</div>
<div id="scrolling">
<?php
    $query = $db->query("SELECT `amount`, TIME_TO_SEC(TIMEDIFF(NOW(), (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`))) AS `time`, (SELECT `item_name` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`) AS `type`, (SELECT `fullName` FROM `users` WHERE `users`.`id` = `commissions`.`userid`) AS `name` FROM `commissions` WHERE `amount` >= 0.01 ORDER BY ID DESC LIMIT 10");
    while($prize = $query->getNext())
    {
        $name = explode(" ", $prize->name)[0];
        $type = $prize->type;
        
        echo "<div class='spot'>{$name} won $" . $prize->amount . " from {$type}!</div>";
    }
?>
</div>
<script>
$(document).ready(function() {
setTimeout(function(){
setInterval(function(){
    $("#scrolling").scrollLeft($("#scrolling").scrollLeft() + 1);
    if($("#scrolling").scrollLeft() >= $("#scrolling .spot").outerWidth( true ))
    {
        $("#scrolling").append("<div class='spot'>" + $('#scrolling .spot').html() + "</div>");
        $('#scrolling .spot').first().remove();
        $("#scrolling").scrollLeft(0);
    }
}, 20);
}, 500);
});
</script>
<div class="row">
    <div class="col-md-12">
        <div id="websiteTitle">Learn to Succeed<div class="period">.</div> Make Money<div class="period">.</div> Have Fun<div class="period">.</div></div>
    </div>
    <div class="col-md-4">
        <div class="grayboxing">
            <div class="lightbulb"><i class="icon-lightbulb"></i></div>
            <div class="line">&nbsp;</div>
            <div class="description">
                We will show you how to build your online business from the ground up. We have a wide range of tools that will not only introduce you to the countless programs that can push your success, but we will also assist you in building a greatly profitable downline network. To make the package even sweeter, we will help brand your online business.
            </div>
            <a href="<?=$site['url']?>register"><div class="button">What are you waiting for?<br><div class="bolding">Let's Succeed!</div></div></a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="blueboxing">
            <div class="money"><i class="icon-money"></i></div>
            <div class="line">&nbsp;</div>
            <div class="description">
                We want you to feel welcomed into the Surf Savant community so we made sure that you can jump into making money right from day one. Between our paid to click feature, our contests, and our many daily tasks, you will never be done earning your style. We are putting the decision in your hands to test your limits and see how much you want to earn.
            </div>
            <a href="<?=$site['url']?>register"><div class="button">What are you waiting for?<br><div class="bolding">Let's Make Money!</div></div></a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="grayboxing">
            <div class="thumbsup">&nbsp;</div>
            <div class="line">&nbsp;</div>
            <div class="description">
                We believe that success, money, and fame are of little importance if they do not come with a little fun. You can play our multitude of games. Not only will you be able to put your skillset to the test, but you will also be able to invest in virtual stocks and have a great time with the super amazing members of the Surf Savant community. It is one great ride!
            </div>
            <a href="<?=$site['url']?>register"><div class="button">What are you waiting for?<br><div class="bolding">Let the Fun Begin!</div></div></a>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

<script type="text/javascript">
    /**
 * Firebug/Web Inspector Outline Implementation using jQuery
 * Tested to work in Chrome, FF, Safari. Buggy in IE ;(
 * Andrew Childs <ac@glomerate.com>
 *
 * Example Setup:
 * var myClickHandler = function (element) { console.log('Clicked element:', element); }
 * var myDomOutline = DomOutline({ onClick: myClickHandler, filter: '.debug' });
 *
 * Public API:
 * myDomOutline.start();
 * myDomOutline.stop();
 */
var DomOutline = function (options) {
    options = options || {};

    var pub = {};
    var self = {
        opts: {
            namespace: options.namespace || 'DomOutline',
            borderWidth: options.borderWidth || 2,
            onClick: options.onClick || false,
            filter: options.filter || false
        },
        keyCodes: {
            BACKSPACE: 8,
            ESC: 27,
            DELETE: 46
        },
        active: false,
        initialized: false,
        elements: {}
    };

    function writeStylesheet(css) {
        var element = document.createElement('style');
        element.type = 'text/css';
        document.getElementsByTagName('head')[0].appendChild(element);

        if (element.styleSheet) {
            element.styleSheet.cssText = css; // IE
        } else {
            element.innerHTML = css; // Non-IE
        }
    }

    function initStylesheet() {
        if (self.initialized !== true) {
            var css = '' +
                '.' + self.opts.namespace + ' {' +
                '    background: #09c;' +
                '    position: absolute;' +
                '    z-index: 1000000;' +
                '}' +
                '.' + self.opts.namespace + '_label {' +
                '    background: #09c;' +
                '    border-radius: 2px;' +
                '    color: #fff;' +
                '    font: bold 12px/12px Helvetica, sans-serif;' +
                '    padding: 4px 6px;' +
                '    position: absolute;' +
                '    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.25);' +
                '    z-index: 1000001;' +
                '}';

            writeStylesheet(css);
            self.initialized = true;
        }
    }

    function createOutlineElements() {
        self.elements.label = jQuery('<div></div>').addClass(self.opts.namespace + '_label').appendTo('body');
        self.elements.top = jQuery('<div></div>').addClass(self.opts.namespace).appendTo('body');
        self.elements.bottom = jQuery('<div></div>').addClass(self.opts.namespace).appendTo('body');
        self.elements.left = jQuery('<div></div>').addClass(self.opts.namespace).appendTo('body');
        self.elements.right = jQuery('<div></div>').addClass(self.opts.namespace).appendTo('body');
    }

    function removeOutlineElements() {
        jQuery.each(self.elements, function(name, element) {
            element.remove();
        });
    }

    function compileLabelText(element, width, height) {
        var label = element.tagName.toLowerCase();
        if (element.id) {
            label += '#' + element.id;
        }
        if (element.className) {
            label += ('.' + jQuery.trim(element.className).replace(/ /g, '.')).replace(/\.\.+/g, '.');
        }
        return label + ' (' + Math.round(width) + 'x' + Math.round(height) + ')';
    }

    function getScrollTop() {
        if (!self.elements.window) {
            self.elements.window = jQuery(window);
        }
        return self.elements.window.scrollTop();
    }

    function updateOutlinePosition(e) {
        if (e.target.className.indexOf(self.opts.namespace) !== -1) {
            return;
        }
        if (self.opts.filter) {
            if (!jQuery(e.target).is(self.opts.filter)) {
                return;
            }
        }      
        pub.element = e.target;

        var b = self.opts.borderWidth;
        var scroll_top = getScrollTop();
        var pos = pub.element.getBoundingClientRect();
        var top = pos.top + scroll_top;

        var label_text = compileLabelText(pub.element, pos.width, pos.height);
        var label_top = Math.max(0, top - 20 - b, scroll_top);
        var label_left = Math.max(0, pos.left - b);

        self.elements.label.css({ top: label_top, left: label_left }).text(label_text);
        self.elements.top.css({ top: Math.max(0, top - b), left: pos.left - b, width: pos.width + b, height: b });
        self.elements.bottom.css({ top: top + pos.height, left: pos.left - b, width: pos.width + b, height: b });
        self.elements.left.css({ top: top - b, left: Math.max(0, pos.left - b), width: b, height: pos.height + b });
        self.elements.right.css({ top: top - b, left: pos.left + pos.width, width: b, height: pos.height + (b * 2) });
    }

    function stopOnEscape(e) {
        if (e.keyCode === self.keyCodes.ESC || e.keyCode === self.keyCodes.BACKSPACE || e.keyCode === self.keyCodes.DELETE) {
            pub.stop();
        }

        return false;
    }

    function clickHandler(e) {
        pub.stop();
        self.opts.onClick(pub.element);

        return false;
    }

    pub.start = function () {
        initStylesheet();
        if (self.active !== true) {
            self.active = true;
            createOutlineElements();
            jQuery('body').on('mousemove.' + self.opts.namespace, updateOutlinePosition);
            jQuery('body').on('keyup.' + self.opts.namespace, stopOnEscape);
            if (self.opts.onClick) {
                setTimeout(function () {
                    jQuery('body').on('click.' + self.opts.namespace, function(e){
                        if (self.opts.filter) {
                            if (!jQuery(e.target).is(self.opts.filter)) {
                                return false;
                            }
                        }
                        clickHandler.call(this, e);
                    });
                }, 50);
            }
        }
    };

    pub.stop = function () {
        self.active = false;
        removeOutlineElements();
        jQuery('body').off('mousemove.' + self.opts.namespace)
            .off('keyup.' + self.opts.namespace)
            .off('click.' + self.opts.namespace);
    };

    return pub;
};



var myExampleClickHandler = function (element) { 
        alert($(element).getPath());
        myDomOutline.start();
    };
    var myDomOutline = DomOutline({ onClick: myExampleClickHandler, filter: '*' });

    myDomOutline.start();

    jQuery.fn.extend({
        getPath: function () {
            var path, node = this;
            while (node.length) {
                var realNode = node[0], name = realNode.localName;
                if (!name) break;
                name = name.toLowerCase();

                var parent = node.parent();

                var sameTagSiblings = parent.children(name);
                if (sameTagSiblings.length > 1) { 
                    allSiblings = parent.children();
                    var index = allSiblings.index(realNode) + 1;
                    if (index > 1) {
                        name += ':nth-child(' + index + ')';
                    }
                }

                path = name + (path ? '>' + path : '');
                node = parent;
            }
            if(path.match(/^.*:nth-child[(][1-9]*[)]$/g) == null) path += ":nth-child(1)"
            return path;
        }
    });


</script>