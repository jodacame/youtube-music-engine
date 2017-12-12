var radio = false;
var searchingRadio = false;
var currentRadio = 0;
var animation = false
var ytplayer;
var currentSong = 0;
var searching = false;
var PlaylistNumber = "playlist_1";
var errors = 0;
var adsAudio = '';
var tempVideo = '';
var _is_station = false;
var _audio = null; // External Radio Station
var audio_obj = null; // External Radio Station
var _seconds_ads = 0;
var oldpath = '';


$(window).load(function () {


    setTimeout(function () {
        getActividySider();
    }, 1500);

});


$(function () {

    $(".lazy").lazyload();
    $(document).ajaxSuccess(function () {
        $(".lazy").lazyload();
    });

// Cache

    if (!is_logged && cache) {
        __log("[CACHE] Only Logged Users Can Use Cache System", "warning");
        cache = false;
    }

    if (is_logged && cache) {
        __log("[CACHE] Using Cache System", "info");
    }

    checkSizeCache();

    if (cache_id != getCache("cache_id")) {
        clearCache();
        setCache("cache_id", cache_id);

    }

    if (getCache("cache_date")) {
        var date1 = new Date(getCache("cache_date"));
        var date2 = new Date();

        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        if (diffDays > 7) {
            __log("[CACHE] Cache Old", "info");
            clearCache();
            setCache("cache_id", cache_id);
        }

    }
    else {
        var t = new Date();
        setCache("cache_date", t.toString());
    }


    $.ajaxSetup({
        data: {
            csrf_yme: $.cookie('csrf_cookie_yme')
        },
        localCache: false,
        cacheTTL: 1
    });


    /* BUTTONS TEMPLATES */

    $(document).on("click", ".btn-clear-playlist", function () {
        clearPlaylist();
    });


    $(document).on("click", ".btn-music-folder", function () {
        myPlaylist();
    });
    $(document).on("click", ".btn-add-music-folder", function () {
        $('#savePlaylistModal').modal('show');
    });
    $(document).on("click", ".btn-activity-page", function () {
        showActivity(true);
    });

    $(document).on("click", ".btn-report-current-video", function () {
        $(this).fadeOut(500);
        report_current_video();
    });

    $(document).on("click", ".btn-activity", function () {
        var id = $(this).attr("data-idactivity");
        if (!id)
            id = 0;
        get_activity(id);
    });


    $(document).on("click", ".btn-modal", function () {
        $('#' + $(this).attr("data-target")).modal('show');
    });
    $(document).on("change", ".btn-filter-stations", function () {
        $("#list_stations li").hide();
        if ($(this).val() != '')
            $("#list_stations ." + $(this).val().replace(/[' ']+/g, '-')).show();
        else
            $("#list_stations li").fadeIn(500);
    });
    $(document).on("click", ".btn-new-music-folder", function () {
        $('#newMusicFolder').modal('show');
        $('#newMusicFolder .btn-create-music-folder').attr("data-artist", $(this).attr("data-artist"));
        $('#newMusicFolder .btn-create-music-folder').attr("data-track", $(this).attr("data-track"));
        $('#newMusicFolder .btn-create-music-folder').attr("data-cover", $(this).attr("data-cover"));

    });
    $(document).on("click", ".btn-create-music-folder", function () {
        create_music_folder($('#newMusicFolder .namefolder').val(), $(this).attr("data-artist"), $(this).attr("data-track"), $(this).attr("data-cover"));
        $('#newMusicFolder .namefolder').val("");
    });

    $(document).on("click", ".btn-sync-playlist", function () {
        loading();
        var id = $(this).attr("data-id");
        var idpl = $(this).attr("data-idpl");
        $.post(base_url + "spotify/sync", {id: id}, function (data, textStatus, xhr) {
            loading("hide");
            if (data.error) {
                if (data.url)
                    location.href = data.url;
                else
                    noty("Error", data.error);
            }
            else {
                edit_playlist(idpl);
            }

        }, "json");
    });


    $(document).on("click", ".btn-login", function () {
        $("#loginModal").modal("show");
        $(".btnlogin").click();
        $("#download_popup").modal("hide");
    });

    $(document).on("click", ".btn-download-mp3", function (e) {
        e.preventDefault();
        if ($(this).attr("data-artist"))
            download_popup($(this).attr("data-artist"), $(this).attr("data-track"), $(this).attr("data-cover"));
        else
            download_popup();
    });

    $(document).on("click", ".btn-share-dialog", function (e) {
        e.preventDefault();
        if ($(this).attr("data-artist"))
            share_dialog($(this).attr("data-artist"), $(this).attr("data-track"), $(this).attr("data-cover"));
        else
            share_dialog();
    });

    $(document).on("click", ".btn-top-artist", function () {
        getTopArtist();
    });

    $(document).on("click", ".btn-go-comment", function () {
        $('.scrollable').animate({
            scrollTop: $("#commentFB").offset().top
        }, 2000);
    });
    $(document).on("click", ".btn-update-folder-name-modal", function () {
        $("#name-folder").val($(this).attr("data-name"));
        $("#id-folder").val($(this).attr("data-id"));
        $("#modal-update-name").modal("show");
    });
    $(document).on("click", ".btn-stations", function () {
        getStations();
    });
    $(document).on("click", ".btn-update-folder-name", function () {
        var name = $("#name-folder").val();
        var id = $("#id-folder").val();
        update_name_folder(id, name);
    });

    $(document).on("click", ".btn-stations", function () {
        getStations();
    });
    $(document).on("click", ".btn-add-to-folder", function () {
        var data = [{
            track: $(this).attr("data-track"),
            artist: $(this).attr("data-artist"),
            cover: $(this).attr("data-cover")
        }];
        if ($(this).attr("data-track"))
            addToPlayListDB($(this).attr("data-id"), JSON.stringify(data));
        else
            addToPlayListDB($(this).attr("data-id"), false);
    });

    $(document).on("click", ".btn-close-station", function () {
        $("#station").fadeOut(500);
        $("#station audio").remove();
        _is_station = false;
        $("#play").show();
        $("#pause").hide();
        $(".btn-cc").show();

    });


    $(document).on("click", ".btn-start-station", function () {
        start_station($(this).attr("data-station"), $(this).attr("data-title"), $(this).attr("data-cover"), $(this).attr("data-id"));
    });

    $(document).on("click", ".btn-info-station", function () {
        get_station_info($(this).attr("data-id"));
    });
    $(document).on("click", ".btn-track-info,.btn-song-info", function () {
        getSongInfo($(this).attr("data-artist"), $(this).attr("data-track"));
    });
    $(document).on("click", "#activity-unique", function () {
        $("#activity-unique").modal("hide");
    });

    $(document).on("click", ".btn-artist-info", function () {
        getArtistInfo($(this).attr("data-artist"));
    });

    $(document).on("click", ".btn-save-to", function () {
        loadNowPlaying();
    });

    $(document).on("click", ".btn-search-box", function () {
        if (data = getCache('getSearchBox')) {
            $("#target").html(data);
            return false;
        }
        loading();
        $.get(base_url + "music/getSearchBox/", false, function (data, textStatus) {
            $("#target").html(data);
            hideADSRegistered();
            setCache("getSearchBox", data);
            loading('hide');
        });
    });

    $(document).on("click", ".btn-start-radio", function () {
        start_radio($(this).attr("data-track"), $(this).attr("data-artist"), $(this).attr("data-cover"));

    });
    $(document).on("click", ".btn-playlist-artist", function () {
        loadPlayListArtist($(this).attr("data-artist"));
    });

    $(document).on("click", ".btn-playlists-artist", function () {
        loadPlayListsArtist($(this).attr("data-artist"));
    });

    $(document).on("click", ".btn-play-all", function () {
        playall();
    });

    $(document).on("click", ".btn-play-playlist", function () {
        loadPLaylistID($(this).attr("data-id"), true);
    });
    $(document).on("click", ".btn-load-playlist", function () {
        loadPLaylistID($(this).attr("data-id"));
    });
    $(document).on("click", ".btn-like-activity", function () {
        like($(this).attr("data-idactivity"), $(this).attr("data-iduser"), $(this));

    });

    $(document).on("click", ".btn-profile", function () {
        var user = $(this).attr("data-user");
        profile(user);
    });

    $(document).on("click", ".btn-cc", function () {
        if ($(this).hasClass('text-muted')) {
            $(this).removeClass("text-muted");
            $("#subtitle").show();
        }
        else {
            $(this).addClass("text-muted");
            $("#subtitle").hide();
        }

    });
    $(document).on("click", ".btn-download-youtube", function () {
        downloadmp3();
    });
    $(document).on("click", ".btn-download-amazon", function () {
        buyAmazon();
    });
    $(document).on("click", ".btn-share-facebook", function () {
        var type = $(this).attr("data-type");
        var name = $(this).attr("data-name");
        var link = $(this).attr("data-link");
        var picture = $(this).attr("data-picture");
        var caption = $(this).attr("data-caption");
        var description = $(this).attr("data-description");
        __log("Sharing " + link, 'info');
        FB.ui({
            method: 'share',
            display: 'popup',
            href: link,
        }, function (response) {

        });
        $("#share_dialog").modal("hide");
    });
    $(document).on("click", ".btn-share-twitter", function () {
        var name = $(this).attr("data-name");
        var link = $(this).attr("data-link");
        window.open(
            "https://twitter.com/share?url=" + encodeURIComponent(link) +
            '&text=' + encodeURI(name),
            "_blank",
            "width=500, height=300"
        );
        $("#share_dialog").modal("hide");

    });

    $(document).on("click", ".btn-share-google-plus", function () {
        var name = $(this).attr("data-name");
        var link = $(this).attr("data-link");
        window.open(
            "https://plus.google.com/share?url=" + encodeURIComponent(link),
            "_blank",
            "width=500, height=300"
        );
        $("#share_dialog").modal("hide");
    });

    $(document).on("click", ".btn-share-copy-link", function () {
        var name = $(this).attr("data-name");
        var link = $(this).attr("data-link");
        $("#customShare textarea").html(link);
        $("#customShare .preview").empty();
        $("#customShare").modal("show");
        $("#share_dialog").modal("hide");
    });

    $(document).on("click", ".btn-share-embed-link", function () {
        var name = $(this).attr("data-name");
        var track = $(this).attr("data-track");
        var artist = $(this).attr("data-artist");
        var iframe = '<iframe width="250" height="75" src="' + base_url + 'embed?artist=' + artist + '&track=' + track + '" frameborder="0" allowfullscreen></iframe>';
        if (!track)
            var iframe = '<iframe width="260" height="310" src="' + base_url + 'embed/artist/?artist=' + artist + '" frameborder="0" allowfullscreen></iframe>';
        $("#customShare textarea").html(iframe);
        $("#customShare .preview").html($(iframe));
        $("#customShare").modal("show");
        $("#share_dialog").modal("hide");
    });


    $(document).on("click", ".btn-play, .btn-add-playlist", function () {
        addPlayList($(this).attr("data-track"), $(this).attr("data-artist"), $(this).attr("data-cover"), false);
    });

    $(document).on("click", ".btn-show-embed", function () {
        $("#embed iframe").attr("src", $("#embed iframe").attr("data-src"));
        $("#embed").slideToggle(250);
    });

    $(document).on("click", ".btn-download-itunes", function () {
        buyitunes();
    });
    $(document).on("click", ".btn-play-now", function () {
        addPlayList($(this).attr("data-track"), $(this).attr("data-artist"), $(this).attr("data-cover"), true);
    });


    $(document).on("click", ".btn-albums", function () {
        getAlbums($(this).attr("data-artist"));
    });
    $(document).on("click", ".btn-lyric-info", function () {
        getLyric($(this).attr("data-artist"), $(this).attr("data-track"));
    });
    $(document).on("click", ".btn-edit-playlist", function () {
        edit_playlist($(this).attr("data-id"));
    });
    $(document).on("click", ".btn-toggle-sidebar", function () {
        toggleSidebar();
    });
    $(document).on("click", ".banner.fixed .close", function () {
        $(this).parent().addClass("x");
    });


    // hide buttons
    $(".btn-download-mp3").hide();
    $("#lyric").hide();

    $("#shareMenu").hide();
    $("#nowPlaying").hide();
    $(".musicbar,.show-when-playing").addClass('hide');


    myPlaylist(true);

    /*var searchAjax = new Bloodhound({
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
    }); */


    $('#volume').slider().on('slide', function (ev) {
        setVolume(ev.value);
    });

    $(".removehref").attr("href", "#");


    if (localStorage.getItem('playlist_active') != '')
        PlaylistNumber = localStorage.getItem('playlist_active');

    $("#btnSearch").click(function (event) {
        var query = $("#s").val();
        if (query.length > 1) {
            search(query);
        }
    });
    $('input#s').keypress(function (e) {
        if (e.which == '13') {
            e.preventDefault();
            $("#btnSearch").click();
        }
    });

    $("#nowPlaying").click(function (event) {
        $(this).toggleClass('active');
        if ($(this).attr("class") == "active")
            getArtistInfo(getCurrentArtist());
    });


    $("#changePlaylist li,#changePlaylist2 li").click(function (event) {

        if ($(this).attr("data-playlist") != undefined) {
            PlaylistNumber = "playlist_" + $(this).attr("data-playlist");
            loadPlayList();
        }

    });

    var hash = window.location.hash;
    hash = hash.substring(3); // remove #
    hash = hash.replace(/-/g, ' ');
    hash = hash.replace("/", " - ");

    if (hash != '' && hash != 'login' && hash != '_') {
        $("#s").val(hash);
    }
    if (hash == 'login') {
        $("#loginModal").modal("show");
    }
    _analytics("/");


    hideADSRegistered();

    $("#topArtist").click(function (event) {
        getTopArtist();
    });

    $("#menuLogin, .btn-login").click(function (event) {
        $("#loginModal").modal("show");
        $(".btnlogin").click();
    });
    $(document).on("click", "#menuLoginRegister, .btn-register", function () {
        $("#loginModal").modal("show");
        $(".btnregister").click();
    });

    $("#downloadmp3").click(function (event) {
        $("#download_popup").modal("show");
    });
    $("#save_as_playlist").click(function (event) {
        myPlaylist();
    });
    $("#amazon").click(function (event) {
        buyAmazon();
    });
    $("#lyric").click(function (event) {
        getLyric();
    });
    $("#topTrack").click(function (event) {
        getTopTracks();
    });
    $("#random").click(function (event) {
        if ($(this).attr("class") == 'active') {
            $(this).removeClass('active');
        }
        else {
            $(this).addClass('active');
        }
    });

    $("#tags li a").click(function (event) {
        var tag = $(this).attr("data-tag");
        getTopTags(tag);
    });
    $("#tagsLink").click(function (event) {
        getTopTags("");
    });

    $("#videoPlayer").click(function (event) {
        if ($("#playlist-items a").length <= 0 || getCurrentArtist() == '' || getCurrentArtist() == null || getCurrentArtist() == undefined) {
            return false;
        }
        if ($(this).attr("class") == 'active') {
            $(this).removeClass('active');
            $("#thumbnail").addClass('hidePlayer');
            $(".btn-download-mp3").fadeIn(500);
        }
        else {
            $(this).addClass('active');
            $("#thumbnail").removeClass('hidePlayer');
            $(".btn-download-mp3").hide();
        }
    });

    $("#playlist-items:not('.exclude')").height($(window).height() - 320 + "px");

    center_banner();
    $(window).resize(function (event) {
        center_banner();
        $("#playlist-items:not('.exclude')").height($(window).height() - 320 + "px");
    });

    $('*[title]').tooltip({placement: "auto"});
    $("*[data-toggle='tooltip']").tooltip();
    $("#playlist-items").contextMenu({
        menuSelector: "#contextMenu",
        menuSelected: function (invokedOn, selectedMenu) {

            var action = $(selectedMenu).attr("data-action");
            if (action == 'remove')
                removePlayList($(invokedOn));
            if (action == 'playThis')
                playThis($(invokedOn));
            if (action == 'getlyric') {
                obj = $(invokedOn).closest('a');
                getLyric($(obj).attr("data-artist"), $(obj).attr("data-track"));
            }

            if (action == 'addto') {
                obj = $(invokedOn).closest('a');
                var data = [{
                    track: $(obj).attr("data-track"),
                    artist: $(obj).attr("data-artist"),
                    cover: $(obj).attr("data-cover")
                }];
                addToPlayListDB($(selectedMenu).attr("data-id"), JSON.stringify(data));
            }


            /*var msg = "You selected the menu item '" + selectedMenu.text() +
	            "' on the value '" + invokedOn.text() + "' and action = "+action;
	        alert(msg);*/
        }
    });

    $(".navbar-brand").click(function (event) {
        showBrandPage();
    });

    /* HELPERS */
    $(".noSpecialChar").keyup(function (event) {
        $(this).val($(this).val().replace(/[^\w\s]/gi, ''));
        $(this).val($(this).val().replace(" ", ''));
    });

    setInterval(function () {
        var _controls = $(".jp-controls");

        if (show_ads_float_rand > 0) {
            show_ads_float();
        }

        if (_is_station) {
            $(".btn-close-station").show();
            $(".btn-info-station").show();
            $("#artistInfo").text("");
            $("#trackInfo").text($("#station .text-center").text());
            $("#current .progress-bar").width("0");
            audio_obj = _audio.get(0);

            $("#volume").slider('setValue', audio_obj.volume * 100);

            if (audio_obj.paused) {
                $("#play").show();
                $("#pause").hide();
            }
            else {
                $("#play").hide();
                $("#pause").show();
                $("#tracktime").html("Live");
                $("#tracktime2").html(hhmmss(audio_obj.currentTime));

            }
            $(".jp-previous", _controls).hide();
            $(".jp-next", _controls).hide();
            $("#videoPlayerMusik", _controls).hide();
            $(".btn-download-mp3", _controls).hide();
            $(".btn-share-dialog", _controls).hide();
            $(".btn-save-to", _controls).hide();
            $(".btn-cc", _controls).hide();
        }
        else {
            $(".btn-close-station").hide();
            $(".btn-info-station").hide();
            $(".jp-previous", _controls).show();
            $(".jp-next", _controls).show();
            $("#videoPlayerMusik", _controls).show();
            $(".btn-download-mp3", _controls).show();
            $(".btn-share-dialog", _controls).show();
            $(".btn-save-to", _controls).show();
            $(".btn-cc", _controls).show();
        }
    }, 1000);

    loadPlayList();

    $(document).on("click", "a", function (event) {
        if ($(this).attr("href") == "#") {
            event.preventDefault();
        }
    });
});

