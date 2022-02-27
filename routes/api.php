<?php

use Illuminate\Http\Request;

Route::prefix('v1')->group(function () {
    Route::group(['namespace' => 'Api\Buyer', 'prefix' => 'buyer'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');

        Route::post('profile-update', 'BuyerController@profileUpdate');
        Route::post('change-password', 'BuyerController@changePassword');
        Route::post('checkout', 'BuyerController@checkout');
        Route::post('sendOrderEmail', 'BuyerController@sendOrderEmail');
        Route::post('checkOrder', 'BuyerController@checkOrder');
        Route::post('apply-coupon', 'BuyerController@applyCoupon')->middleware('auth:api');
        Route::post('remove-coupon', 'BuyerController@removeCoupon')->middleware('auth:api');
        Route::get('singleOrder', 'BuyerController@singleOrder');
        
        // Send reset password mail
        Route::post('reset-password', 'PassworResetController@sendPasswordResetLink');
        // handle reset password form process
        Route::post('new-password', 'NewPasswordController@callResetPassword');
    });

    // User Auth
    Route::post('register', 'Api\UserController@register');
    Route::post('login', 'Api\UserController@login'); 

    // Product Related Data
    Route::get('categories', 'Api\CategoryController@index');

    // Products
    Route::get('/single-product/{slug}', 'Api\HomeController@ProductSingleInfo'); 
    Route::get('/product-view/{slug}', 'Api\HomeController@productView'); 
    Route::get('/recently-viewed', 'Api\HomeController@recentlyViewed'); 
    Route::get('items', 'Api\ItemController@index');
    Route::post('/search_items', 'Api\ItemController@searchItems'); 
    Route::post('/search_in_site', 'Api\ItemController@searchInSite'); 

    // sections
    Route::get('/product-values', 'Api\HomeController@productValues'); 
    Route::get('/product-brands', 'Api\HomeController@productBrands'); 
    
/* -------------------------- Header Default Route -------------------------- */ 
    Route::get('/homepage-content', 'Api\HomeController@HomePageDefaultContent'); 
    Route::get('/headerdefaultcontent', 'Api\HomeController@HeaderDefaultContent'); 
    Route::get('/default-footer', 'Api\HomeController@FooterDefaultContent'); 
    Route::get('static-page/{id}', 'Api\HomeController@StaticPage'); 
    Route::get('home-page', 'Api\HomeController@HomePage'); 
    Route::get('/new-in', 'Api\HomeController@homenewin'); 
    Route::post('/add-newsletter', 'Api\NewsletterController@addNewsletter'); 
    Route::post('/newsletter-update','Api\NewsletterController@newsletterUpdate')->middleware('auth:api');
    // Route::get('/category/{category}', 'Api\HomeController@CategoryPage'); 
    
    Route::post('/add-to-cart', 'Api\CartController@addToCart'); 
    Route::post('/product_image', 'Api\ItemController@getimages'); 
    
    // Route::post('/login', 'Buyer\AuthController@loginPost'); 
    Route::get('/product','Api\HomeController@ProductPage');
    Route::post('/update-cart-item','Api\CartController@updateCartItem');
    Route::post('/update-cart','Api\CartController@updateCart');
    Route::post('/delete-cart','Api\CartController@deleteCart');
    Route::get('/all-sizes','Api\ItemController@GetAllSizes');
    Route::get('/all-colors','Api\ItemController@GetAllColors');
    Route::get('/country','Api\ItemController@getAllCountry');
    Route::get('/state','Api\ItemController@getAllStates');
    Route::get('/shipping-methods','Api\ItemController@getAllShippingMethods');
    Route::get('/checkout', 'Api\Buyer\CheckoutController@singlePageCheckout')->middleware('auth:api');
    Route::post('/checkoutpost', 'Api\Buyer\CheckoutController@singlePageCheckoutPost')->middleware('auth:api');
    Route::post('/ApplyCoupon', 'Api\Buyer\CheckoutController@ApplyCoupon')->middleware('auth:api');


/* --------------------------- Buyer Profile Route -------------------------- */

    Route::post('/wishlist','Api\Buyer\WishListController@index');
    Route::post('/remove_wishlist','Api\Buyer\WishListController@remove_wishlist');
    Route::post('/add-to-wishlist','Api\Buyer\WishListController@AddToWishlist');
    Route::post('/resetpassword','Api\UserController@resetpassword');
    Route::post('/newpassword','Api\UserController@newpassword');
    Route::post('/change-password','Api\UserController@ChangePassword')->middleware('auth:api');
    Route::post('/profile-update','Api\UserController@ProfileUpdate')->middleware('auth:api');
    Route::post('/registration/post','Api\UserController@register');
    Route::post('buyer/logout','Api\UserController@logout'); 
    Route::post('/cart-items','Api\CartController@showCart'); 
    Route::post('/default-address','Api\Buyer\ProfileController@DefaultAddress')->middleware('auth:api');
    Route::post('/update-address','Api\Buyer\ProfileController@updateAddress')->middleware('auth:api');
    Route::post('/new-address','Api\Buyer\ProfileController@addAddress')->middleware('auth:api');
    Route::post('/buyer/UpdateBillingAddress','Api\Buyer\ProfileController@billingaddresspost')->middleware('auth:api');
    Route::post('/buyer/shippingAddressDelete','Api\Buyer\ProfileController@deleteShippingAddress')->middleware('auth:api');
    
    
    // Authenticated Data
    Route::group(['middleware' => 'auth:api'], function(){ 
        // Users Data
        Route::get('/user','Api\UserController@index');
        Route::get('/users','Api\UserController@users');
        Route::get('/profile','Api\Buyer\ProfileController@index');
        Route::post('/address','Api\Buyer\ProfileController@address');
        Route::post('/remove-address','Api\Buyer\ProfileController@removeAddress');
        Route::post('/default-address','Api\Buyer\ProfileController@defaultAddress');
        Route::get('/buyer/orders','Api\Buyer\ProfileController@orders');
        Route::get('/single/order/{id}','Api\Buyer\ProfileController@OrderDetails')->middleware('auth:api');
        // Cart Data 
        
        
        Route::post('/makeReview', 'Api\ReviewController@makeReview');
        Route::match(['post'], '/temporaryImageUpload', 'Api\ImageController@temporaryImageUpload');
        Route::match(['post'], '/removeTemporaryImage', 'Api\ImageController@removeTemporaryImage');
        
        Route::get('/cart','Api\CartController@index');
        Route::get('/cratecheckout','Api\Buyer\CheckoutController@create');
        // Route::get('logout', 'Api\UserController@buyerlogout'); 
        Route::post('logout', 'Buyer\AuthController@logout')->name('logout_buyer');
    });
    Route::post('/getReviews', 'Api\ReviewController@getReviews');
    
});


