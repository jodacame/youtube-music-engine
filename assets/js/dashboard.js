$("#login").click(function(event) {	
	var email 		= $("#email").val();
	var password 	= $("#password").val();
	$.post(base_url+"dashboard/login/", {email:email,password:password}, function(data, textStatus) {
		$("#target").html(data);
	});
});
$(".logout").click(function(event) {		
	$.post(base_url+"dashboard/logout/", false, function(data, textStatus) {
		$("#target").html(data);
	});
});
$(".trgadmin").click(function(event) {
	var target = $(this).attr("data-target");
	show_loading('targetAdmin');
	$.post(base_url+"dashboard/module/"+target, false, function(data, textStatus) {
		$("#targetAdmin").html(data);		
	});

});
$(".adsblock").hide();