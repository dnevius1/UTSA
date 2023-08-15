<?php
$files=array('equipmentpartaa','equipmentpartab','equipmentpartac','equipmentpartad','equipmentpartae'); 
foreach($files as $key=>$value)
{
    shell_exec("/usr/bin/php /var/www/html/importargs.php $key $value > /var/www/html/$value.log 2>/var/www/html/$value.log &");
}
echo "Main Process Done\n";
?>