<?php
namespace Envi\SocialLogin\Driver;
use \Envi\SocialLogin\DriverInterface;
use \EnviController;
use \validator;

class Facebook extends CommonBase implements DriverInterface
{
    /**
     * +-- ログインフォームを表示する
     *
     * @access      public
     * @return      void
     */
    public function showLoginForm()
    {
        $dialog_url = 'https://www.facebook.com/dialog/oauth?client_id=' . $this->app_id . '&redirect_uri='. urlencode ($this->redirect_url) .'&scope='.urlencode($this->driver_config['scope']);
        EnviController::redirect($dialog_url);
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
        $validator = validator();

        $validator->autoPrepare('code', 'noblank', false, false, validator::METHOD_GET);
        $res = $validator->executeAll();
        if ($validator->isError($res)) {
            new LoginErrorException('undefined code.');
        }
        return $this->getAuthority($res['code']);
    }
    /* ----------------------------------------- */

    /**
     * +-- オーソリティを取得する
     *
     * @access      public
     * @param       var_text $code
     * @return      array|boolean
     */
    public function getAuthority($code)
    {
        $token_url = 'https://graph.facebook.com/oauth/access_token';
        $params = 'code=' . $code;
        $params .= '&client_id=' . $this->app_id;
        $params .= '&client_secret=' . $this->app_secret;
        $params .= '&redirect_uri=' . urlencode ($this->redirect_url);
        $params .= '&grant_type=authorization_code';
        $access_token = $this->sendRequest ($token_url, $params, self::REQUEST_GET);

        parse_str($access_token, $response_arr);
        if (isset($response_arr['access_token'])) {
            $info_url = 'https://graph.facebook.com/me';
            $params = $access_token;
            $response = $this->sendRequest($info_url, $params, self::REQUEST_GET);
            return json_decode($response, true);
        }
        $e = new LoginErrorException('get authority error');
        $e->setResponse($response_arr);
        throw $e;
    }
    /* ----------------------------------------- */

}