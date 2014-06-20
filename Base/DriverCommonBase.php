<?php
namespace Envi\SocialLogin\Driver;
/**
 * @package
 * @subpackage
 * @sinse 0.1
 * @author     akito<akito-artisan@five-foxes.com>
 */

/**
 * @package
 * @subpackage
 * @abstract
 * @sinse 0.1
 * @author     akito<akito-artisan@five-foxes.com>
 */
abstract class CommonBase
{

    const REQUEST_POST = 1;
    const REQUEST_GET  = 2;
    protected $redirect_url;
    protected $SocialLogin;
    protected $driver_config;
    protected $app_id;
    protected $app_secret;

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       Envi\SocialLogin $SocialLogin
     * @param       array $driver_config
     * @return      void
     */
    public function __construct(\Envi\SocialLogin $SocialLogin, array $driver_config)
    {
        $this->SocialLogin = $SocialLogin;
        $this->driver_config = $driver_config;
        $this->setRedirectUrl($driver_config['default_redirect_url']);
        $this->app_id = $driver_config['app_id'];
        $this->app_secret = $driver_config['app_secret'];
    }
    /* ----------------------------------------- */

    /**
     * +-- リダイレクトURLを動的に定義する
     *
     * @access      public
     * @param       var_text $url
     * @return      void
     */
    public function setRedirectUrl($url)
    {
        $this->redirect_url = $url;
    }
    /* ----------------------------------------- */

    /**
     * +-- 設定に従ってキーを書き換える
     *
     * @access      public
     * @param       var_text $response
     * @return      array
     */
    public function responseFilter($response)
    {
        $res = array();
        foreach ($response as $key => $val) {
            if (isset($this->driver_config['map'][$key])) {
                $key = $this->driver_config['map'][$key];
            }
            $res[$key] = $val;
        }
        return $res;
    }
    /* ----------------------------------------- */

    /**
     * +-- Requestを送信する
     *
     * @access      public
     * @param       string $url
     * @param       string $params
     * @param       string $type
     * @return      string
     */
    public function sendRequest($url, $params, $type)
    {
        $ch = curl_init ();
        if ($type === self::REQUEST_POST) {
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt ($ch, CURLOPT_POST, 1);
        } else {
            curl_setopt ($ch, CURLOPT_URL, $url . "?" . $params);
        }
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec ($ch);
        curl_close ($ch);
        return $response;
    }
    /* ----------------------------------------- */
}