//Admin Routes
Route::prefix('admin')->group(function () {

    //Auth
    Route::get('login', 'Api\Admin\AuthController@adminLogin')->name('login_admin');
    Route::post('login-post', 'Api\Admin\AuthController@loginPost')->name('login_admin_post');
    Route::post('logout', 'Api\Admin\AuthController@AdminLogout')->name('logout_admin');

    //Dashboard
    Route::get('dashboard', 'Api\Admin\DashboardController@index')->name('admin_dashboard');

    //Category
    Route::get('category', 'Api\Admin\CategoryController@index')->name('admin_category');
    Route::post('category/search', 'Api\Admin\CategoryController@search')->name('admin_category');
    Route::post('category/add', 'Api\Admin\CategoryController@addCategory')->name('admin_category_add');
    Route::post('category/update', 'Api\Admin\CategoryController@updateCategory')->name('admin_category_update');
    Route::post('category/delete', 'Api\Admin\CategoryController@deleteCategory')->name('admin_category_delete');
    Route::post('category/update/parent', 'Api\Admin\CategoryController@updateCategoryParent')->name('admin_category_parent_update');
    Route::post('category/update/sort', 'Api\Admin\CategoryController@sortCategory')->name('admin_sort_category');
    Route::post('category/image/delete', 'Api\Admin\CategoryController@Category_Image_delete')->name('Category_Image_delete');

    //Master Color
    Route::get('master-color', 'Api\Admin\MasterColorController@index')->name('admin_master_color');
    Route::post('master-color/search', 'Api\Admin\MasterColorController@search')->name('admin_master_color');
    Route::post('master-color/add', 'Api\Admin\MasterColorController@addPost')->name('admin_master_color_add');
    Route::post('master-color/update', 'Api\Admin\MasterColorController@update')->name('admin_master_color_update');
    Route::post('master-color/delete', 'Api\Admin\MasterColorController@delete')->name('admin_master_color_delete');

    //Color
    Route::get('color', 'Api\Admin\ColorController@index')->name('admin_color');
    Route::post('color/search', 'Api\Admin\ColorController@search')->name('admin_color_search');
    Route::post('color/add', 'Api\Admin\ColorController@addPost')->name('admin_color_add_post');
    Route::post('color/update', 'Api\Admin\ColorController@editPost')->name('admin_color_update_post');
    Route::post('color/delete', 'Api\Admin\ColorController@delete')->name('admin_color_delete');

    //Size
    Route::get('size', 'Api\Admin\SizeController@index')->name('admin_size');
    Route::post('size/search', 'Api\Admin\SizeController@search')->name('admin_size_search');
    Route::post('size/add', 'Api\Admin\SizeController@addPost')->name('admin_size_add_post');
    Route::post('size/update', 'Api\Admin\SizeController@editPost')->name('admin_size_update_post'); 
    Route::post('size/delete', 'Api\Admin\SizeController@delete')->name('admin_pack_delete');

    //Others
    Route::get('product-settings/others', 'Api\Admin\ItemSettingsOthersController@index')->name('admin_item_settings_others');

    //Made In Country
    Route::post('made-in-country/search', 'Api\Admin\ItemSettingsOthersController@madeInCountrySearch')->name('admin_made_in_country_search');
    Route::post('made-in-country/add', 'Api\Admin\ItemSettingsOthersController@madeInCountryAdd')->name('admin_made_in_country_add');
    Route::post('made-in-country/update', 'Api\Admin\ItemSettingsOthersController@madeInCountryUpdate')->name('admin_made_in_country_update');
    Route::post('made-in-country/delete', 'Api\Admin\ItemSettingsOthersController@madeInCountryDelete')->name('admin_made_in_country_delete');
    Route::post('made-in-country/change_status', 'Api\Admin\ItemSettingsOthersController@madeInCountryChangeStatus')->name('admin_made_in_country_change_status');
    Route::post('made-in-country/change_default', 'Api\Admin\ItemSettingsOthersController@madeInCountryChangeDefault')->name('admin_made_in_country_change_default');

    //Brand
    Route::post('brand/search', 'Api\Admin\ItemSettingsOthersController@brandSearch')->name('admin_brand_search');
    Route::post('brand/add', 'Api\Admin\ItemSettingsOthersController@brandAdd')->name('admin_brand_add');
    Route::post('brand/update', 'Api\Admin\ItemSettingsOthersController@brandUpdate')->name('admin_brand_update');
    Route::post('brand/delete', 'Api\Admin\ItemSettingsOthersController@brandDelete')->name('admin_brand_delete');
    Route::post('brand/change_status', 'Api\Admin\ItemSettingsOthersController@brandChangeStatus')->name('admin_brand_change_status');
    Route::post('brand/change_default', 'Api\Admin\ItemSettingsOthersController@brandChangeDefault')->name('admin_brand_change_default');

    // Point system
    Route::get('point-system', 'Api\Admin\PointSystemController@index')->name('admin_point_system');
    Route::post('point-settings/post', 'Api\Admin\PointSystemController@saveSetting')->name('admin_point_system_setting_post');
    Route::post('points/add/post', 'Api\Admin\PointSystemController@addPoint')->name('admin_points_add_post');
    Route::post('points/edit/post', 'Api\Admin\PointSystemController@editPoint')->name('admin_points_edit_post');
    Route::post('points/delete', 'Api\Admin\PointSystemController@delete')->name('admin_points_delete');
});







