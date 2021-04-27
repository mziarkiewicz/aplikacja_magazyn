// Proste funkcje JavaScript, głównie dotyczące AJAX'a

// Funkcja przechodzi do URL, podanego jako parametr 'link', po potwierdzeniu przez użytkownika.
// (wyświetla zapytanie podane jako parametr 'message')
function confirmLink(link,message) {
	if(confirm(message)) {
		window.location.href=link;
	}
}

// Funkcja wysyłająca dane formularza identyfkowanego przez 'id_form', do podanego adresu 'url'.
// Otrzymana odpowiedź zamienia zawartość elementu na stronie o identyfikatorze 'id_to_reload'.
function ajaxPostForm(id_form,url,id_to_reload)
{
    var form = document.getElementById(id_form);
    var formData = new FormData(form); 
    var xmlHttp = new XMLHttpRequest();
	xmlHttp.onreadystatechange = function() {
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
			document.getElementById(id_to_reload).innerHTML = xmlHttp.responseText;
		}
	}
    xmlHttp.open("POST", url, true); 
    xmlHttp.send(formData); 
}

// Funkcja wysyłająca dane formularza identyfkowanego przez 'id_form', do podanego adresu 'url'.
// Po otrzymaniu odpowiedzi wywoływana jest funkcja użytkownika podana jako 'user_function'.
function ajaxPostFormEx(id_form,url,user_function)
{
    var form = document.getElementById(id_form);
    var formData = new FormData(form); 
    var xmlHttp = new XMLHttpRequest();
	xmlHttp.onreadystatechange = function() {
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
			user_function();
		}
	}
    xmlHttp.open("POST", url, true); 
    xmlHttp.send(formData); 
}
 
// Funkcja odświeżająca zawartość elementu o identyfikatorze 'id_element'.
// Zawartość do odświeżenia jest otrzymana w odpowiedzi na żądanie wysłane do podanego adresu 'url'.
// Jeśli podano parametr 'interval' >0 (sekundy), to po otrzymaniu odpowiedzi po upływie podanego
// interwału odświeżanie zostanie automatycznie ponowione (tzw. AJAX pooling).
function ajaxReloadElement(id_element,url,interval=0) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById(id_element).innerHTML = this.responseText;
			if (interval > 0) 
				setTimeout( function(){ ajaxReloadElement(id_element,url,interval) }, interval);
		}
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}


function doNothing() {
	return false;
}
