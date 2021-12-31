== Changelog ==

Thông tin thêm [về plugin này](https://levantoan.com/san-pham/plugin-ket-noi-giao-hang-tiet-kiem-voi-woocommerce-ghtk-vs-woocommerce/).


=================================================================
CODE Hỗ Trợ
=================================================================
/*
 * Thêm trạng thái woocommerce giống với ghtk
 * */
function ghtk_orrder_status_list(&$new_order_statuses){
    $new_order_statuses['wc-chuatiepnhan'] = 'Chưa tiếp nhận';
    $new_order_statuses['wc-datiepnhan'] = 'Đã tiếp nhận';
    $new_order_statuses['wc-dalayhang'] = 'Đã lấy hàng/Đã nhập kho';
    $new_order_statuses['wc-danggiaohang'] = 'Đã điều phối giao hàng/Đang giao hàng';
    $new_order_statuses['wc-danggiaohang'] = 'Đã điều phối giao hàng/Đang giao hàng';
    $new_order_statuses['wc-khonglayduochang'] = 'Không lấy được hàng';
    $new_order_statuses['wc-hoanlayhang'] = 'Hoãn lấy hàng';
    $new_order_statuses['wc-khonggiaoduochang'] = 'Không giao được hàng';
    $new_order_statuses['wc-delaygiaohang'] = 'Delay giao hàng';
    $new_order_statuses['wc-shipperbaodagiaohang'] = 'Shipper báo đã giao hàng';
    $new_order_statuses['wc-dagiaochuadoisoat'] = 'Đã giao hàng/Chưa đối soát';
    $new_order_statuses['wc-danglayhang'] = 'Đã điều phối lấy hàng/Đang lấy hàng';
    $new_order_statuses['wc-shipperdalayhang'] = 'Shipper báo đã lấy hàng';
    $new_order_statuses['wc-shipperkhonglayduochang'] = 'Shipper (nhân viên lấy/giao hàng) báo không lấy được hàng';
    $new_order_statuses['wc-delaylayhang'] = 'Shipper báo delay lấy hàng';
    $new_order_statuses['wc-shipperkhonggiaoduochang'] = 'Shipper báo không giao được giao hàng';
    $new_order_statuses['wc-shipperdelaygiaohang'] = 'Shipper báo delay giao hàng';
}

function ghtk_add_order_status_views() {
    $new_order_statuses = array();
    ghtk_orrder_status_list($new_order_statuses);
    foreach ($new_order_statuses as $key=>$value){
        register_post_status( $key, array(
            'label'                     => $value,
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( $value . ' <span class="count">(%s)</span>', $value . ' <span class="count">(%s)</span>' )
        ) );
    }
}
add_action( 'init', 'ghtk_add_order_status_views' );

function ghtk_add_order_status( $order_statuses ) {
    $new_order_statuses = array();
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
        if ( 'wc-on-hold' === $key ) {
            ghtk_orrder_status_list($new_order_statuses);
        }
    }
    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'ghtk_add_order_status' );

/*
 * Thêm phí ship mặc định khi lỗi API không lấy được phí ship của GHTK
 * */
add_filter('devvn_ghtk_rate','devvn_ghtk_rate_func', 10, 3);
function devvn_ghtk_rate_func($rates, $key, $shipping_cost){
    if($key == 'ghtk_shipping_method_baophiship'){
        $rates['id'] = $key . '_custom';
        $rates['label'] = 'Vận chuyển qua GHTK';
        $rates['cost'] = 15000;
    }
    return $rates;
}

add_filter('devvn_title_shipping_fee_failed','devvn_title_shipping_fee_failed_custom', 10);
function devvn_title_shipping_fee_failed_custom($title){
    $title = 'Phí ship sẽ báo khi giao hàng';
    return $title;
}

/*Thêm phương thức thanh toán vào list danh sách đơn hàng*/

add_filter('devvn_ghtk_action', 'devvn_ghtk_action_func', 1);
function devvn_ghtk_action_func($order){
    if ( WC()->payment_gateways() ) {
        $payment_gateways = WC()->payment_gateways->payment_gateways();
    } else {
        $payment_gateways = array();
    }

    $payment_method = $order->get_payment_method();
    if ( $payment_method && 'other' !== $payment_method ) {
        echo '<p style=" margin-bottom: 10px; ">' . sprintf(
            __('Payment via %s', 'woocommerce'),
            esc_html(isset($payment_gateways[$payment_method]) ? $payment_gateways[$payment_method]->get_title() : $payment_method)
        ) . '</p>';
    }
}

