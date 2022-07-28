function handleDocumentKeyPress(event) {
	if(event.which == 13)
		sendFormData();
}

function addFormsEventListeners() {
	let up_link = document.getElementById("up-link");
	let in_link = document.getElementById("in-link");
	
	let firstForm = document.getElementById("log-in");
	let secondForm = document.getElementById("sign-up");

	let in_button = document.getElementById("sign-in-button");
	let up_button = document.getElementById("sign-up-button");
	
	up_link.addEventListener("click", function() {
		firstForm.style.visibility = "hidden";
		secondForm.style.visibility = "visible";
	});
	
	in_link.addEventListener("click", function() {
		firstForm.style.visibility = "visible";
		secondForm.style.visibility = "hidden";
	});
	
	in_button.addEventListener("click", sendFormData);
	up_button.addEventListener("click", sendFormData);
	
	firstForm.style.visibility = "visible";
	
	document.addEventListener("keypress", handleDocumentKeyPress);
}

function handleSuccesfullRequest(event) {
	let data = this.response;

	if(data.indexOf(".php") !== -1) {
		window.location.href = data;
		return;
	}
		
	let lines = data.replace(/\r/g, "").split("\n");
	let firstForm = document.getElementById("log-in");
	let secondForm = document.getElementById("sign-up");
	
	let firstFormInputs = firstForm.getElementsByTagName("input");
	let secondFormInputs = secondForm.getElementsByTagName("input");
	let formsWarnings = document.getElementsByClassName("wrong-input");
	
	if(firstFormInputs.length < 2 || secondFormInputs.length < 3 || lines.length < 10) {
		alert("Serverul nu a transmis destule date sau site-ul a fost alterat!");
		console.warn("Serverul nu a transmis destule date sau site-ul a fost alterat!");
		return;
	}

	if(lines[0] == "red" || lines[0] == "black") {
		firstFormInputs[0].style.borderBottomColor = lines[0];
		firstFormInputs[0].value = "";
		firstFormInputs[1].style.borderBottomColor = lines[1];
		firstFormInputs[1].value = "";
		formsWarnings[0].innerHTML = lines[2];
		firstForm.style.visibility = lines[3];
		
		if(lines[3] == "visible")
			firstFormInputs[0].value = lines[9];
		
		secondFormInputs[0].style.borderBottomColor = lines[4];
		secondFormInputs[0].value = "";
		secondFormInputs[1].style.borderBottomColor = lines[5];
		secondFormInputs[1].value = "";
		secondFormInputs[2].style.borderBottomColor = lines[6];
		secondFormInputs[2].value = "";
		formsWarnings[1].innerHTML = lines[7];
		secondForm.style.visibility = lines[8];
		
		if(lines[8] == "visible")
			secondFormInputs[0].value = lines[9];
	}
	else {
		alert("Raspunsul serverului nu e cel asteptat. Daţi refresh paginii şi încercaţi din nou!");
		console.warn("Raspunsul serverului nu e cel asteptat. Daţi refresh paginii şi încercaţi din nou!");
	}
}

function handleRequestError(event) {
	alert("Conexiunea dintre site şi server nu a putut fi realizată. " + 
		"Asiguraţi-vă că aveţi o conexiune la internet stabilă şi încercaţi din nou!");
}

function handleRequestTimeout(event) {
	alert("Conexiunea dintre site şi server a durat prea mult pentru a putea fi realizată. " +
		"Asiguraţi-vă că aveţi o conexiune la internet stabilă şi încercaţi din nou!");
}

function sendFormData(event) {
	let firstForm = document.getElementById("log-in");
	let secondForm = document.getElementById("sign-up");

	let data;
	if(firstForm.style.visibility == "visible") {
		data = new FormData(firstForm);
		data.append("login", "true");
	}
	else {
		data = new FormData(secondForm);
		data.append("sign-up", "true");
	}
	
	let xhml = new XMLHttpRequest();
	xhml.addEventListener("error", handleRequestError);
	xhml.addEventListener("load", handleSuccesfullRequest);
	xhml.addEventListener("timeout", handleRequestTimeout);
	
	let currentUrlSplit = window.location.href.split('?');
	let requestUrl = "/site/php_scripts/login_scripts/login.php";
	if(currentUrlSplit.length >= 2)
		requestUrl = requestUrl + "?" + currentUrlSplit[1];

	xhml.open("POST", requestUrl);
	xhml.send(data);
}

window.onload = addFormsEventListeners;
