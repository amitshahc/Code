var lastheight = 0;
//var lastheightVisible = 0;

function autoResize(id){
    var newheight = 500;
    var newwidth;

	//document.getElementById(id).height= (newheight) + "px";
    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document.body.scrollHeight; 
        //newwidth=document.getElementById(id).contentWindow.document.body.scrollWidth;
	newheightVisible = newheight + 30; 
	//console.log("new "+newheight);
	//console.log("new Visible "+newheightVisible);
    }
	
	//console.log("last old "+lastheight);
	
	//if(newheight != lastheight && newheightVisible != lastheightVisible)
    if(newheight != lastheight)
    {
	//document.getElementById(id).height= (500) + "px";
	document.getElementById(id).height= (newheightVisible) + "px";
    	//document.getElementById(id).width= (newwidth) + "px";	
	lastheight = newheightVisible;
	//lastheightVisible = newheightVisible;
	//console.log("last new "+lastheight);
    }
}
