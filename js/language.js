jQuery(document).ready(function($) {


        function custom_template(obj){
            var data = $(obj.element).data();
            var text = $(obj.element).text();
            if(data && data['img_src']){
                img_src = data['img_src'];
                template = $("<img src=\"" + img_src + "\" style=\"width:20px;height:100%;display: inline;\"/><p style=\"font-weight: 700;font-size:14pt;text-align:center;\">" + text + "</p>");
                return template;
            }
        }

        var options = {
            'templateSelection': custom_template,
            'templateResult': custom_template,
        }
        $('#id_select2_example').select2(options);
        $('.select2-container--default .select2-selection--single').css({'height': '220px'});


});