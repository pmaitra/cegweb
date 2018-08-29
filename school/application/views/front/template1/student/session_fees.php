<section role="main" class="content-body">
    <header class="page-header">
        <h2>Session Fees </h2>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <section class="panel panel-primary">
                <header class="panel-heading">
                    <h2 class="panel-title">Session Fees - 2017-2018</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-none">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Fees Details</th>
                                    <th>Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Due Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($front_fee_details))
                        {
                                $final_marks = 0;
                                $final_got_marks = 0;
                                for($i=0;$i<count($front_fee_details);$i++) {
                                    
                                    $fees = json_decode($front_fee_details[$i]['fees'],TRUE);
                                     for($j=0;$j<count($fees);$j++) {
                                         
                                     
                                   // pr($front_fee_details[$i]);
//                                $total_subject_marks = $front_marks_details[$i]['theoryTotal'] + $front_marks_details[$i]['practicalTotal'];
//                                $total_got_marks = $front_marks_details[$i]['theoryObtained'] + $front_marks_details[$i]['practicalObtained'];
//                                $final_marks = $final_marks+$total_subject_marks;
//                                $final_got_marks = $final_got_marks +$total_got_marks;
                        ?>
                                    <tr>
                                        <td>
                                            <?php echo displayCheck($front_fee_details[$i]['created_at'],'date') ?>
                                        </td>
                                        <td>
                                            <?php echo $fees[$j]['feesCategoryName']; ?>
                                        </td>
                                        <td align="center">
                                            <i class="fa fa-rupee" aria-hidden="true"></i><?php echo $fees[$j]['totalPayableAmount']; ?>
                                        </td>
                                        <td align="center">
                                            <i class="fa fa-rupee" aria-hidden="true"></i><?php echo $fees[$j]['paidAmount']; ?>
                                        </td>
                                        <td align="center">
                                            <i class="fa fa-rupee" aria-hidden="true"></i><?php echo !empty($fees[$j]['due'])?$fees[$j]['due']:0; ?>
                                        </td>
                                    </tr>
                                    <?php }
                                    
                                     } ?>
                                    <?php } ?>
                            </tbody>
                            

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-xl-12 col-md-6">
            <section class="panel panel-primary">
                <header class="panel-heading">
                    <h2 class="panel-title">Download Session Fees Receipt</h2>
                </header>
                <div class="panel-body">
                    <table class="table table-bordered table-striped mb-none">
                        <tbody>
                            <tr>
                                <td>15th April 2017</td>
                                <td>
                                    <a class="text-primary" href="<?php echo BASEURL;?>student/invoice">Print Invoice</a>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="col-xl-12 col-md-6">
            <section class="panel panel-primary">
                <header class="panel-heading">
                    <h2 class="panel-title">Download Admission Fees Receipt</h2>
                </header>
                <div class="panel-body">
                    <table class="table table-bordered table-striped mb-none">
                        <tbody>
                            <tr>
                                <td>14th April 2017</td>
                                <td>
                                    <a class="text-primary" href="<?php echo BASEURL;?>student/invoice">Print Invoice</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <!-- end: page -->
</section>