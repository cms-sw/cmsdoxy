function insertAfter( referenceNode, newNode )
{
 referenceNode.parentNode.insertBefore( newNode, referenceNode.nextSibling );
}

function insertBefore (referenceNode, newNode )
{
 referenceNode.parentNode.insertBefore( newNode, referenceNode );
}



function addLinksToMenu(){

   // Getting all menu tabs (tabs, tabs2, tabs3)
   var menu = document.getElementsByTagName("div");
   var namespaceSelected = false;
   var version = "";



   // VERSION

   var l = parent.location.href;
   var l_array=l.split("/");

   for(var i=0; i < l_array.length; i++) {
	var value = l_array[i];
        if (value.indexOf('CMSSW_') != -1){
	    version = value;
        }
    }



   for (var m = 0; m < menu.length; m++){
   var tabs = menu[m];
   
      // Selecting first line of tabs
      if (tabs.className == "tabs"){
        // Getting tablist
  	var ul = tabs.getElementsByTagName("ul")[0];
  	// Getting all tabs
  	var li_List = ul.getElementsByTagName("li");
	                                              
	// Checking if Namespaces tab is selected
        for( var i = 0; i < li_List.length; i++ ){
		var tmp_Li = li_List[i];
		if (tmp_Li.className == "current"){
			var tmp_a = tmp_Li.getElementsByTagName("a")[0];
			var tmp_span = tmp_a.getElementsByTagName("span")[0];
			if (tmp_span.innerHTML == "Namespaces"){
				namespaceSelected = true;
			}			
		}
	}                                            
        	
	// Last element (search)
	var li = li_List[li_List.length - 1];


	// CVS/GIT DIRECTORY TAB
	
	// Creating new LI Element			
	var newLi = document.createElement("li");			
	// Creating link for Element			
	var newA = document.createElement("a"); 

	// Creating text for this new element			
	var newText=document.createTextNode("Repository");
        
	if (version != ""){

		if (version < "CMSSW_7_0_0"){
			newA.setAttribute('href', 'http://cmssw.cvs.cern.ch/cgi-bin/cmssw.cgi/CMSSW/?pathrev='+version);
			newText=document.createTextNode("CVS Directory");
		}
		else{
			newA.setAttribute('href', 'https://github.com/cms-sw/cmssw/tree/'+version);		
			newText=document.createTextNode("GIT Directory");
		}
	}	

	newA.setAttribute('target', '_blank');			
	// Creating span inside link		
	var newSpan = document.createElement("span");	
	
	// Appending text to new LI element			
	newSpan.appendChild(newText);			
	newA.appendChild(newSpan);			
	newLi.appendChild(newA);						
	// Inserting new LI after "One before" element
	insertBefore(li, newLi);

	// WORKBOOK TAB

	// Creating new LI Element			
	var newLi = document.createElement("li");			
	// Creating link for Element			
	var newA = document.createElement("a"); newA.setAttribute('href', 'https://twiki.cern.ch/twiki/bin/view/CMSPublic/WorkBook');			
	newA.setAttribute('target', '_blank');
	// Creating span inside link		
	var newSpan = document.createElement("span");	
	// Creating text for this new element			
	var newText=document.createTextNode("WorkBook");			
	// Appending text to new LI element			
	newSpan.appendChild(newText);			
	newA.appendChild(newSpan);			
	newLi.appendChild(newA);						
	// Inserting new LI after "One before" element
	insertBefore(li, newLi);


	// OFFLINE GUIDE

	// Creating new LI Element			
	var newLi = document.createElement("li");			
	// Creating link for Element			
	var newA = document.createElement("a"); newA.setAttribute('href', 'https://twiki.cern.ch/twiki/bin/view/CMSPublic/SWGuide');
	newA.setAttribute('target', '_blank');			
	// Creating span inside link		
	var newSpan = document.createElement("span");	
	// Creating text for this new element			
	var newText=document.createTextNode("Offline Guide");			
	// Appending text to new LI element			
	newSpan.appendChild(newText);			
	newA.appendChild(newSpan);			
	newLi.appendChild(newA);						
	// Inserting new LI after "One before" element
	insertBefore(li, newLi);


	// RELEASE SCHEDULE

	// Creating new LI Element			
	var newLi = document.createElement("li");			
	// Creating link for Element			
	var newA = document.createElement("a"); newA.setAttribute('href', 'https://twiki.cern.ch/twiki/bin/viewauth/CMS/ReleaseSchedule');
	newA.setAttribute('target', '_blank');			
	// Creating span inside link		
	var newSpan = document.createElement("span");	
	// Creating text for this new element			
	var newText=document.createTextNode("Release schedule");			
	// Appending text to new LI element			
	newSpan.appendChild(newText);			
	newA.appendChild(newSpan);			
	newLi.appendChild(newA);						
	// Inserting new LI after "One before" element
	insertBefore(li, newLi);






     }    
	if (tabs.className == "tabs2" && namespaceSelected){
		namespaceSelected = false;
		var ul = tabs.getElementsByTagName("ul")[0];	
		// Getting all tabs
	  	var li_List = ul.getElementsByTagName("li");
		// The last
		var li = li_List[li_List.length - 1];
		// Creating new LI Element			
		var newLi = document.createElement("li");			

		if (document.URL.indexOf("namespace") == -1){
		   newLi.setAttribute('class', 'current'); 
		    for( var i = 0; i < li_List.length; i++ ){
			li_List[i].setAttribute('class', ''); 
		    }
		}
		// Creating link for Element			
		var url = document.URL;
		var index = url.indexOf("doc/html");
		var head = url.substring(0, index);
		url = head+"doc/html/configfiles.html"


//		var index = url.indexOf("new_doxy");
//		var head = url.substring(0, index);
//		url = head+"new_doxy/configfiles.html"
		
		var newA = document.createElement("a"); newA.setAttribute('href', url);			
		// Creating span inside link		
		var newSpan = document.createElement("span");	
		// Creating text for this new element			
		var newText=document.createTextNode("Config files");			
		// Appending text to new LI element			
		newSpan.appendChild(newText);			
		newA.appendChild(newSpan);			
		newLi.appendChild(newA);						
		// Inserting new LI after "One before" element
		insertAfter(li, newLi);		
	}
   }
  dropdownMenu();
} 

