<section role="main" class="content-body">
   <header class="page-header">
      <h2>Welcome to Demo School </h2>
   </header>
   <!-- start: page -->
   <div class="row">
      <div class="col-xl-12 col-lg-12">
         <section class="panel panel-primary">
            <header class="panel-heading">
               <h2 class="panel-title">Attendance Details</h2>
            </header>
            <div class="panel-body">
               <table class="table table-bordered table-striped mb-none">
                  <thead>
                     <tr>
                        <th>Standard</th>
                        <th>Section</th>
                        <th>Date</th>
                        <th>Attendance</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($front_attendance_details))
                        {
                                foreach ($front_attendance_details as $singleLeave) {
                        
                        ?>
                     <tr>
                         <td><?php echo displayCheck($singleLeave['standard'])?></td>
                         <td><?php echo displayCheck($singleLeave['section'])?></td>
                         <td><?php echo displayCheck($singleLeave['attendanceDate'],'date')?></td>
                        <td><?php 
                        switch ($singleLeave['type']) {
                            case "1":
                                echo '<button type="button" class="btn btn-success">Present</button>';
                                break;
                            case "3":
                                echo '<button type="button" class="btn btn-danger">Absent</button>';
                                break;
                            case "2":
                                echo '<button type="button" class="btn btn-info">On Leave</button>';
                                break;
                            default:
                                echo "N/A";
                        }
                        
                        
                        ?>
                        </td>
                        
                     </tr>
                     <?php  }
                        }
                        else{
                            echo "<tr><td colspan='4'>No Data Available</td></tr>";
                        }
                        ?>
                  </tbody>
               </table>
            </div>
         </section>
      </div>
   </div>
   <!-- end: page -->
</section>