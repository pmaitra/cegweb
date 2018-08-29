<section role="main" class="content-body">
   <header class="page-header">
      <h2>Welcome to Demo School </h2>
   </header>
   <!-- start: page -->
   <div class="row">
      <div class="col-xl-12 col-lg-12">
         <section class="panel panel-primary">
            <header class="panel-heading">
               <h2 class="panel-title">Event Details </h2>
            </header>
            <div class="panel-body">
               
                     <?php if(!empty($event_details))
                        {
                                                        
                        ?>
                        <h4>Event:</h4>
                        <p><?php echo displayCheck($event_details['title'])?></p>
                        <h4>Description:</h4>
                        <p><?php echo displayCheck($event_details['description'])?></p>
                        <h4>Incharge:</h4>
                        <p><?php echo displayCheck($event_details['incharge'])?></p>
                        <h4>Start Date:</h4>
                        <p><?php echo displayCheck($event_details['startDate'],'date')?></p>
                        <h4>End Date:</h4>
                        <p><?php echo displayCheck($event_details['endDate'],'date')?></p>
                        <a class="btn btn-primary" href="javascript:history.back()">Go Back</a> 
                     <?php  }
                        
                        else{
                            echo "<p>No Data Available</p>";
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