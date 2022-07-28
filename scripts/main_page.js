var isDropDownVisible = false;

function handleLoginButtonClick() {
	window.location.href = "./login.php?l=m";
}

function handleUserButtonClick() {
	let dropDown = document.getElementsByClassName("drop-down")[0];
	dropDown.style.top = this.offsetTop + this.offsetHeight + "px";
	dropDown.style.display = "block";
	
	setTimeout(function() {
		isDropDownVisible = true;
	}, 100);
}

function handleDocumentClick(event) {
	if(isDropDownVisible) {
		let dropDown = document.getElementsByClassName("drop-down")[0];
		let dropDownRect = dropDown.getBoundingClientRect();
		let isMouseInsideDropDown = dropDownRect.x <= event.pageX && event.pageX <= dropDownRect.x + dropDownRect.width &&
			dropDownRect.y <= event.pageY && event.pageY <= dropDownRect.y + dropDownRect.height;
	
		if(!isMouseInsideDropDown) {
			dropDown.style.display = "none";
			setTimeout(function() {
				isDropDownVisible = false;
			}, 100);
		}
	}
}

function hideLogoTextIfNotEnoughSpace() {
	let header = document.getElementsByClassName("header")[0];
	let logoImg = header.getElementsByTagName("img")[0];
	let logoText = header.getElementsByTagName("h1")[0];
	let logoHyperlink = header.getElementsByTagName("a")[0];
	let headerButton = window.outerWidth <= 500 ? document.getElementById("aut") : document.getElementById("login");
	if(headerButton == null)
		headerButton = document.getElementById("user");

	let logoTextMarginRight = logoText.offsetLeft + logoText.offsetWidth + (0.1 * window.outerWidth);
	if(logoTextMarginRight >= headerButton.offsetLeft) {
		if(logoText.style.visibility != "hidden")
			logoText.style.visibility = "hidden";
		
		logoHyperlink.style.width = logoImg.offsetWidth + "px";
	}
	else {
		if(logoText.style.visibility != "visible")
			logoText.style.visibility = "visible";
		
		logoHyperlink.style.width = logoImg.offsetWidth + logoImg.offsetWidth  + "px";
	}
	
	logoHyperlink.style.height = header.offsetHeight + "px";
}

function handleWindowResize() {
	if(isDropDownVisible) {
		let dropDown = document.getElementsByClassName("drop-down")[0];
		let userButton = document.getElementById("user");
		dropDown.style.top = userButton.offsetTop + userButton.offsetHeight + "px";
	}
	
	hideLogoTextIfNotEnoughSpace();
}

function handleSuccesfullRequest() {
	location.reload();
}

function handleRequestError(event) {
	alert("Conexiunea dintre site şi server nu a putut fi realizată. " + 
		"Asiguraţi-vă că aveţi o conexiune la internet stabilă şi încercaţi din nou!");
}

function handleRequestTimeout(event) {
	alert("Conexiunea dintre site şi server a durat prea mult pentru a putea fi realizată. " +
		"Asiguraţi-vă că aveţi o conexiune la internet stabilă şi încercaţi din nou!");
}

function handleLogOut() {
	let logoutRequest = new XMLHttpRequest();
	logoutRequest.addEventListener("error", handleRequestError);
	logoutRequest.addEventListener("load", handleSuccesfullRequest);
	logoutRequest.addEventListener("timeout", handleRequestTimeout);
	
	logoutRequest.open("POST", "/site/php_scripts/logout_scripts/logout.php");
	logoutRequest.send();
}

function addElementsEventListeners() {
	let button = document.getElementById("aut");
	if(button != null)
		button.addEventListener("click", handleLoginButtonClick);
	else {
		button = document.getElementById("user");
		button.addEventListener("click", handleUserButtonClick);	
		document.addEventListener("click", handleDocumentClick);
		
		let logoutButton = document.getElementById("logout");
		logoutButton.addEventListener("click", handleLogOut);
	}
	
	hideLogoTextIfNotEnoughSpace();
	window.addEventListener("resize", handleWindowResize);
};

window.onload = addElementsEventListeners;