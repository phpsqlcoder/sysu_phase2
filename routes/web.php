<?php

Route::get('/customer-sign-up', 'EcommerceControllers\CustomerFrontController@sign_up')->name('customer-front.sign-up');
Route::post('/customer-sign-up', 'EcommerceControllers\CustomerFrontController@customer_sign_up')->name('customer-front.customer-sign-up');
Route::get('/account-logout', 'Auth\LoginController@logout')->name('account.logout');
Route::get('/login', 'EcommerceControllers\CustomerFrontController@login')->name('customer-front.login');
Route::post('/login', 'EcommerceControllers\CustomerFrontController@customer_login')->name('customer-front.customer_login');


Route::get('/home', 'FrontController@home')->name('home');
Route::get('/privacy-policy/', 'FrontController@privacy_policy')->name('privacy-policy');
Route::post('/contact-us', 'FrontController@contact_us')->name('contact-us');

// Custom routes
Route::post('/contact-us-ajax', 'FrontController@contact_us_ajax')->name('contact-us-ajax');
Route::get('/search', 'FrontController@search')->name('search');
// End Custom Routes

//News Frontend
Route::get('/news/', 'Cms4Controllers\ArticleFrontController@news_list')->name('news.front.index');
Route::get('/news/{slug}', 'Cms4Controllers\ArticleFrontController@news_view')->name('news.front.show');
Route::get('/news/{slug}/print', 'Cms4Controllers\ArticleFrontController@news_print')->name('news.front.print');
Route::post('/news/{slug}/share', 'Cms4Controllers\ArticleFrontController@news_share')->name('news.front.share');

Route::get('/albums/preview', 'FrontController@test')->name('albums.preview');


//Product Frontend
Route::any('/', 'Product\Front\ProductFrontController@list')->name('product.front.list');
//Route::post('/shop', 'Product\Front\ProductFrontController@list_search')->name('product.front.list_post');
Route::get('/products/{slug}', 'Product\Front\ProductFrontController@show')->name('product.front.show');

//Cart
Route::post('cart/add-product','EcommerceControllers\CartController@store')->name('cart.add');
Route::post('cart/batch_update','EcommerceControllers\CartController@batch_update')->name('cart.front.batch_update');
Route::post('cart/ajax_update','EcommerceControllers\CartController@ajax_update')->name('cart.ajax_update');
Route::post('cart/remove-product','EcommerceControllers\CartController@remove_product')->name('cart.remove_product');
Route::get('/cart/view', 'EcommerceControllers\CartController@view')->name('cart.front.show');
Route::post('/payment-notification', 'EcommerceControllers\CartController@receive_data_from_payment_gateway')->name('cart.payment-notification');

Route::get('/forgot-password', 'EcommerceControllers\EcommerceFrontController@forgot_password')->name('ecommerce.forgot_password');
Route::post('/forgot-password', 'EcommerceControllers\EcommerceFrontController@sendResetLinkEmail')->name('ecommerce.send_reset_link_email');
Route::get('/reset-password/{token}', 'EcommerceControllers\EcommerceFrontController@showResetForm')->name('ecommerce.reset_password');
Route::post('/reset-password', 'EcommerceControllers\EcommerceFrontController@reset')->name('ecommerce.reset_password_post');

