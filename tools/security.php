<?php
    eval(file_get_contents(GetRootFolder()."/configurations/encryption_key.php"));

    function my_simple_crypt( $string, $action = 'e' ) { //Credit to: https://nazmulahsan.me/simple-two-way-function-encrypt-decrypt-string/
        // you may change these values to your own
        $secret_key = constant("ENC_KEY");
        $secret_iv = '3b9271db9a36c638101743142ac2c6fb';
     
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
     
        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
     
        return $output;
    }

    function Encrypt($string)
    {
        return my_simple_crypt($string,'e');
    }

    function Decrypt($string)
    {
        return my_simple_crypt($string,'d');
    }
?>