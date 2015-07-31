SocialLoginを使用するためのエクステンションクラス
=================================

概要
--------------------------------------------------
FacebookやGoogleアカウントでログインさせるクラスです


パッケージ管理
--------------------------------------------------
SocialLoginパッケージをEnviMvcにバンドルさせるには、

`envi install-bundle new https://raw.githubusercontent.com/EnviMVC/SocialLogin/master/bundle.yml`

コマンドを実行します。

インストール・設定
--------------------------------------------------

パッケージがバンドルされていれば、

`envi install-extension {app_key} {DI設定ファイル} SocialLogin`

コマンドでインストール出来ます。