/*Thay đổi mã đơn khi đăng lên GHTK*/
add_filter('prefix_id_to_ghtk','prefix_id_to_ghtk_func', 10);
function prefix_id_to_ghtk_func($prefix){
    $prefix = 'bkeshop_';
    return $prefix;
}

add_action('admin_head', 'ghtk_custom_css_admin');
function ghtk_custom_css_admin() {
  echo '<style>
    .cancel_order_ghtk {
        display: none !important;
    }
  </style>';
}

/* Chỉ hiện 1 số state nhất định*/
add_filter('vn_checkout_tinh_thanhpho', 'custom_vn_checkout_tinh_thanhpho');
function custom_vn_checkout_tinh_thanhpho($tinh_thanhpho){
    $tinh_thanhpho = array(
        "HOCHIMINH" => "Tp. Hồ Chí Minh",
    );
    return $tinh_thanhpho;
}
=================================================================
#CODE Hỗ Trợ
=================================================================

= 2.0.5.1 - 02.11.2021 =

* Fix lỗi không cập nhật được dữ liệu tỉnh thành với 1 số hosting
* Fix lỗi tên sp với Wholesale plugin

= 2.0.5 - 02.11.2021 =

* Thêm filter enable_script_vn_checkout để có thể gọi js ở bất kỳ page nào. Mặc định của có ở trang checkout và trang sửa địa chỉ ở my account
apply_filters('enable_script_vn_checkout', false)
* Đưa dữ liệu địa giới hành chính vào trong SQL để tăng tốc độ load khi ở trang danh sách đơn hàng (Shop order)
* Nâng cấp để sử dụng với multisite. License sẽ được active sho dạng subfolder, không hỗ trợ subdomain. Ví dụ abc.com/web1 abc.com/web2

= 2.0.4 - 27.09.2021 =

* Thêm tùy chọn ẩn phương thức GHTK và ViettelPost nếu có các shipping methob khác
* Tối ưu lại bản dịch tiếng Việt
* Thêm chức năng làm tròn phí ship. Ví dụ: 18.050VND -> 18.000VND hoặc 18.503VND -> 19.000VND

= 2.0.3 - 24.09.2021 =

* Fix lỗi js báo thiếu thư viện magnificPopup

= 2.0.2.1 - 17.09.2021 =

* Fix nhanh lỗi trong V2.0.2 không nhận địa chỉ dạng tên dẫn tới không đăng đơn hàng được

= 2.0.2 - 16.09.2021 =

* Tối ưu cấu trúc và dữ liệu tỉnh thành để phù hợp với plugin tính phí vận chuyển tới quận/huyện và ViettelPost

= 2.0.1 - 13.09.2021 =

* Thay đổi 1 số filter sang filter mới

ghtk_tinh_thanhpho => vn_checkout_tinh_thanhpho
ghtk_quanhuyen => vn_checkout_quanhuyen
ghtk_phuongxa => vn_checkout_phuongxa
ghtk_get_name_city => vn_checkout_get_name_city
ghtk_get_name_district => vn_checkout_get_name_district
ghtk_get_name_village => vn_checkout_get_name_village
ghtk_get_list_district => vn_checkout_get_list_district
ghtk_get_list_district_select => vn_checkout_get_list_district_select
ghtk_get_list_village => vn_checkout_get_list_village
ghtk_get_list_village_select => vn_checkout_get_list_village_select

= 2.0.0 - 11.09.2021 =

* Xóa pick_address_id ở địa chỉ kho và trong dữ liệu API của GHTK
* Tối ưu lại cấu trúc của plugin để hoạt động chung với các plugin shipping khác (Hiện tại là chạy chung với plugin tính phí ship tới Quận/Huyện)
* Tối ưu chức năng update qua license

= 1.5.5 - 08.07.2021 =

* Update danh sách địa giới hành chính mới nhất ngày 27/04/2021
* ADD: Thêm Gắn nhãn dễ vỡ cho đơn hàng


= 1.5.4 - 23.06.2021 =

