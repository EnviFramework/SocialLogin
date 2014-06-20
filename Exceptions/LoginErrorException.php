<?php
namespace Envi\SocialLogin;

class LoginErrorException extends SocialLoginException
{
    public $response;
    public function setResponse($response)
    {
        $this->response = $response;
    }
}