############# Customer ####################
Route::group(['middleware' => ['authenticated']], function () {
    Route::post('product/review/store', 'EcommerceControllers\ProductReviewController@store')->name('product.review.store');
    Route::get('/checkout', 'EcommerceControllers\CheckoutController@checkout')->name('cart.front.checkout');
    Route::post('/temp_save','EcommerceControllers\CartController@save_sales')->name('cart.temp_sales');
    Route::get('/account/sales', 'EcommerceControllers\SalesFrontController@sales_list')->name('profile.sales');
    Route::post('/account/product-reorder','EcommerceControllers\SalesFrontController@reorder')->name('profile.sales-reorder-product');
    Route::post('/account/reorder', 'EcommerceControllers\SalesFrontController@reorder')->name('my-account.reorder');
    Route::post('/account/cancel/order', 'EcommerceControllers\SalesFrontController@cancel_order')->name('my-account.cancel-order');
    Route::get('/account/manage', 'EcommerceControllers\MyAccountController@manage_account')->name('my-account.manage-account');
    Route::post('/account/manage', 'EcommerceControllers\MyAccountController@update_personal_info')->name('my-account.update-personal-info');
    Route::post('/account/manage/update-contact', 'EcommerceControllers\MyAccountController@update_contact_info')->name('my-account.update-contact-info');
    Route::post('/account/manage/update-address', 'EcommerceControllers\MyAccountController@update_address_info')->name('my-account.update-address-info');

    Route::get('/account/change-password', 'EcommerceControllers\MyAccountController@change_password')->name('my-account.change-password');

    Route::post('/account/change-password', 'EcommerceControllers\MyAccountController@update_password')->name('my-account.update-password');

    Route::get('/account/pay/{id}', 'EcommerceControllers\CartController@pay_again')->name('my-account.pay-again');

    // Paynamics Notification

    // Favorites
    Route::get('/account/favorites','EcommerceControllers\FavoriteController@index_front')->name('profile.favorites');
    Route::get('/favorite/product-add-to-cart/{id}','EcommerceControllers\FavoriteController@add_to_cart')->name('favorite.product-add-to-cart');
    Route::post('/favorite/remove-product','EcommerceControllers\FavoriteController@remove_product')->name('favorite.remove-product');
    Route::post('/add-to-favorites','EcommerceControllers\FavoriteController@btn_add_to_favorites')->name('btn-add-to-favorites');
    Route::post('/remove-to-favorites','EcommerceControllers\FavoriteController@btn_remove_to_favorites')->name('btn-remove-to-favorites');

    // Wishlist
    Route::get('/account/wishlist','EcommerceControllers\WishlistController@index_front')->name('profile.wishlist');

    Route::get('/wishlist/add-to-cart/{id}','EcommerceControllers\WishlistController@add_to_cart')->name('wishlist.add-to-cart');
    Route::post('/add-to-wishlist','EcommerceControllers\WishlistController@add_to_wishlist')->name('add-to-wishlist');
    Route::post('/remove-to-wishlist','EcommerceControllers\WishlistController@remove_to_wishlist')->name('remove-to-wishlist');
    Route::post('/wishlist/remove-product','EcommerceControllers\WishlistController@remove_product')->name('wishlist.remove-product');


});
##############################################################
Route::group(['prefix' => env('APP_PANEL', 'cerebro')], function () {

    Route::get('/', 'Auth\LoginController@showLoginForm')->name('panel.login');

    Auth::routes(['verify' => true]);

    Route::group(['middleware' => 'admin'], function () {

        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::resource('/admin/sales-transaction', 'EcommerceControllers\SalesController');
        Route::post('/admin/sales-transaction/change-status', 'EcommerceControllers\SalesController@change_status')->name('sales-transaction.change.status');
        Route::post('/admin/sales-transaction/{sales}', 'EcommerceControllers\SalesController@quick_update')->name('sales-transaction.quick_update');
        Route::get('/admin/sales-transaction/view/{sales}', 'EcommerceControllers\SalesController@show')->name('sales-transaction.view');
        Route::post('/admin/change-delivery-status', 'EcommerceControllers\SalesController@delivery_status')->name('sales-transaction.delivery_status');


        Route::get('/admin/sales-transaction/view-payment/{sales}', 'EcommerceControllers\SalesController@view_payment')->name('sales-transaction.view_payment');
        Route::post('/admin/sales-transaction/cancel-product', 'EcommerceControllers\SalesController@cancel_product')->name('sales-transaction.cancel_product');
        Route::get('/sales-advance-search/', 'EcommerceControllers\SalesController@advance_index')->name('admin.sales.list.advance-search');


        Route::get('/admin/report/sales', 'EcommerceControllers\ReportsController@sales')->name('admin.report.sales');
        Route::get('/admin/report/sales_summary', 'EcommerceControllers\ReportsController@sales_summary')->name('report.sales.summary');
        Route::get('/admin/report/delivery_status', 'EcommerceControllers\ReportsController@delivery_status')->name('admin.report.delivery_status');
        Route::get('/admin/report/delivery_report/{id}', 'EcommerceControllers\ReportsController@delivery_report')->name('admin.report.delivery_report');

        Route::get('/admin/sales-transaction/view-payment/{sales}', 'EcommerceControllers\SalesController@view_payment')->name('sales-transaction.view_payment');
        Route::post('/admin/sales-transaction/cancel-product', 'EcommerceControllers\SalesController@cancel_product')->name('sales-transaction.cancel_product');

        Route::post('/admin/payment-add-store','EcommerceControllers\SalesController@payment_add_store')->name('payment.add.store');
        Route::get('/display-added-payments', 'EcommerceControllers\SalesController@display_payments')->name('display.added-payments');
        Route::get('/display-delivery-history', 'EcommerceControllers\SalesController@display_delivery')->name('display.delivery-history');

         Route::get('/sales/update-payment/{id}','EcommerceControllers\JoborderController@staff_edit_payment')->name('staff-edit-payment');
        Route::post('/sales/update-payment','EcommerceControllers\JoborderController@staff_update_payment')->name('staff-update-payment');

         Route::resource('/admin/customers', 'Settings\CustomerController');
        Route::post('/customer/deactivate', 'Settings\CustomerController@deactivate')->name('customer.deactivate');
        Route::post('/customer/activate', 'Settings\CustomerController@activate')->name('customer.activate');
        Route::get('/admin/customer-search/', 'Settings\CustomerController@search')->name(
            'customer.search');
        Route::get('/admin/customer-profile-log-search/', 'Settings\CustomerController@filter')->name('customer.activity.search');


        Route::resource('/admin/customers', 'Settings\CustomerController');
        Route::resource('/admin/sales-transaction', 'EcommerceControllers\SalesController');
        Route::resource('/admin/deliveryrate', 'EcommerceControllers\DeliveryRateController');

        // Product Favorite
        Route::get('/product-favorites/', 'EcommerceControllers\FavoriteController@index')->name('product-favorite.list');
        // Product Wishlist
        Route::get('/product-wishlist/', 'EcommerceControllers\WishlistController@index')->name('product-wishlist.list');


        //product review
        Route::get('/product-review/', 'EcommerceControllers\ProductReviewController@index')->name('product-review.list');
        Route::get('/product-review-advance-search/', 'EcommerceControllers\ProductReviewController@advance_index')->name('product-review.list.advance-search');
        Route::post('/product-review/quick', 'EcommerceControllers\ProductReviewController@change_status')->name('product-review.change_status');
        Route::post('/product-review/', 'EcommerceControllers\ProductReviewController@quick_update')->name('product-review.quick_update');
        Route::post('/product-review/delete', 'EcommerceControllers\ProductReviewController@delete')->name('product-review.delete');
        Route::get('/product-review/restore/{id}', 'EcommerceControllers\ProductReviewController@restore')->name('product-review.restore');

        // Product Categories
        Route::resource('/admin/product-categories','Product\ProductCategoryController');
        Route::post('/admin/product-category-get-slug', 'Product\ProductCategoryController@get_slug')->name('product.category.get-slug');
        Route::post('/admin/product-categories-single-delete', 'Product\ProductCategoryController@single_delete')->name('product.category.single.delete');
        Route::get('/admin/product-category/search', 'Product\ProductCategoryController@search')->name('product.category.search');
        Route::get('/admin/product-category/restore/{id}', 'Product\ProductCategoryController@restore')->name('product.category.restore');
        Route::get('/admin/product-category/{id}/{status}', 'Product\ProductCategoryController@update_status')->name('product.category.change-status');
        Route::post('/admin/product-categories-multiple-change-status','Product\ProductCategoryController@multiple_change_status')->name('product.category.multiple.change.status');
        Route::post('/admin/product-category-multiple-delete','Product\ProductCategoryController@multiple_delete')->name('product.category.multiple.delete');


        // Products
        Route::resource('/admin/products','Product\ProductController');
        Route::get('/products-advance-search', 'Product\ProductController@advance_index')->name('product.index.advance-search');
        Route::post('/admin/product-get-slug','Product\ProductController@get_slug')->name('product.get-slug');
        Route::post('/admin/products/upload', 'Product\ProductController@upload')->name('products.upload');

        Route::get('/admin/product-change-status/{id}/{status}','Product\ProductController@change_status')->name('product.single-change-status');
        Route::post('/admin/product-single-delete', 'Product\ProductController@single_delete')->name('product.single.delete');
        Route::get('/admin/product/restore/{id}', 'Product\ProductController@restore')->name('product.restore');
        Route::post('/admin/product-multiple-change-status','Product\ProductController@multiple_change_status')->name('product.multiple.change.status');
        Route::post('/admin/product-multiple-delete','Product\ProductController@multiple_delete')->name('products.multiple.delete');

        Route::resource('/locations', 'DeliverablecitiesController');
        Route::get('/admin/location/{id}/{status}', 'DeliverablecitiesController@update_status')->name('location.change-status');
        Route::post('/admin/location-single-delete', 'DeliverablecitiesController@single_delete')->name('location.single.delete');
        Route::post('/admin/location-multiple-change-status','DeliverablecitiesController@multiple_change_status')->name('location.multiple.change.status');
        Route::post('/admin/location-multiple-delete','DeliverablecitiesController@multiple_delete')->name('location.multiple.delete');

        //Inventory
        Route::resource('/inventory','InventoryReceiverHeaderController');
        Route::get('/inventory-download-template','InventoryReceiverHeaderController@download_template')->name('inventory.download.template');
        Route::post('/inventory-upload-template','InventoryReceiverHeaderController@upload_template')->name('inventory.upload.template');
        Route::get('/inventory-post/{id}','InventoryReceiverHeaderController@post')->name('inventory.post');
        Route::get('/inventory-cancel/{id}','InventoryReceiverHeaderController@cancel')->name('inventory.cancel');
        Route::get('/inventory-view/{id}','InventoryReceiverHeaderController@view')->name('inventory.view');
        // Account
        Route::get('/account/edit', 'Settings\AccountController@edit')->name('account.edit');
        Route::put('/account/update', 'Settings\AccountController@update')->name('account.update');
        Route::put('/account/update_email', 'Settings\AccountController@update_email')->name('account.update-email');
        Route::put('/account/update_password', 'Settings\AccountController@update_password')->name('account.update-password');
        // Website
        Route::get('/website-settings/edit', 'Settings\WebController@edit')->name('website-settings.edit');
        Route::put('/website-settings/update', 'Settings\WebController@update')->name('website-settings.update');
        Route::post('/website-settings/update_contacts', 'Settings\WebController@update_contacts')->name('website-settings.update-contacts');
        Route::post('/website-settings/update-ecommerce', 'Settings\WebController@update_ecommerce')->name('website-settings.update-ecommerce');
        Route::post('/website-settings/update-paynamics', 'Settings\WebController@update_paynamics')->name('website-settings.update-paynamics');
        Route::post('/website-settings/update_media_accounts', 'Settings\WebController@update_media_accounts')->name('website-settings.update-media-accounts');
        Route::post('/website-settings/update_data_privacy', 'Settings\WebController@update_data_privacy')->name('website-settings.update-data-privacy');
        Route::post('/website-settings/remove_logo', 'Settings\WebController@remove_logo')->name('website-settings.remove-logo');
        Route::post('/website-settings/remove_icon', 'Settings\WebController@remove_icon')->name('website-settings.remove-icon');
        Route::post('/website-settings/remove_media', 'Settings\WebController@remove_media')->name('website-settings.remove-media');
        // Audit
        Route::get('/audit-logs', 'Settings\LogsController@index')->name('audit-logs.index');
        // CMS
        //Route::view('/settings/cms/index', 'admin.settings.cms.index')->name('settings.cms')->middleware('checkPermission:admin/settings');

        // Promos
        Route::resource('/admin/promos', 'EcommerceControllers\PromoController');
        Route::get('/admin/promo/{id}/{status}', 'EcommerceControllers\PromoController@update_status')->name('promo.change-status');
        Route::post('/admin/promo-single-delete', 'EcommerceControllers\PromoController@single_delete')->name('promo.single.delete');
        Route::post('/admin/promo-multiple-change-status','EcommerceControllers\PromoController@multiple_change_status')->name('promo.multiple.change.status');
        Route::post('/admin/promo-multiple-delete','EcommerceControllers\PromoController@multiple_delete')->name('promo.multiple.delete');
        Route::get('/admin/promo-restore/{id}', 'EcommerceControllers\PromoController@restore')->name('promo.restore');
        //

        // Users
        Route::resource('/users', 'Settings\UserController');
        Route::post('/users/deactivate', 'Settings\UserController@deactivate')->name('users.deactivate');
        Route::post('/users/activate', 'Settings\UserController@activate')->name('users.activate');
        Route::get('/user-search/', 'Settings\UserController@search')->name('user.search');
        Route::get('/profile-log-search/', 'Settings\UserController@filter')->name('user.activity.search');

        // Coupon
        Route::resource('/coupons','EcommerceControllers\CouponController');
        Route::get('/coupon/{id}/{status}', 'EcommerceControllers\CouponController@update_status')->name('coupon.change-status');
        Route::post('/coupon-single-delete', 'EcommerceControllers\CouponController@single_delete')->name('coupon.single.delete');
        Route::get('/coupon-restore/{id}', 'EcommerceControllers\CouponController@restore')->name('coupon.restore');
        Route::post('/coupon-multiple-change-status','EcommerceControllers\CouponController@multiple_change_status')->name('coupon.multiple.change.status');
        Route::post('/coupon-multiple-delete','EcommerceControllers\CouponController@multiple_delete')->name('coupon.multiple.delete');

        //Reports
        Route::get('/report/customer_list', 'EcommerceControllers\ReportsController@customer_list')->name('report.customer.list');
        Route::get('/report/product_list', 'EcommerceControllers\ReportsController@product_list')->name('report.product.list');
        Route::get('/report/sales_list', 'EcommerceControllers\ReportsController@sales_list')->name('report.sales.list');
        Route::get('/report/unpaid_list', 'EcommerceControllers\ReportsController@unpaid_list')->name('report.sales.unpaid');
        Route::get('/report/sales_payments', 'EcommerceControllers\ReportsController@sales_payments')->name('report.sales.payments');
        Route::get('/report/inventory_list', 'EcommerceControllers\ReportsController@inventory_list')->name('report.inventory.list');
        Route::get('/report/inventory_reorder_point', 'EcommerceControllers\ReportsController@inventory_reorder_point')->name('report.inventory.reorder_point');
        Route::get('/report/stock-card/{id}', 'EcommerceControllers\ReportsController@stock_card')->name('report.product.stockcard');

        // Roles
        Route::resource('/role', 'Settings\RoleController');
        Route::post('/role/delete','Settings\RoleController@destroy')->name('role.delete');
        Route::get('/role/restore/{id}','Settings\RoleController@restore')->name('role.restore');
        // Access
        Route::resource('/access', 'Settings\AccessController');
        Route::post('/roles_and_permissions/update', 'Settings\AccessController@update_roles_and_permissions')->name('role-permission.update');

        if (env('APP_DEBUG') == "true") {
            // Permission Routes
            Route::resource('/permission', 'Settings\PermissionController');
            Route::get('/permission-search/', 'Settings\PermissionController@search')->name('permission.search');
            Route::post('/permission/destroy', 'Settings\PermissionController@destroy')->name('permission.destroy');
            Route::get('/permission/restore/{id}', 'Settings\PermissionController@restore')->name('permission.restore');
        }



        ####### CMS Standards #######
        //Pages
            Route::resource('/pages', 'Cms4Controllers\PageController');
            Route::get('/pages-advance-search', 'Cms4Controllers\PageController@advance_index')->name('pages.index.advance-search');
            Route::post('/pages/get-slug', 'Cms4Controllers\PageController@get_slug')->name('pages.get_slug');
            Route::put('/pages/{page}/default', 'Cms4Controllers\PageController@update_default')->name('pages.update-default');
            Route::put('/pages/{page}/customize', 'Cms4Controllers\PageController@update_customize')->name('pages.update-customize');
            Route::put('/pages/{page}/contact-us', 'Cms4Controllers\PageController@update_contact_us')->name('pages.update-contact-us');
            Route::post('/pages-change-status', 'Cms4Controllers\PageController@change_status')->name('pages.change.status');
            Route::post('/pages-delete', 'Cms4Controllers\PageController@delete')->name('pages.delete');
            Route::get('/page-restore/{page}', 'Cms4Controllers\PageController@restore')->name('pages.restore');
        //

        // Albums
            Route::resource('/albums', 'Cms4Controllers\AlbumController');
            Route::post('/albums/upload', 'Cms4Controllers\AlbumController@upload')->name('albums.upload');
            Route::delete('/many/album', 'Cms4Controllers\AlbumController@destroy_many')->name('albums.destroy_many');
            Route::put('/albums/quick/{album}', 'Cms4Controllers\AlbumController@quick_update')->name('albums.quick_update');
            Route::post('/albums/{album}/restore', 'Cms4Controllers\AlbumController@restore')->name('albums.restore');
            Route::post('/albums/banners/{album}', 'Cms4Controllers\AlbumController@get_album_details')->name('albums.banners');
        //

        // News
            Route::resource('/news', 'Cms4Controllers\ArticleController')->except(['show', 'destroy']);
            Route::get('/news-advance-search', 'Cms4Controllers\ArticleController@advance_index')->name('news.index.advance-search');
            Route::post('/news-get-slug', 'Cms4Controllers\ArticleController@get_slug')->name('news.get-slug');
            Route::post('/news-change-status', 'Cms4Controllers\ArticleController@change_status')->name('news.change.status');
            Route::post('/news-delete', 'Cms4Controllers\ArticleController@delete')->name('news.delete');
            Route::get('/news-restore/{news}', 'Cms4Controllers\ArticleController@restore')->name('news.restore');
            // News Category
            Route::resource('/news-categories', 'Cms4Controllers\ArticleCategoryController')->except(['show']);;
            Route::post('/news-categories/get-slug', 'Cms4Controllers\ArticleCategoryController@get_slug')->name('news-categories.get-slug');
            Route::post('/news-categories/delete', 'Cms4Controllers\ArticleCategoryController@delete')->name('news-categories.delete');
            Route::get('/news-categories/restore/{id}', 'Cms4Controllers\ArticleCategoryController@restore')->name('news-categories.restore');
        //

        // Files
            Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show')->name('file-manager.show');
            Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload')->name('file-manager.upload');
            Route::get('/file-manager', 'Cms4Controllers\FileManagerController@index')->name('file-manager.index');
        //

        // Menu
            Route::resource('/menus', 'Cms4Controllers\MenuController');
            Route::delete('/many/menu', 'Cms4Controllers\MenuController@destroy_many')->name('menus.destroy_many');
            Route::put('/menus/quick1/{menu}', 'Cms4Controllers\MenuController@quick_update')->name('menus.quick_update');
            Route::get('/menu-restore/{menu}', 'Cms4Controllers\MenuController@restore')->name('menus.restore');
        //
    });
});

// Pages Frontend
Route::get('/{any}', 'FrontController@page')->where('any', '.*');
