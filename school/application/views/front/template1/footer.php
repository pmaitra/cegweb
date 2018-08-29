</div>



</section>

<!-- Vendor -->
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery/jquery.js"></script>		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-cookie/jquery-cookie.js"></script>	
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/bootstrap/js/bootstrap.js"></script>		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/nanoscroller/nanoscroller.js"></script>		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>

<!-- Specific Page Vendor -->		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/select2/js/select2.js"></script>		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>		
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/theme.init.js"></script>

<!-- Examples -->
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/tables/examples.datatables.default.js"></script>
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
<script type="text/javascript">

    /*
     * Click on select all checkbox
     */
    $('#selectChecked').click(function (e) {
        $('[name="checkedBox"]').prop('checked', this.checked);
    });

    $('[name="checkedBox"]').click(function (e) {
        if ($('[name="checkedBox"]:checked').length == $('[name="checkedBox"]').length || !this.checked)
            $('#selectChecked').prop('checked', this.checked);
    });
</script>
<script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/custom/student.js"></script>
<script type="text/javascript">

    $(document).on("click", "#printinvoice", function () {
        var divContents = $("#invoice-printarea").html();
        var printWindow = window.open('', '', 'height=500,width=900');
        printWindow.document.write('<html><head><title>Registration Invoice</title>');
        printWindow.document.write('<link rel="stylesheet" href="assets/stylesheets/custom-print.css" type="text/css" />');
        printWindow.document.write('<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css" type="text/css" />');
        printWindow.document.write('</head><body onload="window.print()">');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
    });

</script>
<?php if (!empty($event_calender_flag)) { ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL . "assets/ssp"; ?>assets/eventc/js/calendar.js"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            var ay_session = '<?php echo $front_menu_ay;?>';
        var calendar = $("#calendar-init").calendar(
                {
                    events_source: 'http://www.phptrainingacademy.in/school/webiq/student/eventjson/'+ay_session,
                    view: 'week',
                    tmpl_path: "../../assets/sspassets/eventc/tmpls/",
                    modal: "#events-modal",
                    time_start: '00:00',
                    time_end: '24:00',
                    time_split: '60',
                    onAfterViewLoad: function (view) {
                        $('.current_date').text(this.getTitle());
                        $('.btn-group button').removeClass('active');
                        $('button[data-calendar-view="' + view + '"]').addClass('active');
                    },
                    //events_source: function () { return []; }
                });
                
        $('.btn-group button[data-calendar-nav]').each(function () {
            var $this = $(this);
            $this.click(function () {
                calendar.navigate($this.data('calendar-nav'));
            });
        });

        $('.btn-group button[data-calendar-view]').each(function () {
            var $this = $(this);
            $this.click(function () {
                calendar.view($this.data('calendar-view'));
            });
        });

        $('#first_day').change(function () {
            var value = $(this).val();
            value = value.length ? parseInt(value) : null;
            calendar.setOptions({first_day: value});
            calendar.view();
        });

        $('#language').change(function () {
            calendar.setLanguage($(this).val());
            calendar.view();
        });

        $('#events-in-modal').change(function () {
            var val = $(this).is(':checked') ? $(this).val() : null;
            calendar.setOptions({modal: val});
        });
        $('#format-12-hours').change(function () {
            var val = $(this).is(':checked') ? true : false;
            calendar.setOptions({format12: val});
            calendar.view();
        });
        $('#show_wbn').change(function () {
            var val = $(this).is(':checked') ? true : false;
            calendar.setOptions({display_week_numbers: val});
            calendar.view();
        });
        $('#show_wb').change(function () {
            var val = $(this).is(':checked') ? true : false;
            calendar.setOptions({weekbox: val});
            calendar.view();
        });
        $('#events-modal .modal-header, #events-modal .modal-footer').click(function (e) {
    //e.preventDefault();
    //e.stopPropagation();
        });
        });
    </script>
<?php } ?>
</body>

</html>