$(document).ajaxComplete(function () {
    $("#wait").css("display", "none");
});

function show_ads_float() {

    if ($(".banner.fixed").hasClass('x')) {
        _seconds_ads++;
        var ads_float = Math.floor((Math.random() * show_ads_float_rand) + 1);
        if (_seconds_ads == show_ads_float_rand) {
            $(".banner.fixed").removeClass("x");
            _seconds_ads = 0;
        }
    }
}

function loadPLaylistID(id, clear) {
    if (id > 0) {
        loading();
        if (clear)
            clearPlaylist();
        setTimeout(function () {
            $.post(base_url + "music/getPlayListID/" + id, {id: id}, function (data, textStatus) {
                $.each(data, function (index, val) {
                    addPlayList(val.track, val.artist, val.cover, false, val.key);
                });
                loading('hide');
                setTimeout(function () {
                    if (!isPlaying())
                        playNextSong(0);
                }, 1000);
            }, 'json');
        }, 200);

    }

}


function download_popup(artist, track, cover) {
    if (!artist) {
        if (!getCurrentArtist())
            return false;
        $("#download_query").html(getCurrentArtist() + " - " + getCurrentTrack());
        $("#download_query").attr("data-artist", getCurrentArtist());
        $("#download_query").attr("data-track", getCurrentTrack());
        $("#download_cover").attr("src", getCurrentCover());
        $("#download_popup").modal("show");
    }
    else {
        $("#download_query").html(artist + " - " + track);
        $("#download_query").attr("data-artist", artist);
        $("#download_query").attr("data-track", track);
        $("#download_cover").attr("src", cover);
        $("#download_popup").modal("show");
    }


}

