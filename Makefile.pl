#!/usr/bin/perl

#----------------------------------------------------------------#
#         Customize these variables to your installation         #
#----------------------------------------------------------------#
$REDIRECT_SITE = "https://en.wikipedia.org/wiki/Transphobia";
$acl = "file:///home/marina/public_html/twebblock/ACL";
$cookie_domain = "http://e271.net";


#----------------------------------------------------------------#
#    DON'T EDIT BELOW HERE UNLESS YOU KNOW WHAT YOU ARE DOING    #
#----------------------------------------------------------------#

# CHANGE this code to use curl to get ACL data #

open(ACL,"<ACL");
@BR= <ACL>;
close(ACL);

chomp(@BR);

foreach (@BR)
{
   $_ =~ s/^http:\/\///i;
   $_ =~ s/^https:\/\///i;
   $_ =~ s/\//\\\//g;
   if (/^$/)
   {
       next;
   }
   if (/^#/)
   {
       next;
   }
   push (@BADREFS, $_);
}
    
    

############################################################################
#                       Create the Javascript blocker                      #
############################################################################

#-------------------------------------------------------#
#          Backup Old Javascript blocklist              #
#-------------------------------------------------------#
open(JS,"<javascript/nohate.js");
@JS = <JS>;
close(JS);
open(JSBAK,">javascript/nohate.js.BAK");
print(JSBAK @JS);
close(JSBAK);


open(JS,">javascript/nohate.js");

print(JS 'var badRefs=new Array(');
print(JS "\n");
$len = scalar(@BADREFS);
for ($i=0; $i<=($len -2); $i++)
{
    print(JS '/[http|https]:\/\/');
    print(JS $BADREFS[$i]);
    print(JS '/i');
    print(JS ',');
    print(JS "\n");
}
print(JS '/[http|https]:\/\/');
print(JS "$BADREFS[$len-1]/i\n");

print JS << 'EOF';
);

var i;

for (i = 0; i < badRefs.length; ++i) 
{
    ref = badRefs[i];
    var BAD = ref.exec(document.referrer);
    if (BAD)  
EOF

print(JS "        window.location.href = \"");
print(JS $REDIRECT_SITE);
print(JS "\"\;\n");
print(JS '}');
print(JS "\n");

close(JS);





############################################################################
#                       Create the PHP blocker config                      #
############################################################################

#-------------------------------------------------------#
#          Backup Old php blocker config                #
#-------------------------------------------------------#
open(PHP,"<php/config.php");
@PHP = <PHP>;
close(PHP);
open(PHPBAK,">php/config.php.BAK");
print(PHPBAK @JS);
close(PHPBAK);

open(PHP,">php/config.php");

print PHP << 'EOF';
<?php
    $acl_urls = array(
EOF
print(PHP "        \"$acl\"\,\n");
print(PHP "     \)\;\n");
print(PHP "    \$cookie_domain = \"$cookie_domain\"\;\n");
print(PHP "    \$redirect_site = \"$REDIRECT_SITE\"\;\n");
print(PHP '?>');
print(PHP "\n");

close(PHP);
