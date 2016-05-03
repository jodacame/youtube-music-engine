<?php  

/*
THEMES: 
default
amelia
cerulean
cosmo
cyborg
darkly
flatly
journal
lumen
readable
simplex
slate
spacelab
superhero
united
*/            
$config['theme_default']	= 'slate';                  
$config['theme']			= (isset($_GET['skin']) ? $_GET['skin'] : $config['theme_default']) ;
$config['title']			= "Youtube Music Engine"; // Meta Tag Title HTML
$config['brand']			= "Youtube Music Engine"; // Brand Menu
$config['description']		= "Youtube Music Engine"; // Meta Tag Description HTML
$config['lastfm']			= "b25b959554ed76058ac220b7b2e0a026";
$config['nplaylist'] 		= 1; // Number of allowed playlists
$config['start'] 			= 'TopArtist'; // TopTracks or TopArtist
$config['search'] 			= 'Modern'; // Classic or Modern
$config['popup'] 			= 0; // 0 Disabled; 1 Enabled (PopUp Random Show)
$config['popup_code'] 		= '<a target="_blank" href="http://google.com"><img src="http://placehold.it/250x250"></a>'; // Recomended 250x250
$config['ads_block'] 		= '<a target="_blank" class="img-responsive" href="http://codecanyon.net/item/youtube-music-engine/7490975?ref=jodacame"><img src="https://dl.dropboxusercontent.com/u/5404672/Imagenes%20Web/envanto/yme/banner_728x90.png"></a><br>'; // Empty off Block or Add code advertising here
$config['ads_block_footer']	= '<a target="_blank" class="img-responsive" href="http://codecanyon.net/item/youtube-music-engine/7490975?ref=jodacame"><img src="https://dl.dropboxusercontent.com/u/5404672/Imagenes%20Web/envanto/yme/banner_728x90.png"></a><br>'; // Empty off Block or Add code advertising here

$config['download_button'] 	= 1; // 1: Enable 0: Disable
$config['lyrics_button'] 	= 1; // 1: Enable 0: Disable
$config['volume_control'] 	= 0; // 1: Enable 0: Disable
$config['youtube_button'] 	= 1; // 1: Enable 0: Disable
$config['random_button'] 	= 1; // 1: Enable 0: Disable
$config['cover_search'] 	= 2; // Style Frame Cover Search => 1,2,3,4,5,6,7,8 or 9 
$config['lang'] 			= 'english'; // Default Language
$config['langs_available'] 	= array('english','spanish'); // Same name in folder application/language/
$config['user_change_lang']	= 1; //1: Enable 0: Disable "Can user select language in menu?"
$config['auto_country'] 	= 0; //1: Enable 0: Disable "Top Artist and Top Tracks For Country User"
$config['amazon_afiliate'] 	= 'anthmu-20'; //Empty Disable or Add your Amazon Associate ID for Enable
$config['footer_text'] 		= "© 2014 <a href='http://jodacame.com'>Jodacame.com</a>"; // Custom text footer page
$config['use_database']		= 1; 
$config['items_top'] 		= 30;
$config['purchase_code'] 	= ''; // http://support.jodacame.com/article/view/3
?>