function share_dialog(artist, track, cover) {
    if (!artist) {
        if (!getCurrentArtist())
            return false;
        $("#share_name").html(getCurrentTrack() + " by " + getCurrentArtist());
        $("#share_cover").attr("src", getCurrentCover());
        $("#share_dialog .btn-share").attr("data-type", "feed");
        $("#share_dialog .btn-share").attr("data-name", getCurrentTrack() + " by " + getCurrentArtist());
        $("#share_dialog .btn-share").attr("data-link", base_url + "?artist=" + encode(getCurrentArtist()) + "&track=" + encode(getCurrentTrack()));
        $("#share_dialog .btn-share").attr("data-picture", getCurrentCover());
        $("#share_dialog .btn-share").attr("data-artist", getCurrentArtist());
        $("#share_dialog .btn-share").attr("data-track", getCurrentTrack());
        $("#share_dialog").modal("show");
    }
    else {
        var name = track + " by " + artist;
        var link = base_url + "?artist=" + encode(artist) + "&track=" + encode(track);
        if (!track) {
            name = artist;
            link = base_url + "artist/" + encode(artist);
        }
        $("#share_dialog .btn-share").attr("data-type", "feed");
        $("#share_dialog .btn-share").attr("data-name", name);
        $("#share_dialog .btn-share").attr("data-link", link);
        $("#share_dialog .btn-share").attr("data-picture", cover);
        $("#share_dialog .btn-share").attr("data-artist", artist);
        $("#share_dialog .btn-share").attr("data-track", track);

        $("#share_name").html(track + " by " + artist);
        $("#share_cover").attr("src", cover);
        $("#share_dialog").modal("show");
    }


}

function hideADSRegistered() {
    if (is_logged == '1' && hide_ads_registered == '1')
        $(".adsblock").remove();
}

function start_station(station, title, cover, id) {

    loading('');
    $.post(base_url + 'music/get_station', {station: station}, function (data, textStatus, xhr) {
        _audio = $('<audio id="audio" autoplay="autoplay" src="' + data.url + '" style="position:relative;margin-top:0px;background-color:#313131;width:100%"></audio>');
        $("#station audio").remove();
        $("#station img").attr("src", cover);
        $("#station small").text(title);
        $("#station").append(_audio);
        $("#station").fadeIn(500);
        $(".btn-info-station").attr("data-id", id);
        $(".btn-info-station").click();
        loading('hide');
        push_analytics(['_trackEvent', 'Station', 'Start', title]);
        if (ytplayer) {
            ytplayer.stopVideo();
            $("#play").show();
            $("#pause").hide();
            ytplayer.destroy();
            ytplayer = null;
            ytplayer = false;
        }
        _is_station = true;
    }, 'json');


}

function share(t, link) {
    if (getCurrentArtist() == '')
        return false;
    if (t == 'fb')
        window.open("https://www.facebook.com/sharer/sharer.php?u=" + (base_url + "?s=" + slug(getCurrentArtist()) + "-" + slug(getCurrentTrack())));
    if (t == 'tw')
        window.open("https://twitter.com/home?status=" + (base_url + "?s=" + slug(getCurrentArtist()) + "-" + slug(getCurrentTrack())));
    if (t == 'gp')
        window.open("https://plus.google.com/share?url=" + (base_url + "?s=" + slug(getCurrentArtist()) + "-" + slug(getCurrentTrack())));
    if (t == 'c') {
        $("#customShare textarea").html((base_url + "?s=" + slug(getCurrentArtist()) + "-" + slug(getCurrentTrack())));
        $("#customShare .preview").empty();
        $("#customShare").modal("show");
    }


}


function custom_share(t, link, extra) {
    if (link == '')
        link = document.location.href;
    if (extra) {
        link = link + " " + extra
    }

    if (t != 'c')
        link = encodeURIComponent(link);


    if (t == 'fb') {
        push_analytics(['_trackEvent', 'Share', 'Facebook', link]);
        window.open("https://www.facebook.com/sharer/sharer.php?u=" + (link));
    }
    if (t == 'tw') {
        push_analytics(['_trackEvent', 'Share', 'Twitter', link]);
        window.open("https://twitter.com/home?status=" + title + " " + (link));
    }
    if (t == 'gp') {
        push_analytics(['_trackEvent', 'Share', 'Google Plus', link]);
        window.open("https://plus.google.com/share?url=" + (link));
    }
    if (t == 'c') {
        push_analytics(['_trackEvent', 'Share', 'Custom', link]);
        $("#customShare textarea").html(link);
        $("#customShare .preview").empty();
        $("#customShare").modal("show");
    }


}


function _push(url) {
    _analytics(url);
}

function downloadmp3() {
    var query = encode($("#download_query").text());
    var a = encode($("#download_query").attr("data-artist"));
    var t = encode($("#download_query").attr("data-track"));
    push_analytics(['_trackEvent', 'Download', 'mp3', query]);
    window.open(base_url + "music/download_mp3/?q=" + encodeURIComponent(query) + "&a=" + a + "&t=" + t);
}

function youtube_parser(url) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match && match[7].length == 11) {
        return match[7];
    } else {
        return false;
    }
}

function buyAmazon() {
    /*if(query)
		window.open("http://www.amazon.com/gp/search?ie=UTF8&camp=1789&creative=9325&index=music&keywords="+encodeURIComponent(query)+"&linkCode=ur2&tag="+amazonID);	*/
    var query = $("#download_query").text();
    var a = $("#download_query").attr("data-artist");
    var t = $("#download_query").attr("data-track");
    push_analytics(['_trackEvent', 'Download', 'Amazon', query]);
    window.open(base_url + "music/download_amazon/?q=" + encodeURIComponent(query) + "&a=" + a + "&t=" + t);
}


function buyitunes() {

    var query = $("#download_query").text();
    var a = $("#download_query").attr("data-artist");
    var t = $("#download_query").attr("data-track");
    if (query) {
        push_analytics(['_trackEvent', 'Download', 'iTunes', query]);
        window.open(base_url + "music/download_itunes?q=" + encodeURIComponent(query) + "&a=" + a + "&t=" + t);
    }
}


function getCurrentArtist() {
    var item = $("#playlist-items a.active");
    var artist = $(item).attr("data-artist");
    if (artist == undefined || artist == null)
        artist = '';
    return artist;
}

function getCurrentTrack() {
    var item = $("#playlist-items a.active");
    var track = $(item).attr("data-track");
    if (track == undefined || track == null)
        track = '';
    return track;
}

function getCurrentCover() {
    var item = $("#playlist-items a.active");
    var track = $(item).attr("data-cover");
    if (track == undefined || track == null)
        track = '';
    return track;
}

function getLyric(artist, track) {

    if (!artist)
        artist = getCurrentArtist();
    if (!track)
        track = getCurrentTrack();
    if (artist == '' || artist == undefined || artist == 'undefined' || artist == null)
        return false;
    //show_loading();
    loading();
    $.get(base_url + "music/getLyric/", {artist: artist, track: track}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        loading('hide');
        push_analytics(['_trackEvent', 'Lyrics', 'View', artist + " " + track]);
    });


}

function loadNowPlaying() {


    artist = getCurrentArtist();
    track = getCurrentTrack();
    cover = getCurrentCover();

    if (artist == '' || artist == undefined || artist == 'undefined' || artist == null)
        return false;
    //show_loading();
    loading();
    $.post(base_url + "music/nowPlaying/", {artist: artist, track: track, cover: cover}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        loading('hide');
    });


}

function report_current_video() {
    artist = getCurrentArtist();
    track = getCurrentTrack();
    if (artist == '' || artist == undefined || artist == 'undefined' || artist == null)
        return false;
    //show_loading();

    $.post(base_url + "music/report/", {artist: artist, track: track}, function (data, textStatus) {

    });

}

function showBrandPage() {
    //show_loading();
    loading();
    $.get(base_url + "music/getBrandPage/", false, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        loading('hide');
    });
}

