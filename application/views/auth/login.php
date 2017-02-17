<body class="signin">
  <section>
        <?php
        if( isset( $login_error_mesg ) )
         {
          echo '
            <div style="border:1px solid red;">
                <p>
                    Login Error #' . $this->authentication->login_errors_count . '/' . config_item('max_allowed_attempts') . ': Invalid Username, Email Address, or Password.
                </p>
                <p>
                    Username, email address and password are all case sensitive.
                </p>
            </div>
        ';
        }

        if(  isset( $on_hold_message ) ){
           

           echo '
            <div style="border:1px solid red;">
                <p>
                    Excessive Login Attempts
                </p>
                <p>
                    You have exceeded the maximum number of failed login<br />
                    attempts that this website will allow.
                <p>
                <p>
                    Your access to login and account recovery has been blocked for ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes.
                </p>
                <p>
                    Please use the <a href="/examples/recover">Account Recovery</a> after ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes has passed,<br />
                    or contact us if you require assistance gaining access to your account.
                </p>
            </div>
        ';

       }

   ?>
        <div class="panel panel-signin">
            <div class="panel-body">
                <div class="logo text-center">
                    <img src="<?php echo base_url()?>themes/default/images/logo-primary.png" alt="Chain Logo" >
                </div>
                <br />
                <h4 class="text-center mb5">Already a Member?</h4>
                <p class="text-center">Sign in to your account</p>
                <div class="mb30"></div>
                 <?php echo form_open($login_url);?>
                   <div class="input-group mb15">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" placeholder="Username" name="login_string">
                    </div><!-- input-group -->
                    <div class="input-group mb15">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name ="login_pass">
                    </div><!-- input-group -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <div class="ckbox ckbox-primary mt10">
                                <input type="checkbox" id="rememberMe" value="1">
                                <label for="rememberMe">Remember Me</label>
                            </div>
                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">Sign In <i class="fa fa-angle-right ml5"></i></button>
                        </div>
                    </div>
                </form>
            </div><!-- panel-body -->
            <div class="panel-footer">
                <a href="<?php echo base_url()?>auth/register" class="btn btn-primary btn-block">Not yet a Member? Create Account Now</a>
            </div><!-- panel-footer -->
        </div><!-- panel -->
    </section>
