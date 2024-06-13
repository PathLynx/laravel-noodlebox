<?php/*|--------------------------------------------------------------------------| API Routes|--------------------------------------------------------------------------|| Here is where you can register API routes for your application. These| routes are loaded by the RouteServiceProvider within a group which| is assigned the "api" middleware group. Enjoy building your API!|*///use Illuminate\Support\Facades\Route;Route::namespace('Api')->group(function () {    //语言包    Route::namespace('Lang')->prefix('langs')->group(function () {        Route::get('locale', 'LangController@locale');        Route::get('messages/{locale?}', 'LangController@messages');    });    //认证    Route::namespace('Auth')->prefix('auth')->group(function () {        Route::post('register', 'RegisterController@register');        Route::post('numberauth', 'NumberController@index');        Route::post('login-with-apple', 'AppleController@index');        Route::post('adminlogin', 'AdminLoginController@login');    });    //用户管理    Route::namespace('User')->middleware('auth:api')->group(function () {        Route::get('users', 'UserController@index');        Route::get('users/{id}', 'UserController@show');        Route::post('users', 'UserController@store');        Route::put('users/{uid}', 'UserController@store');        Route::delete('users/batch', 'UserController@batchDelete');        Route::get('user/info', 'UserController@info');        Route::get('users/groups', 'GroupController@index');        Route::post('users/groups', 'GroupController@store');        Route::put('users/groups/{gid}', 'GroupController@store');        Route::delete('users/groups/batch', 'GroupController@batchDestroy');        Route::get('users/addresses', 'AddressController@myaddress');        Route::get('users/addresses/{id}', 'AddressController@show');        Route::post('users/addresses', 'AddressController@store');        Route::put('users/addresses/{id}', 'AddressController@store');        Route::delete('users/addresses/{id}', 'AddressController@destroy');    });    //通用部分    Route::namespace('Basic')->group(function () {        //素材管理        Route::get('materials', 'MaterialController@index');        Route::get('materials/types', 'MaterialController@types');        Route::get('materials/{id}', 'MaterialController@show');        Route::put('materials/{id}', 'MaterialController@update');        Route::post('materials/upload', 'MaterialController@upload');        Route::delete('materials/batch', 'MaterialController@batchDestroy');        //链接管理        Route::get('links', 'LinkController@index');        Route::post('links', 'LinkController@store');        Route::put('links/{id}', 'LinkController@store');        Route::delete('links/batch', 'LinkController@batchDestroy');        //区域管理        Route::get('districts', 'DistrcitController@index');        Route::get('districts/{id}', 'DistrcitController@show');        Route::post('districts', 'DistrcitController@store');        Route::put('districts/{id}', 'DistrcitController@store');        Route::delete('districts/batch', 'DistrcitController@batchDestroy');        //内容片段        Route::get('snippets', 'SnippetController@index');        Route::get('snippets/{id}', 'SnippetController@show');        Route::post('snippets', 'SnippetController@store');        Route::put('snippets/{id}', 'SnippetController@store');        Route::delete('snippets/batch', 'SnippetController@batchDestroy');        //快捷方式        Route::get('shortcuts', 'ShortcutController@index');        Route::get('shortcuts/{id}', 'ShortcutController@show');        Route::post('shortcuts', 'ShortcutController@store');        Route::put('shortcuts/{id}', 'ShortcutController@store');        Route::delete('shortcuts/{id}', 'ShortcutController@destroy');        Route::delete('shortcuts/batch', 'ShortcutController@batchDestroy');        //快递管理        Route::get('expresses', 'ExpressController@index');        Route::post('expresses', 'ExpressController@store');        Route::put('expresses/{id}', 'ExpressController@store');        Route::delete('expresses/batch', 'ExpressController@batchDestroy');        //客服        Route::get('kefus', 'KefuController@index');        Route::post('kefus', 'KefuController@store');        Route::put('kefus/{id}', 'KefuController@store');        Route::delete('kefus/batch', 'KefuController@batchDestroy');        //广告管理        Route::get('ads', 'AdController@index');        Route::post('ads', 'AdController@store');        Route::put('ads/batch', 'AdController@batchUpdate');        Route::put('ads/{id}', 'AdController@store');        Route::delete('ads/batch', 'AdController@batchDestroy');        //模块管理        Route::get('blocks', 'BlockController@index');        Route::get('blocks/{id}', 'BlockController@show');        //菜单管理        Route::get('menus', 'MenuController@index');        Route::get('menus/{id}', 'MenuController@show');        //菜单项管理        Route::post('menu-items', 'MenuItemController@store');        Route::post('menu-items/toggle', 'MenuItemController@toggle');        //优惠券        Route::get('coupons', 'CouponController@index');        Route::post('coupons', 'CouponController@store');        Route::put('coupons/batch', 'CouponController@batchUpdate');        Route::put('coupons/{id}', 'CouponController@store');        Route::delete('coupons/batch', 'CouponController@batchDestroy');        Route::get('regions', 'RegionController@index');        Route::get('regions/{id}', 'RegionController@show');        Route::post('regions', 'RegionController@store');        Route::put('regions/{id}', 'RegionController@store');        Route::delete('regions/batch', 'RegionController@batchDestroy');        Route::post('phones/check', 'PhoneController@check');        Route::post('phones/verify', 'PhoneController@verify');        Route::post('captcha/sms', 'CaptchaController@sendSms');        Route::post('captcha/email', 'CaptchaController@email');    });    //页面    Route::namespace('Page')->group(function () {        Route::get('pages', 'PageController@index');        Route::get('pages/{id}', 'PageController@show');        Route::post('pages', 'PageController@store')->middleware('auth:api');        Route::put('pages/{id}', 'PageController@store')->middleware('auth:api');        Route::delete('pages/batch', 'PageController@batchDestroy')->middleware('auth:api');    });    //分类    Route::namespace('Category')->group(function () {        Route::get('categories', 'CategoryController@index');        Route::get('categories/{id}', 'CategoryController@show');        Route::post('categories', 'CategoryController@store')->middleware('auth:api');        Route::put('categories/{id}', 'CategoryController@store')->middleware('auth:api');        Route::delete('categories/batch', 'CategoryController@batchDestroy')->middleware('auth:api');        Route::post('categories/{id}/increase', 'CategoryController@increase')->middleware('auth:api');        Route::post('categories/{id}/decrease', 'CategoryController@decrease')->middleware('auth:api');    });    //文章管理    Route::namespace('Post')->group(function () {        Route::get('posts', 'PostController@index')->middleware('client');        Route::get('posts/{id}', 'PostController@show');        Route::get('posts/formats', 'PostController@formats');        Route::post('posts', 'PostController@store')->middleware('auth:api');        Route::put('posts/{id}', 'PostController@store')->middleware('auth:api');        Route::put('posts/batch', 'PostController@batchUpdate')->middleware('auth:api');        Route::delete('posts/batch', 'PostController@batchDelete')->middleware('auth:api');    });    //微信管理    Route::namespace('Wechat')->middleware('auth:api')->prefix('wechat')->group(function () {        Route::get('menus', 'MenuController@menus');        Route::get('menu/types', 'MenuController@types');        Route::post('menu', 'MenuController@save');        Route::post('menu/delete', 'MenuController@delete');        Route::post('menu/apply', 'MenuController@apply');        Route::get('material', 'MaterialController@material');        Route::get('materials', 'MaterialController@materials');        Route::get('material/image', 'MaterialController@image');        Route::post('material/delete', 'MaterialController@delete');    });    //电子商务    Route::namespace('Ecommerce')->group(function () {        //商品管理        Route::get('products', 'ProductController@index');        Route::get('products/{id}', 'ProductController@show');        Route::post('products', 'ProductController@store');        Route::post('products/{id}/color', 'ProductController@updateColor')->middleware('auth:api');        //店铺管理        Route::get('shops', 'ShopController@index');        Route::get('shops/{id}', 'ShopController@show');        Route::post('shops', 'ShopController@store')->middleware('auth:api');        Route::put('shops/{id}', 'ShopController@store')->middleware('auth:api');        Route::delete('shops/{id}', 'ShopController@destroy')->middleware('auth:api');        Route::get('freight-templates', 'FreightTemplateController@index');        Route::get('freight-templates/{id}', 'FreightTemplateController@show');        Route::post('freight-templates', 'FreightTemplateController@store')->middleware('auth:api');        Route::put('freight-templates/{id}', 'FreightTemplateController@store')->middleware('auth:api');        Route::delete('freight-templates/{id}', 'FreightTemplateController@destroy')->middleware('auth:api');        Route::get('shipping-zones', 'ShippingZoneController@index');        Route::get('shipping-zones/{id}', 'ShippingZoneController@show');        //购物车        Route::get('carts', 'CartController@index')->name('carts.index')->middleware('auth:api');        Route::get('carts/{id}', 'CartController@show')->name('carts.show')->middleware('auth:api');        Route::post('carts', 'CartController@store')->name('carts.store')->middleware('auth:api');        Route::put('carts/{id}', 'CartController@update')->name('carts.update')->middleware('auth:api');        Route::delete('carts/{id}', 'CartController@destroy')->name('carts.destroy')->middleware('auth:api');        //订单管理        Route::get('orders', 'OrderController@index')->middleware('auth:api');        Route::get('orders/{id}', 'OrderController@show')->middleware('auth:api');        Route::post('orders', 'OrderController@store')->middleware('auth:api');        Route::post('orders/{orderId}/capture', 'OrderController@capture');        Route::post('orders/{orderId}/purchase', 'OrderController@purchase')->middleware('auth:api');        Route::post('points/purchase', 'PointController@purchase')->middleware('auth:api');        Route::get('checkout/settings', 'CheckoutController@settings')->middleware('auth:api');    });    Route::namespace('Payment')->prefix('payment')->group(function () {        Route::post('paypal/create-order', 'PaypalController@createOrder');    });    Route::namespace('My')->prefix('my')->middleware('auth:api')->group(function () {        Route::get('/points', 'PointController@index');    });    Route::namespace('Lottery')->prefix('lottery')->group(function () {        Route::get('prizes', 'PrizeController@index');        Route::get('settings', 'LotteryController@settings');        Route::get('draw', 'LotteryController@draw')->middleware('auth:api');    });});