* Add: Thêm chức năng fix lỗi quốc gia. Vào Woocommerce > Cài đặt GHTK -> Kéo xuống mục "Công cụ" và ấn button "Cập nhật quốc gia"
* Update: Loại bỏ tính năng tracking đơn hàng qua GHTK thay bằng tracking đơn hàng mặc định của woocommerce
* Update: Loại bỏ hình thức vận chuyển xFast
* Update: Thêm tên gọi "Thành phố" vào tên địa chỉ thành phố

= 1.5.3 - 15.05.2021 =

* Sửa lỗi khi tạo tài khoản trong lúc checkout không tự set quốc gia là Việt Nam
* Update: Thay đổi lại link tracking cho đúng với API mới
* Add: Thêm điều khiện payment != cod và status == processing hoặc dùng filter ghtk_disable_cod để tự động set COD = 0 khi đăng đơn

= 1.5.2 - 03.03.2021 =

* Add: Thêm chức năng hủy đơn hàng qua API
* Fix: Tối ưu lại xFast 2h

= 1.5.1 - 27.02.2021 =

* Hiển thị lại mục tổng khối lượng đơn hàng trong form đăng đơn

= 1.5.0 - 18.02.2021 =

* Thêm dịch vụ xFast2h vào tính phí ship và đăng đơn
* Update thêm trường hợp lỗi ko check dc license bằng wp_remote_post
* Bỏ trường "tổng khối lượng" khi đăng đơn. vì GHTK tính theo kl của mỗi sp trong đơn ko áp dụng KL tổng này nữa

= 1.4.8 - 16.01.2021 =

* Sửa lại hàm check file get_address.php để phù hợp với 1 số hosting chặn truy cập file php trực tiếp

= 1.4.7 - 15.01.2021 =

* Update đổi tên địa chỉ phường từ I, II, III,... sang số 1,2,3...
* Update danh sách địa giới hành chính mới nhất ngày 15/01/2021

= 1.4.6 - 10.12.2020 =

* Fix: Sửa lỗi với WordPress 5.6
* Add: Thêm chức năng tùy chỉnh trạng thái đơn hàng đồng bộ từ GHTK->Woo trong phần cài đặt 1 cách trực quan
* Update: Thêm thông báo "Phí vận chuyển sẽ báo sau" khi không tính được phí ship từ GHTK (có thể do api GHTK lỗi hoặc do lý do khác)
* Add: Thêm chức năng bật debug để biết được các request có sai gì hay không. File log nằm tại thư mục plugins /ghtk_log.txt
        Để bật chế độ ghi log hãy thêm code sau vào functions.php
        add_filter('devvn_ghtk_debug', '__return_true');


= 1.4.4 - 28.10.2020 =

* Update: Cập nhật lại danh sách địa giới hành chính cho đầy đủ và chính xác hơn

= 1.4.3 - 20.10.2020 =

* Fix: Sửa lại điều kiện tính phí ship theo kích thước

= 1.4.2 - 12.10.2020 =

* Thay đổi lại cách đăng ký link Webhook. Do GHTK thay đổi API nên bây giờ phải gửi link webhook cho GHTK thêm vào hệ thống 1 cách thủ công không còn đăng ký được qua API nữa

= 1.4.1 - 03.10.2020 =

* Add: Quy đổi kích thước => khối lượng để tính phí ship
* Add: Thêm filter devvn_ghtk_shipping_fee để custom phí của ghtk
    apply_filters('devvn_ghtk_shipping_fee', $shipping_fee, $key);

* Add: Thêm filter devvn_ghtk_rate để custom rate ghtk
    apply_filters('devvn_ghtk_rate', array(
            'id' => $this->id . $key,
            'label' => $val,
            'cost' => $shipping_fee,
            'calc_tax' => 'per_item',
            'meta_data' => array(
                'hubsid' => isset($cost['hubsid']) ? $cost['hubsid'] : 0,
                'transport' => $key,
            )
        ), $key, $shipping_fee
    );

= 1.4.0 - 14.08.2020 =

* Fix: Sửa lỗi js với WordPress 5.5

= 1.3.9 - 30.07.2020 =

* Fix lỗi khi chuyển đổi vnđ -> $ để thanh toán bằng paypal
* Update: GHTK trả hàng sẽ update trạng thái sang cancelled

