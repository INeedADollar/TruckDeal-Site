var isSearchBarVisible = false;
var isDropDownVisible = false;

function showSearchBar() {
	$(".header > img").css("visibility", "hidden");
	$(".header > h1").css("visibility", "hidden");
	$(".header > a").first().css("visibility", "hidden")
	$(".search-button").css("visibility", "hidden");
	
	if($("#aut").length) {
		if($("#aut").css("display") == "none")
			$("#login").css("visibility", "hidden");
		else
			$("#aut").css("visibility", "hidden");
	}
	else
		$("#user").css("visibility", "hidden");
	
	let searchBar = $(".search");
	searchBar.css("visibility", "visible");
	searchBar.css("top", "50%");
	$(".search > input").focus();
	
	setTimeout(function() {
		isSearchBarVisible = true;
	}, 150);
}

function handleDocumentClick(event) {
	if(isSearchBarVisible) {
		let searchBarRect = document.getElementsByClassName("search")[0].getBoundingClientRect();
		let isMouseInsideSearchBar = searchBarRect.x <= event.pageX && event.pageX <= searchBarRect.x + searchBarRect.width &&
			   searchBarRect.y <= event.pageY && event.pageY <= searchBarRect.y + searchBarRect.height;
		
		if(!isMouseInsideSearchBar) {
			let searchBar = $(".search")
			searchBar.css("top", "-5vh");
			
			$(".header > img").css("visibility", "visible");
			$(".header > h1").css("visibility", "visible");
			$(".header > a").first().css("visibility", "visible")
			
			moveSearchBarButtonToCorrectPosition();
			$(".search-button").css("visibility", "visible");
			
			if($("#aut").length) {
				if($("#aut").css("display") == "none")
					$("#login").css("visibility", "visible");
				else
					$("#aut").css("visibility", "visible");
			}
			else 
				$("#user").css("visibility", "visible");
			
			setTimeout(function() {
				searchBar.css("visibility", "hidden");
				isSearchBarVisible = false;
			}, 150);
		}
	}
	
	let dropDown = $(".drop-down");
	if(isDropDownVisible) {
		let dropDownRect = document.getElementsByClassName("drop-down")[0].getBoundingClientRect();
		let isMouseInsideDropDown = dropDownRect.x <= event.pageX && event.pageX <= dropDownRect.x + dropDownRect.width &&
			dropDownRect.y <= event.pageY && event.pageY <= dropDownRect.y + dropDownRect.height;
	
		if(!isMouseInsideDropDown) {
			dropDown.css("display", "none");

			setTimeout(function() {
				isDropDownVisible = false;
			}, 100);
		}
	}
}

function moveSearchBarButtonToCorrectPosition() {
	let buttonPosition;
	let searchBarRight;
	
	if($("#aut").length) {
		if($("#aut").css("display") == "none") {
			buttonPosition = $("#login").position();
			searchBarRight = $(window).width() - buttonPosition.left;
			
			$(".search-button").css("right", "calc(" + searchBarRight + "px + 1vw)");
		}
		else {
			buttonPosition = $("#aut").position();
			searchBarRight = $(window).width() - buttonPosition.left;
			
			$(".search-button").css("right", "calc(" + searchBarRight + "px + 1vw)");
		}
	}
	else {
		buttonPosition = $("#user").position();
		searchBarRight = $(window).width() - buttonPosition.left;
			
		$(".search-button").css("right", "calc(" + searchBarRight + "px + 1vw)");
	}
}

function hideLogoTextIfNotEnoughSpace() {
	let header = $(".header");
	let logoImg = $(".header > img");;
	let logoText = $(".header > h1");
	let logoHyperlink = $(".header > a").first();
	let headerButton = $(".search-button");

	if(isSearchBarVisible) {
		if(logoText.css("visibility") != "hidden")
			logoText.css("visibility", "hidden");

		if(logoHyperlink.css("visibility") != "hidden")
			logoHyperlink.css("visibility", "hidden")

		return;
	}

	let logoTextMarginRight = logoText.offset().left + logoText.width() + (0.1 * $(window).width());
	if(logoTextMarginRight >= headerButton.offset().left) {
		if(logoText.css("visibility") != "hidden")
			logoText.css("visibility", "hidden");
		
		logoHyperlink.css("width", logoImg.offsetWidth + "px");
	}
	else {
		if(logoText.css("visibility") != "visible")
			logoText.css("visibility", "visible");
		
		logoHyperlink.css("width", logoImg.offsetWidth + logoImg.offsetWidth  + "px");
	}
	
	logoHyperlink.css("height", header.offsetHeight + "px");
}

