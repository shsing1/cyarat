<?php

/**
 * CHH 時間函數
 * ============================================================================
 * 
 * ============================================================================
 * Author: shsing1
 * Id: lib_time.php 2009-10-24 11:00:00
*/

if (!defined('IN_CHH'))
{
    die('Hacking attempt');
}

/**
 * 獲得當前格林威治時間的時間戳
 *
 * @return  integer
 */
function gmtime()
{
    return (time() - date('Z'));
}

/**
 * 獲得服務器的時區
 *
 * @return  integer
 */
function server_timezone()
{
    if (function_exists('date_default_timezone_get'))
    {
        return date_default_timezone_get();
    }
    else
    {
        return date('Z') / 3600;
    }
}


/**
 *  生成一個用戶自定義時區日期的GMT時間戳
 *
 * @access  public
 * @param   int     $hour
 * @param   int     $minute
 * @param   int     $second
 * @param   int     $month
 * @param   int     $day
 * @param   int     $year
 *
 * @return void
 */
function local_mktime($hour = NULL , $minute= NULL, $second = NULL,  $month = NULL,  $day = NULL,  $year = NULL)
{
    $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

    /**
    * $time = mktime($hour, $minute, $second, $month, $day, $year) - date('Z') + (date('Z') - $timezone * 3600)
    * 先用mktime生成時間戳，再減去date('Z')轉換為GMT時間，然後修正為用戶自定義時間。以下是化簡後結果
    **/
    $time = mktime($hour, $minute, $second, $month, $day, $year) - $timezone * 3600;

    return $time;
}


/**
 * 將GMT時間戳格式化為用戶自定義時區日期
 *
 * @param  string       $format
 * @param  integer      $time       該參數必須是一個GMT的時間戳
 *
 * @return  string
 */

function local_date($format, $time = NULL)
{
    $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

    if ($time === NULL)
    {
        $time = gmtime();
    }
    elseif ($time <= 0)
    {
        return '';
    }

    $time += ($timezone * 3600);

    return date($format, $time);
}


/**
 * 轉換字符串形式的時間表達式為GMT時間戳
 *
 * @param   string  $str
 *
 * @return  integer
 */
function gmstr2time($str)
{
    $time = strtotime($str);

    if ($time > 0)
    {
        $time -= date('Z');
    }

    return $time;
}

/**
 *  將一個用戶自定義時區的日期轉為GMT時間戳
 *
 * @access  public
 * @param   string      $str
 *
 * @return  integer
 */
function local_strtotime($str)
{
    $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

    /**
    * $time = mktime($hour, $minute, $second, $month, $day, $year) - date('Z') + (date('Z') - $timezone * 3600)
    * 先用mktime生成時間戳，再減去date('Z')轉換為GMT時間，然後修正為用戶自定義時間。以下是化簡後結果
    **/
    $time = strtotime($str) - $timezone * 3600;

    return $time;

}

/**
 * 獲得用戶所在時區指定的時間戳
 *
 * @param   $timestamp  integer     該時間戳必須是一個服務器本地的時間戳
 *
 * @return  array
 */
function local_gettime($timestamp = NULL)
{
    $tmp = local_getdate($timestamp);
    return $tmp[0];
}

/**
 * 獲得用戶所在時區指定的日期和時間信息
 *
 * @param   $timestamp  integer     該時間戳必須是一個服務器本地的時間戳
 *
 * @return  array
 */
function local_getdate($timestamp = NULL)
{
    $timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];

    /* 如果時間戳為空，則獲得服務器的當前時間 */
    if ($timestamp === NULL)
    {
        $timestamp = time();
    }

    $gmt        = $timestamp - date('Z');       // 得到該時間的格林威治時間
    $local_time = $gmt + ($timezone * 3600);    // 轉換為用戶所在時區的時間戳

    return getdate($local_time);
}

?>