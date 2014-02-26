<HTML>
<HEAD><TITLE>Test Page for referrer blocking</TITLE></HEAD>

<BODY BGCOLOR="FFFFFF">
<?php
$referrer = $_SERVER['HTTP_REFERER'];
echo $referrer;

$acl_urls = array("file:///home/marina/public_html/twebblock/ACL");
#
# Need code to curl the ACL's and put them in one array
#

$badreferrers = array("/http:\/\/stratus\.e271\.net/","/godhates\/.fags\/com/");
foreach ($badreferrers as &$badref)
{
    echo "<br>";
    echo $badref;
    if (preg_match($badref, $referrer))
    {
        echo "<br>Match";
    }
    else
    {
        echo "<br>No Match";
    } 
}
?>
</BODY>
</HTML>
