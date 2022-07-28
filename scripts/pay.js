function createOrderList()
{
    let index = sessionStorage.getItem("itemCount")

    $(".info").append("<div class = 'info-options'></div>");
    $(".info-options").append("<h1>Total = 0€</h1>");
    $(".info-options").append("<div class = 'total'></div>");
    $(".total").append("<div class = 'total-content'></div>");
    $(".total-content").append("<div class = 'total-item'></div>");	

	if(index == null) {
		let totalItem = $(".total-item").last();
		totalItem.append("<p>Niciun camion selectat</p>");
		totalItem.append("<p>0€</p>");
    }
	else {
        index = parseInt(index);
		
		let total = 0;
		for(let i = 1; i <= index; i++) {
			let obj = JSON.parse(sessionStorage.getItem(i.toString()));
            $(".total-content").append("<div class = 'total-item'></div>");
			
			let totalItem = $(".total-item").last();
			totalItem.append("<p>" + obj["amount"] + " x " + obj["name"] + "</p>");
			totalItem.append("<p>" + obj["amount"] * 100 + "€</p>");

			total += obj["amount"] * 100; 
		}

		$(".info-options h1").html("Total = " + total + "€");
    }
}

function handlePayButtonClick()
{
    let index = parseInt(sessionStorage.getItem("itemCount"));

	for(let i = 1; i <= index; i++) {
		sessionStorage.removeItem(index.toString());
	}

    sessionStorage.removeItem("itemCount");
}

$(document).ready(function($) 
{
    $('#ccn').mask("9999 9999 9999 9999");
    createOrderList();
    $("#pay").click(handlePayButtonClick);
})