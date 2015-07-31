<?php
namespace Envi\SocialLogin;

/**
 * @package
 * @subpackage
 * @sinse 0.1
 * @author     akito<akito-artisan@five-foxes.com>
 * @doc_ignore
 */

/**
 * @package
 * @subpackage
 * @abstract
 * @sinse 0.1
 * @author     akito<akito-artisan@five-foxes.com>
 * @doc_ignore
 */
class LoginErrorException extends SocialLoginException
{
    public $response;
    public function setResponse($response)
    {
        $this->response = $response;
    }
}
