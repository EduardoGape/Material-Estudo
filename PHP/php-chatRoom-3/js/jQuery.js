$(document).ready(function() {

	setInterval(function(){
   $('#bubble').load('member.php .bubble-chat');
}, 5000)

	$(".title-users").click(function() {
		$(".container-online-users").slideDown();
	});

	$(window).load(function() {
		$("#bubble").animate({ scrollTop: $("#bubble").height()}, 1000);
	});

});