= 1.3.8 - 19.07.2020 =

* Fix: Sửa lại tổng số tiền trong in đơn theo mẫu riêng
* Fix: Sửa lại lỗi khi chọn ca giao hàng không áp dụng vào đơn hàng
* Add: Thêm filter prefix_id_to_ghtk để có thể custom ID của đơn hàng trước khi đăng lên GHTK. Mặc định dạng ORDER_ID
    apply_filters('prefix_id_to_ghtk', '', $orderThis)
* Update: Cập nhật lại đơn vị hành chính cho đầy đủ và chính xác nhất theo http://www.gso.gov.vn/dmhc2015/
* Add: Thêm file .pot

= 1.3.7 - 01.07.2020 =

* Fix lỗi 1 số website không tải được các phương thức thanh toán. Bằng cách đổi từ chọn phương thức thanh toán để freeship sang nhập slug của phương thức đó

* Thêm filter ghtk_tinh_thanhpho để có thể sửa tùy biến dữ liệu tỉnh thành phố của plugin
* Thêm filter ghtk_quanhuyen để có thể sửa tùy biến dữ liệu quận huyện của plugin
* Thêm filter ghtk_phuongxa để có thể sửa tùy biến dữ liệu phường xã thị trấn của plugin

* Thêm filter ghtk_get_name_city để có thể sửa tùy biến dữ liệu trả về tên tỉnh thành phố
* Thêm filter ghtk_get_name_district để có thể sửa tùy biến dữ liệu trả về tên quận huyện
* Thêm filter ghtk_get_name_village để có thể sửa tùy biến dữ liệu trả về tên xã phường thị trấn

* Thêm filter ghtk_get_list_district return apply_filters('ghtk_get_list_district', $matp, $this);
* Thêm filter ghtk_get_list_district_select $district_select = apply_filters('ghtk_get_list_district_select', $matp, $this);

* Thêm filter ghtk_get_list_village return apply_filters('ghtk_get_list_village', $maqh, $this);
* Thêm filter ghtk_get_list_village_select $village_select = apply_filters('ghtk_get_list_village_select', $maqh, $this);


* Thêm filter get_customer_address_shipping để thay đổi lại dữ liệu khách hàng apply_filters('get_customer_address_shipping', $customer_address, $order)

* Fix lỗi filter Hiển thị thông tin vận chuyển của GHTK bên ngoài đơn hàng ở trang tài khoản

= 1.3.6 - 22.06.2020 =

* Thêm chức năng hẹn ngày lấy hàng
* Thêm chức năng chọn ca lấy hàng
* Thêm chức năng click vào mã để copy mã đơn hàng
* Thêm chức năng miễn phí vận chuyển theo hình thức thanh toán. Ví dụ nếu chọn hình thức chuyển khoản thì sẽ freeship cho khách
* Xác nhận trước khi ấn vào nút xóa đơn hàng
* Thêm ô nhập tổng khối lượng đơn hàng. Trường này ko cần thiết phải nhập. Nếu để trống hệ thống sẽ tự động lấy tổng khối lượng của sản phẩm
* Fix: Sửa lại giá tiền thu hộ lúc in đơn hàng theo mẫu riêng bị sai
* Thêm nút "In Ngay" vào trang in theo mẫu riêng
* Thêm filter 'devvn_ghtk_order_note' để bạn có thể tùy chỉnh ghi chú đơn hàng trước khi đăng đơn theo ý muốn

    add_filter('devvn_ghtk_order_note', 'custom_devvn_ghtk_order_note');
    function custom_devvn_ghtk_order_note($noted){
        $noted = 'Hàng dễ vỡ xin nhẹ tay. ' . $noted;
        return $noted;
    }

* Hiển thị thông tin vận chuyển của GHTK bên ngoài đơn hàng ở trang tài khoản. Mặc định ẩn. Để hiển thị bạn hay để code sau vào functions.php của theme bạn đang kích hoạt

     add_filter('view_ghtk_status_in_order_myaccount', '__return_true');

= 1.3.5 - 19.06.2020 =
* Fix gấp lỗi 502 tại trang order trong admin. Lý do vì encode file quận huyện dẫn tới size quá lớn để load. Ở bản này mình đã bỏ encode các file địa chỉ và template nhé

