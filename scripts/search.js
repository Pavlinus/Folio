var searchBtn = document.getElementById("searchBtn");
var content = document.getElementById("projectAreaInner");
var type = document.getElementById("projectType");
var oAjax = new XMLHttpRequest();

searchBtn.addEventListener(
	"click", 
	function() 
	{
		oAjax.open("GET", 
				   "index.php?c=search&act=search&type=" + type.value, 
				   true);
		oAjax.onreadystatechange = getResult;
		oAjax.send();
	}, 
	false);
	

function getResult()
{
	if((oAjax.readyState == 4) && (oAjax.status == 200))
	{
		content.innerHTML = oAjax.responseText;
	}
}