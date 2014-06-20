<?php
namespace Envi;
use Envi\SocialLogin\Factory;
/**
 * @package
 * @subpackage
 * @sinse 0.1
 * @author     akito<akito-artisan@five-foxes.com>
 */
require __DIR__.'/Exceptions/SocialLoginException.php';
require __DIR__.'/Exceptions/DriverNotFoundException.php';
require __DIR__.'/Exceptions/LoginErrorException.php';
require __DIR__.'/Interfaces/DriverInterface.php';
require __DIR__.'/Base/DriverCommonBase.php';
require __DIR__.'/Factory/Factory.php';


/**
 * @package
 * @subpackage
 * @sinse 0.1
 * @author     akito<akito-artisan@five-foxes.com>
 */
class SocialLogin
{
    public $system_config ;
    private $Factory;
    private $Driver;
    private $response_data;
    private $non_filter_response_data;

    public function __construct($system_config)
    {
        $this->system_config = $system_config;
    }

    /**
     * +-- ログインフォームを表示する
     *
     * @access      public
     * @param       var_text $redirect_url OPTIONAL:NULL
     * @return      void
     */
    public function showLoginForm($redirect_url = NULL)
    {
        if ($redirect_url !== NULL) {
            $this->driver()->setRedirectUrl($redirect_url);
        }
        $this->Driver->showLoginForm();
    }
    /* ----------------------------------------- */


    public function setDefaultRedirectUrl($redirect_url)
    {
        $this->driver()->setRedirectUrl($redirect_url);
    }
    /* ----------------------------------------- */

    /**
     * +-- ログインしてユーザー情報を取得する
     *
     * @access      public
     * @return      void
     */
    public function login()
    {
        $res = $this->non_filter_response_data = $this->driver()->login();
        $this->response_data = $this->Driver->responseFilter($res);
        return $this->response_data;
    }
    /* ----------------------------------------- */


    /**
     * +-- 使用するソーシャルログインセレクタを選択する
     *
     * @access      public
     * @param       string $driver_name ドライバ名
     * @return      void
     */
    public function driverSelect($driver_name)
    {
        $this->Driver = $this->factory()->Driver($driver_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- Driverオブジェクト取得
     *
     * @access      private
     * @return      void
     */
    private function driver()
    {
        if (!$this->Driver) {
            throw new SocialLogin\SocialLoginException('please call Envi\SocialLogin::driverSelect');
        }
        return $this->Driver;
    }
    /* ----------------------------------------- */


    /**
     * +-- ファクトリーオブジェクト
     *
     * @access      private
     * @return      Envi\SocialLogin\Factory
     */
    private function factory()
    {
        if ($this->Factory) {
            return $this->Factory;
        }
        $this->Factory = new Factory($this);
        return $this->Factory;
    }
    /* ----------------------------------------- */
}