function handleWindowResize() {	
	if(isSearchBarVisible) {
		if($("#aut").length) {
			$("#aut").css("visibility", "hidden");
			$("#login").css("visibility", "hidden");
		}
		else
			$("#user").css("visibility", "hidden");
	}
	else {
		moveSearchBarButtonToCorrectPosition();
		
		if($("#aut").length) {
			$("#aut").css("visibility", "visible");
			$("#login").css("visibility", "visible");
		}
		else
			$("#user").css("visibility", "visible");
	}
	
	if(isDropDownVisible) {
		let userButton = document.getElementById("user");
		$(".drop-down").css("top", userButton.offsetTop + userButton.offsetHeight + "px");
	}
	
	hideLogoTextIfNotEnoughSpace();
}
	
function handleSearchBarKeyPress(event) {
	if(event.which == 13)
		window.location.href = "./store.php?q=" + $("#sb").val();
}

function handleSearchBarIconPress() {
	window.location.href = "./store.php?q=" + $("#sb").val();
}

function handleLoginButtonClick() {
	window.location.href = "../html/login.php?l=s";
}

function handleSuccesfullRequest() {
	window.location.href = "./store.php";
}

function handleRequestTimeout(event) {
	alert("Conexiunea dintre site şi server a durat prea mult pentru a putea fi realizată. " +
		"Asiguraţi-vă că aveţi o conexiune la internet stabilă şi încercaţi din nou!");
}

function handleRequestError(event) {
	alert("Conexiunea dintre site şi server nu a putut fi realizată. " + 
		"Asiguraţi-vă că aveţi o conexiune la internet stabilă şi încercaţi din nou!");
}

function handleCompleteRequest(request, status) {
	if(status == "success")
		handleSuccesfullRequest();
	else if(status == "timeout")
		handleRequestTimeout();
	else if(status == "error")
		handleRequestError();
}

function handleLogOut() {
	let index = sessionStorage.getItem("itemCount");

	if(index != null) {
		index = parseInt(index);

		for(let i = 1; i <= 1; i++) 
			sessionStorage.removeItem(i.toString());

		sessionStorage.removeItem("itemCount");
	}

	$.ajax({
		url: "/site/php_scripts/logout_scripts/logout.php",
		data: "",
		dataType: "text",
		complete: handleCompleteRequest
	});
}

function handleAmountChange() {
	let truckName = $(this).parent().siblings()[1].innerHTML;
	let index = parseInt(sessionStorage.getItem("itemCount"));

	for(let i = 1; i <= index; i++) {
		let item = sessionStorage.getItem(i.toString());
		if(item != null) {
			item = JSON.parse(item);
			if(item["name"] == truckName) {
				let prevAmount = item["amount"];

				item["amount"] = parseInt(this.value);
				sessionStorage.setItem(i.toString(), JSON.stringify(item));
				
				let total = $(".total h1")[0];
				let prevTotal = parseInt(total.innerHTML.split(" ").at(-1).slice(0, -1));
				console.log(prevTotal);
				total.innerHTML = "Total = " + (prevTotal - (prevAmount * 100) + (item["amount"] * 100)) + "€";

				let totalItemP = $(".total-item").children("p");
				let totalItem = totalItemP[2 * (i - 1)];
				totalItem.innerHTML = item["amount"] + " x" + totalItem.innerHTML.split("x")[1];

				let totalItemPrice = totalItemP[2 * (i - 1) + 1];
				totalItemPrice.innerHTML = item["amount"] * 100 + "€";
			}
		}
	}
}

function handleItemXClick() {
	let itemToDelete = $(this).parent();
	let truckName = itemToDelete.children("p")[0].innerHTML;
	
	let index = parseInt(sessionStorage.getItem("itemCount"));
	let itemFound = false;
	for(let i = 1; i <= index; i++) {
		let item = sessionStorage.getItem(i.toString());
		if(item != null) {
			if(itemFound) {
				sessionStorage.setItem((i - 1).toString(), item);
				continue;
			}

			item = JSON.parse(item);

			if(item["name"] == truckName) {
				itemFound = true;

				let amount = item["amount"];
				sessionStorage.removeItem(i.toString());

				if(index == 1) {
					sessionStorage.removeItem("itemCount")

					let wtrucksOverview = $(".wtrucks-overview");
					wtrucksOverview.empty();
					wtrucksOverview.remove();

					handleWTrucksClick();
				}
				else {
					sessionStorage.setItem("itemCount", (index - 1).toString());
					$(".total-item").eq(i - 1).remove();

					let total = $(".total h1")[0];
					let prevTotal = parseInt(total.innerHTML.split(" ").at(-1).slice(0, -1));
					total.innerHTML = "Total = " + (prevTotal - (amount * 100)) + "€";
				}

				itemToDelete.empty();
				itemToDelete.remove();
			}
		}
	}

	sessionStorage.removeItem(index.toString());
}

