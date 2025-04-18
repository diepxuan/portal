<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-12 22:19:25
 */

use Diepxuan\Magento;

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2024-12-12 22:19:01
 */

return [
    'name'      => 'diepxuan/laravel-magento',
    'namespace' => Magento::class,

    /*
    |--------------------------------------------------------------------------
    | Magento Base URL
    |--------------------------------------------------------------------------
    |
    | The Base URL to the Magento 2 store. Must define http protocol
    | and domain TLD. The root path of the store and not the API path.
    | Example: "https://store.com"
    |
    */
    'base_url' => env('MAGENTO_BASE_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    |  Enable debug mode for this package. This will output HTTP request
    |  headers for every request.
    |
    */
    'debug' => env('MAGENTO_DEBUG_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Magento Consumer Key
    |--------------------------------------------------------------------------
    |
    |  The "Consumer Key" defined from the Magento 2 application.
    |  Developers can add the "Consumer Key" in the "Integrations"
    |  section in your Magento 2 administration panel.
    |
    */
    'consumer_key' => env('MAGENTO_CONSUMER_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | Magento Consumer Secret
    |--------------------------------------------------------------------------
    |
    |  The "Consumer Secret" defined from the Magento 2 application.
    |  Developers can add the "Consumer Secret" in the "Integrations"
    |  section in your Magento 2 administration panel.
    |
    */
    'consumer_secret' => env('MAGENTO_CONSUMER_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | Magento Access Token
    |--------------------------------------------------------------------------
    |
    |  The "Access Token" defined from the Magento 2 application.
    |  Developers can add the "Access Token" in the "Integrations"
    |  section in your Magento 2 administration panel.
    |
    */
    'token' => env('MAGENTO_ACCESS_TOKEN', null),

    /*
    |--------------------------------------------------------------------------
    | Magento Access Token Secret
    |--------------------------------------------------------------------------
    |
    |  The "Access Token Secret" defined from the Magento 2 application.
    |  Developers can add the "Access Token Secret" in the "Integrations"
    |  section in your Magento 2 administration panel.
    |
    */
    'token_secret' => env('MAGENTO_ACCESS_TOKEN_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | Magento Base API Path
    |--------------------------------------------------------------------------
    |
    |  The Magento 2 REST API Base Path. By default, this
    |  is assigned as 'rest'. Developers should only
    |  update this setting if the path has changed.
    |
    */
    'base_path' => env('MAGENTO_BASE_PATH', 'rest'),

    /*
    |--------------------------------------------------------------------------
    | Magento Store Code
    |--------------------------------------------------------------------------
    |
    |  The Magento 2 REST API Store Code By default, this
    |  is assigned to 'all' specifying all magento stores
    |  on requests. Developers may update this to specify
    |  the API around a specific store code.
    |
    | "all", "default", "none"
    |
    */
    'store_code' => env('MAGENTO_STORE_CODE', 'all'),

    /*
    |--------------------------------------------------------------------------
    | Magento API Version
    |--------------------------------------------------------------------------
    |
    |  The Magento 2 REST API Version. By default, Magento 2
    |  sets this to 'V1'. Developers should only update this
    |  setting if the version has changed.
    |
    */
    'version' => env('MAGENTO_API_VERSION', 'V1'),

    /*
    |--------------------------------------------------------------------------
    | Magento API Log Failed Requests
    |--------------------------------------------------------------------------
    |
    |  Logs all non-successful Useful for debugging request parameters,
    |  endpoints, or responses from the Magento API. Logs to the
    |  Laravel Log file.
    */
    'log_failed_requests' => env('MAGENTO_API_LOG_FAILED_REQUESTS', false),

    /*
    |--------------------------------------------------------------------------
    | Magento API Website ID
    |--------------------------------------------------------------------------
    |
    |  Default website_id value to use with customer requests, et al.
    |
    */
    'website_id' => env('MAGENTO_API_WEBSITE_ID', 1),
];