= 1.3.4 - 18.06.2020 =

* Nâng cấp tương thích với API Version 1.5.4 của GHTK: Yêu cầu cần có địa chỉ cấp 4 Tên thôn/ấp/xóm/tổ/…
* Yêu cầu cần có php extension ioncube và php version 7.2 hoặc 7.3 để hoạt động
* Thêm action devvn_invoice_after_shop_address, devvn_invoice_after_customer_address
* Thêm filter devvn_invoice_order_ghtk_full, devvn_invoice_order_ghtk_fullinfor
* Không tự động bật bàn phím khi ấn vào chọn tỉnh thành trên mobile
* Thêm filter khi cập nhật trạng thái đơn hàng


Thêm Filter devvn_ghtk_create_order_products để thay đổi thông tin sản phẩm khi đăng đơn lên GHTK.
Ví dụ bạn chỉ muốn tên hàng hóa là "Túi xách" thì thêm code sau vào functions.php

add_filter('devvn_ghtk_create_order_products', 'custom_devvn_ghtk_create_order_products', 10, 3);
function custom_devvn_ghtk_create_order_products($products, $main_class, $order){
    $products = array(
        array(
            'name' => 'Túi xách',
            'weight' => '0.5' //KG
        )
    );
    return $products;
}

+++++ Mở rộng: Thêm người tạo đơn vào hóa đơn ++++++

add_action('woocommerce_order_status_changed', 'devvn_set_author_order', 10, 3);
function devvn_set_author_order($order_id, $from, $to){
    if($to == 'completed'){
        $current_user = wp_get_current_user();
        update_post_meta($order_id, 'devvn_author_order', $current_user->ID);
    }
}

add_action('devvn_invoice_after_shop_address', 'devvn_invoice_after_shop_address_author_order');
function devvn_invoice_after_shop_address_author_order($order){
    $devvn_author_order = get_post_meta($order->get_id(), 'devvn_author_order', true);
    if($devvn_author_order) {
        $user = get_user_by('id', $devvn_author_order);
        if($user && !is_wp_error($user)) {
            printf(__('<br>Người tạo đơn: %s<br>', 'devvn-ghtk'), $user->display_name);
        }
    }
}

= 1.3.3 - 05.12.2019 =

* Thêm mục chọn cách xưng hô (Anh, Chị) trong trang checkout - Optional
* Fix: lỗi khi chọn freeship trong cài đặt thì giá trị thu hộ lúc đăng đơn bị sai lúc ban đầu load
* Thêm mục checkbox "Khách đã chuyển khoản thu hộ = 0". Nếu được chọn thì tiền thu hộ tự đồng = 0
* Loại bỏ hình thức vận chuyển theo đường bay nếu tỉnh thành của khách mua hàng trùng với kho của shop
* Thêm lựa chọn tỉnh thành > quận huyện > phường xã khi xem profile của thành viên trong admin
* Thêm lựa chọn tỉnh thành > quận huyện > phường xã vào địa chỉ cửa hàng tại Woocomerce > setting > general > Store Address
* Thêm khổ in cho máy in nhiệt khổ giấy 80mm
* Fix lỗi khi chọn địa chỉ tự động điền sẽ bị lỗi không load quận/huyện theo tỉnh/thành phố
* Thêm dấu tích màu vàng vào button "In hóa đơn theo mẫu riêng" nếu đơn đó đã được in
* Thêm {estimated_deliver} để hiển thị ngày dự kiến giao hàng trong email gửi cho khách hàng khi tạo vận đơn

= 1.3.2 - 20.11.2019 =

* Sửa lỗi nhân đôi thông tin đăng đơn tại danh sách sản phẩm
* Thêm kiểu in đơn hàng: In theo chiều dọc khổ A6 - Phù hợp với máy in nhiệt theo cuộn
* Sửa lỗi load địa chỉ với 1 số web cài bảo mật cao không cho thực thi trực tiếp file .php từ bên ngoài
* Tinh chỉnh lại style

= 1.3.1 - 16.11.2019 =