function handleWTrucksClick() {
	$(".drop-down").css("display", "none");

	setTimeout(function() {
		isDropDownVisible = false;
	}, 100);

	$(document.documentElement).append("<div class = 'wtrucks-overview'></div>");

	let wtrucksOverview = $(".wtrucks-overview");
	wtrucksOverview.append("<h1 id = 'wtrucks-title'>Camioane în așteptare</h1>");
	wtrucksOverview.append("<div class = 'trucks-container'></div>");
	
	wtrucksOverview.append("<div class = 'info-options'></div>");
	$(".info-options").append("<div class = 'total'></div>");
	$(".info-options").append("<div class = 'buttons'></div>");

	let index = sessionStorage.getItem("itemCount")

	if(index == null) {
		$(".trucks-container").append("<div class = 'truck'></div>");
		$(".truck").append("<p id = 'no-truck'>Niciun camion în așteptare!</p>");
		$(".total").append("<h1>Total = 0€</h1>");
		$(".total").append("<div class = 'total-content'></div>");
		$(".total-content").append("<div class = 'total-item'></div>");

		let totalItem = $(".total-item").last();
		totalItem.append("<p>Niciun camion selectat</p>");
		totalItem.append("<p>0€</p>");

		$(".buttons").append("<button type = 'button' id = 'back-button'>Înapoi</button>");
		$("#back-button").click(function () {
			wtrucksOverview.empty();
			wtrucksOverview.remove();
		});
	}
	else {
		$(".total").append("<h1></h1>");
		$(".total").append("<div class = 'total-content'></div>");

		$(".buttons").append("<button type = 'button' id = 'pay-button'>Plătește</button>");
		$(".buttons").append("<button type = 'button' id = 'back-button'>Înapoi</button>");
		$("#pay-button").click(function () {
			window.location.href = "./pay.php";
		});
		$("#back-button").click(function () {
			wtrucksOverview.empty();
			wtrucksOverview.remove();
		});

		index = parseInt(index);
		
		let total = 0;
		for(let i = 1; i <= index; i++) {
			let obj = JSON.parse(sessionStorage.getItem(i.toString()));
			$(".trucks-container").append("<div class = 'truck'></div>");

			let truck = $(".truck").last();
			truck.append("<img src = '" + obj["img"] + "'>");
			truck.append("<p id = 'truck-name'>" + obj["name"] + "</p>");
			truck.append("<div class = 'prices'></div>");

			let prices = $(".prices").last();
			prices.append("<p class = 'old-price-l'>" + obj["old_price"] + "</p>");
			prices.append("<p class = 'new-price-l'>" + obj["new_price"] + "</p>");

			truck.append("<div class = 'transport'></div>");

			let transport = $(".transport").last();
			transport.append("<p>Transport Gratuit</p>");

			console.log(obj["transport"]);
			if(obj["transport"] == true)
				transport.append("<p id = 'checked'>✔</p>");
			else
				transport.append("<p id = 'not-checked'>✖</p>");

			truck.append("<div class = 'amount-container'></div>");

			let amountContainer = $(".amount-container").last();
			amountContainer.append("<p>Cantitate</p>");
			amountContainer.append("<select class = 'amount'>");

			let amount = $("select").last();
			amount.on("change", handleAmountChange);
			amount.append("<option value = '1'>1</option>");

			for(let j = 2; j <= 50; j++)
				amount.append("<option value = '" + j + "' selected = ''>" + j + "</option>");

			$(".amount option[value='" + obj["amount"] + "']").last().prop("selected", "selected");
			truck.append("<div class = 'remove' title = 'Scoate acest camion din lista'>X</div>");
			$(".remove").last().click(handleItemXClick);

			$(".total-content").append("<div class = 'total-item'></div>");
			
			let totalItem = $(".total-item").last();
			totalItem.append("<p>" + obj["amount"] + " x " + obj["name"] + "</p>");
			totalItem.append("<p>" + obj["amount"] * 100 + "€</p>");

			total += obj["amount"] * 100; 
		}

		$(".total h1").html("Total = " + total + "€");
	}
}

