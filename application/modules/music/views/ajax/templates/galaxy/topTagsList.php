<div class="row">
                        <?php if($this->config->item("genres") != '')
                        {
                          $tags = explode(",", $this->config->item("genres"));
                          foreach ($tags as $key => $value) {     
                            $image = "assets/images/genres/".encode(strtolower($value)).".png";
                          if(!file_exists($image))                     
                             $image = "assets/images/genres/".encode(strtolower($value)).".jpg";                                                                               
                          if(!file_exists($image))                     
                             $image = "assets/images/no-cover.png";
                            ?>
                             <div class="col-xs-6 col-md-3 col-lg-2 marginTop20" >
                							    <div class="thumbnail cursor-pointer" onclick="getTopTags('<?php echo encode($value); ?>');"  style="background:url('<?php echo base_url().$image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
                							      <div style="height:120px;overflow:hidden;">         
                							        </div>    							         
                                      <div class="caption">                                             
                                      <a href="<?php echo base_url(); ?>tag/<?php echo encode($value); ?>" class="removehref truncate" onClick="return false;" data-tag="<?php echo encode($value); ?>"><?php echo ucwords($value); ?></a>                                    
                                    </div>
                							    </div>
                							      

							                </div>  
                          	<?php
                          }
                        }
                        else
                        {

                          ?>
                        <div class="alert alert-warning">Setting your Genres in your admin panel</div>
                        <?php } ?>
</div>
<div class="clearfix"></div><br>
<script>
$(".removehref").attr("href","#");
var stateObj = { foo: "bar" };
history.pushState(stateObj, "", "<?php echo base_url(); ?>tag/all");
</script>