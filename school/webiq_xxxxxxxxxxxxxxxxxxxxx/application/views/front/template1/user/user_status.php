<?php
    //Selected Check start
    switch ($candidate_details['selected_flag']) 
    {
        case '0':
        //Scrutiny Check start
            switch ($candidate_details['scrutiny_flag']) 
            {
                case '0':
                    $display_data['message'] = 'Your application scrutiny is in progress.';
                    if($candidate_details['payment_flag'] == 0)
                    {
                        $display_data['message'] = 'Please complete the applicaion along with payment.';
                    }        
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
                                ?>	

                                                                            <header class="panel-heading">												
                                                                                    <h2 class="panel-title">Interview Details</h2>
                                                                            </header>
                                                                                    <div class="panel-body">
                                                                                            <table class="table table-bordered table-striped mb-none">
                                                                                                    <thead>
                                                                                                            <tr>
                                                                                                                    <th>Applicant Name</th>
                                                                                                                    <th>Interview Centre</th>
                                                                                                                    <th>Interview Date</th>
                                                                                                                    <th>Timing</th>
                                                                                                            </tr>
                                                                                                    </thead>

                                                                                                    <tbody>
                                                                                                            <?php if(!empty($candidate_details)){?>
                                                                                                            <tr>
                                                                                                                    <td><?php echo $candidate_details['first_name'].' '.$candidate_details['middle_name'].' '.$candidate_details['last_name'];?></td>

                                                                                                                    <td><?php echo $venue_details['city'].', '.$venue_details['address'];?></td>
                                                                                                                    <td><?php echo date('d M Y',strtotime($venue_details['interview_date']));?></td>
                                                                                                                    <td><?php echo $venue_details['interview_time_slot'];?></td>
                                                                                                            </tr>
                                                                                                            <?php
                                                                                             }
                                                                                            ?>
                                                                                                    </tbody>
                                                                                            </table>

                                                                                    </div>

                        <?php

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
											
											<tr class="alert alert-success">
												<td>PGPSM</td>
												<td><?php echo !empty($display_data['message'])?$display_data['message']:'';?></td>
											</tr>
										</tbody>
									</table>

								</div>
							</section>
						</div>
                                        </div>
					
					<!-- end: page -->
				</section>