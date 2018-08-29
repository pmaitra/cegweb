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
	<!-- Theme Base, Components and Settings -->
	<script src="<?php echo BASEURL;?>assets/javascripts/theme.js"></script>
				
	<!-- Theme Initialization Files -->
	<script src="<?php echo BASEURL;?>assets/javascripts/theme.init.js"></script>
		
	<!-- Examples -->
	<script src="<?php echo BASEURL;?>assets/javascripts/forms/examples.wizard.js"></script>
        <script src="<?php echo BASEURL;?>assets/javascripts/forms/examples.advanced.form.js"></script>
        <!-- <script src="assets/javascripts/ui-elements/examples.modals.js"></script>-->
        <script src="<?php echo BASEURL;?>assets/javascripts/forms/dashboard.validation.js"></script>
        <script src="<?php echo BASEURL;?>assets/javascripts/forms/admin.dashboard.validation.js"></script>
        
        <?php 
                if(!empty($user_registration_flag))
                {
        ?>
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
 

	</body>

</html>