<section role="main" class="content-body">
   <header class="page-header">
      <h2>Reset Password</h2>
   </header>
   <!-- start: page -->
   <div class="row">
      <div class="col-md-12 col-lg-12 col-xl-12">
         <div id="changePassword" class="tab-pane">
             <?php if ($this->session->flashdata('success_message')) { ?>
                                <div class="alert alert-success"> 
                                    <?php echo $this->session->flashdata('success_message');
                                     ?> </div>
                            <?php } ?>
             <?php if ($this->session->flashdata('error_message')) { ?>
                                <div class="alert alert-danger"> 
                                    <?php echo $this->session->flashdata('error_message');
                                     echo validation_errors();?> </div>
                            <?php } ?>
             <form class="form-horizontal" method="post" action="<?php echo BASEURL.'home/reset'?>">
                     <h4 class="mb-xlg"></h4>
                     <fieldset class="mb-xl">
                         <div class="form-group">
                           <label class="col-md-3 control-label" for="profileNewPassword"><b>Old Password</b></label>
                           <div class="col-md-8">
                               <input type="password" class="form-control" name ="oldpassword" id="profileNewPassword">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-md-3 control-label" for="profileNewPassword"><b>New Password</b></label>
                           <div class="col-md-8">
                              <input type="password" class="form-control" name ="newpassword" id="profileNewPassword">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-md-3 control-label" for="profileNewPasswordRepeat"><b>Confirm Password</b></label>
                           <div class="col-md-8">
                              <input type="password" class="form-control" name ="confirmpassword" id="profileNewPasswordRepeat">
                           </div>
                        </div>
                     </fieldset>
                     <div class="">
                        <div class="row">
                           <div class="col-md-9 col-md-offset-3">
                              <button type="submit" class="btn btn-primary">Submit</button>
                              <button type="reset" class="btn btn-default">Reset</button>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
      </div>
   </div>
   <!-- end: page -->
</section>