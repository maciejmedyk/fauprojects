<?php

#Return the type of device as a string in lowercase
function detectDevice()
{
    $userAgent = $_SERVER["HTTP_USER_AGENT"];
    $devicesTypes = array(
        "desktop" => array("msie 11", "msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
        "android"  => array("android.*mobile"),
        "ios"	   => array("iphone", "ipod", "ipad"),
        "bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
    );
    
    foreach($devicesTypes as $deviceType => $devices) 
    {           
        foreach($devices as $device) 
        {
            if(preg_match("/" . $device . "/i", $userAgent)) 
            {
                $deviceName = $deviceType;
            }
        }
    }
    return strtolower(ucfirst($deviceName));
}

#Return true if current device matches type requested
#$type is a string of the type of device to test against.
function isDevice($type)
{
	$type = strtolower($type);
	if(detectDevice() === $type)
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>