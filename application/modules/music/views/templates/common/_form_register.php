 <h3 class="form-signin-heading"><?php echo ___("label_register"); ?></h3>
<input type="text" name="email" maxlength="100"class="form-control" placeholder="<?php echo ___("label_email"); ?>" required autofocus>
<input type="text" name="nickname" maxlength="30" class="form-control noSpecialChar" placeholder="<?php echo ___("label_nickname"); ?>" required autofocus>
<input type="password" name="password1" class="form-control" placeholder="<?php echo ___("label_password"); ?>" required>                               
<input type="password" name="password2" class="form-control" placeholder="<?php echo ___("label_repeat_password"); ?>" required>     

<button onclick="register_user();" class="btn btn-info" style="width:100%;margin-top:10px;margin-bottom:10px" type="button"><?php echo ___("label_register"); ?></button>                          