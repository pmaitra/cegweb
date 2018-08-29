
<?php
    //Selected Check start
    switch ($candidate_details['selected_flag']) 
    {
        case '0':
        //Scrutiny Check start
            switch ($candidate_details['scrutiny_flag']) 
            {
                case '0':
                    $display_data['message'] = 'Your application scrutiny is in progress';
                    $display_data['cls_details'] ='alert-info';
                break;
                case '1':
                    //interview schedule Check start
                    switch ($candidate_details['interview_schedule_flag']) 
                    {
                        case '0':
                            $display_data['message'] = 'Your application scrutiny has done.Interview schedule is in progress.';
                            $display_data['cls_details'] ='alert-info'; 
                            break;
                        case '1':
                            $interview_flag = 1;
                            $display_data['message'] = 'Your Application has been approved for interview.';
                            $display_data['cls_details'] ='alert-success';                            
                            break;

                        break;
                            default:
                                    $display_data['message'] = 'Your Application has Rejected.';
                                    $display_data['cls_details'] ='alert-danger'; 
                                    break;
                        }
                        //interview schedule Check end
                    break;
                    default:
                    $display_data['message'] = 'Your Application has Rejected.';
                    $display_data['cls_details'] ='alert-danger'; 
                    break;
                } 
            break;
            case '1':
                $display_data['message'] = 'Your Application has been selected.Please contact for admission.';
                $display_data['cls_details'] ='alert-success';                            
                break;
            default:
                $display_data['message'] = 'Your Application has Rejected.';
                $display_data['cls_details'] ='alert-danger'; 
                break;
            //Selected Check end 
    }
    
?>

