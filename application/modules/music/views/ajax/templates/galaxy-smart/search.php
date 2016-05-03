<div class="list-group" >
    <?php 
    if(count($search->results->trackmatches->track) == 0)
    {
        ?>
        <div class="alert alert-info">
            <strong><?php echo $query ?></strong>  No Found!
        </div>
        <?php
    }   
    if(count($search->results->trackmatches->track)>1)
        $search_a = $search->results->trackmatches->track;
    if(count($search->results->trackmatches->track)==1)
        $search_a[0] = $search->results->trackmatches->track;


    foreach ($search_a as $key => $value) {
        $picture = $value->image[3]->text;
        if($picture == '')
           $picture = base_url()."assets/images/no-cover.png";
       if($value->name != '')
        {
             
                $radius = '';
                if($this->config->item("cover_search") == 4)
                    $radius = 'border-radius:50%;';

                
                ?>
                   <a  href="#"  onClick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist); ?>','<?php echo $picture; ?>');return false;" class="list-group-item">
                        
                            
                                
                                
                                                                        
                                    <spam class="nowrap" title="<?php echo $value->name; ?>"><?php echo $value->name; ?> <span class="text-muted"><?php echo $value->artist; ?></span></span>
                                    
                                
                        
                    </a>
                <?php
                    
                }
               
            }
    
    ?> 
</div>
<script>
$(".removehref").attr("href","#");
</script>