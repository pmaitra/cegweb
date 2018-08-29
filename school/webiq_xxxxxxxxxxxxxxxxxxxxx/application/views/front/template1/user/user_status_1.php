<section role="main" class="content-body">
					<header class="page-header">
						<h2>Application Status</h2>
					
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
							<?php
                                                        //Selected Check start
							switch ($candidate_details['selected_flag']) {
                                                                case '0':
                                                                //Scrutiny Check start
                                                                switch ($candidate_details['scrutiny_flag']) 
                                                                {
                                                                        case '0':
                                                                ?>
                                                                <div class="alert alert-info"> Your application scrutiny is in progress.</div>
                                                                <?php
                                                                        break;
                                                                        case '1':
                                                                            //interview schedule Check start
                                                                            switch ($candidate_details['interview_schedule_flag']) {
                                                                            case '0':
                                                                            ?>
                                                                                            <div class="alert alert-info"> Your application scrutiny has done.
                                                                                                Interview schedule is in progress.</div>
                                                                            <?php
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
                                                                                                                    <td><?php echo date('d M Y',strtotime($venue_details['interview_time']));?></td>
                                                                                                                    <td><?php echo date('h:i A',strtotime($venue_details['interview_time']));?></td>
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
                                                                                ?>
                                                                                        <div class="alert alert-danger"> Your Application has Rejected</div>
                                                                                <?php	
                                                                                        break;
                                                                                            }
                                                                                            //interview schedule Check end
                                                                                        break;

                                                                                        default:
                                                                                        ?>

                                                                                                        <div class="alert alert-danger"> Your Application has Rejected</div>

                                                                                <?php			
                                                                                        break;

                                                                                 } 
                                                                                 //Scrutiny Check end 
                                                                                 ?>
							
                                                                <?php			
                                                                    break;
                                                                    case '1':
                                                                    ?>

                                                                        <div class="alert alert-success"> Your Application has been selected.
                                                                            Please contact for admission.</div>

                                                                    <?php
                                                                    break;
                                                                    default:
                                                                     ?>

                                                                        <div class="alert alert-danger"> Your Application has been rejected</div>

                                                                     <?php			
                                                                     break;    
                                                                 } 
                                                                //Selected Check end 
                                                                ?>
                                                                                                            
							</section>
						</div>
						
					</div>
					
					
					<!-- end: page -->
				</section>