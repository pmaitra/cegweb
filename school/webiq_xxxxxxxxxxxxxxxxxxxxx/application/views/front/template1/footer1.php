</div>

			

		</section>
		<?php //echo BASEURL;?>

		<!-- Vendor -->
		<script src="<?php echo BASEURL;?>assets/vendor/jquery/jquery.js"></script>		
        <script src="<?php echo BASEURL;?>assets/vendor/bootstrap/js/bootstrap.js"></script>			
	
		<!-- Specific Page Vendor -->		
        <script src="<?php echo BASEURL;?>assets/vendor/jquery-ui/jquery-ui.js"></script>			
        <script src="<?php echo BASEURL;?>assets/vendor/select2/js/select2.js"></script>		
        <script src="<?php echo BASEURL;?>assets/vendor/jquery-validation/jquery.validate.js"></script>		
        <script src="<?php echo BASEURL;?>assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>	
        <script src="<?php echo BASEURL;?>assets/vendor/nanoscroller/nanoscroller.js"></script>
	<script src="<?php echo BASEURL;?>assets/vendor/pnotify/pnotify.custom.js"></script>
        <!-- Theme Base, Components and Settings -->
	<script src="<?php echo BASEURL;?>assets/javascripts/theme.js"></script>
	         <script src="<?php echo BASEURL;?>assets/javascripts/forms/custom.init.js"></script>			
	<!-- Theme Initialization Files -->
	<script src="<?php echo BASEURL;?>assets/javascripts/theme.init.js"></script>
		
	<!-- Examples -->
	<!--<script src="<?php echo BASEURL;?>assets/javascripts/forms/examples.wizard.js"></script>-->
        <script src="<?php echo BASEURL;?>assets/javascripts/forms/examples.advanced.form.js"></script>
        <!-- <script src="assets/javascripts/ui-elements/examples.modals.js"></script>-->

        <script src="<?php echo BASEURL;?>assets/javascripts/forms/dashboard.validation.js"></script>
        <script src="<?php echo BASEURL;?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <!-- <script src="<?php echo BASEURL;?>assets/javascripts/forms/custom.admin.js"></script> -->
        
        <!-- Theme Base, Components and Settings -->
	
        <?php 
                if(!empty($user_registration_flag))
                {
        ?>
       
	   <script src="<?php echo BASEURL;?>assets/javascripts/forms/bootstrapvalidator.min.js">"</script>
        <script src="<?php echo BASEURL;?>assets/javascripts/forms/custom.form.validation.js"></script>
        <script src="<?php echo BASEURL;?>assets/javascripts/forms/user_registration.js"></script>
        <script src="<?php echo BASEURL;?>assets/javascripts/forms/custom.preview.js"></script>
        
        <?php
                }
        ?>
        <?php if(!empty($default_tab_selection))
       {
        ?>
         <script><?php echo $default_tab_selection;?>()</script>
         <?php
               }
        ?>
         
        <?php if(!empty($default_print))
       {
        ?>
         <script src="<?php echo BASEURL;?>assets/javascripts/forms/custom.print.js"></script>
         
         <?php
               }
        ?>
         <script src="<?php echo BASEURL;?>assets/javascripts/forms/user_feedback.js"></script>
	</body>

</html>