var badRefs=new Array(
/[http|https]:\/\/e271.net\/~marina\/STAR\/twebblock\/javascript\//i,
/[http|https]:\/\/www.e271.net\/~marina\/STAR\/twebblock\/javascript\//i,
/[http|https]:\/\/stratus.e271.net\/~marina\/twebblock\/php\/bad.html/i,
/[http|https]:\/\/www.stratus.e271.net\/~marina\/twebblock\/php\/bad.html/i,
/[http|https]:\/\/4chan.org\//i,
/[http|https]:\/\/www.4chan.org\//i,
/[http|https]:\/\/reddit.com\//i,
/[http|https]:\/\/www.reddit.com\//i,
/[http|https]:\/\/facebook.com\/EncyclopaediaDramatica/i,
/[http|https]:\/\/www.facebook.com\/EncyclopaediaDramatica/i,
/[http|https]:\/\/trolling-asshole.com/i
/[http|https]:\/\/www.trolling-asshole.com/i
);

var i;

for (i = 0; i < badRefs.length; ++i) 
{
    ref = badRefs[i];
    var BAD = ref.exec(document.referrer);
    if (BAD)  
        window.location.href = "https://en.wikipedia.org/wiki/Transphobia";
}
