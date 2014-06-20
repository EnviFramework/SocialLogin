<?php
/**
 *
 *
 *
 * PHP versions 5
 *
 *

 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */
use Envi\SocialLogin;

/**
 *
 *
 *
 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */
class SocialLoginTest extends testCaseBase
{
    /**
     * +-- 初期化
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
        $this->free();
    }
    /* ----------------------------------------- */


    public function createObj()
    {
        $config = array (
          'drivers' =>
              array (
                'facebook' =>
                array (
                  'driver_path' => 'Drivers/Facebook.php',
                  'class_name' => '\\Envi\\SocialLogin\\Driver\\Facebook',
                  'app_id' => '',
                  'app_secret' => '',
                  'default_redirect_url' => 'http://antenna.haluhi.net/contents/login/facebook',
                  'scope' => 'email',
                  'map' =>
                  array (
                    'email' => 'email',
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    'social_name' => 'name',
                    'link' => 'profile_url',
                    'user_name' => 'username',
                  ),
                ),
                'google' =>
                array (
                  'driver_path' => 'Drivers/Google.php',
                  'class_name' => '\\Envi\\SocialLogin\\Driver\\Google',
                  'app_id' => '',
                  'app_secret' => '',
                  'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
                  'default_redirect_url' => 'http://antenna.haluhi.net/contents/login/google',
                  'map' =>
                  array (
                    'email' => 'email',
                    'given_name' => 'first_name',
                    'family_name' => 'last_name',
                    'social_name' => 'name',
                    'link' => 'profile_url',
                    'user_name' => 'username',
                  ),
                ),
              ),
            );
        return array(
            $config,
            new SocialLogin($config)
        );
    }


    /**
     * +-- ファクトリーオブジェクト
     *
     * @access      public
     * @return      void
     * @cover       Envi\SocialLogin::factory
     * @dataProvider createObj
     */
    public function factoryTest($system_conf, $social_login)
    {
        $factory = $this->call($social_login, 'factory', array());
        $this->assertInstanceOf('Envi\SocialLogin\Factory', $factory);
        $factory2 = $this->call($social_login, 'factory');
        $this->assertInstanceOf('Envi\SocialLogin\Factory', $factory2);
        $this->assertEquals(spl_object_hash($factory), spl_object_hash($factory2));
    }
    /* ----------------------------------------- */
    /**
     * +-- Driverオブジェクト取得
     *
     * @access      public
     * @return      void
     * @cover       Envi\SocialLogin::driver
     * @dataProvider createObj
     */
    public function driverTest($system_conf, $social_login)
    {
        $e = NULL;
        try{
            $driver = $this->call($social_login, 'driver', array());
        } catch (exception $e) {
        }
        $this->assertInstanceOf('Envi\SocialLogin\SocialLoginException', $e);
        $social_login->driverSelect('facebook');
        $driver = $this->call($social_login, 'driver', array());
        $this->assertInstanceOf('Envi\SocialLogin\Driver\Facebook', $driver);
        $driver2 = $this->call($social_login, 'driver');
        $this->assertInstanceOf('Envi\SocialLogin\Driver\Facebook', $driver2);
        $this->assertEquals(spl_object_hash($driver), spl_object_hash($driver2));
    }
    /* ----------------------------------------- */


    /**
     * +-- ログインフォームを表示する
     *
     * @access      public
     * @return      void
     * @cover       Envi\SocialLogin::showLoginForm
     */
    public function showLoginFormTest()
    {

    }


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       Envi\SocialLogin::setDefaultRedirectUrl
     */
    public function setDefaultRedirectUrlTest()
    {
    }

    /**
     * +-- ログインしてユーザー情報を取得する
     *
     * @access      public
     * @return      void
     * @cover       Envi\SocialLogin::login
     */
    public function loginTest()
    {
    }
    /* ----------------------------------------- */


    /**
     * +-- 使用するソーシャルログインセレクタを選択する
     *
     * @access      public
     * @return      void
     * @cover       Envi\SocialLogin::driverSelect
     * @dataProvider createObj
     */
    public function driverSelectTest($system_conf, $social_login)
    {
        $factory_mock = EnviMock::mock('Envi\SocialLogin\Factory');
        $factory_mock->shouldReceive('Driver')
            ->once()
            ->with('facebook')
            ->andNoBypass();
        $social_login->driverSelect('facebook');
        $driver = $this->call($social_login, 'driver');
        $this->assertInstanceOf('Envi\SocialLogin\Driver\Facebook', $driver);
    }
    /* ----------------------------------------- */

    /**
     * +-- 終了処理
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
    }

}