* Thêm chức năng đăng đơn hàng lên GHTK bên ngoài list đơn hàng trong admin
* In cùng lúc nhiều đơn hàng theo mẫu riêng
* Tối ưu lại danh sách đơn hàng trong admin. Thêm list sản phẩm bên ngoài danh sách đơn hàng.
* Thay đổi bố cục lúc tạo đơn hàng trực quan và dễ nhìn hơn.
* Đồng bộ trạng thái từ GHTK "Đã giao hàng/Chưa đối soát" sang "Đã hoàn thành" ở Woo

= 1.3.0 - 14.11.2019 =

* Chọn xong quận huyện mới bắt đầu tính phí ship, Chọn tỉnh thành và xã phường sẽ không tính phí ship nữa. Tránh mất thời gian khi checkout
* Đổi First name thành Họ và tên, trước đây là Last name. (Đồng bộ với 1 số phần mềm khác)
* Cải thiện tốc độ tải địa chỉ tỉnh thành, quận huyện và xã phường lên 100 lần so với bản cũ
* Thêm filter devvn_ghtk_shipping_methob để tùy chỉnh lại thứ tự và hình thức giao hàng

= 1.2.9 - 14.08.2019 =

* Update: Sửa lỗi với phiên bản woocommerce 3.7.0

= 1.2.8 - 07.08.2019 =

* Update: Sửa lỗi không nhận mã vận đơn khi in bằng mẫu riêng

= 1.2.7 - 12.06.2019 =

* Update: Thêm các khu ở huyện Côn Đảo
* Update: Sắp xếp các tên tỉnh thành/quận huyện/ xã phường theo chữ cái A-Z

= 1.2.6 - 26.05.2019 =

