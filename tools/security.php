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

    

    define('SECRET_KEY', constant("ENC_KEY"));

    function createToken($data)
    {
        /* Create a part of token using secretKey and other stuff */
        $tokenGeneric = SECRET_KEY.$_SERVER["SERVER_NAME"]; // It can be 'stronger' of course

        /* Encoding token */
        $token = hash('sha256', $tokenGeneric.$data);

        return array('token' => $token, 'userData' => $data);
    }

    //Generate and return auth key for user
    function auth($username)
    {
        // Concatenating data with TIME
        $data = time()."_".$username;
        $token = createToken($data);
        echo json_encode($token,$data);
    }


    define('VALIDITY_TIME', 3600);

    function checkToken($receivedToken, $receivedData)
    {
        /* Recreate the generic part of token using secretKey and other stuff */
        $tokenGeneric = SECRET_KEY.$_SERVER["SERVER_NAME"];

        // We create a token which should match
        $token = hash('sha256', $tokenGeneric.$receivedData);   

        // We check if token is ok !
        if ($receivedToken != $token)
        {
            echo 'wrong Token !';
            return false;
        }

        list($tokenDate, $userData) = explode("_", $receivedData);
        // here we compare tokenDate with current time using VALIDITY_TIME to check if the token is expired
        // if token expired we return false

        // otherwise it's ok and we return a new token
        return createToken(time()."#".$userData);   
    }
?>