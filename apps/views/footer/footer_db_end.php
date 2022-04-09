<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: footer_db_end.php
 *  Path: application/views/footer/footer_db_end.php
 *  Description: This html file will end the page body and add javascript
 *  files, required model on page in the last of html page.
 * 
 * 
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         17/04/2019              Created

 *
 *  Copyright (c) 2018 - AdGyde Solutions Private Limited
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is, and remains
 *  the property of AdGyde Solutions Private Limited.
 *  The intellectual and technical concepts contained herein
 *  are proprietary to AdGyde Solutions Private Limited and
 *  are considered trade secrets and/or confidential under Law
 *  Dissemination of this information or reproduction of this material,
 *  in whole or in part, is strictly forbidden unless prior written
 *  permission is obtained from AdGyde Solutions Private Limited.
 *
 */
$js = isset($js) ? $js : array();
$popup = isset($popup) ? $popup : array();
?>

<?php
foreach ($js as $jsId => $jsPath) {
    echo "<script id='$jsId' type='text/javascript' src='$jsPath'></script>\n";
}

foreach ($popup as $filePath) {
    include_once($filePath);
}
?>
</body>
</html>