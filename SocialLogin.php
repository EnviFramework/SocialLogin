<?php
/**
 * SocialLoginを使用するためのエクステンションクラス
 *
 * FacebookやGoogleアカウントでログインさせるクラスです
 *
 *
 * インストール・設定
 * --------------------------------------------------
 * envi install-extension {app_key} {DI設定ファイル} SocialLogin
 *
 * コマンドでインストール出来ます。
 *
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage MinifyExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2015 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/SocialLogin
 * @see        https://www.enviphp.net/
 * @since      File available since Release 1.0.0
*/
namespace Envi;
use Envi\SocialLogin\Factory;


require __DIR__.'/Exceptions/SocialLoginException.php';
require __DIR__.'/Exceptions/DriverNotFoundException.php';
require __DIR__.'/Exceptions/LoginErrorException.php';
require __DIR__.'/Interfaces/DriverInterface.php';
require __DIR__.'/Base/DriverCommonBase.php';
require __DIR__.'/Factory/Factory.php';



/**
 * SocialLoginを使用するためのエクステンションクラス
 *
 * FacebookやGoogleアカウントでログインさせるクラスです
 *
 *
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage MinifyExtension
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2015 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/SocialLogin
 * @see        https://www.enviphp.net/
 * @since      File available since Release 1.0.0
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

    /**
     * +-- 標準のredirect_urlをセットする
     *
     * @access      public
     * @param       string $redirect_url
     * @return      void
     */
    public function setDefaultRedirectUrl($redirect_url)
    {
        $this->driver()->setRedirectUrl($redirect_url);
    }
    /* ----------------------------------------- */

    /**
     * +-- ログインしてユーザー情報を取得する
     *
     * 戻り先アクションでコールします
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
     * +-- 使用するソーシャルログインドライバを選択する
     *
     * @access      public
     * @param       string $driver_name ドライバ名
     * @return      DriverInterface
     */
    public function driverSelect($driver_name)
    {
        $this->Driver = $this->factory()->Driver($driver_name);
        return $this->Driver;
    }
    /* ----------------------------------------- */

    /**
     * +-- 選択されているDriverオブジェクト取得
     *
     * @access      private
     * @return      DriverInterface
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
