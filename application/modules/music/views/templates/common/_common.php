<?php 
if($this->config->item("force_register") == '1' && !is_logged()) {  
	?>
	<script type="text/javascript">
		$("#popup_guest").modal("hide");
		$("#loginModal").modal("hide");
		$("#loginModal").modal("show");
	</script>
	<?php
}
echo $this->config->item("page_ajax_script"); 
?>