var inputArea = document.getElementById("inputAreaInner");

inputArea.addEventListener("change", inputChange, false);

function inputChange(evt) 
{
	switch(evt.target.name)
	{
		case 'email':
			var email = evt.target.value;
			
			if(!validateEmail(email))
			{
				evt.target.style.borderColor = "#ff8b38";
			}
			else
			{
				evt.target.style.borderColor = "transparent";
			}
			break;
	}
}

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}