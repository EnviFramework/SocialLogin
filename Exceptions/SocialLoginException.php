<?php
namespace Envi\SocialLogin;
use exception;

class SocialLoginException extends exception
{
    public $response;
    public function setResponse($response)
    {
        $this->response = $response;
    }
}
