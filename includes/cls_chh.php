<?php
/**
 * CHH 基礎類
 * ============================================================================
 * ============================================================================
 * Author: shsing1
 * Id: cls_chh.php 2009-10-24 11:00:00
*/

if (!defined('IN_CHH'))
{
    die('Hacking attempt');
}

define('APPNAME', 'CHH');
define('VERSION', 'v1.0.0');
define('RELEASE', '20091024');

class CHH
{
    var $db_name = '';
    var $prefix  = 'chh_';

    /**
     * 構造函數
     *
     * @access  public
     * @param   string      $ver        版本號
     *
     * @return  void
     */
    function CHH($db_name, $prefix)
    {
        $this->db_name = $db_name;
        $this->prefix  = $prefix;
    }

    /**
     * 將指定的表名加上前綴後返回
     *
     * @access  public
     * @param   string      $str        表名
     *
     * @return  string
     */
    function table($str)
    {
        return '`' . $this->db_name . '`.`' . $this->prefix . $str . '`';
    }

    /**
     * CHH 密碼編譯方法;
     *
     * @access  public
     * @param   string      $pass       需要編譯的原始密碼
     *
     * @return  string
     */
    function compile_password($pass)
    {
        return md5($pass);
    }

    /**
     * 取得當前的域名
     *
     * @access  public
     *
     * @return  string      當前的域名
     */
    function get_domain()
    {
        /* 協議 */
        $protocol = $this->http();

        /* 域名或IP地址 */
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
        {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }
        elseif (isset($_SERVER['HTTP_HOST']))
        {
            $host = $_SERVER['HTTP_HOST'];
        }
        else
        {
            /* 端口 */
            if (isset($_SERVER['SERVER_PORT']))
            {
                $port = ':' . $_SERVER['SERVER_PORT'];

                if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
                {
                    $port = '';
                }
            }
            else
            {
                $port = '';
            }

            if (isset($_SERVER['SERVER_NAME']))
            {
                $host = $_SERVER['SERVER_NAME'] . $port;
            }
            elseif (isset($_SERVER['SERVER_ADDR']))
            {
                $host = $_SERVER['SERVER_ADDR'] . $port;
            }
        }

        return $protocol . $host;
    }

    /**
     * 獲得 CHH 當前環境的 URL 地址
     *
     * @access  public
     *
     * @return  void
     */
    function url()
    {
        $curr = strpos(PHP_SELF, 'admin/') !== false ?
                preg_replace('/(.*)(admin)(\/?)(.)*/i', '\1', dirname(PHP_SELF)) :
                dirname(PHP_SELF);

        $root = str_replace('\\', '/', $curr);

        if (substr($root, -1) != '/')
        {
            $root .= '/';
        }

        return $this->get_domain() . $root;
    }

    /**
     * 獲得 CHH 當前環境的 HTTP 協議方式
     *
     * @access  public
     *
     * @return  void
     */
    function http()
    {
        return (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
    }

    /**
     * 獲得數據目錄的路徑
     *
     * @param int $sid
     *
     * @return string 路徑
     */
    function data_dir($sid = 0)
    {
        if (empty($sid))
        {
            $s = 'data';
        }
        else
        {
            $s = 'user_files/';
            $s .= ceil($sid / 3000) . '/';
            $s .= $sid % 3000;
        }
        return $s;
    }

    /**
     * 獲得圖片的目錄路徑
     *
     * @param int $sid
     *
     * @return string 路徑
     */
    function image_dir($sid = 0)
    {
        if (empty($sid))
        {
            $s = 'images';
        }
        else
        {
            $s = 'user_files/';
            $s .= ceil($sid / 3000) . '/';
            $s .= ($sid % 3000) . '/';
            $s .= 'images';
        }
        return $s;
    }

}

?>