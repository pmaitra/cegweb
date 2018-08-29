<section role="main" class="content-body">
   <header class="page-header">
      <h2>Welcome to Demo School </h2>
   </header>
   <!-- start: page -->
   <div class="row">
      <div class="col-xl-12 col-lg-12">
         <section class="panel panel-primary">
            <header class="panel-heading">
               <h2 class="panel-title">Disciplinary Action</h2>
            </header>
            <div class="panel-body">
               <table class="table table-bordered table-striped mb-none">
                  <thead>
                     <tr>
                        <th>Date</th>
                        <th>Disciplinary Action</th>
                        <th>Code of Conduct</th>
                        <th>Code Description</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($front_action_details))
                        {
                                foreach ($front_action_details as $single_action) {
                        ?>
                     <tr>
                         <td><?php echo displayCheck($single_action['logTime'],'datetime')?></td>
                         <td><?php echo displayCheck($single_action['comment'])?></td>
                         <td><?php echo displayCheck($single_action['codeOfConduct'])?></td>
                         <td><?php echo displayCheck($single_action['description'])?></td>
                         
                         
                        
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