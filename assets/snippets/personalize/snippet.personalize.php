<?php
/**
 * Personalize
 *
 * Checks to see if web- / mgr-users are logged in or not, to display accordingly yesChunk/noChunk
 *
 * @category    snippet
 * @version     2.1
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @properties
 * @internal    @modx_category Login
 * @internal    @installset base
 * @documentation [+site_url+]assets/snippets/personalize/readme.html
 * @reportissues https://github.com/modxcms/evolution
 * @author      Created By Ryan Thrash (modx@vertexworks.com)
 * @author      powered up by kudo (kudo@kudolink.com)
 * @author      powered up by yama(yamamoto@kyms.ne.jp)
 * @author      Refactored 2013 by Dmi3yy
 * @lastupdate  11/08/2013
 */

if(!defined('MODX_BASE_PATH')) die('What are you doing? Get out of here!');

# prepare params and variables

if     ($this->isFrontend() && isset ($_SESSION['webValidated'])) $detected_context = 'web';
elseif ($this->isBackend()  && isset ($_SESSION['mgrValidated'])) $detected_context = 'mgr';
else                                                              $detected_context = '';

$yesChunk = (isset($yesChunk)) ? $yesChunk : '';
$noChunk  = (isset($noChunk))  ? $noChunk  : '';
$ph       = (isset($ph))       ? $ph       : 'username';
$context  = (isset($context))  ? $context  : $detected_context;
$yesTV    = (isset($yesTV))    ? $yesTV    : '';
$noTV     = (isset($noTV))     ? $noTV     : '';

$output = '';
switch($context) {
    case 'web':
        $short_name = $_SESSION['webShortname'];
        $full_name  = $_SESSION['webFullname'];
        $email      = $_SESSION['webEmail'];
        $last_login = $_SESSION['webLastlogin'];
        break;
    case 'mgr':
    case 'manager':
        $short_name = $_SESSION['mgrShortname'];
        $full_name  = $_SESSION['mgrFullname'];
        $email      = $_SESSION['mgrEmail'];
        $last_login = $_SESSION['mgrLastlogin'];
        break;
    default:
        $short_name = '';
}
if (!empty($context)) {
    if($yesTV !== '') {
        $pre_output = $modx->documentObject[$yesTV];
        if(is_array($pre_output)) $output = $pre_output[1];
        else                      $output = $pre_output;
    }
    elseif($yesChunk !== '')      $output = $modx->getChunk($yesChunk);
    else                          $output = "username : {$short_name}";

    if(empty($last_login)) $last_login_text = 'first login';
    else                   $last_login_text = $modx->toDateFormat($last_login);

    $modx->setPlaceholder($ph,          $short_name);
    $modx->setPlaceholder('short_name', $short_name);
    $modx->setPlaceholder('full_name',  $full_name);
    $modx->setPlaceholder('email',      $email);
    $modx->setPlaceholder('last_login', $last_login_text);
} else {
    if($noTV !== '') {
        $pre_output = $modx->documentObject[$noTV];
        if(is_array($pre_output)) $output = $pre_output[1];
        else                      $output = $pre_output;
    }
    elseif($noChunk!=='')         $output = $modx->getChunk($noChunk);
    else                          $output = 'guest';
}
return $output;