function handleUserButtonClick() {
	let dropDown = $(".drop-down");
	dropDown.css("top", this.offsetTop + this.offsetHeight + "px");
	dropDown.css("display", "block");

	setTimeout(function() {
		isDropDownVisible = true;
	}, 100);
}

function handleYesButtonClick() {
	$("#yes-btn").css("display", "none");
	$("#no-btn").css("display", "none");
	$(".dialog > p:nth-child(1)").css("display", "none");
	
	$(".dialog > p:nth-child(2)").css("display", "initial");
	$("#ok-btn").css("display", "initial");
}

function handleNoButtonClick() {
	$(".modal").css("visibility", "hidden");
	$(".modal").css("opacity", "0");
	$(".dialog > p:nth-child(2)").css("display", "initial");
	$("#ok-btn").css("display", "initial");
}

function handleOkButtonClick() {
	$(".modal").css("visibility", "hidden");
	$(".modal").css("opacity", "0");
	$(".dialog > p:nth-child(1)").css("display", "initial");
	$("#yes-btn").css("display", "initial");
	$("#no-btn").css("display", "initial");
}

function handleItemButtonClick() {
	let buttonSiblings = $(this).siblings()

	let item = {
		name: buttonSiblings[buttonSiblings.length == 7 ? 4 : 1].innerHTML,
		img: buttonSiblings[buttonSiblings.length == 7 ? 3 : 0].src,
		old_price: buttonSiblings[buttonSiblings.length == 7 ? 5 : 2].innerHTML,
		new_price: buttonSiblings[buttonSiblings.length == 7 ? 6 : 3].innerHTML,
		transport: (buttonSiblings.length == 7),
		amount: 1
	};

	let index = 1;
	let amount = 1;
	let elementFound = false;

	if(sessionStorage.getItem(index.toString()) != null) {
		index = parseInt(sessionStorage.getItem("itemCount"));

		for(let i = 1; i <= index; i++) {
			let currentItem = sessionStorage.getItem(i.toString());
			if(currentItem != null) {
				currentItem = JSON.parse(currentItem);

				if(currentItem["name"] == item["name"]) {
					amount = (currentItem["amount"] < 50 ? currentItem["amount"] + 1 : 50);
					elementFound = true;
					index = i;
					break;
				}
			}
		}

		if(!elementFound) {
			index += 1;
			sessionStorage.setItem("itemCount", index.toString());
		}
	}
	else
		sessionStorage.setItem("itemCount", "1");


	item["amount"] = amount;
	sessionStorage.setItem(index, JSON.stringify(item));

	if(!$("#user").length) {
		let currentUrlSplit = window.location.href.split('?');
		let loginUrl = "./login.php?l=s";
		
		if(currentUrlSplit.length >= 2)
			window.location.href = loginUrl + "&" + currentUrlSplit[1] + "&d=t";
		else
			window.location.href = loginUrl + "&d=t";
		
		return;
	}

	$(".modal").first().css("visibility", "visible");
	$(".modal").first().css("opacity", "100");
	$(".ok-btn").first().click(handleOkButtonClick);
}

function showSuccesfullPayDialog() {
	$(".modal").eq(1).css("visibility", "visible");
	$(".modal").eq(1).css("opacity", "100");
	$(".ok-btn").eq(1).click(handleOkButtonClick);
}

$(document).ready(function() {
	if($("#aut").length)
		$("#aut").click(handleLoginButtonClick);
	else
		$("#user").click(handleUserButtonClick);
	
	setTimeout(function() {
		moveSearchBarButtonToCorrectPosition();
		$(".search-button").css("visibility", "visible");
	}, 300);
	
	$(".search-button").click(showSearchBar);
	$("#sb").keypress(handleSearchBarKeyPress);
	$("#si").click(handleSearchBarIconPress);
	$("#wtrucks").click(handleWTrucksClick);
	$("#logout").click(handleLogOut);
	
	$(".item > button").click(handleItemButtonClick);
	$(document).mousedown(handleDocumentClick);
	$(window).resize(handleWindowResize);
	
	if(window.location.href.indexOf("d=t") !== -1)
		handleItemButtonClick();

	if(window.location.href.indexOf("p=s") !== -1)
		showSuccesfullPayDialog();
});