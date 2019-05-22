<?php
    define("RootFolder",__DIR__);
    IncludeTools();

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

?>