<section role="main" class="content-body">
					<header class="page-header">
						<h2>Dashboard</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									
								</li>
							</ol>
					
							
						</div>
					</header>

					<!-- start: page -->
					<div class="row">
                                            
						<div class="col-md-12 col-lg-12 col-xl-12">							
							<section class="panel panel-primary">
								<header class="panel-heading">												
									<h2 class="panel-title">Application Status</h2>
								</header>
								<div class="panel-body">
									<table class="table table-bordered table-striped mb-none">
										<tbody>
                                                                                    <?php if(!empty($user_course_list)){
                                                                                            foreach ($user_course_list as $single_user_course) {
                                                                                     ?>
                                                                                   
											<tr class="alert alert-success">
												<td><?php echo !empty($single_user_course['all_details']['program_name'])?$single_user_course['all_details']['program_name']:'N/A';?></td>
												<td><?php echo !empty($single_user_course['status']['message'])?$single_user_course['status']['message']:'N/A';?></td>
											</tr>
                                                                                     <?php }
                                                                                    }
                                                                                    else {
                                                                                        ?>
                                                                                        <tr class="alert alert-success">
												<td> Sorry , no course assigned.</td>
												
											</tr>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
										</tbody>
									</table>

								</div>
							</section>
						</div>
                                            <?php if(!empty($user_course_list)){
                                                    foreach ($user_course_list as $single_user_course_interview) {
                                                        //pr($single_user_course_interview);
                                                     if(!empty($single_user_course_interview['status']['interview_flag'])) {?>
                                            <div class="col-md-12 col-lg-12 col-xl-12">							
							<section class="panel panel-primary">
                                                           
                                                            <header class="panel-heading">												
                                                                                    <h2 class="panel-title">Interview Details</h2>
                                                                            </header>
                                                                                    <div class="panel-body">
                                                                                            <table class="table table-bordered table-striped mb-none">
                                                                                                    <thead>
                                                                                                            <tr>
                                                                                                                    
                                                                                                                    <th>Course</th>
                                                                                                                    <th>Name</th>
                                                                                                                    <th>Interview Center</th>
                                                                                                                    <th>Interview Date & Time</th>
                                                                                                                    
                                                                                                            </tr>
                                                                                                    </thead>

                                                                                                    <tbody>
                                                                                                            <?php //pr($single_user_course_interview['status']['interview_times_slot_details']);?>
                                                                                                            <tr>
                                                                                                                    <td width="15%"><?php echo $single_user_course_interview['all_details']['program_name'];?></td>
                                                                                                                    <td width="15%"><?php echo $single_user_course_interview['all_details']['first_name'].' '.$single_user_course_interview['all_details']['middle_name'].' '.$single_user_course_interview['all_details']['last_name'];?></td>
                                                                                                                    
                                                                                                                    <td  width="36%"><?php echo $single_user_course_interview['status']['interview_details']['city'].', '.$single_user_course_interview['status']['interview_details']['address'];?></td>
                                                                                                                    <td width="34%"><b>IST : </b><?php echo date('d M Y',strtotime($single_user_course_interview['status']['interview_details']['interview_date']));?> ,
                                                                                                                    <?php echo !empty($single_user_course_interview['status']['interview_times_slot_details'][$single_user_course_interview['status']['interview_details']['interview_time_slot']])?$single_user_course_interview['status']['interview_times_slot_details'][$single_user_course_interview['status']['interview_details']['interview_time_slot']]:"";?></br>
                                                                                                                    <b>GMT : </b><?php echo gmdate('d M Y',strtotime($single_user_course_interview['status']['interview_details']['interview_date']));?> ,
                                                                                                                    <?php echo !empty($single_user_course_interview['status']['interview_times_slot_details'][$single_user_course_interview['status']['interview_details']['interview_time_slot']])?$single_user_course_interview['status']['interview_times_slot_details'][$single_user_course_interview['status']['interview_details']['interview_time_slot']]:"";?>
                                                                                                                    </td>
                                                                                                            </tr>
                                                                                                            <?php
                                                                                             //}
                                                                                            ?>
                                                                                                    </tbody>
                                                                                            </table>

                                                                                    </div>
							</section>
						</div>
                                            
                                            <?php } ?>
                                            <?php if(!empty($single_user_course_interview['status']['booking_flag'])) {
                                                //pr($single_user_course_interview['status']['booking_fee_details']);
                                                ?> 
<!--                                            <div class="col-md-12 col-lg-12 col-xl-12">							
							<section class="panel panel-primary">
								<header class="panel-heading">												
									<h2 class="panel-title"><?php echo $single_user_course_interview['all_details']['program_name']; ?> Booking Details</h2>
								</header>
								<div class="panel-body">
									<table class="table table-bordered table-striped mb-none fee-structure">
										<thead>
											<tr>
												<th width="10%">Sr. No.</th>
												<th width="35%">Particulars</th>
												<th width="15%">Due Dates</th>
												<th width="15%">Payment Details</th>
												<th width="15%" class="vert-right">Amount</th>												
												<th width="10%" class="vert-middle">Action</th>
											</tr>
										</thead>
                                                                                <tbody>
                                                                                    <tr>
												<td>1</td>
												<td>Booking Fees</td>
                                                                                                <td><b>IST : </b><?php echo !empty($single_user_course_interview['status']['booking_fee_details']['first_fee_end_date'])?
                                                                                                date('d M Y',strtotime($single_user_course_interview['status']['booking_fee_details']['first_fee_end_date'])):'N/A'; ?>
                                                                                                <b>GMT : </b><?php echo !empty($single_user_course_interview['status']['booking_fee_details']['first_fee_end_date'])?
                                                                                                gmdate('d M Y',strtotime($single_user_course_interview['status']['booking_fee_details']['first_fee_end_date'])):'N/A'; ?> 
                                                                                                 </td>
												
												<td><?php echo !empty($single_user_course_interview['status']['booking_fee_details']['first_fee'])?
                                                                                                '<span> <i class="fa fa-rupee" aria-hidden="true"></i>'.$single_user_course_interview['status']['booking_fee_details']['first_fee']:'N/A'; ?></td>
												<td class="vert-right"><?php echo !empty($single_user_course_interview['status']['booking_fee_details']['first_fee'])?
                                                                                                '<span> <i class="fa fa-rupee" aria-hidden="true"></i>'.$single_user_course_interview['status']['booking_fee_details']['first_fee']:'N/A'; ?></td>												
                                                                                                <td  class="vert-middle">
                                                                                                    <a href="<?php echo BASEURL.'bookingfeepayment/'.$single_user_course_interview['status']['booking_fee_details']['application_id'].'_'.$single_user_course_interview['status']['booking_fee_details']['first_fee'];?>" class="mb-xs mt-xs mr-xs btn-sm btn-success">Pay</a>
                                                                                                </td>
											</tr>
                                                                                </tbody>
                                                                        </table>
                                                                </div>
                                                        </section>
                                            </div>-->
                                            <?php } ?>
                                            <?php if(!empty($single_user_course_interview['status']['admission_flag'])) {?>
                                                
						<div class="col-md-12 col-lg-12 col-xl-12">							
							<section class="panel panel-primary">
								<header class="panel-heading">												
									<h2 class="panel-title"><?php echo $single_user_course_interview['all_details']['program_name']; ?> Admission Details</h2>
								</header>
								<div class="panel-body">
									<table class="table table-bordered table-striped mb-none fee-structure">
										<thead>
											<tr>
												<th width="5%">Sr.</th>
												<th width="20%">Particulars</th>
												<th width="10%">DueDate</th>
												<th width="35%">Payment Details</th>
												<th width="10%" class="vert-right">Amount</th>												
												<th width="20%" class="vert-middle">Action</th>
											</tr>
										</thead>
										<tbody>
                                                                                    <?php 
                                                                                    if(!empty($single_user_course_interview['status']['admission_payment_details']))
                                                                                    {
                                                                                        foreach ($single_user_course_interview['status']['admission_payment_details'] as $single_admission_payment_details )
                                                                                        {
                                                                                            $paid_arr[$single_admission_payment_details['term_id']] = $single_admission_payment_details['invoice_id'];
                                                                                            
                                                                                                $paid_term_arr[] = $single_admission_payment_details['term_id'];
                                                                                            
                                                                                        }
                                                                                        $paid_term_arr = array_unique($paid_term_arr);
                                                                                        
                                                                                        
                                                                                    }
                                                                                    if (!empty($single_user_course_interview['status']['admission_details'])){
                                                                                        $payment_fee_details = $single_user_course_interview['status']['admission_details'];
                                                                                        //pr($payment_fee_details);
                                                                                        for($i=0;$i<count($payment_fee_details);$i++)
                                                                                        {
                                                                                            
                                                                                            if(!empty($payment_fee_arr) && array_key_exists($payment_fee_details[$i]['term_id'], $payment_fee_arr))
                                                                                            {
                                                                                               // $payment_fee_arr[$payment_fee_details[$i]['term_id']][]=$payment_fee_details[$i];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['total_fee'] = 
                                                                                                        ($payment_fee_arr[$payment_fee_details[$i]['term_id']]['total_fee']+$payment_fee_details[$i]['general_fee']);
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['fee_type']=$payment_fee_details[$i]['fee_type'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['general_fee']=$payment_fee_details[$i]['general_fee'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['st_fee']=$payment_fee_details[$i]['st_fee'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['sc_fee']=$payment_fee_details[$i]['sc_fee'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['obc_fee']=$payment_fee_details[$i]['obc_fee'];
                                                                                                
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['term_name']=$payment_fee_details[$i]['term_name'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['payment_last_date']=$payment_fee_details[$i]['payment_last_date'];
                                                                                                
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['fee_type']=$payment_fee_details[$i]['fee_type'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['general_fee']=$payment_fee_details[$i]['general_fee'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['st_fee']=$payment_fee_details[$i]['st_fee'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['sc_fee']=$payment_fee_details[$i]['sc_fee'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['fee_structure'][$i]['obc_fee']=$payment_fee_details[$i]['obc_fee'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['total_fee']=$payment_fee_details[$i]['general_fee'];
                                                                                                $payment_fee_arr[$payment_fee_details[$i]['term_id']]['term_id']=$payment_fee_details[$i]['term_id'];
                                                                                                
                                                                                            }
                                                                                        }
                                                                                        //pr($single_user_course_interview['status']['admission_details']);
                                                                                        $count=0;
                                                                                        //pr($payment_fee_arr);
                                                                                        foreach ($payment_fee_arr as $single_admission_details) {
                                                                                            $count++;
                                                                                    ?>
											
                                                                                        <tr>
												<td><?php echo $count; ?></td>
                                                                                                <td><?php echo !empty($single_admission_details['term_name'])?$single_admission_details['term_name']:'N/A';?></td>
                                                                                                <td><?php echo !empty($single_admission_details['payment_last_date'])?date('d M,Y',strtotime($single_admission_details['payment_last_date'])):'N/A';?></td>
												<td><?php //pr();
                                                                                                    if(!empty($single_admission_details['fee_structure']))
                                                                                                    {  //pr($single_admission_details['fee_structure']);
                                                                                                        foreach ($single_admission_details['fee_structure'] as $single_fees) {
                                                                                                           // pr($single_fees);
                                                                                                            echo '<p>'.$single_fees['fee_type'].' </p><span> <i class="fa fa-rupee" aria-hidden="true"></i>'.$single_fees['general_fee'].'</span>';
                                                                                                        }
                                                                                                        if(!empty($single_user_course_interview['status']['first_fee_detials']['amount']) && ($count == 1))
                                                                                                        {
                                                                                                            
                                                                                                            echo '<p>Booking Fees </p><span> - <i class="fa fa-rupee" aria-hidden="true"></i>'.$single_user_course_interview['status']['first_fee_detials']['amount'].'</span>';
                                                                                                        
                                                                                                            $single_admission_details['total_fee'] = $single_admission_details['total_fee'] - $single_user_course_interview['status']['first_fee_detials']['amount'];
                                                                                                        }
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        echo 'N/A';
                                                                                                    }
                                                                                                ?></td>
												
												<td class="vert-aligned">
                                                                                                    <?php echo !empty($single_admission_details['total_fee'])?'<i class="fa fa-rupee" aria-hidden="true"></i>'.$single_admission_details['total_fee']:'N/A';?></td>
												<td class="vert-middle">
                                                                                                    <?php
                                                                                                    //pr($single_user_course_interview['status']['admission_avaliable_count']);
                                                                                                    if(!empty($single_user_course_interview['status']['admission_avaliable_count']) 
                                                                                                            && ($single_user_course_interview['status']['admission_avaliable_count'] > 0))
                                                                                                    {
                                                                                                    if(!empty($paid_term_arr) && in_array($single_admission_details['term_id'],$paid_term_arr)){ ?>
                                                                                                        <a href="<?php echo BASEURL.'invoicedisplay/'.$paid_arr[$single_admission_details['term_id']];?>" class="mb-xs mt-xs mr-xs btn-sm btn-success">Invoice</a>
                                                                                                    <?php }else{ ?>
                                                                                                        <p>Payment</p>
                                                                                                        <p>
                                                                                                            <a href="<?php echo BASEURL.'feepayment/'.$single_user_course_interview['all_details']['application_id'].'_'.$single_admission_details['term_id'].'_'.$single_admission_details['total_fee'];?>" class="mb-xs mt-xs mr-xs btn-sm btn-success">Online</a>
                                                                                                        </p>
                                                                                                        <p>
                                                                                                            <a class="mb-xs mt-xs mr-xs btn-sm btn-info" href="#" data-toggle="modal" data-target="#oflinePaymentModal">Offline</a>
<!--                                                                                                            <a href="<?php echo BASEURL.'feepayment/'.$single_user_course_interview['all_details']['application_id'].'_'.$single_admission_details['term_id'].'_'.$single_admission_details['total_fee'];?>" class="mb-xs mt-xs mr-xs btn-sm btn-info">Offline</a>-->
                                                                                                        </p>
                                                                                                    <?php }
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
											</tr>
                                                                                    <?php }} ?>
											
										</tbody>
									</table>

								</div>
							</section>
						</div>
						
					
			
                                            <?php } }} ?>
                                            
                                            
						<div class="col-md-6 col-lg-16 col-sm-6">							
							<section class="panel panel-primary">
								<header class="panel-heading">												
									<h2 class="panel-title">Registration Invoice</h2>
								</header>
								<div class="panel-body">
									<table class="table table-bordered table-striped mb-none">
										<tbody>
                                                                                    <?php if(!empty($user_course_list)){
                                                                                            foreach ($user_course_list as $single_user_course) {
                                                                                     ?>
											<tr>
												<td><?php echo !empty($single_user_course['all_details']['program_name'])?$single_user_course['all_details']['program_name'].' Application':'N/A';?> </td>
												<td><a class="text-primary" href="<?php echo BASEURL.'paymentreciept/'.$single_user_course['all_details']['application_id']?>">Print Invoice</a></td>
											</tr>
                                                                                    <?php }} ?>  
<!--											<tr>
												<td>PGDQF Application</td>
												<td><a class="text-primary" href="#">Download Invoice</a></td>
											</tr>-->
										</tbody>
									</table>

								</div>
							</section>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-6">							
							<section class="panel panel-primary">
								<header class="panel-heading">												
									<h2 class="panel-title">Download Registration Form</h2>
								</header>
								<div class="panel-body">
									<table class="table table-bordered table-striped mb-none">
										<tbody>
											<?php if(!empty($user_course_list)){
                                                                                            foreach ($user_course_list as $single_user_course) {
                                                                                        ?>
                                                                                        <tr>
												<td><?php echo !empty($single_user_course['all_details']['program_name'])?$single_user_course['all_details']['program_name'].' Application':'N/A';?> </td>
												<td><a class="text-primary" href="<?php echo BASEURL.'applicationdownload/'.$single_user_course['all_details']['application_id'];?>"> Download Form</a></td>
											</tr>
                                                                                         <?php }} ?>  
<!--											<tr>
												<td>PGDQF Application</td>
												<td><a class="text-primary" href="#">Download Form</a></td>
											</tr>-->
										</tbody>
									</table>

								</div>
							</section>
						</div>						
					</div>

					
					
					<!-- end: page -->
				</section>

	<!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="oflinePaymentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Offline Payment</h4>
      </div>
      <div class="modal-body">
        <p>Please upload your offline invoice</p>
        
        <p>
            <div class="form-group">
                              <label class="control-label">  
                                  </label>
                              <input type="file" class="form-control file_upload_input" id="profile_picture" name="profile_picture" value="" placeholder="">
                              <input type="hidden" class="" value="" id="profile_picture_input">
                            </div>
            </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>			