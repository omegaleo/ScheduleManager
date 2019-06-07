<?php
    define("RootFolder",__DIR__);
    date_default_timezone_set('Europe/London'); 
    IncludeTools();
    session_start();
    $debug=TRUE;

    if($debug==TRUE)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    }

    function GetRootFolder()
    {
        return constant("RootFolder");
    }

    function HeaderImports()
    {
        $files = scandir(GetRootFolder().'/library/css');
        foreach($files as $file)
        {
            if(strpos($file,".css")!==false)
            {
                echo "<link rel='stylesheet' href='library/css/".$file."'/>";
            }
        }

        $files = scandir(GetRootFolder().'/library/js');
        foreach($files as $file)
        {
            if(strpos($file,".js")!==false)
            {
                echo "<script src='library/js/".$file."'></script>";
            }
        }

        $files = scandir(GetRootFolder().'/css');
        foreach($files as $file)
        {
            if(strpos($file,".css")!==false)
            {
                echo "<link rel='stylesheet' href='css/".$file."'/>";
            }
        }

        $files = scandir(GetRootFolder().'/js');
        foreach($files as $file)
        {
            if(strpos($file,".js")!==false)
            {
                echo "<script src='js/".$file."'></script>";
            }
        }
    }

    function IncludeTools()
    {
        $files = scandir(GetRootFolder().'/tools');
        foreach($files as $file)
        {
            if(strpos($file,".php")!==false)
            {
                include(GetRootFolder()."/tools/".$file);
            }
        }
    }

    function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
    
            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),
    
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,
    
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,
    
            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    function getDayOfWeekString($dayOfWeekNumber)
    {
        $days = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday'
          ];
        $dayOfWeek = $days[$dayOfWeekNumber];
        return $dayOfWeek;
    }
?>