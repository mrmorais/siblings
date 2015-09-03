$(".exercicio-row td").hover(
function() {
	$(this).children("img").fadeTo(200, 0.25).end().children(".hover").show();
}, 
function() {
	$(this).children("img").fadeTo(200, 1).end().children(".hover").hide();
});

$(".personal-inbox").click(function() {
	var chat_inb = $(this).children(".chat-inbox");
	if (chat_inb.attr("class") == "chat-inbox chat-hided") {
		chat_inb.fadeIn(500);
		chat_inb.attr("class", "chat-inbox");
	} else {
		chat_inb.fadeOut(500);
		chat_inb.attr("class", "chat-inbox chat-hided");
	}
});