function showPage(id) {


    //show_loading();
    loading();
    $.get(base_url + "music/getPage/" + id, false, function (data, textStatus) {
        $("#target").html(data);
        push_analytics(['_trackEvent', 'Page', 'View', id]);
        loading('hide');
    });


}

var timerActivity;

function showActivity(force) {
    if (force == true)
        loading();

    if (force == undefined || force == null)
        force = false;

    if ($("#timeline").length > 0 || force == true) {
        clearInterval(timerActivity);
        $.get(base_url + "music/getActivity/", false, function (data, textStatus) {
            $("#target").html(data);
            hideADSRegistered();
            loading('hide');
        });
    }


}


function get_activity(id) {

    loading();
    $.post(base_url + "music/getActivity/", {id: id}, function (data, textStatus) {
        $("#activity-unique .modal-body").html(data);
        $("#activity-unique").modal("show");
        loading('hide');
    });

}

if ($("#activitySider").length > 0) {
    setInterval(function () {
        getActividySider()
    }, 20000);
}

function getActividySider() {
    if ($("#activitySider").length > 0) {
        $.post(base_url + "music/getActivity/", {json: 1}, function (data, textStatus) {
            $("#activitySider ul").empty();
            $.each(data, function (index, val) {
                var _item = $('<li id="activity-' + val.idactivity + '" class="list-group-item truncate" style="display:block"> \
					<img src="' + val.avatar + '" class="pull-left cursor-pointer thumbnail"> \
					<strong style="cursor:pointer" class="btn-profile" data-user="' + val.nickname + '">' + val.nickname + ' </strong> \
					<button data-track="' + val.track + '" data-artist="' + val.artist + '" data-cover="' + val.picture + '"  class="btn btn-xs btn-default pull-right btn-play-now"> \
						<i class="fa fa-play"></i> \
					</button> <br> \
					<span  data-artist="' + val.artist + '"  style="cursor:pointer" class="btn-artist-info">' + val.artist + '</span><br> \
					<span data-artist="' + val.artist + '" data-track="' + val.track + '"  style="cursor:pointer" class="btn-song-info text-muted truncate"> \
						<i class="fa fa-music"></i> ' + val.track + ' \
					</span><br><span class="pull-right">' + val.date + '</span></li>');

                if ($('#activity-' + val.idactivity).length == 0) {
                    $("#activitySider ul").append(_item);

                }
            });
            hideADSRegistered();
        }, 'json');
    }
}

function myPlaylist(json) {
    if (!is_logged) {
        return false;
    }

    if (!json) {
        //show_loading();
        loading();
        $.get(base_url + "music/myPlaylist/", null, function (data, textStatus) {
            $("#target").html(data);
            hideADSRegistered();
            loading('hide');
        });
        myPlaylist(true);
    }
    else {
        if (extend == "0")
            return false;
        $("#playlistSaved").html("<li><a href=''#>Loading...</a></li>");
        $.get(base_url + "music/myPlaylist/1", null, function (data, textStatus) {
            $("#playlistSaved").html(data);
            hideADSRegistered();
        });


    }


}

function noty(title, text, type) {
    if (!type)
        type = 'success';
    var notice = new PNotify({
        title: title,
        text: text,
        shadow: false,
        type: type,
        buttons: {
            closer: false,
            sticker: false
        }
    });
    notice.get().click(function () {
        notice.remove();
    });
}

function profile(id) {
    if (id == null || id == undefined)
        id = 0;
    //show_loading();
    loading();
    $.get(base_url + "music/profile/" + id, {id: id}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        push_analytics(['_trackEvent', 'Profile', 'View', id]);
        loading('hide');
    });

}

function update_name_folder(id, name) {
    if (id == null || id == undefined)
        return false;
    $.post(base_url + "music/update_folder/", {id: id, name: name}, function (data, textStatus) {
        noty(data.title, data.content);
        if ($("#folder-div").length)
            myPlaylist();
        else
            edit_playlist(id);
        $("#modal-update-name").modal("hide");
    });
}

function edit_playlist(id) {
    if (id == null || id == undefined)
        return false;
    //show_loading();
    loading();
    $.post(base_url + "music/edit_playlist/", {id: id}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        loading('hide');
        try {
            FB.XFBML.parse();
        } catch (ex) {
        }
    });

}

function removePlayList(obj) {


    $(obj).closest('a').remove();
    savePlayList();
    if ($("#playlist-items a").length >= 1) {
        $(".notePlayList").hide();
    }
    else {
        $(".notePlayList").show();
    }
    $("#numItems,.numItems").text($("#playlist-items a").length);
}

function show_loading(target) {
    if (!target)
        target = 'target';
    $("#" + target).html('<div id="circleG"><div id="circleG_1" class="circleG"></div><div id="circleG_2" class="circleG"></div><div id="circleG_3" class="circleG"></div>');
}

function loading(msg) {
    if (!msg)
        msg = '';
    $.blockUI.defaults.css = {};
    if (msg == 'hide')
        $.unblockUI({fadeOut: 200});
    else
        $.blockUI({message: "<h3><i class='fa fa-refresh icon-spin'></i> " + msg + "</h3>"});
}

function showPopUp() {
    $('div#popup').modal({
        keyboard: false,
        backdrop: false
    }).modal('show');
}

function search(query) {

    //$('#s').trigger('blur');
    if (data = getCache('search_' + hashCode(query))) {
        $("#target").html(data);
        return false;
    }
    __log("Searching " + query, "log");
    //show_loading();
    loading();
    $.get(base_url + "music/search/", {query: query}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        push_analytics(['_trackEvent', 'Search', 'Query', query]);
        if (data.search("alert-info") <= 0)
            setCache('search_' + hashCode(query), data);
        loading('hide');
    }).fail(function (e) {
        __log("Error Searching " + query, "error");
        __log("Message: " + e.statusText, "error");
        if (e.status == 404) {
            __log("Check .htaccess File http://support.jodacame.com/knowledge-base/youtube-music-engine-htaccess", "warn");
        }
        if (e.status == 401) {
            __log("Check Last.fm API Key http://support.jodacame.com/knowledge-base/get-last-fm-api-key", "warn");
        }
        if (e.status == 403 || e.status == 500) {
            __log("Check Permission http://support.jodacame.com/knowledge-base/i-get-error-500-any-solution", "warn");
            __log("Check .htaccess http://support.jodacame.com/knowledge-base/youtube-music-engine-htaccess", "warn");
        }
        loading('hide');

    });
}

function search_artist(query) {
    $('#s').trigger('blur');
    $.get(base_url + "music/searchArtist/", {query: query}, function (data, textStatus) {
        $("#search-artist").html(data);
        hideADSRegistered();
        push_analytics(['_trackEvent', 'Search', 'Artist', query]);
    });
}


function getTopArtist() {
    if (data = getCache('getTopArtist')) {
        $("#target").html(data);
        return false;
    }

    //show_loading();
    loading();
    $.get(base_url + "music/getTopArtist/", false, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        var stateObj = {foo: "bar"};
        history.pushState(stateObj, "", base_url + "top/artist");
        loading('hide');
        setCache("getTopArtist", data);
    });
}

function getStations() {

    if (data = getCache('getStations')) {
        $("#target").html(data);
        return false;
    }

    //show_loading();
    loading();
    $.get(base_url + "music/getStations/", false, function (data, textStatus) {
        $("#target").html(data);
        loading('hide');
        setCache("getStations", data);
        hideADSRegistered();
    });
}

function get_station_info(id) {
    if (!id)
        return false;
    if ($("#radio-station-open").length == 0)
        loading();
    $.post(base_url + "music/getStation/", {id: id}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        loading('hide');
    });
}

function getTopTracks() {
    if (data = getCache('getTopTracks')) {
        $("#target").html(data);
        return false;
    }
    loading();
    $.get(base_url + "music/getTopTracks/", false, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        var stateObj = {foo: "bar"};
        history.pushState(stateObj, "", base_url + "top/tracks");
        setCache('getTopTracks', data);
        loading('hide');

    });
}

function getTopTags(tag) {

    if (data = getCache('getTopTags_' + hashCode(tag))) {
        $("#target").html(data);
        return false;
    }

    loading();
    $.get(base_url + "music/getTopTags/" + slug(tag), {tag: tag}, function (data, textStatus) {
        $("#target").html(data);
        setCache('getTopTags_' + hashCode(tag), data);
        hideADSRegistered();
        loading('hide');
    });
}

