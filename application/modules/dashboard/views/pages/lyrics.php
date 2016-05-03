<a class="btn btn-success pull-right" href="<?php echo base_url(); ?>dashboard/lyric">New Lyric</a>
<div class="clearfix"></div>
<br>
 <table class="table table-hover table-striped table-bordered" id="lyricsTable">
<thead>
  <tr> 
    
    <th>Artist</th>                
    <th>Track</th>    
    <th style="width:50px"></th>                  
  </tr>
</thead>
<tbody>           
</tbody>
</table>

<script>
$(function () {
	$("#lyricsTable").dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo base_url(); ?>dashboard/all_lyrics",		
		"sPaginationType": "bootstrap",										
		 bAutoWidth     : true
		});	
});
</script>