* Fix: Lỗi hiển thị thuộc tính sản phẩm khi đăng lên GHTK ở tên SP
* Add: Thêm ô nhập giá trị hàng hóa khi đăng đơn. Cái này để thay đổi giá trị khi không muốn đóng bảo hiểm vận đơn.
* Update: Đặt mặc định chú ý đơn hàng của khách vào chỗ ghi chú cho GHTK khi đăng đơn. Thấy nhiều người cần nên để mặc định luôn.
* Update: Đổi lại thư viện popup sang Magnific-Popup [https://github.com/dimsemenov/Magnific-Popup] do nội dung đăng đơn dài cái cũ không còn phù hợp nữa

= 1.2.5 - 03.04.2019 =

* Fix: Sửa lỗi nhận với 1 số trường hơp bị sai mã vạch khi in với mẫu riêng

= 1.2.4.1 - 08.03.2019 =

* Fix: Sửa nhanh 1 lỗi ko nhận tên SHOP khi đăng đơn trong bản 1.2.4

= 1.2.4 - 08.03.2019 =

* Add: Thêm lựa chọn hình thức vận chuyển khi đăng đơn
* Add: Thêm lựa chọn gửi hàng tại điểm khi đăng đơn
* Add: Thêm lựa chọn hình thức vận chuyển: đường bộ - đường bay ở trang checkout
* Update: Trạng thái hoàn trả hàng của GHTK -> Tạm giữ trên Woocommerce

= 1.2.3 - 16.01.2019 =

* Fix: Chỉnh lại phần khối lượng của 1 sp trước khi đăng đơn lên GHTK khi số lượng sản phẩm > 1 sp

= 1.2.2 - 17.11.2018 =

* Update: Update tương thích với thay đổi của API mới bên GHTK
* Fix: Chỉnh lại định dạng địa chỉ kho hàng khi có mã kho hàng

= 1.2.1 - 13.11.2018 =

* Add: Chế độ sandbox - Hoạt động ở môi trường test. Đơn hàng sẽ không được thực thi ở chế độ này
* Fix: Fix nhanh lỗi hiển thị địa chỉ ở bản update 1.2.0
* Fix: Định dạng mặc định khối lượng về KG khi đăng đơn hàng

= 1.2.0 - 06.11.2018 =

* Add: Lựa chọn hình thức vận chuyển đường bộ (road) hoặc đường bay (fly)
* Update: Tương thích với Woocommerce 3.5.1

= 1.1.9 - 10.10.2018 =

* Add: Thêm chức năng gửi mã vận đơn cho khách hàng khi đã đăng đơn thành công lên GHTK

= 1.1.8 - 13.09.2018 =

* Fix: Sửa định dạng của webhook URL
* Fix: Thay đổi kho giao hàng khi đăng đơn lên GHTK

= 1.1.6 - 07.07.2018 =

* Add: Có thể thêm nhiều kho hàng, lựa chọn cửa hàng/kho giao hàng khi đăng đơn
* Add: Có thể lựa chọn khu vực bán hàng cho cửa hàng/kho để giảm chi phí khi tính phí ship và đăng đơn lên GHTK
* Update: Sắp xếp tỉnh thành theo thứ tự A-Z và đưa Hà Nội và Hồ Chí Minh lên đầu

= 1.1.5 - 14.06.2018 =

* Tracking đơn hàng ngay trên website. Sử dụng shortcode [ghtk_tracking_form] để hiển thị form tracking
  - Để có thể tracking cần có mã shop và token.
  - Mã shop thêm tại mục sau Setting/Cài đặt GHTK -> Cài đặt thông tin cửa hàng -> Mã SHOP

= 1.1.4 - 02.05.2018 =

* Add: Hỗ trợ plugin Point Of Sale
* Update: Lưu trạng thái đơn hàng bằng ajax

= 1.1.3 - 15.04.2018 =

* FIX: Sửa lỗi khi check vào Shop trả tiền ship nhưng vẫn tính cho khách trả
* ADD: Thêm mã ghtk ra ngoài trang toàn bộ đơn hàng

= 1.1.2 - 03.04.2018 =

* FIX: Sửa lỗi không hiển thị trường first_name khi kích hoạt hỗ trợ thanh toán qua Alepay

= 1.1.1 - 30.03.2018 =

* Update: Sửa lỗi ko hiển thị attribute ở tên sản phẩm khi in hóa đơn với sản phẩm được thêm vào sau khi khách đã đặt hàng.

= 1.1.0 - 22.03.2018 =

* Fix: Thêm thuộc tính vào tên sản phẩm khi in hóa đơn theo mẫu riêng

= 1.0.9 - 20.03.2018 =

* Add: In hóa đơn theo mẫu riêng của shop

= 1.0.8 - 13.03.2018 =

* Update: Thay đổi thông báo khi chưa điền đầy đủ thông tin như: tỉnh thành phố, quận huyện.
* Update: Hiển thị tên của tỉnh/thành phố, quận huyện và xã phường thị trấn trong APP IOS của Woocommerce

= 1.0.7 - 12.03.2018 =

* Update: Thêm js ở phần tính phí vận chuyển tại trang giỏ hàng để phù hợp với 1 số theme

= 1.0.6 - 10.03.2018 =

* Update: Thay đổi trạng thái đơn hàng khi đã đối soát -> đơn hàng về đã hoàn thành

= 1.0.5 - 08.03.2018 =

* Update: Có thể lựa chọn quận huyện và tính phí vận chuyển ngay trên trang giỏ hàng.
* Update: 1 số css

= 1.0.4 - 06.03.2018 =

* ADD: Tự động update plugin thông qua license
* Fix: Sửa lỗi khi ẩn field xã phường ở bản 1.0.3

= 1.0.3 - 27.02.2018 =

* Fix: Sửa tổng giá trị đơn hàng gửi lên GHTK khi có mã giảm giá
* Fix: Cập nhật tình trạng đơn hàng bằng Webhook

= 1.0.2 - 09.02.2018 =

* Add: Thêm bộ lọc đơn hàng theo tỉnh thành
* Update: Support cổng thanh toán Alepay (Setting -> Cài đặt GHTK -> Kích hoạt Alepay)
* Update: 99% Tương thích với plugin "WooCommerce Checkout Field Editor (Manager) Pro"
* Update: Tương thích với Woocommerce 3.3.x
* Update: Tương thích với Flatsome
* Update: Tương thích với PHP 7.x.x

= 1.0.1 - 07.02.2018 =

* Tiêu đề sản phẩm kèm theo variation của sản phẩm. Ví dụ Iphone Màu-trắng | Dung lượng – 8G
* Sử dụng webhook để tự động cập nhật tình trạng đơn hàng từ hệ thống của ghtk. Các thiết lập webhook [xem thêm tại đây](https://levantoan.com/san-pham/plugin-ket-noi-giao-hang-tiet-kiem-voi-woocommerce-ghtk-vs-woocommerce/#setting-webhook)

= 1.0 - 02.02.2018=

* Ra mắt plugin