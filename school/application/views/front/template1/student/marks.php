<?php error_log("======================== HERE =================");
?><section role="main" class="content-body">
   <header class="page-header">
      <h2>Exam Marks</h2>
   </header>
   <!-- start: page -->
   <div class="row">
      <div class="col-xl-12 col-md-4">
         <section class="panel panel-primary">
            <header class="panel-heading">
               <h2 class="panel-title">Exam</h2>
            </header>
            <div class="panel-body">
               <div class="form-group">
                  <label class="control-label">Exam Name</label>
                  <select id="goToUrl" class="form-control valid">
                     <option value="NULL">Please select</option>
                     <?php if(!empty($front_exam_details))
                        {
				$allMarks =[];
                                foreach ($front_exam_details as $single_exam) {
                        	 if(!in_array( $single_exam['exam'],$allMarks))
                                    {
                                        echo "<option value = '".BASEURL.'student/marks/'.$single_exam['marksId']."'>".ucfirst($single_exam['exam'])."</option>";
                                    }
                                    $allMarks[] = $single_exam['exam'];   
			//print_r($allMarks);
			?>
                            
                        <?php }
                                } ?>
                  </select>
               </div>
            </div>
         </section>
      </div>
      <div class="col-xl-12 col-md-8">
         <section class="panel panel-primary">
            <header class="panel-heading">
               <h2 class="panel-title">Exam - Pre Mid: 2017-2018</h2>
            </header>
            <div class="panel-body">
               <table class="table table-bordered table-striped mb-none">
                  <thead>
                     <tr>
                        <th>Sl No.</th>
                        <th>Subjects</th>
                        <th>Max. Marks</th>
                        <th>Marks Obtained</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                         <td colspan="4">Please select Exam !!!</td>
                        
                     </tr>
                     
                  </tbody>
                  
               </table>
            </div>
         </section>
      </div>
   </div>
   <!-- end: page -->
</section>
