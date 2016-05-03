 <!-- .carousel slide -->

 <?php
$show = false;
if($this->config->item("carousel_show") == 'all')
    $show = true;
if($this->config->item("carousel_show") == 'guest' && !is_logged())
    $show = true;
if($this->config->item("carousel_show") == 'registered' && is_logged())
    $show = true;

$items = getCarousel();
if($items->num_rows() > 0 && $this->config->item("carousel_active") == '1' && $show == true)
{
 ?>
 <div class="row  visble-md visible-lg">
          <div class="xol-xs-12">
                  <section class="panel panel-default" style="margin-top:10px">
                          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                         

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                              <?php 
                              $x = 'active';
                              $type['artist-info'] = ___('label_carousel_artist');
                              $type['playlist-artist'] = ___('label_artist_playlist');
                              $type['song-info'] = ___('label_carousel_track');
                              $type['start-radio'] = ___('label_carousel_radio');
                              $type['station'] = ___('label_start_radio_station');
                              $type['url'] = ___('label_carousel_url');
                              foreach ($items->result() as $row) {
                                ?>
                                <div class="item <?php echo  $x ; ?>">
                                  <img src="<?php echo base_url()."uploads/".$row->picture; ?>" style="width:100%" alt="...">
                                    <div class="carousel-caption">
                                    <h2><?php echo $row->title; ?></h2>                                        
                                    <?php if($row->type != 'url')  { ?>
                                    <?php if($row->type != 'station')  { ?>
                                    <button data-artist="<?php echo $row->artist; ?>"  data-track="<?php echo $row->track; ?>"  data-cover="<?php echo  base_url()."assets/images/no-cover.png"; ?>" class="btn btn-primary pull-right btn-<?php echo $row->type; ?>"> <?php echo $type[$row->type]; ?></button>
                                    <?php } else{ 
                                        $station = getStations(array("idtstation" => intval($row->station))); 
                                        $rowE  = $station->row();    

                                      ?>
                                    <button class="btn btn-primary pull-right btn-start-station" data-station="<?php echo $rowE->m3u; ?>" data-title="<?php echo $rowE->title; ?>" data-cover="<?php echo $image; ?>" data-id="<?php echo $rowE->idtstation;  ?>"> <?php echo $type[$row->type]; ?></button>
                                    <?php } ?>
                                    <?php }else{ ?>
                                    <a target="<?php echo $row->external_url_target; ?>" class="btn btn-primary pull-right "  href="<?php echo $row->external_url; ?>"> <?php echo $type[$row->type]; ?> </a>
                                    <?php } ?>
                                  </div>
                                </div>
                                <?php
                                $x='';
                              }
                              ?>
                              

                     

                            
                            </div>
                            <?php if($items->num_rows() > 1){ ?>
                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                              <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                              <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                            <?php } ?>
                          </div>
                  </section>
                  <!-- / .carousel slide -->
        </div>
</div>
<?php } ?>