<section role="main" class="content-body">
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
                <h2 class="panel-title">Exam : <?php echo displayCheck($exam);?></h2>
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
                     <?php if(!empty($front_marks_details))
                        {
                                $final_marks = 0;
                                $final_got_marks = 0;
                                for($i=0;$i<count($front_marks_details);$i++) {
                                $total_subject_marks = $front_marks_details[$i]['theoryTotal'] + $front_marks_details[$i]['practicalTotal'];
                                $total_got_marks = $front_marks_details[$i]['theoryObtained'] + $front_marks_details[$i]['practicalObtained'];
                                $final_marks = $final_marks+$total_subject_marks;
                                $final_got_marks = $final_got_marks +$total_got_marks;
                        ?>
                     <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><?php echo $front_marks_details[$i]['subject']; ?></td>
                        <td align="center"><?php echo $total_subject_marks; ?></td>
                        <td align="center"><?php echo $total_got_marks; ?></td>
                     </tr>
                                <?php } ?>
                  </tbody>
                  <tfoot>
                     <tr style="background: #eee">
                        <td colspan="2">Total</td>
                        <td align="center"><?php echo $final_marks; ?></td>
                        <td align="center"><?php echo $final_got_marks; ?></td>
                     </tr>
                  </tfoot>
                   <?php } ?>
               </table>
            </div>
         </section>
      </div>
   </div>
   <!-- end: page -->
</section>
