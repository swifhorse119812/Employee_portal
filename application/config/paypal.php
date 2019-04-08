<?php
/** set your paypal credential **/

$config['client_id'] = 'AR3hevDBki9Wr-U723P7AOuEbZA0tkGSWUoURCivM1L1phl_0S_TKWpZSmoZOIp-C11STZ84rzfzbOwh';
$config['secret'] = 'EASq2kF0oVgrpOX-EYZo2sP6dr8zJC40Km5Hyc4Xn8L9EuAhGXeZSZLWRrjT3Yftc3BDDzIMmVcqJM_t';

/**
 * SDK configuration
 */
/**
 * Available option 'sandbox' or 'live'
 */
$config['settings'] = array(

    'mode' => 'sandbox',
    /**
     * Specify the max request time in seconds
     */
    'http.ConnectionTimeOut' => 1000,
    /**
     * Whether want to log to a file
     */
    'log.LogEnabled' => true,
    /**
     * Specify the file that want to write on
     */
    'log.FileName' => 'application/logs/paypal.log',
    /**
     * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
     *
     * Logging is most verbose in the 'FINE' level and decreases as you
     * proceed towards ERROR
     */
    'log.LogLevel' => 'FINE'
);
 