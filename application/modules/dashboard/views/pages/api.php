<?php
foreach ($api->result_array() as $key => $value) {
    $methods[$value['method']]['desc'] = $value['description_method'];
    $methods[$value['method']]['type'] = $value['type'];
    $methods[$value['method']]['param'][] = array("name" => $value['param'],"desc" => $value['description']);
}
$api_key = $this->config->item("apikey1");
?>
 <div class="row">
 	<div class="col-md-12">
        <div class="alert alert-info">
            <i class="fa fa-info"></i> Your API Key is <strong><?php echo ($api_key); ?></strong>
            <a href="?new=1" class="pull-right"><i class="fa fa-refresh"></i> Generate New</a>
        </div>
	 	<div class="box box-warning">	 	 	
	 	 		<div class="box-header">
	 	 			<h3 class="box-title"><i class="fa fa-gears"></i> Methods</h3>
	 	 		</div>
		 		<div class="box-body">	
                
                 
                    <div class="list-group">
                          <?php foreach($methods as $key => $value) {
                          ?>
                           <div class="list-group-item">
                            <h4 class="list-group-item-heading"><?php echo $key; ?></h4>
                            <p class="list-group-item-text">
                            <?php echo $value['desc']; ?>
                          
                            
                            
                            <small><strong class="pull-right" style="cursor:pointer" onClick="$('.param-<?php echo $key; ?>').slideToggle(500);">See Details</strong></small>
                            <br>                            
                            <div class="param-<?php echo $key; ?>" style="display:none">                                      
                            <br>
                            <strong>HTTP request</strong>
                            <br>
                            <br>
                            <code style="padding:10px;font-size:16px">

                            <strong><?php echo $value['type']; ?></strong> <?php echo base_url(); ?>api/<?php echo $key; ?><?php if($value['type'] == 'GET'){ ?><strong>?params</strong> <?php } ?>
                            </code>
                            <br>
                            <br>
                            <br>
                                <strong>Parameters</strong>
                                <br>
                                <br>
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <td>Parameter name</td>
                                                <td>Value</td>
                                                <td>Description</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($value['param'] as $k => $v)
                                            {                                            
                                                ?>
                                                <tr>
                                                    <td><strong><?php echo $v['name']; ?></strong></td>
                                                    <td>String</td>
                                                    <td><?php echo $v['desc']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                             <tr>
                                                    <td><strong>format</strong></td>
                                                    <td>xml / json</td>
                                                    <td>Output Format</td>
                                                </tr>

                                        </tbody>
                                    </table>                                  
                            
                                    <br>
                                    <br>


                                    <strong>Try it!</strong>
                                    <br>
                                    <form method="<?php echo $value['type']; ?>" target="_blank" action="<?php echo base_url(); ?>api/<?php echo $key; ?>">
                                        <table width="100%" cellspacing="2" cellpadding="5">
                                        <?php foreach($value['param'] as $k => $v)
                                        {  
                                            $valuet = '';
                                            if($v['name'] == 'key')
                                                $valuet = $api_key;
                                            ?>
                                            <tr>
                                            <td class="text-right"><?php echo $v['name']; ?></td>
                                            <td>
                                            <input  required name="<?php echo $v['name']; ?>" type="text" class="form-control" value="<?php echo $valuet; ?>">               
                                            </td>
                                            <td class="text-muted">                                            
                                                <?php echo $v['desc']; ?>
                                            </td>
                                          
                                        <?php } ?>
                                        </tr>
                                            <tr>
                                            <td class="text-right">format</td>
                                            <td>
                                            <select name="format" required class="form-control">
                                            <option value="json" selected>json</option>
                                            <option value="xml">xml</option>
                                            </select>
                                            </td>
                                            <td class="text-muted">                                            
                                                Output Format
                                            </td>
                                          </tr>

                                        <tr>
                                        <td></td>
                                        <td><button type="submit" class="btn btn-success"><i class=" fa fa-play"></i> Execute</button></td>
                                        <td></td>
                                        </tr>
                                        </table>
                                        <br>
                                        
                                    </form>
                                </div>
                            </p>
                          </div>
                          <?php
                            }
                          ?>
                        </div>

                    
                    <div class="clearfix"></div>
				</div>
		</div>
	</div>
</div>
