<?php

class verification_code
{
    /**
     +----------------------------------------------------------
     * 生成随机验证码
     +----------------------------------------------------------
     */
    static function get_verification_code(){
        
         $verification_code = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."verification_code ORDER BY rand() limit 4");
         $rand_code=$verification_code[array_rand($verification_code)];
         es_session::set("verification_code",md5($rand_code['iconfont']));
         $data['key']=$rand_code;
         $data['verification_code']=$verification_code;
         return $data;
         
    }
}

?>