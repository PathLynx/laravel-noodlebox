<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2020 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: https://www.gzdsx.cn
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2020/03/29
 * Time: 下午3:16
 */

Route::group(['namespace' => 'Notify'], function () {
    Route::any('paypal/webhooks', 'PaypalController@webhooks');
});
