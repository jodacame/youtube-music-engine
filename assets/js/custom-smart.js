var radio 			= false;
var searchingRadio	= false;
var currentRadio 	= 0;
var animation 		= false
var ytplayer;
var currentSong 	= 0;
var searching 		= false;
var PlaylistNumber 	= "playlist_1";
var errors 			= 0;
var adsAudio 		= '';
var tempVideo 		= '';
$(function() {




	// hide buttons
	$("#play").hide();
	$("#amazon").hide();
	$("#lyric").hide();
	$("#downloadmp3").hide();
	$("#shareMenu").hide();
	$("#nowPlaying").hide();

	getActividySider();

	myPlaylist(true);
	var searchAjax = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,          
      remote: base_url+'music/typeahead/?query=%QUERY'
    });         
    searchAjax.initialize();         
    $('#s').typeahead(null, {
      name: 'text',
      displayKey: 'value',
      source: searchAjax.ttAdapter(),
      templates: {
          suggestion: Handlebars.compile(['<div id="list-search" onClick="search(\'{{value}}\')" class="list-group"> <a href="#" class="list-group-item"><div class="row">',
            '<div class="col-xs-1 hidden-xs hidden-sm" style="width:54px"><img style="height:48px" src="{{image}}"></div>',        
            '<div class="col-xs-11">{{name}}<br style="margin:0px"><small><i>{{artist}}</i></small></div></div></a></div>'
          ].join(''))
        }
    }); 



	$('#volume').slider().on('slide', function(ev){ 	
		setVolume(ev.value);
	});

	$(".removehref").attr("href","#");
	if($("#files").length)
	  document.getElementById('files').addEventListener('change', handleFileSelect, false);

	if(localStorage.getItem('playlist_active') != '')
		PlaylistNumber 	= localStorage.getItem('playlist_active');
	loadPlayList();
	$("#btnSearch").click(function(event) {
		var query = $("#s , .searchField").val();
		if(query.length>1)
		{
			search(query);
		}
	});
	$('input#s ,.searchField').keypress(function(e) {
	  if (e.which == '13') {
	     e.preventDefault();
	     $("#btnSearch").click();
	   }
	});

	$("#nowPlaying").click(function(event) {
		$(this).toggleClass('active');
		if($(this).attr("class") == "active")
			getArtistInfo(getCurrentArtist());
	});
	
	$("#changePlaylist li,#changePlaylist2 li").click(function(event) {

		if($(this).attr("data-playlist") != undefined)
		{
			PlaylistNumber 	= "playlist_"+$(this).attr("data-playlist");
			console.log(PlaylistNumber);
			loadPlayList();			
		}
		
	});

	var hash   = window.location.hash;
     hash       = hash.substring(3); // remove #
     hash       = hash.replace(/-/g, ' ');
     hash       = hash.replace("/"," - ");

     if(hash !='' && hash != 'login')
     {
        $("#s").val(hash);                
     }
     if(hash == 'login')
     {     	
     	$("#loginModal").modal("show");
     }

     window.onpopstate = function(event) {

				//$('#s').val(location.search.replace( /[-]+/g, " ").replace("?s=","").replace("?artist=","").replace("&track="," "));				
		
	};


	$("#topArtist").click(function(event) {
		getTopArtist();
	});	

	$("#menuLogin").click(function(event) {
		$("#loginModal").modal("show");
	});	
	$("#downloadmp3").click(function(event) {
		downloadmp3();
	});
	$("#save_as_playlist").click(function(event) {
		myPlaylist();
	});
	$("#amazon").click(function(event) {
		buyAmazon();
	});
	$("#lyric").click(function(event) {
		getLyric();
	});
	$("#topTrack").click(function(event) {
		getTopTracks();
	});
	$("#random").click(function(event) {
		if($(this).attr("class") == 'active')
		{
			$(this).removeClass('active');
		}
		else
		{
			$(this).addClass('active');
		}
	});

	$("#tags li a").click(function(event) {
		var tag = $(this).attr("data-tag");
		getTopTags(tag);
	});
	$("#tagsLink").click(function(event) {		
		getTopTags("");
	});

	$("#videoPlayer").click(function(event) {
		if($("#playlist-items a").length <=0 || getCurrentArtist() == ''  || getCurrentArtist() == null || getCurrentArtist() == undefined)
		{
			return false;
		}
		if($(this).attr("class") == 'active')
		{
			$(this).removeClass('active');
			$("#thumbnail").addClass('hidePlayer');
			$("#amazon").fadeIn(500);
		}
		else
		{
			$(this).addClass('active');
			$("#thumbnail").removeClass('hidePlayer');			
			$("#amazon").hide();
		}
	});

	$("#playlist-items:not('.exclude')").height($(window).height()-320+"px");
	$(window).resize(function(event) {
		$("#playlist-items:not('.exclude')").height($(window).height()-320+"px");
	});

	$('*[title]').tooltip({placement: "auto"});
	$("*[data-toggle='tooltip']").tooltip();
	$("#playlist-items").contextMenu({
	    menuSelector: "#contextMenu",
	    menuSelected: function (invokedOn, selectedMenu) {

	    	console.log(selectedMenu);
	    	var action = $(selectedMenu).attr("data-action");
	    	if(action == 'remove')	    	
	    		removePlayList($(invokedOn));
	    	if(action == 'playThis')	    	
	    		playThis($(invokedOn));
	    	if(action == 'getlyric')
	    	{
	    		obj = $(invokedOn).closest('a');
	    		getLyric($(obj).attr("data-artist"),$(obj).attr("data-track"));
	    	}	    	
	    		
	    	if(action == 'addto')
	    	{
	    		obj = $(invokedOn).closest('a');
	    		var data = [{track:$(obj).attr("data-track"), artist:$(obj).attr("data-artist"), cover:$(obj).attr("data-cover")}];	    			    		
	    		addToPlayListDB($(selectedMenu).attr("data-id"),JSON.stringify(data));
	    	}	    	
	    		
	    	
	        /*var msg = "You selected the menu item '" + selectedMenu.text() +
	            "' on the value '" + invokedOn.text() + "' and action = "+action;
	        alert(msg);*/
	    }
	});

	
	 
	
});



