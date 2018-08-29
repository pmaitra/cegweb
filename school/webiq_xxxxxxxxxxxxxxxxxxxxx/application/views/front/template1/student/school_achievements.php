<section role="main" class="content-body">
    <header class="page-header">
        <h2>Welcome to Demo School </h2>
    </header>
    <!-- start: page -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <section class="panel panel-primary">
                <header class="panel-heading">
                    <h2 class="panel-title">Your Achievements</h2>
                </header>
                <div class="panel-body">
        <table class="table table-bordered table-striped mb-none">
                        <thead>
                            <tr>
                                <th>Event Name</th>
                                <th>Event Position</th>
                                <th>Event Start Date</th>
                                <th>Event End Date</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (!empty($front_action_details)) {
                                foreach ($front_action_details as $single_action) {
                                    $imageCreation=genarateImageFromByteArr($single_action['eventPhoto']);
                                    ?>
                                    <tr>
                                        <td><?php echo displayCheck($single_action['title']) ?></td>
                                        <td><?php echo displayCheck($single_action['eventPosition']) ?></td>
                                        <td><?php echo displayCheck($single_action['startDate'],'date') ?></td>
                                        <td><?php echo displayCheck($single_action['endDate'],'date') ?></td>
                                        <td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal-<?php echo $i; ?>">View</button></td>
                                    </tr>
                                <div id="myModal-<?php echo $i ;?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"><?php echo displayCheck(ucfirst($single_action['title'])) ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                
                                                <p class=""><img class="img-thumbnail img-responsive" src="<?php echo $imageCreation;?>" onerror="this.src ='<?php echo BASEURL."assets/ssp";?>assets/images/noimg.png'">
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <?php
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='5'>No Data Available</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- Trigger the modal with a button -->


            </section>
        </div>
    </div>
    <!-- end: page -->
</section>