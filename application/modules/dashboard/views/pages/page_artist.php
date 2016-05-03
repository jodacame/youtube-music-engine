<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">	 	 	
	 		<div class="box-body">		 			
	 			<input type="hidden" name="id" value="0">
				<input required="" maxlength="25" type="text" value="" class="form-control" name="artist" id="artist" style="width:100%" placeholder="Search Artist Here...">
				<br>	
				<table id="searchArtist" class="table table-hover -table-stripped ">
				</table>				
	 		</div>														
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">		 			
					<table class="table table-hover -table-stripped ">
						<?php
						if($page->num_rows() > 0)
						{
							foreach ($page->result() as $row) {
								?>
								<tr>
									<td><img src="<?php echo $row->cover; ?>" class="img-responsive" style="width:50px"></td>
									<td><?php echo $row->artist; ?></td>
									<td><form method="POST"><input type="hidden" name="idremove" value="<?php echo $row->id; ?>"><button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Remove</button></form></td>
								</tr>
								<?php
							}
						}
						?>
					</table>
					<?php 
					if($page->num_rows() == 0)
					{
						?><br>
						<div class="alert alert-warning">
							<strong>Page Emty</strong> No artist yet configured
						</div>
						<?php
					}
					?>
		 		</div>											
			</form>
		</div>
	</div>				
</div>
<script>
var artistSearch;
var template = 	"<tr> \
						<td><img src='{image}' class='img-responsive' style='width:50px'></td> \
						<td>{name}<br><small><a target='_blank' href='{url}'>View on Last.fm</a></small></td> \
						<td><form method='POST'><input type='hidden' name='artist' value=\"{name}\"><input type='hidden' name='cover' value='{image}'><button type='submit' class='btn btn-xs btn-success'><i class='fa fa-plus'></i> Add</button></form></td> \
					</tr>";
				
$(function () {
	$("#artist").keyup(function(event) {
		
		artistSearch = $(this).val() ;
		if(artistSearch == '')
			return false;
		delay(function(){
				$("#searchArtist").html("Searching...");
		    	$.getJSON("http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=" + artistSearch+ "&api_key=<?php echo $this->config->item("lastfm"); ?>&limit=30&format=json&callback=?", function(data) {
		    		$("#searchArtist").html('');
				    $.each(data.results.artistmatches.artist, function(index, val) {
				    	console.log(val);
				    	var item = replaceAll('{image}',val.image[3]["#text"],template);
				    	item = replaceAll('{name}',val.name,item);
				    	item = replaceAll('{url}',val.url,item);
				    	
				    	$("#searchArtist").append(item);	 
				    });
				    
				});
		 }, 500 );
		
	});	
});

var delay = (function(){
var timer = 0;
return function(callback, ms){
clearTimeout (timer);
timer = setTimeout(callback, ms);
};
})();

function replaceAll(find, replace, str) {
  return str.replace(new RegExp(find, 'g'), replace);
}

</script>