function share(t,link)
{	
	if(getCurrentArtist() == '')
		return false;
	if(t == 'fb')
		window.open("https://www.facebook.com/sharer/sharer.php?u="+(base_url+"?s="+slug(getCurrentArtist())+"-"+slug(getCurrentTrack())));
	if(t == 'tw')
		window.open("https://twitter.com/home?status="+(base_url+"?s="+slug(getCurrentArtist())+"-"+slug(getCurrentTrack())));
	if(t == 'gp')
		window.open("https://plus.google.com/share?url="+(base_url+"?s="+slug(getCurrentArtist())+"-"+slug(getCurrentTrack())));
	if(t == 'c')
	{
		$("#customShare textarea").html((base_url+"?s="+slug(getCurrentArtist())+"-"+slug(getCurrentTrack())));
		$("#customShare").modal("show");
	}

	
}


function custom_share(t,link)
{	
	if(t != 'c')
		link = encodeURIComponent(link);
	
	if(t == 'fb')
		window.open("https://www.facebook.com/sharer/sharer.php?u="+(link));
	if(t == 'tw')
		window.open("https://twitter.com/home?status="+(link));
	if(t == 'gp')
		window.open("https://plus.google.com/share?url="+(link));
	if(t == 'c')
	{
		$("#customShare textarea").html(link);
		$("#customShare").modal("show");
	}

	
}

function downloadmp3()
{
	try{
		
		var video 	= ytplayer.getVideoUrl().replace("feature=player_embedded&","");
		var videoID = youtube_parser(video);
		var url_download = download_service.replace("%youtube_url%",video);
		var url_download = url_download.replace("%youtube_video%",videoID);

		window.open(url_download);
		//window.open("//youtube.andthemusic.net?url="+(video.replace("feature=player_embedded&","")));
		//window.open("http://youtube.andthemusic.net?url="+encodeURIComponent(video.replace("feature=player_embedded&","")));
	}catch(e)
	{

	}
}

function buyAmazon()
{
	try{	
		var amazonID = $("#amazon").attr("data-amazon");
		if(amazonID == '')
		{
			alert("Pls Configure your Amazon ID");
			return false;
		}
		if(getCurrentArtist() != '')
		{
			var query = getCurrentArtist() + " - "+getCurrentTrack();		
			window.open("http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=music&keywords="+encodeURIComponent(query)+"&linkCode=ur2&tag="+amazonID);
		}		
		
	}catch(e)
	{

	}

}


function buyOnAmazon(query)
{
	try{	
		var amazonID = $("#amazon").attr("data-amazon");
		if(amazonID == '')
		{
			alert("Pls Configure your Amazon ID");
			return false;
		}
		window.open("http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=music&keywords="+encodeURIComponent(query)+"&linkCode=ur2&tag="+amazonID);					
	}catch(e)
	{

	}

}

function getCurrentArtist()
{
	var item = $("#playlist-items a.active");
	var artist = $(item).attr("data-artist");
	if(artist == undefined || artist == null)
		artist = '';
	return artist;
}
function getCurrentTrack()
{
	var item = $("#playlist-items a.active");
	var track =  $(item).attr("data-track");
	if(track == undefined || track == null)
		track = '';
	return track;
}

function getLyric(artist,track)
{

	if(!artist)
		artist 	= getCurrentArtist();
	if(!track)
	track 	= getCurrentTrack();
	if(artist == '' || artist == undefined || artist == 'undefined' || artist == null)
		return false;
	show_loading();	
	$.get(base_url+"music/getLyric/", {artist:artist,track:track}, function(data, textStatus) {
		$("#target").html(data);
	});


}

function showPage(id)
{


	show_loading();	
	$.get(base_url+"music/getPage/"+id, false, function(data, textStatus) {
		$("#target").html(data);
	});


}
var timerActivity;
function showActivity(force)
{	
	if(force == true)
		show_loading();	

	if(force == undefined || force == null)
		force = false;

	if($("#timeline").length > 0 || force == true)
	{
		clearInterval(timerActivity);
		$.get(base_url+"music/getActivity/", false, function(data, textStatus) {
			$("#target").html(data);
		});	
	}
	


}


