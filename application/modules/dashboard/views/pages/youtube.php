

<br>
 <table class="table table-hover table-striped table-bordered" id="lyricsTable">
<thead>
  <tr> 
    <th style="width:32px"></th>
    <th>Artist</th>                
    <th>Track</th>    
    <th>Youtube</th>    
    <th style="width:300px;">MBID</th>    
    <th>Genre</th>    
    <th style="width:70px">Reported</th>    
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
		"sAjaxSource": "<?php echo base_url(); ?>dashboard/all_tracks",		
		"sPaginationType": "bootstrap",										
		 bAutoWidth     : true
		});	
});
</script>