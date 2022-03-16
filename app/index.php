<?php
require_once 'vendor/autoload.php';

use MaxMind\Db\Reader;

$databaseFile = 'GeoLite2-Country.mmdb';

$ipAddress = isset($_SERVER['HTTP_CLIENT_IP'])
    ? $_SERVER['HTTP_CLIENT_IP']
    : (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
        ? $_SERVER['HTTP_X_FORWARDED_FOR']
        : $_SERVER['REMOTE_ADDR']);

try {
    $reader = new Reader($databaseFile);
    $country = $reader->get($ipAddress)['country']['iso_code'];
    $reader->close();

    if ($country == 'VN') {
        $redirect = "ADD REDIRECT URL HERE";
        header("Location: $redirect");
    } else {
        ?>
        <iframe src="ADD IFRAME URL HERE" frameborder="0"
                style="overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0%;left:0px;right:0px;bottom:0px"
                height="100%" width="100%"></iframe>
        <?php
    }
    die();
} catch (Reader\InvalidDatabaseException $e) {

    /**
     * @comment Something went wrong while reading the IP address information from the database
     */
    echo 'Error: Please reach the support team';
} catch (Exception $e) {

    /**
     * @comment something went wrong while closing the connection with the database
     */
    echo 'Error: Please reach the support team';
}