if($("#activitySider").length > 0)
{
	setInterval(function(){getActividySider()}, 5000);
}

function getActividySider()
{
	if($("#activitySider").length > 0)
	{
		$.post(base_url+"music/getActivity/", {json:1}, function(data, textStatus) {
			$("#activitySider ul").empty();
			$.each(data, function(index, val) {
				var _item = $('<li id="activity-'+val.idactivity+'" class="list-group-item" style="display:block"><img src="'+val.avatar+'" class="pull-left cursor-pointer thumbnail"><strong style="cursor:pointer" onClick="profile(\''+val.nickname+'\')">'+val.nickname+' </strong><button onclick="addPlayList(\''+val.track.replace("'","\\'")+'\',\''+val.artist.replace("'","\\'")+'\',\''+val.picture+'\',true)" class="btn btn-xs btn-default pull-right"><i class="fa fa-play"></i></button> <br><span  onClick="getArtistInfo(\''+val.artist.replace("'","\\'")+'\')"  style="cursor:pointer">'+val.artist+'</span><br> <span onClick="getSongInfo(\''+val.artist.replace("'","\\'")+'\',\''+val.track.replace("'","\\'")+'\')"  style="cursor:pointer" class=""cursor:pointer;text-muted"><i class="fa fa-music"></i> '+val.track+'</span><br><span class="pull-right">'+val.date+'</span></li>');
				if($('#activity-'+val.idactivity).length == 0)
				{
					$("#activitySider ul").append(_item);
					
				}
			});
		},'json');	
	}
}

function myPlaylist(json)
{	
	
	if(!json)
	{
		show_loading();	
		$.get(base_url+"music/myPlaylist/", null, function(data, textStatus) {
			$("#target").html(data);
		});	
		myPlaylist(true);
	}
	else
	{
		if(extend == "0")
			return false;
		$("#playlistSaved")	.html("<li><a href=''#>Loading...</a></li>");
		$.get(base_url+"music/myPlaylist/1", null, function(data, textStatus) {
			$("#playlistSaved").html(data);
		});	

		
	}

	


}

function profile(id)
{
	if(id == null || id == undefined)
		id = 0;
	show_loading();	
	$.get(base_url+"music/profile/"+id, {id:id}, function(data, textStatus) {
		$("#target").html(data);		
	});	

}
function removePlayList(obj)
{
	
	$(obj).closest('a').remove();
	$("#numItems").text($("#playlist-items a").length);
	savePlayList();
}
function show_loading(target)
{
	if(!target)
		target = 'target';
	$("#"+target).html('<div id="circleG"><div id="circleG_1" class="circleG"></div><div id="circleG_2" class="circleG"></div><div id="circleG_3" class="circleG"></div>');
}
function showPopUp()
{
	  $('div#popup').modal({
                keyboard:false,
                backdrop:false
        }).modal('show');  
}
function search(query)
{
	$('#s').trigger('blur');
	show_loading();	
	$.get(base_url+"music/search/"+slug(query), {query:query}, function(data, textStatus) {
		$("#target").html(data);
	});
}

function search_artist(query)
{
	$('#s').trigger('blur');		
	$.get(base_url+"music/searchArtist/"+slug(query), {query:query}, function(data, textStatus) {
		$("#search-artist").html(data);
	});
}


