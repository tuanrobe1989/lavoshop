!function(i){i(document).ready(function(){var n={formatNoMatches:woocommerce_district_admin.formatNoMatches},e=loading_shipping=!1;i("#_billing_state").select2(n),i("#_billing_city").select2(n),i("#_billing_address_2").select2(n),i("body").on("select2:select select2-selecting","#_billing_state",function(n){i("#_billing_city option").val("");var t=n.val;t||(t=i("#_billing_state option:selected").val()),t&&!e&&(e=!0,i.ajax({type:"post",dataType:"json",url:woocommerce_district_admin.ajaxurl,data:{action:"load_diagioihanhchinh",matp:t},context:this,beforeSend:function(){i("#_billing_city,#_billing_address_2").html("").select2();var n=new Option("Loading...","");i("#_billing_city, #_billing_address_2").append(n)},success:function(n){e=!1,i("#_billing_city,#_billing_address_2").html("").select2();var t=new Option("Chọn xã/phường/thị trấn","");if(i("#_billing_address_2").append(t),n.success){var a=n.data;t=new Option("Chọn quận/huyện",""),i("#_billing_city").append(t),i.each(a,function(n,e){t=new Option(e.name,e.maqh),i("#_billing_city").append(t)})}}}))}),i("#_billing_address_2").length>0&&i("#_billing_city").on("change select2:select select2-selecting",function(e){var t=e.val;t||(t=i("#_billing_city option:selected").val()),t&&i.ajax({type:"post",dataType:"json",url:woocommerce_district_admin.ajaxurl,data:{action:"load_diagioihanhchinh",maqh:t},context:this,beforeSend:function(){i("#_billing_address_2").html("").select2();var n=new Option("Loading...","");i("#_billing_address_2").append(n)},success:function(e){if(i("#_billing_address_2").html("").select2(n),e.success){var t=e.data,a=new Option("Chọn xã/phường/thị trấn","");i("#_billing_address_2").append(a),i.each(t,function(n,e){var t=new Option(e.name,e.xaid);i("#_billing_address_2").append(t)})}}})}),i("#_shipping_state").select2(n),i("#_shipping_city").select2(n),i("#_shipping_address_2").select2(n),i("body #_shipping_state").on("select2:select select2-selecting",function(n){i("#_shipping_city option").val("");var e=n.val;e||(e=i("#_shipping_state option:selected").val()),e&&!loading_shipping&&(loading_shipping=!0,i.ajax({type:"post",dataType:"json",url:woocommerce_district_admin.ajaxurl,data:{action:"load_diagioihanhchinh",matp:e},context:this,beforeSend:function(){i("#_shipping_city,#_shipping_address_2").html("").select2();var n=new Option("Loading...","");i("#_shipping_city, #_shipping_address_2").append(n)},success:function(n){loading_shipping=!1,i("#_shipping_city,#_shipping_address_2").html("").select2();var e=new Option("Chọn xã/phường/thị trấn","");if(i("#_shipping_address_2").append(e),n.success){var t=n.data;e=new Option("Chọn quận/huyện","");i("#_shipping_city").append(e),i.each(t,function(n,e){var t=new Option(e.name,e.maqh);i("#_shipping_city").append(t)})}}}))}),i("#_shipping_address_2").length>0&&i("#_shipping_city").on("change select2:select select2-selecting",function(e){var t=e.val;t||(t=i("#_shipping_city option:selected").val()),t&&i.ajax({type:"post",dataType:"json",url:woocommerce_district_admin.ajaxurl,data:{action:"load_diagioihanhchinh",maqh:t},context:this,beforeSend:function(){i("#_shipping_address_2").html("").select2();var n=new Option("Loading...","");i("#_shipping_address_2").append(n)},success:function(e){if(i("#_shipping_address_2").html("").select2(n),e.success){var t=e.data,a=new Option("Chọn xã/phường/thị trấn","");i("#_shipping_address_2").append(a),i.each(t,function(n,e){var t=new Option(e.name,e.xaid);i("#_shipping_address_2").append(t)})}}})})})}(jQuery);