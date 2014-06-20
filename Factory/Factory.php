<?php
namespace Envi\SocialLogin;

class Factory
{
    protected $SocialLogin;

    /**
     * +-- コンストラクタ
     *
     * @access      public
     * @param       Envi\SocialLogin $SocialLogin
     * @return      void
     */
    public function __construct(\Envi\SocialLogin $SocialLogin)
    {
        $this->SocialLogin = $SocialLogin;
    }
    /* ----------------------------------------- */

    /**
     * +-- ドライバー取得
     *
     * @access      public
     * @param       var_text $driver_name
     * @return      void
     */
    public function Driver($driver_name)
    {
        if (!isset($this->SocialLogin->system_config['drivers'][$driver_name])) {
            throw new DriverNotFoundException($driver_name.' is not found.');
        }
        $driver_config = $this->SocialLogin->system_config['drivers'][$driver_name];
        $this->loading($driver_config);
        $class_name = $driver_config['class_name'];
        $Driver = new $class_name($this->SocialLogin, $driver_config);
        return $Driver;
    }
    /* ----------------------------------------- */

    /**
     * +-- ドライバークラスロード
     *
     * @access      private
     * @param       array $driver_config
     * @return      void
     */
    private function loading(array $driver_config)
    {
        if (class_exists($driver_config['class_name'], true)) {
            return;
        }
        if (strpos($driver_config['driver_path'], '/') === 0) {
            include $driver_config['driver_path'];
            return;
        }
        include dirname(__DIR__).DIRECTORY_SEPARATOR.$driver_config['driver_path'];
    }
    /* ----------------------------------------- */
}
