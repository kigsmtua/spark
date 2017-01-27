<body class="signin">
  <section>
        <div class="panel panel-signin">
            <div class="panel-body">
                <div class="logo text-center">
                    <img src="<?php echo base_url()?>themes/default/images/logo-primary.png" alt="Chain Logo" >
                </div>
                <br />
                <h4 class="text-center mb5">Already a Member?</h4>
                <p class="text-center">Sign in to your account</p>
                <div class="mb30"></div>
                <form action="<?php echo base_url()?>site/login" method="post">
                    <div class="input-group mb15">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" placeholder="Username">
                    </div><!-- input-group -->
                    <div class="input-group mb15">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Password">
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
                <a href="signup" class="btn btn-primary btn-block">Not yet a Member? Create Account Now</a>
            </div><!-- panel-footer -->
        </div><!-- panel -->
    </section>
