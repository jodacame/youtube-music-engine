<div style="width:100%;margin-top:30px" id="searchBox">

<div align="center"><?php echo $this->config->item("brand"); ?></div>
<div align="center" style="font-size:36px;font-weight:400;"> <?php echo $this->config->item("title"); ?></div>
<br />

<form method="GET" action="">
<div class="page-content inset" style="margin:auto;">      	
	            <div class="row">               
	                <div class="col-md-12 well">
	                    <div class="input-group input-group" style="width:100%">
                 
	                        <input type="search" required class="form-control s" id="s2" name="s" placeholder="<?php echo ___("label_listen"); ?>" value="">
	                        <span class="input-group-btn">
	                            <button class="btn btn-primary" id="btnSearch" type="submit"><?php echo ___("label_search"); ?> <i class="fa fa-search"></i></button>
	                        </span>
							
	                    </div>                  
					</div>
					<?php if(!is_logged()){ ?>
					<div class="pull-right">
						<button type="button" class="btn btn-md btn-success loginBTN"><i class="fa fa-user"></i> <?php echo ___("label_register"); ?></button><button type="button" class="btn btn-md btn-success loginBTN"><i class="fa fa-arrow-circle-o-right"></i> <?php echo ___("label_login"); ?></button>
					</div>
					<?php  } ?>
				</div>




</div>
</form>

<script>
$(function () {
	//$(".adsblock").hide();	
	$(".loginBTN").click(function(event) {
		$("#loginModal").modal("show");
	});
	

});
</script>
</div>.