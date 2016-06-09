function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  
  if(!re.test(email.value))
  {
	  email.setCustomValidity("Некорректный email адрес");
	  return false;
  }
  else
  {
	  email.setCustomValidity("");
	  return true;
  }
}