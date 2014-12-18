<div class="modal-dialog modal-wide">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">{{{$data['title']}}}</h4>
      </div>
      <div class="modal-body">
        
                <div class="messages"> </div>
                    <form class="form-horizontal" id="createform" role="form" method="POST" accept-charset="UTF-8">
                    <fieldset>
                        <div id="voucher_info" class="form-group">
                            <div class="col-md-12">
                                <div class="form-group row">
                                  @if(isset($data['cv_number']))
                                    <input class="form-control" type="hidden" name="invoice_ref" id="invoice_ref" value="{{{$data['cv_number']}}}">
                                  @else
                                    <input class="form-control" type="hidden" name="rfp_number" id="rfp_number" value="{{{$data['rfp_number']}}}">
                                  @endif
                                    <label for="payee_name" class="col-md-4 control-label">Payee Name</label>
                                    <div class="col-md-6">
                                      @if(!isset($data['supplier']))
                                        <input class="form-control" placeholder="Payee Name" type="text" readonly = "readonly" name="payee_name" id="payee_name" value="">
                                      @else
                                        <input class="form-control" placeholder="Payee Name" type="text" readonly = "readonly" name="payee_name" id="payee_name" value="{{{$data['supplier']}}}">
                                      @endif
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="amount_request" class="col-md-4 control-label">Amount Requested</label>
                                    <div class="col-md-6">
                                      @if(!isset($data['amount_requested']))
                                        <input class="form-control" placeholder="Amount Requsted" type="text" readonly = "readonly" name="amount_request" id="amount_request" value="">
                                      @else
                                        <input class="form-control" placeholder="Amount Requsted" type="text" readonly = "readonly" name="amount_request" id="amount_request" value="{{{$data['amount_requested']}}}">
                                      @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="payee_address" class="col-md-4 control-label">Cheque Number</label>
                                    <div class="col-md-6">
                                      @if(!isset($data['cheque_number']))
                                        <input class="form-control" placeholder="Cheque Number" type="text" name="cheque_number" id="cheque_number" value="">
                                      @else
                                        <input class="form-control" placeholder="Cheque Number" type="text" name="cheque_number" id="cheque_number" value="{{{$data['cheque_number']}}}">
                                      @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-4 control-label">Description</label>
                                    <div class="col-md-6">
                                      @if(!isset($data['description']))
                                        <input class="form-control" placeholder="Description" type="text" name="description" id="description" value="">
                                      @else
                                        <input class="form-control" placeholder="Description" type="text" name="description" id="description" value="{{{$data['description']}}}">
                                      @endif
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <span class="col-md-6 col-md-offset-2 control-label"><label>Debit</label></span>
                                    <div id="debit" class="col-md-12 debit_items">
                                        <div class="col-md-12 col-md-offset-1">
                                            <input class="btn btn-warning btn-block btn-sm" onclick="addDebitRow(this.form);" 
                                            type="button" value="Add Debit" />
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <span class="col-md-6 col-md-offset-1 control-label"><label>Credit</label></span>
                                    <div id="credit" class="col-md-12 credit_items">
                                        <div class="col-md-12 col-md-offset-0">
                                            <input class="btn btn-primary btn-block btn-sm" onclick="addCreditRow(this.form);" 
                                            type="button" value="Add Credit" />
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
     <div class="modal-footer">
          
            <div class="progress progress-striped f_bar">

                <div class="progress-bar bar f_bar" style="width: 0%;">
                     
                    <span class="prog_txt"></span>

                </div>

            </div>

          <button type="button" class="btn btn-default" id="dumer" data-dismiss="modal">Close</button>
          @if(isset($data['cv_number']))
            <button type="button" id="updateBtn" class="btn btn-primary updateBtn">Update changes</button>
          @else
            <button type="button" id="submitBtn" class="btn btn-primary submitBtn">Save</button>
          @endif

      </div>
    </div>
</div>
    <script src="{{ URL::asset('js/dyn_fields.js')}}"></script>
    <script>

        
        // $('.datepicker').datepicker({
        //   format: 'yyyy-mm-dd',
        //   autoclose: true,
        // });
        
        $("#submitBtn").click(function(e){
          $(".f_bar").addClass( "active" )
          $(".bar").css("width", "0%");
         
          $("#createform :input").prop("readonly", true);
          $("#submitBtn").prop("disabled", true);
          var request = $.ajax({
            url: "cv",
            type: "POST",
            data: $("#createform").serialize(),
            // dataType: "json"
          });
          $(".bar").css("width", "50%");

          request.done(function( data ) {
            $("#createform :input#description").prop("readonly", false);
            $("#submitBtn").prop("disabled", false);
            $(".bar").css("width", "100%");
            $(".f_bar").removeClass( "active" );

            $('#modal_form').modal('hide');
            
          });
          request.fail(function( jqXHR, textStatus ) {
            $(".bar").css("width", "50%");
            console.log("Failed");
            console.log(textStatus);
            $('#modal_form').modal('hide');
          });
      });

        $("#updateBtn").click(function(e){
          $(".f_bar").addClass( "active" )
          $(".bar").css("width", "0%");
         
          $("#createform :input").prop("readonly", true);
          $("#updateBtn").prop("disabled", true);
          var request = $.ajax({
            url: "cv/" + encodeURIComponent($("#cv_number").val()),
            type: "PATCH",
            data: $("#createform").serialize()
            // dataType: "json"
          });
          $(".bar").css("width", "50%");

          request.done(function( data ) {
            $("#createform :input#description").prop("readonly", false);
            $("#updateBtn").prop("disabled", false);
            $(".bar").css("width", "100%");
            $(".f_bar").removeClass( "active" );
            
          });
          request.fail(function( jqXHR, textStatus ) {
            $(".bar").css("width", "50%");
            console.log("Failed");
            console.log(textStatus);
          });
      });

    </script>
    



