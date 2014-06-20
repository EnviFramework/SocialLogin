<?php
namespace Envi\SocialLogin;

interface DriverInterface
{
    public function login();
    public function showLoginForm();
    public function getAuthority($code);
}
