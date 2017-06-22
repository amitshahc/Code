var lastheight = 0;

function autoResize(id) {
    var newheight = 500;
    var newwidth;

    //jQuery("#" + id).css('height', 'auto');

    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    //document.getElementById(id).height= (newheight) + "px";
    if (document.getElementById) {
        newheight = isChrome ? document.getElementById(id).contentWindow.document.body.offsetHeight : document.getElementById(id).contentWindow.document.body.scrollHeight;
        //newheight=document.getElementById(id).contentWindow.document.body.scrollHeight; 
        //newwidth=document.getElementById(id).contentWindow.document.body.scrollWidth;
        newheightVisible = newheight + 30; //30
    }

    if (newheight != lastheight) {
        //document.getElementById(id).height= (500) + "px";
        //document.getElementById(id).height= (newheightVisible) + "px";
        jQuery("#" + id).css('height', newheightVisible);
        lastheight = newheightVisible;
    }
}
