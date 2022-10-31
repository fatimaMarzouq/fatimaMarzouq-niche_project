        <!-- <footer style="margin-left:0;">

          <div class="pull-right">

            NICHEFAS

          </div>

          <div class="clearfix"></div>

        </footer> -->

        <!-- /footer content -->


    </div>



    <!-- jQuery -->

    <script src="<?=site_url()?>vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap -->

    <script src="<?=site_url()?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- FastClick -->

    <script src="<?=site_url()?>vendors/fastclick/lib/fastclick.js"></script>

    <!-- NProgress -->

    <script src="<?=site_url()?>vendors/nprogress/nprogress.js"></script>

    <!-- Chart.js -->

    <script src="<?=site_url()?>vendors/Chart.js/dist/Chart.min.js"></script>

    <!-- gauge.js -->

    <script src="<?=site_url()?>vendors/gauge.js/dist/gauge.min.js"></script>

    <!-- bootstrap-progressbar -->

    <script src="<?=site_url()?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

    <!-- iCheck -->

    <script src="<?=site_url()?>vendors/iCheck/icheck.min.js"></script>

    <!-- Skycons -->

    <script src="<?=site_url()?>vendors/skycons/skycons.js"></script>

    <!-- Flot -->

    <script src="<?=site_url()?>vendors/Flot/jquery.flot.js"></script>

    <script src="<?=site_url()?>vendors/Flot/jquery.flot.pie.js"></script>

    <script src="<?=site_url()?>vendors/Flot/jquery.flot.time.js"></script>

    <script src="<?=site_url()?>vendors/Flot/jquery.flot.stack.js"></script>

    <script src="<?=site_url()?>vendors/Flot/jquery.flot.resize.js"></script>

    <!-- Flot plugins -->

    <script src="<?=site_url()?>vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>

    <script src="<?=site_url()?>vendors/flot-spline/js/jquery.flot.spline.min.js"></script>

    <script src="<?=site_url()?>vendors/flot.curvedlines/curvedLines.js"></script>

    <!-- DateJS -->

    <script src="<?=site_url()?>vendors/DateJS/build/date.js"></script>

    <!-- JQVMap -->

    <script src="<?=site_url()?>vendors/jqvmap/dist/jquery.vmap.js"></script>

    <script src="<?=site_url()?>vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

    <script src="<?=site_url()?>vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>

    <!-- bootstrap-daterangepicker -->

    <script src="<?=site_url()?>vendors/moment/min/moment.min.js"></script>

    <script src="<?=site_url()?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>



    <!-- Custom Theme Scripts -->

    <script src="<?=site_url()?>build/js/custom.min.js"></script>

  







    <script src="<?=site_url()?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>

    <script src="<?=site_url()?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script src="<?=site_url()?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="<?=site_url()?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

    <script src="<?=site_url()?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
   
    <script src="<?=site_url()?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>

    <script src="<?=site_url()?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>

    <script src="<?=site_url()?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>

    <script src="<?=site_url()?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>

    <script src="<?=site_url()?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>

    <script src="<?=site_url()?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>

    <script src="<?=site_url()?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>

<script>
   
 
     $(document).ready(function () {

       
       

        $('#export_id').click(function(){
          
               $('#export_input').val(1);
                var form_action = $('#filter_status_id').attr('action');

                var sort = "<?=$_GET['sort']?>";
                var type = "<?=$_GET['by']?>";
                header_arr = [];

               

               $("#table_list th").each(function(){

                   var heading_html = $(this).html().split('<span', 1)[0];
                   var heading_html_final = heading_html.split('<i', 1)[0];
                   header_arr.push(heading_html_final);
               });

               var header_array =header_arr.join("$$$$");
               var header_array_1 = header_array.toString();
    
                $('#export_header').val(header_array_1);

               var form_action_1 = form_action+"/<?= $page?>";

               
                var form_action = $('#export_table').attr('action');
                $('#export_table').attr('action', form_action);
              
                $('#export_table').submit();

                $('#export_table').val(0);



                  


            });
      

          
      
       $('#datatable3333333').DataTable( {
        pageLength: 50,
        dom: 'Bfrtip',
        //"lengthChange": false,
        buttons: [
            //'copyHtml5',
            'excelHtml5',
            //'csvHtml5',
            //'pdfHtml5'
        ]
    } );

     
    // $('#datatable333444555').DataTable( {
    //     pageLength: 50,
    //     dom: 'Bfrtip',
    //     //"lengthChange": false,
    //     buttons: [
    //         //'copyHtml5',
    //         'excelHtml5',
    //         //'csvHtml5',
    //         //'pdfHtml5'
    //     ]
    // } );
      

        $('#datatable333444').DataTable( {
        pageLength: 50,
        dom: 'Bfrtip',
        //"lengthChange": false,
        buttons: [
            //'copyHtml5',
           // 'excelHtml5',
            //'csvHtml5',
            //'pdfHtml5'
        ]
    } );

    });

     
 selectDate();
function selectDate() {
 // let table = $('#userTable').DataTable();
  let table =  $('#datatable333444555').DataTable( {
        pageLength: 50,
        dom: 'Bfrtip',
        "bDestroy": true,
        //"lengthChange": false,
        buttons: [
            //'copyHtml5',
            'excelHtml5',
            //'csvHtml5',
            //'pdfHtml5'
        ]
    } );
        
  table.draw();
}
$(document).ready(function () {
    $.fn.dataTable.ext.search.push( function( settings, data, dataIndex ) { 
      let toDate = $('#toDate').val();
      let fromDate = $('#fromDate').val();
      let formatedToDate = toDate ? new Date(moment(toDate, "YYYY-MM-DD")) : '';
      let formatedFromDate = fromDate ? new Date(moment(fromDate, "YYYY-MM-DD")) : '';
      let dateField = data[4];
      let formatedDateField = dateField ? new Date(moment(dateField, "YYYY-MM-DD")) : '';
      if(formatedToDate && formatedFromDate && formatedDateField) {
        return formatedToDate.getTime() <= formatedDateField.getTime() && formatedDateField.getTime() <= formatedFromDate.getTime()
      } else if(formatedToDate && !formatedFromDate && formatedDateField) {
        return formatedToDate.getTime() <= formatedDateField.getTime()
      } else if(!formatedToDate && formatedFromDate && formatedDateField) {
        return formatedDateField.getTime() <= formatedFromDate.getTime()
      } else if(!formatedToDate && !formatedFromDate) {
        return true
      }
      return false; 
    });
  });
</script>


    

  </body>

</html>

