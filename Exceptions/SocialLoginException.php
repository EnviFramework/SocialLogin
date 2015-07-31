<?php
namespace Envi\SocialLogin;
use exception;

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
class SocialLoginException extends exception
{
    public $response;
    public function setResponse($response)
    {
        $this->response = $response;
    }
}
