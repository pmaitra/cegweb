<section role="main" class="content-body">
   <header class="page-header">
      <h2>Welcome to Demo School </h2>
   </header>
   <!-- start: page -->
   <div class="row">
      <div class="col-xl-12 col-lg-12">
         <section class="panel panel-primary">
            <header class="panel-heading">
               <h2 class="panel-title">Leave Details</h2>
            </header>
            <div class="panel-body">
               <table class="table table-bordered table-striped mb-none">
                  <thead>
                     <tr>
                        <th>Date</th>
                        <th>Details</th>
                        <th>Approved by</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($front_leave_details))
                        {
                                foreach ($front_leave_details as $singleLeave) {
                        
                        ?>
                     <tr>
                         <td><?php echo displayCheck($singleLeave['leaveDate'],'date')?></td>
                        <td><?php echo displayCheck($singleLeave['reason'])?></td>
                        <td><?php echo displayCheck($singleLeave['approver'])?></td>
                     </tr>
                     <?php  }
                        }
                        else{
                            echo "<tr><td colspan='3'>No Data Available</td></tr>";
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