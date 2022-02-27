<?php

use App\Enumeration\Role;
use Illuminate\Support\Facades\Hash;

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// Buyer Resource
Route::get('/resource/index', 'Buyer\ResourceController@index')->name('buyer_resource');
Route::post('/resource/search_items', 'Buyer\ResourceController@searchItems')->name('buyer_search_items_resource');

Route::get('/', 'HomeController@index')->name('home');

// Authorize and Capture
Route::post('/authorize_capture', 'Buyer\CheckoutController@authorizeAndCapture')->name('authorize_capture');

Route::prefix('admin')->group(function () {
    
    // Auth
    Route::get('login', 'Admin\AuthController@login')->name('login_admin');
    Route::post('login/post', 'Admin\AuthController@loginPost')->name('login_admin_post');
    Route::post('logout', 'Admin\AuthController@logout')->name('logout_admin');

    // Dashboard
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin_dashboard')->middleware('employee');

    // Category
    Route::get('category', 'Admin\CategoryController@index')->name('admin_category')->middleware('employee');
    Route::post('category/add', 'Admin\CategoryController@addCategory')->name('admin_category_add')->middleware('employee');
    Route::post('category/delete', 'Admin\CategoryController@deleteCategory')->name('admin_category_delete')->middleware('employee');
    Route::post('category/detail', 'Admin\CategoryController@categoryDetail')->name('admin_category_detail')->middleware('employee');
    Route::post('category/update', 'Admin\CategoryController@updateCategory')->name('admin_category_update')->middleware('employee');
    Route::post('category/update/parent', 'Admin\CategoryController@updateCategoryParent')->name('admin_category_parent_update')->middleware('employee');
    Route::post('category/update/sort', 'Admin\CategoryController@sortCategory')->name('admin_sort_category')->middleware('employee');
    Route::post('category/image/delete', 'Admin\CategoryController@Category_Image_delete')->name('Category_Image_delete')->middleware('employee');

    //Brands
    Route::get('brands', 'Admin\BrandController@brands')->name('admin_brands')->middleware('employee');
    Route::post('brands/add', 'Admin\BrandController@brandsAdd')->name('admin_brands_add')->middleware('employee');
    Route::post('brands/update', 'Admin\BrandController@brandsUpdate')->name('admin_brands_update')->middleware('employee');
    Route::post('brands/delete', 'Admin\BrandController@brandsDelete')->name('admin_brands_delete')->middleware('employee');
    Route::post('brands/change/status', 'Admin\BrandController@brandsChangeStatus')->name('admin_brands_change_status')->middleware('employee');

    //Made In Country
    Route::get('made/in/country', 'Admin\MadeInCountryController@madeInCountry')->name('admin_made_in_country')->middleware('employee');
    Route::post('made/in/country/add', 'Admin\MadeInCountryController@madeInCountryAdd')->name('admin_made_in_country_add')->middleware('employee');
    Route::post('made/in/country/update', 'Admin\MadeInCountryController@madeInCountryUpdate')->name('admin_made_in_country_update')->middleware('employee');
    Route::post('made/in/country/delete', 'Admin\MadeInCountryController@madeInCountryDelete')->name('admin_made_in_country_delete')->middleware('employee');
    Route::post('made/in/country/change/status', 'Admin\MadeInCountryController@madeInCountryChangeStatus')->name('admin_made_in_country_change_status')->middleware('employee');
    Route::post('made/in/country/change/default', 'Admin\MadeInCountryController@madeInCountryChangeDefault')->name('admin_made_in_country_change_default')->middleware('employee');

    // Sort Items
    Route::get('sort/items', 'Admin\SortController@index')->name('admin_sort_items_view')->middleware('employee');
    Route::post('sort/items/save', 'Admin\SortController@save')->name('admin_sort_items_save')->middleware('employee');
    Route::post('sort/item/single', 'Admin\SortController@saveSingle')->name('admin_sort_single_item')->middleware('employee');

    // Master Color
    Route::get('master/color', 'Admin\MasterColorController@index')->name('admin_master_color')->middleware('employee');
    Route::post('master/color/add/post', 'Admin\MasterColorController@addPost')->name('admin_master_color_add')->middleware('employee');
    Route::post('master/color/delete', 'Admin\MasterColorController@delete')->name('admin_master_color_delete')->middleware('employee');
    Route::post('master/color/update', 'Admin\MasterColorController@update')->name('admin_master_color_update')->middleware('employee');

    // Color
    Route::get('color', 'Admin\ColorController@index')->name('admin_color')->middleware('employee');
    Route::post('color/add/post', 'Admin\ColorController@addPost')->name('admin_color_add_post')->middleware('employee');
    Route::post('color/edit/post', 'Admin\ColorController@editPost')->name('admin_color_edit_post')->middleware('employee');
    Route::post('color/delete', 'Admin\ColorController@delete')->name('admin_color_delete')->middleware('employee');

    //Size
    Route::get('size', 'Admin\SizeController@size')->name('admin_size')->middleware('employee');
    Route::post('size/add', 'Admin\SizeController@sizeAdd')->name('admin_size_add')->middleware('employee');
    Route::post('size/update', 'Admin\SizeController@sizeUpdate')->name('admin_size_update')->middleware('employee');
    Route::post('size/delete', 'Admin\SizeController@sizeDelete')->name('admin_size_delete')->middleware('employee');
    Route::post('size/change/status', 'Admin\SizeController@sizeChangeStatus')->name('admin_size_change_status')->middleware('employee');

    //Item values
    Route::get('item/values', 'Admin\ItemValueController@index')->name('admin_item_values')->middleware('employee');
    Route::post('item/values/add', 'Admin\ItemValueController@itemValueAdd')->name('admin_item_values_add')->middleware('employee');
    Route::post('item/values/update', 'Admin\ItemValueController@itemValueUpdate')->name('admin_item_values_update')->middleware('employee');
    Route::post('item/values/delete', 'Admin\ItemValueController@itemValueDelete')->name('admin_item_values_delete')->middleware('employee');
    Route::post('item/values/change/status', 'Admin\ItemValueController@itemValueChangeStatus')->name('admin_item_values_change_status')->middleware('employee');

    // Create a new item
    Route::get('create/new/item', 'Admin\ItemController@createNewItemIndex')->name('admin_create_new_item')->middleware('employee');
    Route::post('create/new/item/post', 'Admin\ItemController@createNewItemPost')->name('admin_create_new_item_post')->middleware('employee');
    Route::post('create_new_item/add/color', 'Admin\ItemController@addColor')->name('admin_item_add_color')->middleware('employee');
    Route::post('create_new_item/upload/image', 'Admin\ItemController@uploadImage')->name('admin_item_upload_image')->middleware('employee');

    // Edit Item
    Route::get('item/edit/{item}', 'Admin\ItemController@editItem')->name('admin_edit_item')->middleware('employee');
    Route::post('item/edit/{item}', 'Admin\ItemController@editItemPost')->name('admin_edit_item_post')->middleware('employee');
    Route::post('edit/new/item/remove/video', 'Admin\ItemController@removeVideo')->name('admin_item_remove_video')->middleware('employee');

    // Clone Item
    Route::get('item/clone/{item}', 'Admin\ItemController@cloneItem')->name('admin_clone_item')->middleware('employee');
    Route::post('item/clone/{old_item}', 'Admin\ItemController@cloneItemPost')->name('admin_clone_item_post')->middleware('employee');
    Route::post('items/list-clone', 'Admin\ItemController@cloneMultiItems')->name('admin_clone_multi_items')->middleware('employee');

    // Item List
    Route::get('items/all', 'Admin\ItemController@itemListAll')->name('admin_item_list_all')->middleware('employee');
    Route::post('item/list/change/to/inactive', 'Admin\ItemController@itemsChangeToInactive')->name('admin_item_list_change_to_inactive')->middleware('employee');
    Route::post('item/list/change/to/active', 'Admin\ItemController@itemsChangeToActive')->name('admin_item_list_change_to_active')->middleware('employee');
    Route::post('item/list/delete', 'Admin\ItemController@itemsDelete')->name('admin_item_list_delete')->middleware('employee');
    Route::get('item/category/{category}', 'Admin\ItemController@itemListByCategory')->name('admin_item_list_by_category')->middleware('employee');
    Route::post('items/category/move', 'Admin\ItemController@categoryMove')->name('admin_category_move')->middleware('employee');

    // Orders
    Route::get('orders/all', 'Admin\OrderController@allOrders')->name('admin_all_orders')->middleware('employee');
    Route::get('orders/type', 'Admin\OrderController@admin_orders_according_type')->name('admin_orders_according_type')->middleware('employee');
    Route::get('orders/new', 'Admin\OrderController@newOrders')->name('admin_new_orders')->middleware('employee');
    Route::get('orders/confirmed', 'Admin\OrderController@confirmOrders')->name('admin_confirmed_orders')->middleware('employee');
    Route::get('orders/backed', 'Admin\OrderController@backedOrders')->name('admin_backed_orders')->middleware('employee');
    Route::get('orders/shipped', 'Admin\OrderController@shippedOrders')->name('admin_shipped_orders')->middleware('employee');
    Route::get('orders/cancelled', 'Admin\OrderController@cancelledOrders')->name('admin_cancelled_orders')->middleware('employee');
    Route::get('orders/returned', 'Admin\OrderController@returnedOrders')->name('admin_returned_orders')->middleware('employee');
    Route::get('orders/details/{order}', 'Admin\OrderController@orderDetails')->name('admin_order_details')->middleware('employee');
    Route::POST('send_message_buyer', 'Admin\OrderController@send_message_buyer')->name('send_message_buyer')->middleware('employee');
    Route::post('orders/details/post/{order}', 'Admin\OrderController@orderDetailsPost')->name('admin_order_details_post')->middleware('employee');
    Route::get('orders/incomplete', 'Admin\OrderController@incompleteOrders')->name('admin_incomplete_orders')->middleware('employee');
    Route::get('orders/incomplete/{user}', 'Admin\OrderController@incompleteOrderDetails')->name('admin_incomplete_order_detail')->middleware('employee');
    Route::post('orders/backorder/create', 'Admin\OrderController@createBackorder')->name('admin_create_back_order')->middleware('employee');
    Route::post('orders/out_of_stock', 'Admin\OrderController@outOfStock')->name('admin_out_of_stock')->middleware('employee');
    Route::post('orders/delete_item', 'Admin\OrderController@deleteOrderItem')->name('admin_delete_order_item')->middleware('employee');
    Route::post('order/delete', 'Admin\OrderController@deleteOrder')->name('admin_delete_order')->middleware('employee');
    Route::get('order/item_details', 'Admin\OrderController@itemDetails')->name('admin_get_item_details')->middleware('employee');
    Route::post('order/add/item', 'Admin\OrderController@addItem')->name('admin_order_add_item')->middleware('employee');
    Route::post('order/change/status', 'Admin\OrderController@changeStatus')->name('admin_change_order_status')->middleware('employee');
    Route::get('orders/print/pdf', 'Admin\OrderController@printPdf')->name('admin_print_pdf')->middleware('employee');
    Route::get('orders/print/pdf/without_image', 'Admin\OrderController@printPdfWithOutImage')->name('admin_print_pdf_without_image')->middleware('employee');
    Route::get('orders/print/packlist', 'Admin\OrderController@printPacklist')->name('admin_print_packlist')->middleware('employee');
    Route::post('orders/check_password', 'Admin\OrderController@checkPassword')->name('admin_order_check_password')->middleware('employee');
    Route::post('orders/mask/card_number', 'Admin\OrderController@maskCardNumber')->name('admin_order_mask_card_number')->middleware('employee');

    //shipping order export
    Route::post('export-information', 'Admin\OrderController@exportInformation')->name('export_information')->middleware('employee');

    //Incomplete order send mail
    Route::post('orders/incomplete/sendmail', 'Admin\OrderController@incompleteOrderSendMail')->name('admin_incomplete_order_send_mail')->middleware('employee');

    // Admin Orders
    Route::get('orders/create', 'Admin\AdminNewOrderController@itemListAll')->name('admin_new_order_create')->middleware('employee');
    Route::POST('set_session', 'Admin\AdminNewOrderController@set_session')->name('set_session')->middleware('employee');
    Route::post('orders/set_new_customer', 'Admin\AdminNewOrderController@set_new_customer')->name('set_new_customer')->middleware('employee');
    Route::post('admin/name/autocomplete', 'Admin\AdminNewOrderController@nameSearch')->name('admin_name_autocomplete')->middleware('employee');
    Route::post('admin/email/autocomplete', 'Admin\AdminNewOrderController@emailSearch')->name('admin_email_autocomplete')->middleware('employee');

    // Admin Cart
    Route::get('cart/item/color', 'Admin\AdminCartController@cartItemColor')->name('cart_item_color')->middleware('employee');
    Route::post('cart/item/add', 'Admin\AdminCartController@addToCart')->name('cart_item_add')->middleware('employee');
    Route::get('admin/cart', 'Admin\AdminCartController@showCart')->name('show_admin_cart')->middleware('employee');
    Route::post('admin/cart/delete', 'Admin\AdminCartController@deleteCart')->name('admin_delete_cart')->middleware('employee');
    Route::post('cart/update/admin', 'Admin\AdminCartController@updateCart')->name('update_cart_admin')->middleware('employee');
    Route::get('admin/cart/update/success', 'Admin\AdminCartController@updateCartSuccess')->name('admin_update_cart_success')->middleware('employee');

    // Admin Checkout
    Route::post('admin/checkout/create', 'Admin\AdminCheckoutController@create')->name('create_admin_checkout')->middleware('employee');
    Route::get('admin/checkout', 'Admin\AdminCheckoutController@singlePageCheckout')->name('admin_show_checkout')->middleware('employee');
    Route::post('admin/checkout/post', 'Admin\AdminCheckoutController@singlePageCheckoutPost')->name('admin_checkout_post')->middleware('employee');
    Route::post('admin/address/select', 'Admin\AdminCheckoutController@addressSelect')->name('admin_checkout_address_select')->middleware('employee');
    Route::post('admin/add/shipping_address', 'Admin\AdminCheckoutController@addShippingAddress')->name('admin_add_shipping_address')->middleware('employee');
    Route::post('admin/checkout/apply_coupon', 'Admin\AdminCheckoutController@applyCoupon')->name('admin_apply_coupon')->middleware('employee');
    Route::get('admin/checkout/complete', 'Admin\AdminCheckoutController@complete')->name('admin_checkout_complete')->middleware('employee');

    // Logo
    Route::get('logo', 'Admin\BannerController@logo')->name('admin_logo')->middleware('employee');
    Route::post('logo/add/post', 'Admin\BannerController@logoPost')->name('admin_logo_add_post')->middleware('employee');
    Route::post('logo/remove', 'Admin\BannerController@LogoRemove')->name('admin_logo_remove')->middleware('employee');

    // Main Banner
    Route::get('banner/main', 'Admin\BannerController@mainBanner')->name('admin_main_banner')->middleware('employee');
    Route::post('banner/main/add', 'Admin\BannerController@mainBannerAdd')->name('admin_main_banner_add')->middleware('employee');
    Route::post('banner/main/sort', 'Admin\BannerController@mainBannerSort')->name('admin_main_banner_sort')->middleware('employee');
    Route::post('banner/main/update', 'Admin\BannerController@mainBannerUpdate')->name('admin_main_banner_update')->middleware('employee');
    Route::post('banner/main/delete', 'Admin\BannerController@mainBannerDelete')->name('admin_main_banner_delete')->middleware('employee');

    // Section Two Banner
    Route::get('section/two/banner', 'Admin\BannerController@sectionTwoBanner')->name('admin_section_two_banner')->middleware('employee');
    Route::post('section/two/banner/add', 'Admin\BannerController@sectionTwoBannerAdd')->name('admin_section_two_banner_add')->middleware('employee');
    Route::post('section/two/banner/sort', 'Admin\BannerController@sectionTwoBannerSort')->name('admin_section_two_banner_sort')->middleware('employee');
    Route::post('section/two/banner/update', 'Admin\BannerController@sectionTwoBannerUpdate')->name('admin_section_two_banner_update')->middleware('employee');
    Route::post('section/two/banner/delete', 'Admin\BannerController@sectionTwoBannerDelete')->name('admin_section_two_banner_delete')->middleware('employee');
    
    // Customer
    Route::get('customer/all', 'Admin\BuyerController@allBuyer')->name('admin_all_buyer')->middleware('employee');
    Route::post('customer/change/status', 'Admin\BuyerController@changeStatus')->name('admin_buyer_change_status')->middleware('employee');
    Route::post('customer/change/verified', 'Admin\BuyerController@changeVerified')->name('admin_buyer_change_verified')->middleware('employee');
    Route::post('customer/change/mailing_list', 'Admin\BuyerController@changeMailingList')->name('admin_buyer_change_mailing_list')->middleware('employee');
    Route::post('customer/change/block', 'Admin\BuyerController@changeBlock')->name('admin_buyer_change_block')->middleware('employee');
    Route::get('customer/edit/{buyer}', 'Admin\BuyerController@edit')->name('admin_buyer_edit')->middleware('employee');
    Route::post('customer/edit/post/{buyer}', 'Admin\BuyerController@editPost')->name('admin_buyer_edit_post')->middleware('employee');
    Route::get('customer/export', 'Admin\BuyerController@allBuyerExport')->name('admin_all_buyer_export')->middleware('employee');
    Route::post('customer/delete', 'Admin\BuyerController@delete')->name('admin_buyer_delete')->middleware('employee');
    
    //customer create from admin panel
    Route::get('customer/create', 'Admin\BuyerController@customerCreate')->name('customer_create')->middleware('employee');
    Route::post('customer/post', 'Admin\BuyerController@customerPost')->name('customer_register_post')->middleware('employee');
    Route::get('customer/complete', 'Admin\BuyerController@customerComplete')->name('customer_register_complete')->middleware('employee');

    // Store Credit
    Route::post('store/credit/add', 'Admin\StoreCreditController@add')->name('admin_add_store_credit')->middleware('employee');
    Route::get('store/credit', 'Admin\StoreCreditController@view')->name('admin_store_credit_view')->middleware('employee');

    //Age Group
    Route::get('age/group', 'Admin\AgeGroupController@ageGroup')->name('admin_age_group')->middleware('employee');
    Route::post('age/group/add', 'Admin\AgeGroupController@ageGroupAdd')->name('admin_age_group_add')->middleware('employee');
    Route::post('age/group/update', 'Admin\AgeGroupController@ageGroupUpdate')->name('admin_age_group_update')->middleware('employee');
    Route::post('age/group/delete', 'Admin\AgeGroupController@ageGroupDelete')->name('admin_age_group_delete')->middleware('employee');

    //Skin Types
    Route::get('skin/types', 'Admin\SkinTypesController@skinTypes')->name('admin_skin_types')->middleware('employee');
    Route::post('skin/types/add', 'Admin\SkinTypesController@skinTypesAdd')->name('admin_skin_types_add')->middleware('employee');
    Route::post('skin/types/update', 'Admin\SkinTypesController@skinTypesUpdate')->name('admin_skin_types_update')->middleware('employee');
    Route::post('skin/types/delete', 'Admin\SkinTypesController@skinTypesDelete')->name('admin_skin_types_delete')->middleware('employee');

    // Administration -> Vendor Information
    Route::get('administration/admin/information', 'Admin\VendorInformationController@index')->name('admin_admin_information')->middleware('employee');
    Route::post('administration/company/information/post', 'Admin\VendorInformationController@companyInformationPost')->name('admin_company_information_post')->middleware('employee');
    Route::post('administration/size/chart/post', 'Admin\VendorInformationController@sizeChartPost')->name('admin_size_chart_post')->middleware('employee');
    Route::post('administration/order/notice/post', 'Admin\VendorInformationController@orderNoticePost')->name('admin_order_notice_post')->middleware('employee');
    Route::post('administration/shipping/post', 'Admin\VendorInformationController@admin_shipping_post')->name('admin_shipping_post')->middleware('employee');
    Route::post('administration/stylepick/post', 'Admin\VendorInformationController@stylePickPost')->name('admin_style_pick_post')->middleware('employee');
    Route::post('administration/save/settings', 'Admin\VendorInformationController@saveSetting')->name('admin_save_setting_post')->middleware('employee');

    // Administration -> Account Setting
    Route::get('administration/account/setting', 'Admin\AccountSettingController@index')->name('admin_account_setting')->middleware('employee');
    Route::post('administration/admin_id/post', 'Admin\AccountSettingController@adminIdPost')->name('admin_admin_id_post')->middleware('employee');
    Route::post('administration/manage_account/add/post', 'Admin\AccountSettingController@addAccountPost')->name('admin_add_account_post')->middleware('employee');
    Route::post('administration/manage_account/delete/post', 'Admin\AccountSettingController@deleteAccountPost')->name('admin_delete_account_post')->middleware('employee');
    Route::post('administration/manage_account/update/post', 'Admin\AccountSettingController@updateAccountPost')->name('admin_update_account_post')->middleware('employee');
    Route::post('administration/manage_account/status_update/post', 'Admin\AccountSettingController@statusUpdateAccountPost')->name('admin_status_update_account_post')->middleware('employee');
    Route::post('administration/store_setting/save/post', 'Admin\AccountSettingController@saveStoreSetting')->name('admin_save_store_setting_post')->middleware('employee');
    
    // Administration -> Admin Message
    Route::get('all/message', 'Admin\AccountSettingController@allMessage')->name('all_message')->middleware('employee');
    Route::POST('all/message/status', 'Admin\AccountSettingController@allMessageStatus')->name('all_message_status')->middleware('employee');

    // Administration -> Courier
    Route::get('courier', 'Admin\CourierController@index')->name('admin_courier')->middleware('employee');
    Route::post('courier/add/post', 'Admin\CourierController@addPost')->name('admin_courier_add')->middleware('employee');
    Route::post('courier/delete', 'Admin\CourierController@delete')->name('admin_courier_delete')->middleware('employee');
    Route::post('courier/update', 'Admin\CourierController@update')->name('admin_courier_update')->middleware('employee');

    // Administration -> Coupons
    Route::get('coupons', 'Admin\PromotionController@index')->name('admin_promotions')->middleware('employee');
    Route::post('coupons/add/post', 'Admin\PromotionController@addPost')->name('admin_promotions_add_post')->middleware('employee');
    Route::post('coupons/edit/post', 'Admin\PromotionController@editPost')->name('admin_promotions_edit_post')->middleware('employee');
    Route::post('coupons/delete', 'Admin\PromotionController@delete')->name('admin_promotions_delete')->middleware('employee');

    // Administration -> Point system
    Route::get('point/system', 'Admin\PointSystemController@index')->name('admin_point_system')->middleware('employee');
    Route::post('point/settings', 'Admin\PointSystemController@saveSetting')->name('admin_save_point_system_setting_post')->middleware('employee');
    Route::post('discount/settings', 'Admin\PointSystemController@saveDiscount')->name('admin_save_discount_setting_post')->middleware('employee');
    Route::post('points/add/post', 'Admin\PointSystemController@addPoint')->name('admin_points_add_post')->middleware('employee');
    Route::post('points/edit/post', 'Admin\PointSystemController@editPoint')->name('admin_points_edit_post')->middleware('employee');
    Route::post('points/delete', 'Admin\PointSystemController@delete')->name('admin_points_delete')->middleware('employee');

    // Administration -> Ship Method
    Route::get('ship/method', 'Admin\ShipMethodController@index')->name('admin_ship_method')->middleware('employee');
    Route::post('ship/method/add/post', 'Admin\ShipMethodController@addPost')->name('admin_ship_method_add')->middleware('employee');
    Route::post('ship/method/delete', 'Admin\ShipMethodController@delete')->name('admin_ship_method_delete')->middleware('employee');
    Route::post('ship/method/update', 'Admin\ShipMethodController@update')->name('admin_ship_method_update')->middleware('employee');

    // Administration -> Social links
    Route::get('social/links', 'Admin\SocialController@index')->name('admin_social_link')->middleware('employee');
    Route::post('social/links/add', 'Admin\SocialController@addUpdatePost')->name('admin_social_links_add_post')->middleware('employee');

    // Administration -> Social Feed
    Route::get('social/feeds', 'Admin\SocialController@social_feed_access')->name('admin_social_feed')->middleware('employee');
    Route::post('social/feeds/add', 'Admin\SocialController@socialFeedaddUpdatePost')->name('admin_social_feed_add_post')->middleware('employee');

    // Administration -> Buyer Home
    Route::get('buyer/home', 'Admin\OtherController@buyerHome')->name('admin_buyer_home')->middleware('employee');
    Route::post('buyer/home/save', 'Admin\OtherController@buyerHomeSave')->name('admin_buyer_home_save')->middleware('employee');

    // Administration -> Welcome Notification
    Route::get('welcome/notification', 'Admin\OtherController@welcomeNotification')->name('admin_welcome_notification')->middleware('employee');
    Route::post('welcome/notification/save', 'Admin\OtherController@welcomeNotificationSave')->name('admin_welcome_notification_save')->middleware('employee');

    Route::get('top/notification', 'Admin\OtherController@topNotification')->name('admin_top_notification')->middleware('employee');
    Route::post('top/notification/save', 'Admin\OtherController@topNotificationSave')->name('admin_top_notification_save')->middleware('employee');

    // Pages
    Route::get('page/{id}', 'Admin\PageController@index')->name('admin_page_view')->middleware('employee');
    Route::post('page/save{id}', 'Admin\PageController@save')->name('admin_page_save')->middleware('employee');

    //Home page 
    Route::get('home-page', 'Admin\HomePageController@index')->name('admin_home_page_view')->middleware('employee');
    Route::post('home-page/save{id}', 'Admin\HomePageController@save')->name('admin_home_page_save')->middleware('employee');

    // item statistics
    Route::get('/item/statistics', 'Admin\ItemStatisticsController@index')->name('item_statistics')->middleware('employee');
    Route::POST('/item/statistics/filter', 'Admin\ItemStatisticsController@filter')->name('item_statistics_filter')->middleware('employee');
    Route::POST('/item/statistics/get_quantity_of_color_product', 'Admin\ItemStatisticsController@get_quantity_of_color_product')->name('qty_c_products')->middleware('employee');
    Route::POST('/item/statistics/stylenoSearch', 'Admin\ItemStatisticsController@stylenoSearch')->name('stylenoSearch')->middleware('employee');

    // Export to SP
    Route::get('export/sp', 'Admin\OtherController@exportToSPView')->name('admin_export_to_sp_view')->middleware('employee');
    Route::post('export/sp', 'Admin\OtherController@exportToSPPost')->name('admin_export_to_sp_post')->middleware('employee');

    // Others
    Route::post('modal/items', 'Admin\OtherController@getItems')->name('admin_get_items_for_modal')->middleware('employee');

    //import customer data
    Route::get('/read-excel',function(){
        $fileD = fopen(public_path('customers5.csv'), "r");
        $column = fgetcsv($fileD);
        while (!feof($fileD)) {
            $rowData[] = fgetcsv($fileD);
        }
        foreach ($rowData as $key => $value) {
            $inserted_data = array('company_name' => $value[0], 'first_name' => $value[1], 'email' => $value[2], 'address' => $value[3], 'unit' => $value[4],
                'phone' => $value[5], 'city' => $value[6], 'state' => $value[7], 'zipcode' => $value[8],
                'fax' => $value[9], 'website' => $value[10], 'approved' => $value[11], 'approved_at' => $value[12], 'created_at' => $value[13],
                'orders' => $value[14], 'logins' => $value[15], 'last_login' => $value[16], 'password' => $value[17]);
            $name = explode(' ', $inserted_data['first_name']);
            $approvedAt=null;
            $createdAt = null;
            $lastLogin = null;
            if ($approvedAt) {

                $approvedAt = explode(' ', $inserted_data['approved_at']);
            }
            if ($createdAt) {

                $createdAt = explode(' ', $inserted_data['created_at']);
            }
            if ($lastLogin) {

                $lastLogin = explode(' ', $inserted_data['last_login']);
            }

            $userCheck = App\Model\User::where('email', $inserted_data['email'])->first();

            if ($inserted_data['approved'] == 'Y' && !isset($userCheck)) {
                $meta = App\Model\MetaBuyer::create([
                    'verified' => 1,
                    'active' => ($inserted_data['approved'] == 'Y') ? 1 : 0,
                    'user_id' => 0,
                    'primaryCustomerMarket' => 1,
                    'primary_customer_market' => 1,
                    'seller_permit_number' => '123456',
                    'company_name' => $inserted_data['company_name'],
                    'website' => $inserted_data['website'],
                    'billing_location' => (!isset($inserted_data['address'])) ? 'INT' : 'US',
                    'billing_address' => $inserted_data['address'],
                    'billing_unit' => $inserted_data['unit'],
                    'billing_state' => $inserted_data['state'],
                    'billing_city' => $inserted_data['city'],
                    'billing_country_id' => (!isset($inserted_data['address'])) ? 20 : 1,
                    'billing_zip' => $inserted_data['zipcode'],
                    'hear_about_us' => 'google',
                    'receive_offers' => 1,
                    'billing_phone' => $inserted_data['phone'],
                    'billing_fax' => $inserted_data['fax']]);

                $user = App\Model\User::create([
                    'first_name' => (isset($name[0])) ? $name[0] : '',
                    'last_name' => (isset($name[1])) ? $name[1] : '',
                    'active' => ($inserted_data['approved'] == 'Y') ? 1 : 0,
                    'updated_at' => date('Y-m-d', strtotime($approvedAt[0].' '.$approvedAt[1])),
                    'created_at' => date('Y-m-d', strtotime($createdAt[0].' '.$createdAt[1])),
                    'last_login' => date('Y-m-d', strtotime($lastLogin[0].' '.$lastLogin[1])),
                    'order_count' => $inserted_data['orders'],
                    'email' => $inserted_data['email'],
                    'password' => Hash::make($inserted_data['password']),
                    'role' => Role::$BUYER,
                    'buyer_meta_id' => $meta->id,
                ]);

                App\Model\BuyerShippingAddress::create([
                    'user_id' => $user->id,
                    'default' => 1,
                    'location' => (!isset($inserted_data['address'])) ? 'INT' : 'US',
                    'address' => $inserted_data['address'],
                    'unit' => $inserted_data['unit'],
                    'commercial' => 0,
                    'state_text' => $inserted_data['state'],
                    'country_id' => (!isset($inserted_data['address'])) ? 20 : 1,
                    'city' => $inserted_data['city'],
                    'zip' => $inserted_data['zipcode'],
                    'phone' => $inserted_data['phone'],
                    'fax' => $inserted_data['fax'],
                ]);

                $meta->user_id = $user->id;
                $meta->save();
            }

        }
        print_r($rowData);
    });
});

Route::get('/{path}','HomeController@index');
Route::get('/{parent}/{category}','HomeController@index');
Route::get('/{parent}/{category}/{third}','HomeController@index');
Route::get('/details/{item}', 'HomeController@itemDetails')->name('item_details_page');
 

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{catchall?}', 'HomeController@index')->where('catchall', '^(?!api).*$')->name('home');
Route::get('/{route?}', 'HomeController@index')->where('route', '([0-9]+(\/){0,1})*');
// Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d-/_.]+)?' );

Route::get('/new-password', 'HomeController@index')->name('new_password_buyer');