function getTopArtist()
{
	show_loading();	
	$.get(base_url+"music/getTopArtist/", false, function(data, textStatus) {
		$("#target").html(data);
	});
}
function getTopTracks()
{
	show_loading();	
	$.get(base_url+"music/getTopTracks/", false, function(data, textStatus) {
		$("#target").html(data);
	});
}
function getTopTags(tag)
{
	show_loading();	
	$.get(base_url+"music/getTopTags/"+slug(tag), {tag:tag}, function(data, textStatus) {
		$("#target").html(data);
	});
}
function getArtistInfo(artist)
{

	artist = artist.replace( /[']+/g, "");
	artist = artist.replace( "/", "-");
	console.log(artist);
	if(artist == '' || artist == undefined || artist == 'undefined' || artist == null)
		return false;
	show_loading();	
	$.get(base_url+"music/getArtistInfo/"+slug(artist), {artist:artist}, function(data, textStatus) {
		$("#target").html(data);
	});
}
function getSongInfo(artist,track)
{
	artist = artist.replace( /[']+/g, "\'");
	artist = artist.replace( "/", "-");
	track = track.replace( /[']+/g, "\'");
	track = track.replace( "/", "-");

	
	if(artist == '' || artist == undefined || artist == 'undefined' || artist == null || track == undefined || track == null)
		return false;
	show_loading();	
	$.post(base_url+"music/getSongInfo/", {artist:artist,track:track}, function(data, textStatus) {
		$("#target").html(data);
		var stateObj = { foo: "bar" };
		history.pushState(stateObj, "", base_url+"?artist="+artist.replace(/ +/g,"-")+"&track="+track.replace(/ +/g,"-"));
	});
}

function like(id,obj)
{

	$.post(base_url+"music/likeActivity/", {id:id}, function(data, textStatus) {
		$(".like",$(obj)).html(data);
		$(obj).attr("disabled","disabled");
	});
}
function getAlbums(artist)
{	
	if(artist == '' || artist == undefined || artist == 'undefined' || artist == null)
		return false;
	show_loading();	
	$.get(base_url+"music/getAlbums/"+slug(artist), {artist:artist}, function(data, textStatus) {
		$("#target").html(data);
	});

}

function getEvents(artist)
{	
	if(artist == '' || artist == undefined || artist == 'undefined' || artist == null)
		return false;
	show_loading();	
	$.get(base_url+"music/getEvents/"+slug(artist), {artist:artist}, function(data, textStatus) {
		$("#target").html(data);
	});

}
function getTracksAlbum(album,artist)
{	
	if(artist == '' || artist == undefined || artist == 'undefined' || artist == null)
		return false;
	show_loading();	
	$.get(base_url+"music/getTracksAlbums/"+slug(artist)+"/"+slug(album), {artist:artist,album:album}, function(data, textStatus) {
		$("#target").html(data);
	});

}

function clearPlaylist(){
	$("#playlist-items").empty();
	savePlayList();
	$("#numItems").text($("#playlist-items a").length);
}
function addAlltoPlaylist()
{
	$(".addTrg").click();
}

function addPlayList(track,artist,cover,play,key)
{
	track = track.replace( /[']+/g, "\'");
	artist = artist.replace( /[']+/g, "\'");


	if($( "#playlist-items a" ).length == 500)
	{
		$.smallBox({title:"Error",content:error_max,timeout:3000});	
	}
	
	if($( "#playlist-items a" ).length >= 500)
	{		
		return false;
	}
	
	

	if(!key)
		key = "";
	if(key != '')
	{
		if($("."+key).length>0 && 	$("#playlist-items li").length<50)
		{
			console.log("Duplicate Track "+track+" - "+artist+ " - key: "+key);
			getNextSongRadio(track,artist);
			return false;
		}
	}
	
	var item = $('<a data-track="'+track+'" data-artist="'+artist+'" data-cover="'+cover+'" href="#" onClick="return false;" class="list-group-item '+key+'"><span class="pull-right"><button class="btn btn-danger btn-xs" onClick="removePlayList(this)"><i class="fa fa-trash-o"></i></button> <button class="btn btn-primary btn-xs" onClick="playThis(this);"><i class="fa fa-play"></i></button></span><span class="glyphicon glyphicon-music"></span> '+track+'<span  onClick="getArtistInfo(\''+artist+'\');" title="Get Artist Info" class="text-muted"> by '+artist+'</span></a>');
	$("#playlist-items").append(item); 
	savePlayList();
	if(play)
	{		
		playThis(item);
	}

	$( "#playlist-items" ).sortable(
	{
		update: function( event, ui ) {savePlayList();},
		items: "a:not(.active)"
	});

	//$("#playlist-items").dragsort("destroy");/


	if(animation == true)
		return false;

	/*animation = true;
	$("#playlist-items").animate({
        scrollTop: item.offset().top
    }, 2000, function() {
    	animation = false;
  	});*/
	$("#numItems").text($("#playlist-items a").length);
}
function getNextSongRadio(track,artist)
{
	if(searchingRadio == true)
		return false;
	if(currentRadio > 10)
		return false;
	searchingRadio = true;
	console.log("Buscando relacionado con "+artist+" "+track);	
	$.getJSON(base_url+'music/getRelated/'+slug(track)+"/"+slug(artist)+"/"+currentRadio, {track:track,artist:artist}, function(json, textStatus) {		
			searchingRadio = false;
			if(json.track != null)
				addPlayList(json.track,json.artist,json.cover,false,json.key2);
			
	});
	currentRadio++;
	console.log("currentRadio: "+currentRadio);
	
}
function start_radio(track,artist,cover)
{
	if(track == '' || artist == '')
		return false;
	clearPlaylist();
	addPlayList(track,artist,cover,true);
	radio = true;
}
function stop_radio()
{
	radio = false;
}
function slug(str) {
	str = str.replace( /[' ']+/g, '-');
	str = str.replace( /['&']+/g, 'and');
	str = str.replace( /['(']+/g, '-');
	str = str.replace( /[')']+/g, '-');
	return str;
   //return normalize(str);
}

function setVolume(newVolume) {
  if (ytplayer) {
    ytplayer.setVolume(newVolume);
  }
}

function getVolume() {
  if (ytplayer) {
    return ytplayer.getVolume();
  }
}

function hhmmss(secs)
{
	var sec_num = parseInt(secs, 10); // don't forget the second parm
	var hours   = Math.floor(sec_num / 3600);
	var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
	var seconds = sec_num - (hours * 3600) - (minutes * 60);
	if (hours   < 10) {hours   = "0"+hours;}
	if (minutes < 10) {minutes = "0"+minutes;}
	if (seconds < 10) {seconds = "0"+seconds;}
	var time    = hours+':'+minutes+':'+seconds;
	return time;                     
}

var normalize = (function() {
  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
      to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      mapping = {};
 
  for(var i = 0, j = from.length; i < j; i++ )
      mapping[ from.charAt( i ) ] = to.charAt( i );
 
  return function( str ) {
  		str = str.replace( /[,]+/g, '%2C');
  		str = str.replace( /['']+/g, '%27');
      var ret = [];
      for( var i = 0, j = str.length; i < j; i++ ) {
          var c = str.charAt( i );
          if( mapping.hasOwnProperty( str.charAt( i ) ) )
              ret.push( mapping[ c ] );
          else
              ret.push( c );
      }
      return ret.join( '' ).replace( /[^-A-Za-z0-9%]+/g, '-' ).toLowerCase();
 } 
})();
/* PLAYER */
$(function() {	
	$("#play").click(function(event) {
		errors = 0;
		play();
	});

	$("#current.progress").on('click',function(e){	  
		var parentOffset = $(this).parent().offset(); 	
	    var relX = e.pageX - parentOffset.left;     
	    var pos  = (100 * relX)/($(this).width());
	    if(pos <0) pos = 0;
	    if(pos >100) pos = 100;
	    $("#current .progress-bar" ).width(pos+"%");
	    var size2 = $("#current.progress" ).width();
	    var size = $("#current .progress-bar").width();
	    var current = (size*100)/size2;
	    var duracion = getDuration();
	    if(current <0) current = 0;
	    if(current > duracion) current = duracion;    
	    var pos = ((duracion * current)/100)-1;
	    seekTo(pos);		
  	});

	
});

function onYouTubeIframeAPIReady() {
	console.log("Ready Youtube");

  }

function playThis(obj)
{
	obj 		= $(obj).closest('a');
	currentSong = $(obj).index();	
	playNextSong($(obj).index());
}
function playNextSong(index)
{

	
	$("#play").hide();
	$("#pause").show();

	console.log(getPlayerState());
	currentRadio = 0;
	if(index == 0 && getPlayerState() == 2)
	{
		errors = 0;
		play();
		return false;
	}

	
	if($("#random").attr("class") == 'active')
	{
		var currentSongP = currentSong;
		currentSong = Math.floor((Math.random()*$("#playlist-items a").length)+0);
		if(currentSongP == currentSong)
			currentSong = Math.floor((Math.random()*$("#playlist-items a").length)+0);
		if(currentSongP == currentSong)
			currentSong = Math.floor((Math.random()*$("#playlist-items a").length)+0);
		if(currentSongP == currentSong)
			currentSong = Math.floor((Math.random()*$("#playlist-items a").length)+0);
		if(currentSongP == currentSong)
			currentSong = Math.floor((Math.random()*$("#playlist-items a").length)+0);
	}
	else
	{
		if(adsAudio == '')
			currentSong++;	
		else
			adsAudio = '';
	}
	
	if(index || index == 0)
		currentSong=index;
	if(currentSong >= $("#playlist-items a").length)
		currentSong = 0;
	$("#playlist-items a.active").removeClass('active');
	var item = $("#playlist-items a").get(currentSong);
	
	//window.location.hash 	= "#!/"+$(item).attr("data-artist")+"/"+$(item).attr("data-track");
	var stateObj = { foo: "bar" };
	//history.pushState(stateObj, "", "?s="+jQuery.trim($(item).attr("data-artist").replace(/ +/g,"-"))+"-"+jQuery.trim($(item).attr("data-track").replace(/ +/g,"-")));
	history.pushState(stateObj, "", base_url+"?artist="+jQuery.trim($(item).attr("data-artist").replace(/ +/g,"-"))+"&track="+jQuery.trim($(item).attr("data-track").replace(/ +/g,"-")));


    document.title 			= $(item).attr("data-track") + " | "+title;

    if($("#videoPlayer").attr("class") != 'active')
    	$("#amazon").show();

	$("#lyric").show();
	$("#downloadmp3").show();
	$("#shareMenu").show();
	//$("#nowPlaying").show();


	getVideo($(item).attr("data-track"),$(item).attr("data-artist"),$(item));
	$("#thumbnail img,#thumbnailx img").attr("src",$(item).attr("data-cover"));
	$(item).addClass('active');
	if($("#nowPlaying").attr("class") == "active")
			getArtistInfo(getCurrentArtist());

	if ( $("#myTab").is(":visible") ) {
	   getSongInfo(getCurrentArtist(),getCurrentTrack());
	}


	if($("#flagLyrics").length > 0)
		getLyric();
	var ads = Math.floor((Math.random()*5)+1);
	console.log(ads);
	if(ads == 5 && popup != '0')
		showPopUp();
}
function playBackSong()
{
	currentSong--;
	if(currentSong < 0)
		currentSong = ($("#playlist-items a").length-1);

	$("#playlist-items a.active").removeClass('active');
	var item = $("#playlist-items a").get(currentSong);
	
	getVideo($(item).attr("data-track"),$(item).attr("data-artist"),$(item));
	$("#thumbnail img,#thumbnailx img").attr("src",$(item).attr("data-cover"));
	$(item).addClass('active');

	if($("#nowPlaying").attr("class") == "active")
			getArtistInfo(getCurrentArtist());

	if($("#flagLyrics").length > 0)
		getLyric();

}

function savePlayListDB()
{
	

	var item;
	var list = [];
	$.each($("#playlist-items a"), function(index, val) {		
		item = {"track": $(this).attr("data-track"),"artist": $(this).attr("data-artist"),"cover": $(this).attr("data-cover")};
		list.push(item);
	});		
	var playlistJSON = JSON.stringify(list);
	var name = $("#namePlaylist").val();
	if(name == '')
		return false;
	$.post(base_url+'music/savePlayList', {playlist: playlistJSON,name:name,action:"1"}, function(data, textStatus, xhr) {
		if(data.error==1)
		{
			alert(data.msg);			
		}
		if(data.error==0)
		{
			$('#savePlaylistModal').modal('hide');			
			myPlaylist();

		}
	},"json");

}

function removeFolder(id)
{
	if(!id)
		return false;
	if(confirm("Remove Folder?"))
	{

		$.post(base_url+'music/savePlayList', {id:id,action:"3"}, function(data, textStatus, xhr) {
		if(data.error==1)
		{
			alert(data.msg);			
		}
		if(data.error==0)
		{				
			myPlaylist();

		}
		},"json");

	}
}

function addToPlayListDB(id,playlistJSON)
{
	
	if(!playlistJSON)
	{
		var item;
		var list = [];
		$.each($("#playlist-items a"), function(index, val) {		
			item = {"track": $(this).attr("data-track"),"artist": $(this).attr("data-artist"),"cover": $(this).attr("data-cover")};
			list.push(item);
		});		
		playlistJSON = JSON.stringify(list);
	}

	

	if(!id)
		return false;
	$.post(base_url+'music/savePlayList', {playlist: playlistJSON,id:id,action:"2"}, function(data, textStatus, xhr) {
		if(data.error==1)
		{
			alert(data.msg);			
		}
		if(data.error==0)
		{
			$.smallBox({title:data.title,content:data.content,timeout:3000,img:data.image});			
			myPlaylist();

		}
	},"json");

}


function savePlayList()
{
	var item;
	var list = [];
	$.each($("#playlist-items a"), function(index, val) {		
		item = {"track": $(this).attr("data-track"),"artist": $(this).attr("data-artist"),"cover": $(this).attr("data-cover")};
		list.push(item);
	});		
	localStorage.setItem(PlaylistNumber, JSON.stringify(list)); 
}
function loadPlayList(append)
{
	
	

	if(PlaylistNumber == undefined || PlaylistNumber == "undefined" || PlaylistNumber == null || PlaylistNumber == '')
		PlaylistNumber = "playlist_1";

	list = JSON.parse(localStorage.getItem(PlaylistNumber));
	if(!append)
	{		
		$("#playlist-items").empty();
	}
	if(list !== null && typeof list === 'object')
	{

		$.each(list, function(index, val) {
			if(index<502)
			addPlayList(val.track,val.artist,val.cover,false);
		});	
	}
	localStorage.setItem("playlist_active", PlaylistNumber); 
	$("#changePlaylist li.active,#changePlaylist2 li.active").removeClass("active");
	$("."+PlaylistNumber).addClass('active');
	
	 $("#numItems").text($("#playlist-items a").length);
	
}

function exportPlayList()
{
	var list = localStorage.getItem(PlaylistNumber);
	$("#export textarea").val(list);
	$("#export").submit();
}
// IMPORT
function importPlayList()
{
	 $('div#importPlayList').modal({
                keyboard:false,
                backdrop:false
        }).modal('show');
	 $("#pltrg").text(PlaylistNumber.replace("playlist_","Playlist "));
}

function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = files[i]; i++) {
      var fr = new FileReader();
		fr.onload = function(e) {
		    // e.target.result should contain the text		    
		    localStorage.setItem(PlaylistNumber,e.target.result); 
		    loadPlayList();
		    $('div#importPlayList').modal("hide");
		};
		fr.readAsText(f);
    }
    
  }





function getVideo(track,artist,obj)
{
	console.log(obj);
	if($("#playlist-items a").length <=0)
		return false;
	$("#artistInfo").text("Loading...");
	$("#trackInfo").text("");
	searching = true;
	$.getJSON(base_url+'music/getYoutube/'+slug(track)+"/"+slug(artist), {track:track,artist:artist,picture:$(obj).attr("data-cover").replace("http://","").replace("https://","")}, function(json, textStatus) {		
		if(json.id != 'null' && json.id != null)
		{
			adsAudio  = '';
			if(json.ads != null)
				adsAudio = json.ads;

			loadNewVideo(json.id,0,'small',adsAudio);
			play();	
			
			$("#trackInfo").text(track);
			$("#trackInfo").unbind('click');
			$("#trackInfo").click(function(event) {
				getSongInfo(artist,track);
			});

			$("#artistInfo").text(artist);
			$("#artistInfo").unbind('click');
			$("#artistInfo").click(function(event) {
				getArtistInfo(artist);
			});
			errors = 0;
		}		
		else
		{
			errors++;
			console.log("Next Song Video Null");
			if(errors >= 5)
			{
				$.smallBox({title:"Error",content:"The playlist is paused due multiples errors during playback.",timeout:10000});	
			}
			else
			{				
				$.smallBox({title:"No Found",content:"Video/Audio No Found!",timeout:3000});	
				playNextSong();	

				
			}
			
		}
		searching = false;
	});
}


function loadPlayListDB(json,append)
{
 	localStorage.setItem(PlaylistNumber,json); 
	loadPlayList(append);
}

function loadPlayListShare(hash)
{
	
	$.getJSON(base_url+'music/getPlayList/'+hash, function(data) {		
		
		if(data !== null && typeof data === 'object')
		{
			$("#playlist-items").empty();	
			$.each(data, function(index, val) {
				if(index<502)
				addPlayList(val.track,val.artist,val.cover,false);
			});	

			playNextSong(0);
		}	
	});	
	

}

function loadNewVideo(id, startSeconds,quality,ads) {

  if (ytplayer) {
  	
     $("#current progress-bar").width("0%");   
     if(ads != '')  
     {
     	tempVideo 	= id;
     	id 			= ads;
     	console.log(ads);
     }
    ytplayer.loadVideoById(id, parseInt(startSeconds),quality);

    if(is_mobile)
		{
			
			$("#videoPlayer").removeClass('active');
			$("#thumbnail").addClass('hidePlayer');						
			
		}

  }
  else
  {  		
		ytplayer = new YT.Player('ytapiplayer', {
		      height: '250',
		      width: '250',
		      videoId: id,
		      playerVars: {'controls': 1,'autoplay':1 },
		      events: {
		        'onReady': onYouTubePlayerReady
		      }
		});	

		if(start_youtube =="1")
		{
			$("#videoPlayer").addClass('active');
			$("#thumbnail").removeClass('hidePlayer');			
			$("#amazon").hide();
		}

		if(is_mobile)
		{
			
			$("#videoPlayer").addClass('active');
			$("#thumbnail").removeClass('hidePlayer');
			$('#thumbnailx ,.info-thumb').popover('show');
			setTimeout(function() {$('#thumbnailx ,.info-thumb').popover('hide');}, 5000);
			
		}
		$("#trgToogle").click();
	
  }
}
function onYouTubePlayerReady(playerId) {
	try{
		console.log('ready');	  	
	  	setInterval(updateytplayerInfo, 250);  
	  	//ytplayer.addEventListener("onStateChange", "onytplayerStateChange");
	  	ytplayer.addEventListener("onError", "onPlayerError");
	  	$("#volume").slider('setValue', getVolume());	
	}catch(e)
	{
		console.log(e);
		
	}
	
}
function onytplayerStateChange(newState) {
 
}
function updateytplayerInfo() {

	if(!ytplayer)
		return false;

	// > 15 Minutes
	if(getCurrentTime() > 900)
	{
		console.log("next song 15");
		playNextSong();
	}
	$("#tracktime").html(hhmmss(getDuration()));
    $("#tracktime2").html(hhmmss(getCurrentTime()));
    pos = (getCurrentTime() * 100)/getDuration(); 
    $("#current .progress-bar").width(pos+"%");

  

    if(radio)
    {   	
    	$("#stopRadio").show();
    	if(parseInt(pos) % 30 == 0)
    	{
    		var track 	= $("#playlist-items a.active").attr("data-track");
    		var artist 	= $("#playlist-items a.active").attr("data-artist");
    		getNextSongRadio(track,artist)		
    	}
    }
    else
    {
    	$("#stopRadio").hide();
    }
	pos = ((getBytesLoaded()+getStartBytes()) * 100)/getBytesTotal();
	if(!isNaN(pos))
	{
		$("#buffer .progress-bar").width(pos+"%");     
	}  
    if(getPlayerState() == 0 && searching == false)
    {
    	console.log("Next Song!");
    	playNextSong();
    }
    $("#numItems").text($("#playlist-items a").length);

    
    if(getPlayerState() == 1)
    {
    	$("#pause").show();
    	$("#play").hide();
    	
    	 if(is_mobile)
		{	
			
			$("#videoPlayer").removeClass('active');
			$("#thumbnail").addClass('hidePlayer');						
			
		}

    }
    else
    {
    	$("#pause").hide();
    	//$("#play").show();
    	$("#play").hide();
    }


	
    
}


function cueNewVideo(id, startSeconds) {
  		console.log('cueNewVideo');
    ytplayer.cueVideoById(id, startSeconds);
  
}
function play() {
	try{
		if(ytplayer)
		{
			if($("#playlist-items a").length <=0)
				return false;
		    ytplayer.playVideo();	
		    $("#play").hide();
		    $("#pause").show();
		}	
	}catch(e)
	{

	}
	
	
  
}
function pause() {
  	console.log('pause');
    ytplayer.pauseVideo();  
    $("#play").show();
    $("#pause").hide();
}
function onPlayerError(e)
{	
	setTimeout(function() {playNextSong();}, 10000);	
}
function getPlayerState() {	
	try{
    	return ytplayer.getPlayerState();  
	}catch(e)
	{
		return -1;
	}

    
}
function seekTo(seconds) {
  if(getPlayerState() == -1)
  	return false;
    ytplayer.seekTo(seconds, true);
  
}
function getBytesLoaded() {    
    try{
    	return ytplayer.getVideoBytesLoaded();  
	}catch(e)
	{
		return 0;
	}
}

function getBytesTotal() {
	try{
    	return ytplayer.getVideoBytesTotal();  
	}catch(e)
	{
		return 0;
	}
   
}

function getCurrentTime() { 
	try{
    	return ytplayer.getCurrentTime();  
	}catch(e)
	{
		return 0;
	}

}

function getDuration() {  
	try{
    	return ytplayer.getDuration();  
	}catch(e)
	{
		return 0;
	}

}

function getStartBytes() {
	try{
    	return ytplayer.getVideoStartBytes();  
	}catch(e)
	{
		return 0;
	}    
}

function register_user()
{
	var email 	= $('#registerForm [name="email"]').val();
	var pwd1 	= $('#registerForm [name="password1"]').val();
	var pwd2 	= $('#registerForm [name="password2"]').val();	
	if(isEmpty(pwd1) || isEmpty(pwd2)  || isEmpty(email))
	{
		alert(msg_required_fields);
		return false;
	}

	$.post(base_url+'music/registerUser', {"email": email,"pwd1":pwd1, "pwd2":pwd2}, function(data, textStatus, xhr) {
		if(data.error == 1)
		{
			alert(data.msg);
		}
		if(data.error == 0)
		{
			//location.reload();
			location.href=data.target;
		}
	},"json");
}
function changePassword()
{
	$("#chPasswordModal").modal("show");
}

function change()
{
	var pwd1 	= $('#changePasswordForm [name="password1"]').val();
	var pwd2 	= $('#changePasswordForm [name="password2"]').val();
	if(isEmpty(pwd1) || isEmpty(pwd2))
	{
		alert(msg_required_fields);
		return false;
	}
	$.post(base_url+'music/updatePassword', {"password1": pwd1,"password2":pwd2}, function(data, textStatus, xhr) {
		if(data.error == 1)
		{
			alert(data.msg);
		}
		if(data.error == 0)
		{
			alert(data.msg);
			$("#chPasswordModal").modal("hide");
		}
	},"json")

}
function login()
{
	var email 	= $('#loginForm [name="email"]').val();
	var pwd1 	= $('#loginForm [name="password1"]').val();
	if(isEmpty(pwd1) || isEmpty(email))
	{
		alert(msg_required_fields);
		return false;
	}
	$.post(base_url+'music/login', {"email": email,"pwd1":pwd1}, function(data, textStatus, xhr) {
		if(data.error == 1)
		{
			alert(data.msg);
		}
		if(data.error == 0)
		{
			document.location= base_url;
		}
	},"json")

}

function recoveryPassword()
{
	var email 	= $('#recoveryForm [name="email"]').val();
	if(isEmpty(email))
	{
		alert(msg_required_fields);
		return false;
	}
	$("#recoveryForm button").attr("disabled","disabled");
	$.post(base_url+'music/recovery', {"email": email}, function(data, textStatus, xhr) {		
		alert(data.msg);		
		$("#recoveryForm button").attr("disabled","");
		$("#recoveryForm button").removeAttr("disabled");
		if(data.error == "0")
			$("#loginModal").modal("hide");
	},"json")
	
}
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
function isEmpty(str) {
    return (!str || 0 === str.length);
}

window.onbeforeunload = function () {
	if(getPlayerState()==1)
	{
    	return msg_exit_page;
	}
}

function youtube_parser(url){
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match&&match[7].length==11){
        return match[7];
    }else{
        return false;
    }
}

// Automatically cancel unfinished ajax requests 
// when the user navigates elsewhere.
$(function () {
	 var xhrPool = [];
  $(document).ajaxSend(function(e, jqXHR, options){
    xhrPool.push(jqXHR);
  });
  $(document).ajaxComplete(function(e, jqXHR, options) {
    xhrPool = $.grep(xhrPool, function(x){return x!=jqXHR});
  });
  var abort = function() {
    $.each(xhrPool, function(idx, jqXHR) {
      jqXHR.abort();
    });
  };

  var oldbeforeunload = window.onbeforeunload;
  window.onbeforeunload = function() {
    var r = oldbeforeunload ? oldbeforeunload() : undefined;
    if (r == undefined) {
      // only cancel requests if there is no prompt to stay on the page
      // if there is a prompt, it will likely give the requests enough time to finish
      abort();
    }
    return r;
  }
});

