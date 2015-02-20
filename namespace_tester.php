<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 17.02.2015
 * Time: 11:27
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/RCMLibs/ClassLoader.php';

use RCMLibs\RCMNameTest;

$oNameTester = new RCMNameTest();
$oNameTester->doTest();