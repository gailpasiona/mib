var DebitrowNum = 0;
var CreditrowNum = 0;
    var DebitrowExist = false;
    var CreditrowExist = false;
    var d_accounts = null;
    var c_accounts = null;
   // var accounts = function(){
    $.get("coa_list",{ type: "2" }, function(data){d_accounts = data;}); 
    $.get("coa_list",{ type: "1" }, function(data){c_accounts = data;}); 

    function addDebitRow(frm) {
    if(!DebitrowExist){
        DebitrowNum = $('.debit').length;
        DebitrowExist = true;
    }
    DebitrowNum ++;
    console.log(DebitrowNum);
    
    var row = '<div id="DebitrowNum'+DebitrowNum+'" class="col-md-12 col-md-offset-1">\n\ \n\
        <div class="col-md-6 debit"><span class="col-md-1 control-label"></span>\n\
        <select class="form-control d_acct" id="debit_account[]" name="debit_account[]"></select></div>\n\ ';
    
    var row1 = '<div class="col-md-4"><span class="col-md-1 control-label"></span>\n\
                <input type="text" class="form-control" id="debit_amount[]" name="debit_amount[]" placeholder="Amount"></div>\n\ ';
    
   
    var r = row + row1 + '<div class="col-sm-2"> <span class="col-md-1 control-label"></span><button type="button" class="close" onclick="removeDebitRow('+DebitrowNum+');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div></div>';//<input class="btn btn-danger btn-sm btn-block" type="button" value="X" onclick="removeDebitRow('+DebitrowNum+');">
    //console.log(accounts);
   
   jQuery('.debit_items').append(r);
    load_accounts($('.d_acct'), d_accounts);
      //frm.add_qty.value = '';
//    frm.add_name.value = '';
    }  

    function load_accounts(obj,list){
         // $('.d_acct').empty();
          $.each(list, function(index, element) {
          obj.append("<option value='"+ element.account_id +"'>" + element.account_title + "</option>");
         });
    }
    
   function removeDebitRow(rnum) {
        jQuery('#DebitrowNum'+rnum).remove();
   }
   

   function addCreditRow(frm) {
    if(!CreditrowExist){
        CreditrowNum = $('.credit').length;
        CreditrowExist = true;
    }
    CreditrowNum ++;
    console.log(CreditrowNum);
    
    var row = '<div id="CreditrowNum'+CreditrowNum+'" class="col-md-12 col-md-offset-0">\n\ \n\
        <div class="col-md-6 credit"><span class="col-md-1 control-label"></span>\n\
        <select class="form-control c_acct" id="credit_account[]" name="credit_account[]"></select></div>\n\ ';
    
    var row1 = '<div class="col-md-4"><span class="col-md-1 control-label"></span>\n\
                <input type="text" class="form-control" id="credit_amount[]" name="credit_amount[]" placeholder="Amount"></div>\n\ ';
    
   
    var r = row + row1 + '<div class="col-sm-2"> <span class="col-md-1 control-label"></span><button type="button" class="close" onclick="removeCreditRow('+CreditrowNum+');"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></div></div>';
    
   jQuery('.credit_items').append(r);
    load_accounts($('.c_acct'), c_accounts);
      //frm.add_qty.value = '';
//    frm.add_name.value = '';
    }  
    
   function removeCreditRow(rnum) {
        jQuery('#CreditrowNum'+rnum).remove();
   }


   function init_rownum(val) {
       rowNum = val;
       alert(rowNum);
   }
   
   function clearall(){
       this.rowNum = 0;
   }