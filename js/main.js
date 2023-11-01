function ajax_action(action,table,id,value){

    jQuery.post("/admin/includes/ajax.php", { action: action, table : table, id : id, value : value},function(data) {
        location.reload();

    });

}

function delete_mass(table){
    var counter = 0;
    jQuery("input[name='marked[]']:checked").each(function() {
        counter = counter +1;
        jQuery.post("/admin/includes/ajax.php", { action: "delete_mass", table : table, to_del : jQuery(this).val()},function(data) {
        });
    });
    jQuery( document ).ajaxStop(function() {
       if(jQuery("input[name='marked[]']:checked").length==counter)
            location.reload();
    });
}

(function(jQuery) {


    jQuery.fn.autocomplete = function(option) {
        return this.each(function() {
            this.timer = null;
            this.items = new Array();

            jQuery.extend(this, option);

            jQuery(this).attr('autocomplete', 'off');

            // Focus
            jQuery(this).on('focus', function() {
                this.request();
            });

            // Blur
            jQuery(this).on('blur', function() {
                setTimeout(function(object) {
                    object.hide();
                }, 200, this);
            });

            // Keydown
            jQuery(this).on('keydown', function(event) {
                switch(event.keyCode) {
                    case 27: // escape
                        this.hide();
                        break;
                    default:
                        this.request();
                        break;
                }
            });

            // Click
            this.click = function(event) {
                event.preventDefault();

                value = jQuery(event.target).parent().attr('data-value');

                if (value && this.items[value]) {
                    this.select(this.items[value]);
                }
            }

            // Show
            this.show = function() {
                var pos = jQuery(this).position();

                jQuery(this).siblings('ul.dropdown-menu').css({
                    top: pos.top + jQuery(this).outerHeight(),
                    left: pos.left
                });

                jQuery(this).siblings('ul.dropdown-menu').show();
            }

            // Hide
            this.hide = function() {
                jQuery(this).siblings('ul.dropdown-menu').hide();
            }

            // Request
            this.request = function() {
                clearTimeout(this.timer);

                this.timer = setTimeout(function(object) {
                    object.source(jQuery(object).val(), jQuery.proxy(object.response, object));
                }, 200, this);
            }

            // Response
            this.response = function(json) {
                html = '';

                if (json.length) {
                    for (i = 0; i < json.length; i++) {
                        this.items[json[i]['value']] = json[i];
                    }

                    for (i = 0; i < json.length; i++) {
                        if (!json[i]['category']) {
                            html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
                        }
                    }

                    // Get all the ones with a categories
                    var category = new Array();

                    for (i = 0; i < json.length; i++) {
                        if (json[i]['category']) {
                            if (!category[json[i]['category']]) {
                                category[json[i]['category']] = new Array();
                                category[json[i]['category']]['name'] = json[i]['category'];
                                category[json[i]['category']]['item'] = new Array();
                            }

                            category[json[i]['category']]['item'].push(json[i]);
                        }
                    }

                    for (i in category) {
                        html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

                        for (j = 0; j < category[i]['item'].length; j++) {
                            html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
                        }
                    }
                }

                if (html) {
                    this.show();
                } else {
                    this.hide();
                }

                jQuery(this).siblings('ul.dropdown-menu').html(html);
            }

            jQuery(this).after('<ul class="dropdown-menu"></ul>');
            jQuery(this).siblings('ul.dropdown-menu').delegate('a', 'click', jQuery.proxy(this.click, this));

        });
    }
})(window.jQuery);


