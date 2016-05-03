<div class="row">
	<div class="col-xs-12">

	<table id="tableListPage"  class="table table-striped table-bordered table-hover">
	    <thead>
	        <tr>
	            <th>Title</th>
	            <th>Extract</th>
	            <th>Actions</th>	            
	        </tr>
	    </thead>
	    <tbody>
	    <?php foreach ($pages->result() as $row) {
	    	?>
	    	<tr>
	    		<td><?php echo $row->title; ?></td>
	    		<td><?php echo substr(strip_tags($row->content),0,100)."..."; ?></td>
		    	<td style="width:50px">
		    		<a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>dashboard/page/<?php echo $row->idpage; ?>" ><i class="fa fa-edit"></i></a>
					<button class="btn btn-danger btn-xs" onclick="removePage('<?php echo $row->idpage; ?>');"><i class="fa fa-trash-o"></i></button>
		    	</td>
		    </tr>
	    	<?php
	    }
	    ?>
	    </tbody>
	  </table>
	  <a href="<?php base_url(); ?>dashboard/page" class="btn btn-success" style="width:100%">New Page</a>
	</div>
	
</div>
<script>
$(function () {
	 $('#tableListPage').dataTable();
});

function removePage(id)
{	
	$.post(base_url+"dashboard/module/pages", {id_page:id,remove:'1'}, function(data, textStatus) {
		location.reload();	
	}); 

}

</script>