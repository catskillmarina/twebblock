<HTML>
<HEAD><TITLE>Test Page for referrer blocking</TITLE></HEAD>

<BODY BGCOLOR="FFFFFF">
<?php
$referrer = $_SERVER['HTTP_REFERER'];
echo "<h1>referrer: ", $referrer, "</h1><hr>\n";

$acl_urls = array(
    "file:///home/marina/public_html/twebblock/ACL",
    );

$badreferrers = array();

foreach ($acl_urls as &$acl)
{
    echo "<h1>acl: $acl</h1>";
    #---------------------------------------#
    # curl the contents from each $acl_urls #
    #---------------------------------------#
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $acl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $curloutput = curl_exec($ch);
    curl_close($ch); 

    $temparray = array();

    $patterns = array();
    $patterns[0] = '/^#.+$/';
    $patterns[1] = '/^$/';
    $patterns[2] = '/http:\/\//i';
    $patterns[3] = '/https:\/\//i';
    $patterns[4] = '/\//';
    $patterns[5] = '/\./';
    $replacements = array();
    $replacements[0] = '';
    $replacements[1] = '';
    $replacements[2] = '';
    $replacements[3] = '';
    $replacements[4] = '\/';
    $replacements[5] = '\.';
    $curlclean = preg_replace($patterns, $replacements, $curloutput);


    $curlresults = preg_split("/\R/",$curlclean);
    foreach ($curlresults as &$ref)
    {
        # think about FTP urls
        if(!preg_match("/#/", $ref)&&!preg_match("/^$/", $ref))
        {
            array_push ($temparray, $ref);
        }
    }

    # add [http|https] to beginning of strings
    $patterns = array();
    $patterns[0] = '/^/';
    $patterns[1] = '/$/';
    $replacements = array();
    $replacements[0] = '/[http|https]:\/\/';
    $replacements[1] = '/';
    $temparraymod = preg_replace($patterns, $replacements, $temparray);

    $badrefarray = array_merge($badreferrers, $temparraymod);
}


echo "<h1>BEFORE $badrefarray PRINT</h1>\n";
$i = 0;
foreach($badrefarray as &$foo)
{
    echo "<font color =\"0000ff\">$i: $foo</font><br>\n";
    $i++;
}

foreach ($badrefarray as &$badref)
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