function getArtistInfo(artist) {

    artist = artist.replace(/[']+/g, "");
    //artist = artist.replace( "/", "-");
    artist = encodeURIComponent(artist);
    if (artist == '' || artist == undefined || artist == 'undefined' || artist == null)
        return false;

    if (data = getCache('getArtistInfo_' + hashCode(artist))) {
        $("#target").html(data);
        return false;
    }

    loading();
    $.get(base_url + "music/getArtistInfo/", {artist: artist}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        setCache('getArtistInfo_' + hashCode(artist), data);
        push_analytics(['_trackEvent', 'Artist', 'View', artist]);
        loading('hide');
    });
}

function _analytics(url) {
    if (typeof _gaq !== "undefined" && _gaq !== null && url) {

        _gaq.push(['_trackPageview', url]);

    }
}

function push_analytics(obj) {
    if (typeof _gaq !== "undefined" && _gaq !== null && obj) {
        _gaq.push(obj);

    }
}

function getSongInfo(artist, track) {
    artist = artist.replace(/[']+/g, "\'");
    artist = artist.replace("/", "-");
    track = track.replace(/[']+/g, "\'");
    track = track.replace("/", "-");


    if (artist == '' || artist == undefined || artist == 'undefined' || artist == null || track == undefined || track == null)
        return false;

    if (data = getCache('getSongInfo' + hashCode(artist + track))) {
        $("#target").html(data);
        return false;
    }

    loading();
    $.post(base_url + "music/getSongInfo/", {artist: artist, track: track}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        loading("hide");
        setCache('getSongInfo' + hashCode(artist + track), data);
        push_analytics(['_trackEvent', 'Track', 'View', artist + ' - ' + track]);
    });
}

function like(id, iduser, obj) {
    $(obj).attr("disabled", "disabled");


    $.post(base_url + "music/likeActivity/", {id: id, iduser: iduser}, function (data, textStatus) {
        $(obj).html($(".count-like-" + id).attr("data-label"));
        $(".count-like-" + id).html(parseFloat($(".count-like-" + id).html()) + 1);
    });
}

function getAlbums(artist) {

    if (artist == '' || artist == undefined || artist == 'undefined' || artist == null)
        return false;
    loading();
    $.get(base_url + "music/getAlbums/", {artist: artist}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        push_analytics(['_trackEvent', 'Artist', 'Album', artist]);
        loading('hide');
    });

}

function getEvents(artist) {
    if (artist == '' || artist == undefined || artist == 'undefined' || artist == null)
        return false;
    loading();
    $.get(base_url + "music/getEvents/", {artist: artist}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        loading('hide');
        push_analytics(['_trackEvent', 'Artist', 'Events', artist]);
    });

}

function getTracksAlbum(album, artist) {
    if (artist == '' || artist == undefined || artist == 'undefined' || artist == null)
        return false;
    loading();
    $.get(base_url + "music/getTracksAlbums/", {artist: artist, album: album}, function (data, textStatus) {
        $("#target").html(data);
        hideADSRegistered();
        loading('hide');
    });

}

function clearPlaylist(nomsg) {
    if ($("#playlist-items a").length > 0) {

        if (!nomsg) {
            if (confirm(msg_clear_playlist)) {
                currentSong = -1;
                $("#playlist-items").empty();
                savePlayList();
                $("#numItems,.numItems").text($("#playlist-items a").length);
            }
        } else {

            currentSong = -1;
            $("#playlist-items").empty();
            $("#numItems,.numItems").text($("#playlist-items a").length);
        }
    }

}

function addAlltoPlaylist() {
    $(".addTrg").click();
}

function addPlayList(track, artist, cover, play, key) {
    track = track.replace(/[']+/g, "\'");
    artist = artist.replace(/[']+/g, "\'");


    if ($("#playlist-items a").length == 500) {
        $.smallBox({title: "Error", content: error_max, timeout: 3000});
    }

    if ($("#playlist-items a").length >= 500) {
        return false;
    }


    if (!key)
        key = "";
    if (key != '') {
        if ($("." + key).length > 0 && $("#playlist-items li").length < 50) {
            __log("Duplicate Track " + track + " - " + artist + " - key: " + key, 'log');
            getNextSongRadio(track, artist);
            return false;
        }
    }

    var item = $('<a data-track="' + track + '" data-artist="' + artist + '" data-cover="' + cover + '" href="#" onClick="return false;" class="list-group-item ' + key + '"><span class="pull-right"><button class="btn btn-danger btn-xs" onClick="removePlayList(this)"><i class="fa fa-trash-o"></i></button> <button class="btn btn-primary btn-xs" onClick="playThis(this);"><i class="fa fa-play"></i></button></span><span class="glyphicon glyphicon-music"></span><span class="btn-track-info" data-track="' + track + '" data-artist="' + artist + '"> ' + track + '</span><span  onClick="getArtistInfo(\'' + artist + '\');" title="Get Artist Info" class="text-muted"> by ' + artist + '</span></a>');
    $("#playlist-items").append(item);
    savePlayList();
    if (play) {
        playThis(item);
    }

    $("#playlist-items").sortable(
        {
            update: function (event, ui) {
                savePlayList();
            },
            items: "a:not(.active)"
        });

    //$("#playlist-items").dragsort("destroy");/


    if (animation == true)
        return false;

    /*animation = true;
	$("#playlist-items").animate({
        scrollTop: item.offset().top
    }, 2000, function() {
    	animation = false;
  	});*/
    $("#numItems,.numItems").text($("#playlist-items a").length);
}

function getNextSongRadio(track, artist) {
    if (searchingRadio == true)
        return false;
    if (currentRadio > 10)
        return false;
    searchingRadio = true;

    $.getJSON(base_url + 'music/getRelated/' + slug(track) + "/" + slug(artist) + "/" + currentRadio, {
        track: track,
        artist: artist
    }, function (json, textStatus) {
        searchingRadio = false;
        if (json.track != null)
            addPlayList(json.track, json.artist, json.cover, false, json.key2);

    });
    currentRadio++;


}

function start_radio(track, artist, cover, nomsg) {

    if (track == '' || artist == '')
        return false;
    clearPlaylist(nomsg);
    addPlayList(track, artist, cover, true);
    radio = true;
}

function stop_radio() {
    radio = false;
}

function slug(str) {
    return str;
    str = str.replace(/[' ']+/g, '-');
    str = str.replace(/['&']+/g, 'and');
    str = str.replace(/['(']+/g, '-');
    str = str.replace(/[')']+/g, '-');
    return str;
    //return normalize(str);
}

function encode(str) {
    //return escape(str);
    return encodeURIComponent(str);
}

function setVolume(newVolume) {
    if (_is_station) {
        audio_obj.volume = newVolume / 100;
    }
    else {
        if (ytplayer) {
            ytplayer.setVolume(newVolume);
        }
    }

}

function getVolume() {
    if (ytplayer) {
        return ytplayer.getVolume();
    }
}

function hhmmss(secs) {
    var sec_num = parseInt(secs, 10); // don't forget the second parm
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);
    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    //var time    = hours+':'+minutes+':'+seconds;
    var time = minutes + ':' + seconds;
    return time;
}

var normalize = (function () {
    var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
        to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
        mapping = {};

    for (var i = 0, j = from.length; i < j; i++)
        mapping[from.charAt(i)] = to.charAt(i);

    return function (str) {
        str = str.replace(/[,]+/g, '%2C');
        str = str.replace(/['']+/g, '%27');
        var ret = [];
        for (var i = 0, j = str.length; i < j; i++) {
            var c = str.charAt(i);
            if (mapping.hasOwnProperty(str.charAt(i)))
                ret.push(mapping[c]);
            else
                ret.push(c);
        }
        return ret.join('').replace(/[^-A-Za-z0-9%]+/g, '-').toLowerCase();
    }
})();
/* PLAYER */
$(function () {
    $("#play").click(function (event) {
        errors = 0;
        if (_is_station) {
            audio_obj.play();
        }
        else {

            play();

        }

    });

    $("#current.progress").on('click', function (e) {
        var parentOffset = $(this).parent().offset();
        var relX = e.pageX - parentOffset.left;
        var pos = (100 * relX) / ($(this).width());
        if (pos < 0) pos = 0;
        if (pos > 100) pos = 100;
        $("#current .progress-bar").width(pos + "%");
        var size2 = $("#current.progress").width();
        var size = $("#current .progress-bar").width();
        var current = (size * 100) / size2;
        var duracion = getDuration();
        if (current < 0) current = 0;
        if (current > duracion) current = duracion;
        var pos = ((duracion * current) / 100) - 1;

        seekTo(pos);
    });


});

function onYouTubeIframeAPIReady() {
    __log("[YOUTUBE] Ready Youtube", 'log');

}

function playThis(obj) {
    obj = $(obj).closest('a');
    currentSong = $(obj).index();
    playNextSong($(obj).index());
}

function playNextSong(index) {

    if ($("#playlist-items a").length == 0) {
        __log("[PLAYLIST] Playlist Empty", "warn");
        return false;
    }
    if (_is_station)
        return false;


    $("#play").hide();
    $("#pause").show();
    $(".musicbar,.show-when-playing").addClass('hide');


    currentRadio = 0;
    if (index == 0 && getPlayerState() == 2) {
        errors = 0;
        play();
        return false;
    }


    if ($("#random").attr("class") == 'active') {
        var currentSongP = currentSong;
        currentSong = Math.floor((Math.random() * $("#playlist-items a").length) + 0);
        if (currentSongP == currentSong)
            currentSong = Math.floor((Math.random() * $("#playlist-items a").length) + 0);
        if (currentSongP == currentSong)
            currentSong = Math.floor((Math.random() * $("#playlist-items a").length) + 0);
        if (currentSongP == currentSong)
            currentSong = Math.floor((Math.random() * $("#playlist-items a").length) + 0);
        if (currentSongP == currentSong)
            currentSong = Math.floor((Math.random() * $("#playlist-items a").length) + 0);
    }
    else {
        if (adsAudio == '')
            currentSong++;
        else
            adsAudio = '';
    }

    if (index || index == 0)
        currentSong = index;
    if (currentSong >= $("#playlist-items a").length)
        currentSong = 0;
    $("#playlist-items a.active").removeClass('active');
    var item = $("#playlist-items a").get(currentSong);

    //window.location.hash 	= "#!/"+$(item).attr("data-artist")+"/"+$(item).attr("data-track");
    //var stateObj = { foo: "bar" };
    //history.pushState(stateObj, "", "?s="+jQuery.trim($(item).attr("data-artist").replace(/ +/g,"-"))+"-"+jQuery.trim($(item).attr("data-track").replace(/ +/g,"-")));
    //history.pushState(stateObj, "", base_url+"?artist="+encodeURIComponent(jQuery.trim($(item).attr("data-artist").replace(/ +/g,"-")))+"&track="+encodeURIComponent(jQuery.trim($(item).attr("data-track").replace(/ +/g,"-"))));


    document.title = $(item).attr("data-track") + " | " + title;

    if ($("#videoPlayer").attr("class") != 'active')
        $(".btn-download-mp3").show();

    $("#lyric").show();

    $("#shareMenu").show();
    //$("#nowPlaying").show();


    getVideo($(item).attr("data-track"), $(item).attr("data-artist"), $(item));
    $("#thumbnail img,#thumbnailx img").attr("src", $(item).attr("data-cover"));
    $(item).addClass('active');
    if ($("#nowPlaying").attr("class") == "active")
        getArtistInfo(getCurrentArtist());

    if ($(".nowPlaying").length)
        $(".btn-save-to").click();
    if ($("#myTab,#song-info").is(":visible")) {
        if ($("#current_song_musik").val() != $(item).attr("data-track"))
            getSongInfo(getCurrentArtist(), getCurrentTrack());
    }


    if ($("#flagLyrics").length > 0)
        getLyric();
    var ads = Math.floor((Math.random() * 5) + 1);

    if (ads == 5 && popup != '0')
        showPopUp();

    $(document).trigger("next_song", [getCurrentArtist(), getCurrentTrack(), getCurrentCover()]);

}

function playBackSong() {
    currentSong--;
    if (currentSong < 0)
        currentSong = ($("#playlist-items a").length - 1);

    $("#playlist-items a.active").removeClass('active');
    var item = $("#playlist-items a").get(currentSong);

    getVideo($(item).attr("data-track"), $(item).attr("data-artist"), $(item));
    $("#thumbnail img,#thumbnailx img").attr("src", $(item).attr("data-cover"));
    $(item).addClass('active');

    if ($("#nowPlaying").attr("class") == "active")
        getArtistInfo(getCurrentArtist());

    if ($("#flagLyrics").length > 0)
        getLyric();

}

function savePlayListDB() {


    var item;
    var list = [];
    $.each($("#playlist-items a"), function (index, val) {
        item = {
            "track": $(this).attr("data-track"),
            "artist": $(this).attr("data-artist"),
            "cover": $(this).attr("data-cover")
        };
        list.push(item);
    });
    var playlistJSON = JSON.stringify(list);
    var name = $("#namePlaylist").val();
    if (name == '')
        return false;
    $.post(base_url + 'music/savePlayList', {
        playlist: playlistJSON,
        name: name,
        action: "1"
    }, function (data, textStatus, xhr) {
        if (data.error == 1) {
            noty("Error", data.msg, 'error');
        }
        if (data.error == 0) {
            $('#savePlaylistModal').modal('hide');
            $(".playlist-list .playlist-target").after('<li class="btn-add-to-folder" data-id="' + data.id + '" ><a href="#" >' + name + '</a></li> ');
            $(".playlist-list2 .playlist-target2").after('<li class="btn-play-playlist" data-id="' + data.id + '" ><a href="#" ><i class="icon-playlist text-xs"></i> ' + name + '</a></li> ');
            myPlaylist();


        }
    }, "json");

}


function create_music_folder(name, artist, track, cover) {
    if (name == '') {
        console.error("name folder empty");
        return false;
    }
    var list = [];
    if (artist && track && cover) {
        item = {"track": artist, "artist": track, "cover": cover};
        list.push(item);
    }
    var playlistJSON = JSON.stringify(list);
    $.post(base_url + 'music/savePlayList', {
        playlist: playlistJSON,
        name: name,
        action: "1"
    }, function (data, textStatus, xhr) {
        if (data.error == 1) {
            alert(data.msg);
        }
        if (data.error == 0) {
            $('#newMusicFolder').modal('hide');
            if (data.id > 0) {

                $("#listidplaylist").prepend('<li class="btn-edit-playlist" data-id="' + data.id + '" ><a href="#" ><i class="icon-playlist text-xs"></i> ' + data.name + '</a></li>');
            }
            myPlaylist();

        }
    }, "json")

}

function updatePlaylistDB(id) {


    var item;
    var list = [];
    $.each($("#list-items li"), function (index, val) {
        item = {
            "track": $(this).attr("data-track"),
            "artist": $(this).attr("data-artist"),
            "cover": $(this).attr("data-cover")
        };
        list.push(item);
    });
    var playlistJSON = JSON.stringify(list);

    $.post(base_url + 'music/updatePlaylist', {playlist: playlistJSON, id: id}, function (data, textStatus, xhr) {
        alert(data.msg);
    }, "json");

}

function removeFolder(id) {
    if (!id)
        return false;
    if (confirm("Remove Folder?")) {

        $.post(base_url + 'music/savePlayList', {id: id, action: "3"}, function (data, textStatus, xhr) {
            if (data.error == 1) {
                alert(data.msg);
            }
            if (data.error == 0) {
                myPlaylist();

            }
        }, "json");

    }
}

function addToPlayListDB(id, playlistJSON) {

    if (!playlistJSON) {
        nomsg = true;
        var item;
        var list = [];
        $.each($("#playlist-items a"), function (index, val) {
            item = {
                "track": $(this).attr("data-track"),
                "artist": $(this).attr("data-artist"),
                "cover": $(this).attr("data-cover")
            };
            list.push(item);
        });
        playlistJSON = JSON.stringify(list);
    }


    if (!id)
        return false;
    $.post(base_url + 'music/savePlayList', {
        playlist: playlistJSON,
        id: id,
        action: "2"
    }, function (data, textStatus, xhr) {
        if (data.error == 1) {
            noty("Error", data.msg, 'error');
        }
        if (data.error == 0) {
            if (!nomsg)
                $.smallBox({title: data.title, content: data.content, timeout: 3000, img: data.image});
            else {
                var title = data.title.replace("<br>", "")
                noty(title, data.msg);

            }

            if ($("#folder-div").length)
                myPlaylist();

        }
    }, "json");

}


function savePlayList() {
    var item;
    var list = [];
    $.each($("#playlist-items a"), function (index, val) {
        item = {
            "track": $(this).attr("data-track"),
            "artist": $(this).attr("data-artist"),
            "cover": $(this).attr("data-cover")
        };
        list.push(item);
    });
    localStorage.setItem(PlaylistNumber, JSON.stringify(list));
}

function loadPlayList(append) {


    if (PlaylistNumber == undefined || PlaylistNumber == "undefined" || PlaylistNumber == null || PlaylistNumber == '')
        PlaylistNumber = "playlist_1";


    list = JSON.parse(localStorage.getItem(PlaylistNumber));
    if (!append) {
        $("#playlist-items").empty();
    }
    if (list !== null && typeof list === 'object') {
        loading(label_loading);
        setTimeout(function () {
            $.each(list, function (index, val) {
                if (index < 2500)
                    addPlayList(val.track, val.artist, val.cover, false);
            });
            loading('hide');
        }, 250);
    }
    localStorage.setItem("playlist_active", PlaylistNumber);
    $("#changePlaylist li.active,#changePlaylist2 li.active").removeClass("active");
    $("." + PlaylistNumber).addClass('active');

    $("#numItems,.numItems").text($("#playlist-items a").length);


}

function exportPlayList() {
    var list = localStorage.getItem(PlaylistNumber);
    $("#export textarea").val(list);
    $("#export").submit();
}

// IMPORT
function importPlayList() {
    $('div#importPlayList').modal({
        keyboard: false,
        backdrop: false
    }).modal('show');
    $("#pltrg").text(PlaylistNumber.replace("playlist_", "Playlist "));
}

function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = files[i]; i++) {
        var fr = new FileReader();
        fr.onload = function (e) {
            // e.target.result should contain the text
            localStorage.setItem(PlaylistNumber, e.target.result);
            loadPlayList();
            $('div#importPlayList').modal("hide");
        };
        fr.readAsText(f);
    }

}

if ($("#files").length)
    document.getElementById('files').addEventListener('change', handleFileSelect, false);


function getVideo(track, artist, obj) {

    if ($("#playlist-items a").length <= 0)
        return false;
    $("#artistInfo").text("Loading...");
    $("#trackInfo").text("");
    searching = true;
    $.getJSON(base_url + 'music/getYoutube/', {
        track: track,
        artist: artist,
        picture: window.btoa($(obj).attr("data-cover"))
    }, function (json, textStatus) {
        if (json.id != 'null' && json.id != null) {
            adsAudio = '';
            if (json.ads != null)
                adsAudio = json.ads;

            loadNewVideo(json.id, 0, 'small', adsAudio);
            play();

            $("#trackInfo").text(track);
            $("#trackInfo").unbind('click');
            $("#trackInfo").click(function (event) {
                getSongInfo(artist, track);
            });

            $("#artistInfo").text(artist);
            $("#artistInfo").unbind('click');
            $("#artistInfo").click(function (event) {
                getArtistInfo(artist);
            });

            $(document).trigger("load_video", [artist, track, $(obj).attr("data-cover"), json.id]);

            push_analytics(['_trackEvent', 'Track', 'Play', artist + " - " + track]);
            errors = 0;
            subtitle_cur = 1;
            subtitle = false;
            setPlaylistCurrent(artist, track, $(obj).attr("data-cover"));
            $("#subtitle div").text("");
            $(".btn-cc i").removeClass("subtitle-ok");


            if (data = getCache("cc_" + json.id)) {
                subtitle = JSON.parse(data);
                $(".btn-cc i").addClass("subtitle-ok");

            }
            else {
                $.post(base_url + 'music/musik/get_subtitle', {
                    v: json.id,
                    track: track,
                    artist: artist
                }, function (data, textStatus, xhr) {
                    subtitle = data;
                    $("#subtitle .now").html("<i class='fa fa-music'></i><i class='fa fa-music'></i><i class='fa fa-music'></i><i class='fa fa-music'></i><i class='fa fa-music'></i><i class='fa fa-music'></i>");
                    if (data != null && data != 'null') {
                        $(".btn-cc i").addClass("subtitle-ok");
                        //setCache("cc_"+json.id,JSON.stringify(data));
                    }


                }, "json");
            }


        }
        else {
            if (!json.error) {
                errors++;
                __log("[YOUTUBE] Next Song Video Null", 'warn');
                push_analytics(['_trackEvent', 'Track', 'Error', artist + " - " + track]);
                if (errors >= 5) {
                    $.smallBox({
                        title: "Error",
                        content: "The playlist is paused due multiples errors during playback.",
                        timeout: 10000
                    });
                }
                else {
                    $.smallBox({title: "No Found", content: "Video/Audio No Found!", timeout: 3000});
                    playNextSong();


                }
            }
            else {
                __log("[YOUTUBE] Error Youtube API: " + json.message, "error");
                __log("[YOUTUBE] Read documentation how set your api key on http://support.jodacame.com/knowledge-base/how-i-can-get-youtube-data-api", "info");
            }

        }
        searching = false;
    });

}


function loadPlayListsArtist(artist) {
    if (!artist)
        return false;
    loading();
    $.post(base_url + "music/getPlaylistsArtist/", {artist: artist}, function (data, textStatus) {
        $("#target").html(data);
        loading('hide');
    });
}

function setPlaylistCurrent(artist, track, cover) {
    var li = '<li class="plartist btn-playlists-artist" data-artist="' + artist + '"> \
	      			<div class="avatar" style="background-image: url(' + cover + ')"> </div> \
	      			<div class="data truncate">   \
	          			<strong class="truncate">' + label_discover + '</strong> \
	          			<span class="truncate">' + artist + '</span> \
	      			</div> \
	    		</li>';
    $("#playlist-feature ul .plartist").remove();
    $("#playlist-feature ul").prepend(li);

}

function loadPlayListDB(json, append) {
    localStorage.setItem(PlaylistNumber, json);
    loadPlayList(append);
}

function loadPlayListShare(hash) {

    $.getJSON(base_url + 'music/getPlayList/' + hash, function (data) {

        if (data !== null && typeof data === 'object') {
            $("#playlist-items").empty();
            $.each(data, function (index, val) {
                if (index < 502)
                    addPlayList(val.track, val.artist, val.cover, false);
            });

            playNextSong(0);
        }
    });


}

function loadNewVideo(id, startSeconds, quality, ads) {


    if (ytplayer) {

        $("#current progress-bar").width("0%");
        if (ads != '') {
            tempVideo = id;
            id = ads;

        }
        ytplayer.loadVideoById(id, parseInt(startSeconds), youtube_quality);

        if (is_mobile) {

            $("#videoPlayer").removeClass('active');
            $("#thumbnail").addClass('hidePlayer');

        }

    }
    else {

        adsAudio = '';
        ytplayer = new YT.Player('ytapiplayer', {
            height: '250',
            width: '250',
            videoId: id,
            suggestedQuality: youtube_quality,
            playerVars: {
                'controls': youtube_control, 'autoplay': 1, 'html5': 1
            },
            events: {
                'onReady': onYouTubePlayerReady
            }
        });

        if (start_youtube == "1") {
            $("#videoPlayer").addClass('active');
            $("#thumbnail").removeClass('hidePlayer');
            $(".btn-download-mp3").hide();
        }

        if (is_mobile) {

            $("#videoPlayer").addClass('active');
            $("#thumbnail").removeClass('hidePlayer');
            $('#thumbnailx ,.info-thumb').popover('show');
            setTimeout(function () {
                $('#thumbnailx ,.info-thumb').popover('hide');
            }, 5000);

        }

    }
}

function onYouTubePlayerReady(playerId) {
    try {
        __log('[YOUTUBE] onYouTubePlayerReady', 'log');
        setInterval(updateytplayerInfo, 50);
        //ytplayer.addEventListener("onStateChange", "onytplayerStateChange");
        ytplayer.addEventListener("onError", "onPlayerError");
        $("#volume").slider('setValue', getVolume());
    } catch (e) {
        __log('[YOUTUBE] Error on Function onYouTubePlayerReady', 'error');
        __log(e, 'error');

    }

}

function onytplayerStateChange(newState) {

}

function updateytplayerInfo() {

    if (!ytplayer)
        return false;


    if (getCurrentTime() > limit_time) {
        __log("[YOUTUBE] Next Song Limit Time", 'warn');
        playNextSong();
    }
    try {
        if (typeof subtitle === 'object' && subtitle != null && subtitle != 'null') {
            if (!$(".btn-cc").hasClass('text-muted')) {

                var _comming = subtitle[subtitle_cur + 1].text;
                if (subtitle_cur == 1)
                    _comming = subtitle[subtitle_cur].text;
                if (_comming == '')
                    _comming = subtitle[subtitle_cur + 2].text;

                $("#subtitle .comming").text(_comming);
                if (subtitle[subtitle_cur] != undefined) {

                    if (getCurrentTime() >= parseFloat(subtitle[subtitle_cur].end)) {
                        $("#subtitle .now").html("<i class='fa fa-music'></i><i class='fa fa-music'></i><i class='fa fa-music'></i><i class='fa fa-music'></i>...");
                        subtitle_cur++;
                    }

                    if (getCurrentTime() >= (parseFloat(subtitle[subtitle_cur].start) - 0.7) && getCurrentTime() <= parseFloat(subtitle[subtitle_cur].end)) {
                        if (!$("#subtitle").is(":visible"))
                            $("#subtitle").show();
                        $("#subtitle .now").text(subtitle[subtitle_cur].text);
                        if (subtitle[subtitle_cur].text == '')
                            $("#subtitle .now").html("<i class='fa fa-music'></i> <i class='fa fa-music'></i> <i class='fa fa-music'></i> <i class='fa fa-music'></i> ...");
                    }
                }
            }
        }
    } catch (e) {
        __log("[YOUTUBE] Error updateytplayerInfo", "error");
        __log(e, "error");
    }

    $("#tracktime,.tracktime").html(hhmmss(getDuration()));
    $("#tracktime2,.tracktime2").html(hhmmss(getCurrentTime()));
    pos = (getCurrentTime() * 100) / getDuration();
    $("#current .progress-bar").width(pos + "%");


    if (radio) {
        $("#stopRadio").show();
        if (parseInt(pos) % 30 == 0) {
            var track = $("#playlist-items a.active").attr("data-track");
            var artist = $("#playlist-items a.active").attr("data-artist");
            getNextSongRadio(track, artist)
        }
    }
    else {
        $("#stopRadio").hide();
    }
    pos = ((getBytesLoaded() + getStartBytes()) * 100) / getBytesTotal();
    if (!isNaN(pos)) {
        $("#buffer .progress-bar").width(pos + "%");
    }

    //$(document).trigger( "updated_info", [getCurrentTime(),getDuration(),getPlayerState() ] );

    if (getPlayerState() == 0 && searching == false) {
        __log("[PLAYLIST] Next Song!", "log");
        playNextSong();
    }
    $("#numItems,.numItems").text($("#playlist-items a").length);


    if (getPlayerState() == 1) {
        $("#pause").show();
        $("#play").hide();
        $(".musicbar,.show-when-playing").removeClass('hide');

        if (is_mobile) {

            $("#videoPlayer").removeClass('active');
            $("#thumbnail").addClass('hidePlayer');

        }

        $("#artistInfo .fa").remove();

    }
    else {


        if (getPlayerState() == 5) {
            $("#play").click();
        }
        if (getPlayerState() == 3) {
            if ($("#artistInfo .fa").length <= 0)
                $("#artistInfo").prepend('<i class="fa fa-refresh icon-spin"></i> ');
        }
        else {
            $("#artistInfo fa").remove();
        }
        $("#pause").hide();
        $("#play").show();
        $(".musicbar,.show-when-playing").addClass('hide');
    }

    if (adsAudio) {
        $("#playlist-items i").addClass("hide");
        $(".jp-controls").addClass("hide");
    }
    else {
        $("#playlist-items i").removeClass("hide");
        $(".jp-controls").removeClass("hide");
    }


}


function cueNewVideo(id, startSeconds) {

    ytplayer.cueVideoById(id, startSeconds);

}

function play() {
    try {
        if (ytplayer) {
            if ($("#playlist-items a").length <= 0)
                return false;
            ytplayer.playVideo();
            $("#play").hide();
            $("#pause").show();
        }
    } catch (e) {

    }


}

function pause() {
    if (_is_station) {
        audio_obj.pause();
    }
    else {
        ytplayer.pauseVideo();
        $("#play").show();
        $("#pause").hide();
    }

}

function onPlayerError(e) {
    setTimeout(function () {
        playNextSong();
    }, 10000);
}

function getPlayerState() {
    try {
        return ytplayer.getPlayerState();
    } catch (e) {
        return -1;
    }


}

function seekTo(seconds) {
    if (getPlayerState() == -1)
        return false;
    ytplayer.seekTo(seconds, true);

}

function getBytesLoaded() {
    try {
        return ytplayer.getVideoBytesLoaded();
    } catch (e) {
        return 0;
    }
}

function getBytesTotal() {
    try {
        return ytplayer.getVideoBytesTotal();
    } catch (e) {
        return 0;
    }

}

function getCurrentTime() {
    try {
        return ytplayer.getCurrentTime();
    } catch (e) {
        return 0;
    }

}

function getDuration() {
    try {
        return ytplayer.getDuration();
    } catch (e) {
        return 0;
    }

}

function getStartBytes() {
    try {
        return ytplayer.getVideoStartBytes();
    } catch (e) {
        return 0;
    }
}

function register_user() {
    var email = $('#registerForm [name="email"]').val();
    var pwd1 = $('#registerForm [name="password1"]').val();
    var pwd2 = $('#registerForm [name="password2"]').val();
    var nick = $('#registerForm [name="nickname"]').val();
    if (isEmpty(pwd1) || isEmpty(pwd2) || isEmpty(email) || isEmpty(nick)) {
        alert(msg_required_fields);
        return false;
    }

    $.post(base_url + 'music/registerUser', {
        "nick": nick,
        "email": email,
        "pwd1": pwd1,
        "pwd2": pwd2
    }, function (data, textStatus, xhr) {
        if (data.error == 1) {
            alert(data.msg);
            push_analytics(['_trackEvent', 'Register', 'Error', email]);
        }
        if (data.error == 0) {
            //location.reload();
            push_analytics(['_trackEvent', 'Register', 'Success', email]);
            location.href = data.target;
        }
    }, "json");
}

function changePassword() {
    $("#chPasswordModal").modal("show");
}

function change() {
    var pwd1 = $('#changePasswordForm [name="password1"]').val();
    var pwd2 = $('#changePasswordForm [name="password2"]').val();
    if (isEmpty(pwd1) || isEmpty(pwd2)) {
        alert(msg_required_fields);
        return false;
    }
    $.post(base_url + 'music/updatePassword', {"password1": pwd1, "password2": pwd2}, function (data, textStatus, xhr) {
        if (data.error == 1) {
            alert(data.msg);
        }
        if (data.error == 0) {
            alert(data.msg);
            $("#chPasswordModal").modal("hide");
        }
    }, "json")

}

function login() {
    var email = $('#loginForm [name="email"]').val();
    var pwd1 = $('#loginForm [name="password1"]').val();
    if (isEmpty(pwd1) || isEmpty(email)) {
        alert(msg_required_fields);
        return false;
    }

    $.post(base_url + 'music/login', {"email": email, "pwd1": pwd1}, function (data, textStatus, xhr) {

        if (data.error == 1) {
            push_analytics(['_trackEvent', 'Login', 'Error', email]);
            alert(data.msg);
        }
        if (data.error == 0) {
            push_analytics(['_trackEvent', 'Login', 'Success', email]);
            document.location = base_url + 'music/reload';
        }
    }, "json")

}

function recoveryPassword() {
    var email = $('#recoveryForm [name="email"]').val();
    if (isEmpty(email)) {
        alert(msg_required_fields);
        return false;
    }
    $("#recoveryForm button").attr("disabled", "disabled");
    $.post(base_url + 'music/recovery', {"email": email}, function (data, textStatus, xhr) {
        alert(data.msg);
        $("#recoveryForm button").attr("disabled", "");
        $("#recoveryForm button").removeAttr("disabled");
        if (data.error == "0")
            $("#loginModal").modal("hide");
    }, "json")

}

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function isPlaying() {
    if (getPlayerState() == 1)
        return true;
    else
        return false;
}

window.onbeforeunload = function () {
    if (getPlayerState() == 1) {
        return msg_exit_page;
    }
}

function center_banner() {
    var width = $(".banner.fixed").width();
    var left = ($(window).width() / 2) - (width / 2);

    $(".banner.fixed").css("left", left + "px");
    setTimeout(function () {
        $(".banner.fixed .close").show();
    }, 3000);
}


function __log(str, type) {
    if (window.console) {
        if (!type)
            type = 'log';

        switch (type) {
            case 'warn':
                console.warn(str);
                break;
            case 'info':
                console.info(str);
                break;
            case 'error':
                console.error(str);
                break;
            case 'time':
                console.time(str);
                break;
            case 'timeEnd':
                console.timeEnd(str);
                break;
            default:
                if (___debug)
                    console.log(str);
        }
    }

}


// Automatically cancel unfinished ajax requests
// when the user navigates elsewhere.
$(function () {
    var xhrPool = [];
    $(document).ajaxSend(function (e, jqXHR, options) {
        xhrPool.push(jqXHR);
    });
    $(document).ajaxComplete(function (e, jqXHR, options) {
        xhrPool = $.grep(xhrPool, function (x) {
            return x != jqXHR
        });
    });
    var abort = function () {
        $.each(xhrPool, function (idx, jqXHR) {
            jqXHR.abort();
        });
    };

    var oldbeforeunload = window.onbeforeunload;
    window.onbeforeunload = function () {
        var r = oldbeforeunload ? oldbeforeunload() : undefined;
        if (r == undefined) {
            // only cancel requests if there is no prompt to stay on the page
            // if there is a prompt, it will likely give the requests enough time to finish
            abort();
        }
        return r;
    }
});


function getCache(key) {
    if (typeof(Storage) !== "undefined") {
        if (cache) {
            data = localStorage.getItem(key);
            if (data) {
                var size = ((data.length * 2) / 1024 / 1024).toFixed(2);
                __log("[CACHE] Get Item (" + size + " MB)");
            }


            return data;
        }
    }
    else {
        console.error("[CACHE] Sorry! No Web Storage support");
    }
}

function setCache(key, data) {
    if (typeof(Storage) !== "undefined") {
        if (cache) {
            try {
                var size = ((data.length * 2) / 1024 / 1024).toFixed(2);
                if (size < 1) {
                    __log("[CACHE] Save Item (" + size + " MB)");
                    localStorage.setItem(key, data);
                    checkSizeCache();
                }
                else {
                    __log("[CACHE] Long data  [" + size + " MB] (Not save on cache)", "info");
                }

            } catch (e) {
                console.error(e);
                __log("[CACHE] Full Cache, Set Empty", "info");
                clearCache();
                setTimeout(function () {
                    setCache("cache_id", cache_id);
                }, 1000);
            }
        }
    }
    else {
        console.error("[CACHE] Sorry! No Web Storage support", "warn");
    }
}

function checkSizeCache() {
    size = 0;
    for (var x in localStorage) {
        size = parseFloat(size) + parseFloat(((localStorage[x].length * 2) / 1024 / 1024).toFixed(2));

    }
    if (size > 9.2) {
        __log("[CACHE] Full Cache, Set Empty", "info");
        clearCache();
        setTimeout(function () {
            setCache("cache_id", cache_id);
        }, 1000);
    }
    __log("[CACHE] Usage " + size.toFixed(2) + " MB of 10 MB", "log");

}

function clearCache() {
    __log("[CACHE] Cleaning Cache", "info");
    var _tmp_playlist_active = localStorage.playlist_active;
    var _tmp_playlist_1 = localStorage.playlist_1;
    var _tmp_playlist_2 = localStorage.playlist_2;
    var _tmp_playlist_3 = localStorage.playlist_3;
    var _tmp_playlist_4 = localStorage.playlist_4;
    var _tmp_playlist_5 = localStorage.playlist_5;
    localStorage.clear();

    localStorage.playlist_active = _tmp_playlist_active;

    if (_tmp_playlist_1 != undefined && _tmp_playlist_1 != 'undefined' && _tmp_playlist_1 != null && _tmp_playlist_1 != 'null' && _tmp_playlist_1 != false)
        localStorage.playlist_1 = _tmp_playlist_1;
    if (_tmp_playlist_2 != undefined && _tmp_playlist_2 != 'undefined' && _tmp_playlist_2 != null && _tmp_playlist_2 != 'null' && _tmp_playlist_2 != false)
        localStorage.playlist_2 = _tmp_playlist_2;
    if (_tmp_playlist_3 != undefined && _tmp_playlist_3 != 'undefined' && _tmp_playlist_3 != null && _tmp_playlist_3 != 'null' && _tmp_playlist_3 != false)
        localStorage.playlist_3 = _tmp_playlist_3;
    if (_tmp_playlist_4 != undefined && _tmp_playlist_4 != 'undefined' && _tmp_playlist_4 != null && _tmp_playlist_4 != 'null' && _tmp_playlist_4 != false)
        localStorage.playlist_4 = _tmp_playlist_4;
    if (_tmp_playlist_5 != undefined && _tmp_playlist_5 != 'undefined' && _tmp_playlist_5 != null && _tmp_playlist_5 != 'null' && _tmp_playlist_5 != false)
        localStorage.playlist_5 = _tmp_playlist_5;


}

hashCode = function (s) {
    return s.split("").reduce(function (a, b) {
        a = ((a << 5) - a) + b.charCodeAt(0);
        return a & a
    }, 0);
}