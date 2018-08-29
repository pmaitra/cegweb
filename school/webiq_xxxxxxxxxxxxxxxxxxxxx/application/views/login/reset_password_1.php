<section class="body-sign">           
                               
            <div class="center-sign">
                

                <div class="panel panel-sign">
                    <div class="panel-title-sign mt-xl text-right">
                        <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Forget Password &nbsp; In</h2>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo BASEURL;?>forgetPasswordSubmit" method="post">
                            <div class="form-group mb-lg">
                                <label>Username</label>
                                <div class="input-group input-group-icon">
                                    <input name="username" type="text" required="" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                    <label class="pull-left">New Password</label>
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="new_password" type="password" required="" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                    <label class="pull-left">Confirm New Password</label>
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="confirm_password" type="password" required="" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                    
                       
                            <div class="row">
                                
                                <div class="col-sm-4 text-right">
                                    <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                    
                                </div>
                            </div>

                        </form>
                    </div>
                </div>                    
            </div>
            
           
		</section>