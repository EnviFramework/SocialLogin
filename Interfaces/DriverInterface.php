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
interface DriverInterface
{
    public function login();
    public function showLoginForm();
    public function getAuthority($code);
}
