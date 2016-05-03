

<?php if($this->config->item("contact_email") != '') { ?>
<form role="form" id="formEmail" onSubmit="return false;sendEmail();" style="margin:20px">
  <div class="form-group">
    <label for="from"><?php echo ___('contact_form_from'); ?></label>
    <input type="email" name="from" value="<?php echo  $this->session->userdata('username'); ?>"  required class="form-control" id="from" placeholder="">
  </div>
  <div class="form-group">
    <label for="name"><?php echo ___('contact_form_name'); ?></label>
    <input type="text" name="name"  id="name" value="<?php echo  $this->session->userdata('names'); ?>" required class="form-control" id="from" placeholder="">
  </div>
  <div class="form-group">
    <label for="subject"><?php echo ___('contact_form_subject'); ?></label>
    <input type="text" required name="subject" class="form-control" id="subject" >
  </div>
 <div class="form-group">
    <label for="message"><?php echo ___('contact_form_message'); ?></label>
    <textarea  rows="10" required name=""message class="form-control" id="message" ></textarea>
  </div>
   <div class="form-group">
    <label for="captcha"><?php echo ___('contact_form_captcha'); ?>  <strong><?php echo $this->session->userdata('captcha1'); ?> + <?php echo $this->session->userdata('captcha2'); ?> = ?  </strong> </label>
    <input type="number" name="captcha" required class="form-control" id="captcha" >
  </div>
  <div class="alert" id="response" style="display:none">

  </div>
  <button type="submit" class="btn btn-success" id="btnEmail" onCLick="sendEmail(this)"><?php echo ___('contact_form_send'); ?></button>
</form>
<script>
function sendEmail(btn){
  var from    = $("#from").val();
  var subject = $("#subject").val();
  var message = $("#message").val();
  var captcha = $("#captcha").val();
  var name    = $("#name").val();
  


  if(from != '' && subject != '' && message != '' && captcha != '' && name != '')
  {
    if($("#formEmail")[0].checkValidity()) 
    {

      $(btn).attr("disabled","disabled");
      $(btn).prepend(" <i class='fa fa-spin fa-spinner hide show inline'></i> ");
      $.post(base_url+'music/sendEmail', {from: from,subject:subject,message:message,name:name,captcha:captcha}, function(data, textStatus, xhr) {
        if(data.error == '1')
        {
            $("#response").removeClass('alert-success');
            $("#response").addClass('alert-danger');
            $("#response").html(data.msg);
            $("#response").fadeIn(500);

        }
        else
        {
            $("#response").removeClass('alert-error');
            $("#response").addClass('alert-success');
            $("#response").html(data.msg);
            $("#response").fadeIn(500);
            $("#formEmail input,#formEmail textarea").val('');
        }
        $("#btnEmail").removeAttr("disabled");
        $("#btnEmail i").remove();
        
      },"json");
    }
    
  }
}
</script>
<?php } else { ?>
<div class="alert alert-danger">
<strong>No Email Found</strong><br>Please set your Email contact in <i>Setting > Website</i>
</div>
<?php } ?>