function dropdownMenu(){
	var iframe = document.createElement("iframe"); 
	iframe.setAttribute('src', "https://cmssdt.cern.ch/SDT/doxygen/versionList.php");
	iframe.setAttribute('width', "400");
	iframe.setAttribute('height', "50");
	iframe.setAttribute('frameborder', "0");
	iframe.setAttribute('style', "position:absolute; left:40%; top:5px;");
	var body = document.getElementsByTagName("body")[0];
	insertAfter(body, iframe);
			
}

// Doxygen Support Tool (it should be rewritten)
function clear(string)
{
    var index = string.lastIndexOf('/');
    
    if(index == -1) return string;
    else return string.substring(index + 1, string.length);
}

$(document).ready(function(){
    return ; // test
    var DoxygenVersion = $("meta[name=doxygen_version]").attr("content");
    
    // try to find source code section
    var SourceCodeSection = $(".fragment");
    
    // detect source code section. If it exists, set SourceCodeFlag flag
    var SourceCodeFlag = SourceCodeSection[0] ? (true) :(false);
    
    // Detect programming language. If it is python, set the python flag
    var PythonFlag = document.URL.indexOf("py_") == -1 ? (false) : (true) ;
    
    // If doxygen version matches and source code section exists and it is python source code...
    if(DoxygenVersion == "1.8.5" && SourceCodeFlag && PythonFlag)
    {   
        // Collect all content of pop-ups (source tooltips)
        var ttc = $('div[class="ttc"]');
        var ttc_dict = Object(); // structure: {link0:definition0, ...} 
        ttc.each(
        function()
        {
            ttc_dict[clear($(this).children('.ttname').children('a').attr('href'))] = $(this).children('.ttdef').text();
        });
        
        // Get all linked source code
        var links = SourceCodeSection.find('a[class="code"]');
        links.each(
        function()
        {
            // If the link has not a definition, it should be broken...
            if(clear($(this).attr('href')) in ttc_dict && ttc_dict[clear($(this).attr('href'))] == '')
            {
                $(this).replaceWith('<b>'+$(this).text()+'</b>');
                //$(this).css({'background':'#FFDDDD', 'text'});
            }
        });
    }
    
});
