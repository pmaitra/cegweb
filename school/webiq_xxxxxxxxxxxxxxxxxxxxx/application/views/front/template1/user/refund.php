
    <section role="main" class="content-body">
      <header class="page-header">
        <h2>Requests</h2>
        <div class="right-wrapper pull-right">
          <ol class="breadcrumbs">
           
          </ol>
        </div>
      </header>
      
      <!-- start: page -->

      <div class="row">
      
        <div class="col-md-6 col-lg-12 col-xl-6">
          <section class="panel panel-primary">
            <header class="panel-heading">
              <div class="panel-actions"> <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a> </div>
              <h2 class="panel-title"> Requests for Refund</h2>
            </header>

            <div style="display: block;" class="panel-body">
                <?php if($this->session->flashdata('success_message')){ ?>
                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div class="alert alert-success"> <?php echo $this->session->flashdata('success_message');?> </div>
                  </div>
                </div>
                <?php } ?>
                <?php if($this->session->flashdata('error_msg')){ ?>
                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg');?> </div>
                  </div>
                </div>
                <?php } ?>
                <?php if($this->session->flashdata('err_msg')){ ?>
                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div class="alert alert-danger"> <?php echo $this->session->flashdata('err_msg');?> </div>
                  </div>
                </div>
                <?php } ?>
                <input type="hidden" name="candidate_id" id="candidate_id" value="<?php echo (!empty($candidate_id))?$candidate_id:''; ?>">

                <div class="row">
                    
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-md-6">
                      <label for="drive_name" class="control-label col-md-4">Course List  <span class="star">*</span></label>
                      <div class="form-group col-md-8">
                        <select id="drive_name" name="drive_name" class="form-control">
                          <option value="0">Select</option>
                          <?php if(!empty($refund_course_list)){
                            foreach($refund_course_list as $single_course){
                            ?>
                            <option value="<?php echo $single_course['course_id']?>"><?php echo $single_course['drive_name']?></option>

                            <input type="hidden" name="first_fee" id="first_fee" value="<?php echo $single_course['first_fee']?>">
                            <input type="hidden" name="first_fee_refund_percentage" id="first_fee_refund_percentage" value="<?php echo $single_course['first_fee_refund_percentage']?>">

                            <?php } } ?>
                        </select>
                      </div>
                    </div>
                </div>
            </div>

            <footer style="display: block;" class="panel-footer">
            <button class="btn  btn-primary " id="btn_request_for_refund"> Submit </button>
              
            </footer>
          </section>  
            
            <section class="panel panel-primary">
								<header class="panel-heading">												
									<h2 class="panel-title">Refund List</h2>
								</header>
								<div class="panel-body">
									<table class="table table-bordered table-striped mb-none" id="datatable-tabletools">
										<thead>
											<tr>
												<th>Drive Name</th>
                        <th>Program Type</th>
												<th>Amount</th>
                        <th>Request Date</th>
                        <th>Status</th>
											</tr>
										</thead>
										<tbody>

                       <?php if(!empty($display_refund_list)){
                           //pr($display_service_request_list);
                           for ($i=0;$i<count($display_refund_list);$i++) {
                         ?>
											<tr>
												<td><span title="<?php echo $display_refund_list[$i]['drive_name'];?>"><?php echo $display_refund_list[$i]['drive_name'];?></span></td> 
                        <td><?php echo $display_refund_list[$i]['program_type'];?></td>     
                        <td><?php echo $display_refund_list[$i]['amount'];?></td>
                        <td><?php echo date('d/m/Y',strtotime($display_refund_list[$i]['created_date']));?></td>
                        
                        <td><?php 
                            switch ($display_refund_list[$i]['status'])
                            {
                                case 0:$display_status = 'Pending';
                                    break;
                                case 1:$display_status = 'Approved';
                                    break;
                                case 2:$display_status = 'Rejected';
                                    break;
                                default :$display_status = 'Pending';
                                    break;
                            }
                            
                            echo $display_status;
                          ?>
                            
                        </td>	
												
                          								
											</tr>

					<?php
                  	 }}
                   	?>
											
										</tbody>
									</table>

								</div>
								<footer style="display: block;" class="panel-footer">
									<!--<button class="btn btn-primary" id="admin_review_select_btn">Approve</button>
									<button class="btn btn-primary" id="admin_review_reject_btn">Reject</button>-->
								</footer>
							</section>
        </div>
        
      </div>
      
      <!-- end: page --> 
    </section>
  </div>
</section>

