<?php
listDir("./");
exec("/usr/local/bin/redis-server /etc/redis/6379.conf  >/dev/null  &");
echo "redis_port_6379 Started.\r\n";

function listDir($dir)
{
	if(is_dir($dir))
   	{
     	if ($dh = opendir($dir))
		{
        	while (($file = readdir($dh)) !== false)
			{
     			if((is_dir($dir."/".$file)) && $file!="." && $file!="..")
				{
     				echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>";
     				listDir($dir."/".$file."/");
     			}
				else
				{
             	if($file!="." && $file!=".."&&!in_array($file,array('index.html','start.php','nohup.out','enryStart.sh')))
    					{
             				//echo $file."<br>";
                    exec("node ".$file."  >/dev/null  &");
                    echo $file." Started.\r\n";
                    sleep(2);
          		}
     			}
        	}
        	closedir($dh);
     	}
   	}
}
