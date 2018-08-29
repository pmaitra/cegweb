<section role="main" class="content-body">
    <header class="page-header">
        <h2>Welcome to Demo School </h2>
    </header>
    <!-- start: page -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <section class="panel panel-primary">
                <header class="panel-heading">
                    <h2 class="panel-title">School Notes</h2>
                </header>
                <div class="panel-body">
                    <table class="table table-bordered table-striped mb-none">
                        <thead>
                            <tr>
                                <th>Serial number</th>
                                <th>Note</th>
                                <th>Sender</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (!empty($front_action_details)) {
                                foreach ($front_action_details as $single_action) {
                                    ?>
                                    <tr data-toggle="modal" data-target="#myModal-<?php echo $single_action['id']; ?>">
                                        <td><a href="#"><?php echo $i; ?></a></td>
                                        <td><?php echo displayCheck($single_action['title']) ?></td>
                                        <td><?php echo displayCheck($single_action['sender']) ?></td>
                                    </tr>
                                <div id="myModal-<?php echo $single_action['id'] ?>" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title"><?php echo displayCheck(ucfirst($single_action['title'])) ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Description:</h4>

                                                <p><?php echo displayCheck($single_action['description']) ?><p>
                                                <h4>Sender:</h4>
                                                <p><?php echo displayCheck($single_action['sender']) ?></p>
                                                <h4>Received:</h4>
                                                <p><?php echo displayCheck($single_action['logTime'], 'datetime') ?></p>
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
    echo "<tr><td colspan='4'>No Data Available</td></tr>";
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