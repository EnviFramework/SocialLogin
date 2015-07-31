<?php
/**
 * SocialLoginのGoogleドライバ
 *
 * Googleアカウントでログインさせるクラスです
 *
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
namespace Envi\SocialLogin\Driver;
use \Envi\SocialLogin\DriverInterface;
use \EnviController;
use \validator;

/**
 * SocialLoginのGoogleドライバ
 *
 * Googleアカウントでログインさせるクラスです
 *
 *
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
class Google extends CommonBase implements DriverInterface
{

    public function showLoginForm()
    {
        $dialog_url = 'https://accounts.google.com/o/oauth2/auth?'
       . 'scope='.urlencode($this->driver_config['scope'])
       . '&client_id=' . $this->app_id . '&redirect_uri=' . urlencode ($this->redirect_url) . '&response_type=code';
        EnviController::redirect($dialog_url);
    }

    public function login()
    {
        $validator = \validator();

        $validator->autoPrepare('code', 'noblank', false, false, validator::METHOD_GET);
        $res = $validator->executeAll();
        if ($validator->isError($res)) {
            new LoginErrorException('undefined code.');
        }
        return $this->getAuthority($res['code']);
    }

    public function getAuthority($code)
    {
        $token_url = 'https://accounts.google.com/o/oauth2/token';
        $params = 'code=' . $code;
        $params .= '&client_id=' . $this->app_id;
        $params .= '&client_secret=' . $this->app_secret;
        $params .= '&redirect_uri=' . urlencode ($this->redirect_url);
        $params .= '&grant_type=authorization_code';
        $response = $this->sendRequest ($token_url, $params, self::REQUEST_POST);

        $response = json_decode($response, true);
        if (isset ($response['access_token'])) {
            $info_url = 'https://www.googleapis.com/oauth2/v1/userinfo';
            $params = 'access_token=' . urlencode ($response['access_token']);
            $response = $this->sendRequest($info_url, $params, self::REQUEST_GET);
            return json_decode($response, true);
        }
        $e = new LoginErrorException('get authority error');
        $e->setResponse($response);
        throw $e;
    }

}