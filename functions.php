<?php


    function HeaderImports()
    {
        $files = scandir(GetRootFolder().'/library/css');
        foreach($files as $file)
        {
            if(strpos($file,".css")!==false)
            {
                echo "<link rel='stylesheet' href='".(GetRootFolder()."/library/css/".$file)."'/>";
            }
        }

        $files = scandir(GetRootFolder().'/library/js');
        foreach($files as $file)
        {
            if(strpos($file,".js")!==false)
            {
                echo "<script src='".(GetRootFolder()."/library/js/".$file)."'/>";
            }
        }

        $files = scandir(GetRootFolder().'/css');
        foreach($files as $file)
        {
            if(strpos($file,".css")!==false)
            {
                echo "<link rel='stylesheet' href='".(GetRootFolder()."/css/".$file)."'/>";
            }
        }

        $files = scandir(GetRootFolder().'/js');
        foreach($files as $file)
        {
            if(strpos($file,".js")!==false)
            {
                echo "<script src='".(GetRootFolder()."/js/".$file)."'/>";
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