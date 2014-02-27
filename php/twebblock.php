<?php
function twebblock ()
{
    include "config.php";

    $referrer = $_SERVER['HTTP_REFERER'];
    # echo "<h1>referrer: ", $referrer, "</h1><hr>\n";
    
    $badreferrers = array();
    
    foreach ($acl_urls as &$acl)
    {
        # echo "<h1>acl: $acl</h1>";
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
        $patterns[4] = '/www\./i';
        $patterns[5] = '/\//';
        $patterns[6] = '/\./';
        $replacements = array();
        $replacements[0] = '';
        $replacements[1] = '';
        $replacements[2] = '';
        $replacements[3] = '';
        $replacements[4] = '';
        $replacements[5] = '\/';
        $replacements[6] = '\.';
        $curlclean = preg_replace($patterns, $replacements, $curloutput);
    
    
        $curlresults = preg_split("/\R/",$curlclean);
        foreach ($curlresults as &$ref)
        {
            # think about FTP urls
            if(!preg_match("/#/", $ref)&&!preg_match("/^$/", $ref))
            {
                $a = "www.";
                $b = $a . $ref;
                array_push ($temparray, $ref);
                array_push ($temparray, $b);
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
    
    
    foreach ($badrefarray as &$badref)
    {
        # echo "<br>";
        echo $badref;
        echo "\n";
        if (preg_match($badref, $referrer))
        {
            echo "<br>Match";
            header("Location: $redirect_site");
            die();
        }
    }
}
?>
