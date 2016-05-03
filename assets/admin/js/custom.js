$(function () {
	$(".select2").select2();

	$('.select2-artist').select2({
		minimumInputLength: "3",
		  ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
           url: base_url+"dashboard/search_artist",
            dataType: 'json',
            quietMillis: 300, 
            data: function (term, page) {
                return {
                    q: term, // search term
                    page_limit: 10                    
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.                                
                return {results: data.artist};
            }
        }	  
	});

	$('.select2-song').select2({
		minimumInputLength: "3",
		  ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
           url: base_url+"dashboard/search_song",
            dataType: 'json',
            quietMillis: 300, 
            data: function (term, page) {
                return {
                    q: term, // search term
                    page_limit: 10                    
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.                
                return {results: data.songs};
            }
        }	  
	});

    $('*[data-toggle="popover"]').popover();

    $(".btn-search-station").click(function(event) {
        var query = $("#station_search").val();
        $(this).text("Searching....");
        $("#resulttunein").empty();        
        $.post(base_url+"dashboard/tunein", {query:query,type:"search"}, function(data, textStatus, xhr) {
            $(".btn-search-station").text("Go!");
            $.each(data, function(index, val) {
               // if(val.CanEmbed == true && val.CanPlay == true)
                if(val.CanPlay == true)
                    $("#resulttunein").append("<div style='width:100%;height100px;position:relative'><button class='btn btn-success btn-addstation' data-id='"+val.PlayGuideId+"' style='position:absolute;right:10px;margin-top:10px;'><i class='fa fa-plus'></i></button><iframe src='http://tunein.com/embed/player/"+val.PlayGuideId+"/'' style='width:100%;height:100px;' scrolling='no' frameborder='no'></iframe></div>");
            });
        });
    });

    $('#station_search').on('keypress', function(event) {        
            if(event.keyCode==13){
                $(".btn-search-station").click();
            }
        });

$(".colorpicker").colorpicker();
    $(document).on('click', '.btn-addstation', function(event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        $(this).text("Saving...");
        $(this).attr("disable","disable");
        $.post(base_url+"dashboard/tunein", {id:id,type:"save"}, function(data, textStatus, xhr) {
            alert(data.msg);
            location.href = base_url+"dashboard/stations";
        });
    });
});