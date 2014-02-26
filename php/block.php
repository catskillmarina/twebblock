<HTML>
<HEAD><TITLE>Test Page for referrer blocking</TITLE></HEAD>

<BODY BGCOLOR="FFFFFF">
<?php
$referrer = $_SERVER['HTTP_REFERER'];
echo $referrer;

$acl_urls = array("file:///home/marina/public_html/twebblock/ACL");

$badreferrers = array("/http:\/\/stratus\.e271\.net/","/godhates\/.fags\/com/");

foreach ($acl_urls as &$acl)
{
#   curl the contents from each $acl_urls
#   split the curled contents into an array
    

    $temparray = array();
    foreach ($curlresults as &$ref)
    {
        if (preg_match("/^#/", $ref))
        {
            next;
        }
        if (preg_match("/^$/", $ref))
        {
            next;
        }
        # remove http:// and https://
        # escape '.'s
        # escape '/'s
        # add [http|https] to beginning of strings
        # think about FTP urls
        array_push ($temparray, $ref);
    }
    array_merge($badreferrers, $temparray);
}

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
