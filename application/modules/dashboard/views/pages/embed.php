<form method="POST">
<div class="col-xs-12">
    <div class="box box-info">

        <div class="box-body">
       
            <div class="form-group">
                <?php for($x=1;$x<=6;$x++){ ?>
                <label>Color <?php echo $x; ?>:</label>
                <div class="input-group colorpicker">
                    <div class="input-group-addon"><i></i></div>
                    <input required name="embed_color<?php echo $x; ?>" type="text" value='<?php echo $this->config->item("embed_color$x"); ?>' class="form-control"/>                    
                </div><!-- /.input group -->
                <?php } ?>

            <div class="form-group ">
                <label >Brand</label>
                <input  name="title_embed" type="text" placeholder="Empty for hide brand" class="form-control" placeholder="" value="<?php echo htmlentities($this->config->item("title_embed"), ENT_QUOTES, "UTF-8"); ?>">
              </div>  

                

            </div><!-- /.form group -->
            
        </div><!-- /.box-body -->
        <div class="box-footer">
        <i>Customize Colors Widged Embed</i>
        <br>
        <br>
        <button type="submit" class="btn btn-block btn-success">Save</button>
        </div>
    </div><!-- /.box -->
</div>
</form>

