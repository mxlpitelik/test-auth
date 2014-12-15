<?php

class oauth
{
    public static $sn_config=[
        "fb" => [
                    "client_id" => '824340717608900', // Client ID
                    "client_secret" => '4414bb4576068d653292e4036e8b2a1a', // Client secret
                    "redirect_uri" => 'http://localhost/test-auth/oauth/fb.php', // Redirect URIs
                    "url" => 'https://www.facebook.com/dialog/oauth',
                    "response_type" => 'code',
                    "scope"         => 'email,user_birthday'
                ]
    ];

    function __construct()
    {
//        $this->fb_link();
    }
    
    static function fb_link()
    {
        $url = self::$sn_config['fb']['url'];

        $params = array(
            'client_id'     => self::$sn_config['fb']['client_id'],
            'redirect_uri'  => self::$sn_config['fb']['redirect_uri'],
            'response_type' => self::$sn_config['fb']['response_type'],
            'scope'         => self::$sn_config['fb']['scope']
        );
        
        return $url . '?' . urldecode(http_build_query($params));
    }
    
    function method_fb()
    {
        if (isset($_GET['code'])) {
            $result = false;

            $params = array(
                'client_id'     => self::$sn_config['fb']['client_id'],
                'redirect_uri'  => self::$sn_config['fb']['redirect_uri'],
                'client_secret' => self::$sn_config['fb']['client_secret'],
                'code'          => $_GET['code']
            );

            $url = 'https://graph.facebook.com/oauth/access_token';
            
            $tokenInfo = null;
            $answer=file_get_contents($url . '?' . http_build_query($params));
//            die($answer);
            parse_str($answer, $tokenInfo);
            
            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
                $params = array('access_token' => $tokenInfo['access_token']);

                $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params))), true);
                if (isset($userInfo['id'])) {
                    return($userInfo);
                }
            }
        }
    }
}

?>