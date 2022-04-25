<?php
  $tr = rand(1,10).rand(20,100).rand(50,700).rand(600,400);
  $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $ref = substr(str_shuffle($pool), rand(0,30));
?>
<!-- general form elements -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Wallet Topup</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <!-- form start -->
    <div class="col-md-7 col-md-offset-2">
       <form method="POST" action="{{ admin_url('pay') }}" accept-charset="UTF-8" role="form">
        
        @php
        $array = 
        [
          'index' => Admin::user()->id
        ];
        @endphp
          <input type="hidden" name="email" value="{{Admin::user()->profile['email']}}">
          <input type="hidden" name="order_id" value="{{$tr}}">

          <div class="form-group">
            <label for="amount">Select Payment Point</label>
            <select class="form-control" name="paypoint">
              <option></option>
              @foreach($lan as $row)
              <option value="{{ $row->id }}">{{ $row->name }} - ({{ $row->location }})</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="amount">Enter Your Amount</label>
            <input type="number" id="amount" class="form-control" required>
            <input type="hidden" name="amount" id="amnt" value="0" class="form-control" required>
          </div>

          <input type="hidden" name="first_name" value="{{Admin::user()->profile['first_name']}}">
          <input type="hidden" name="last_name" value="{{Admin::user()->profile['surname']}}">
          <input type="hidden" name="phone" value="{{Admin::user()->profile['mobile']}}">
          <input type="hidden" name="quantity" value="1">
          <input type="hidden" name="currency" value="GHS">
          <input type="hidden" name="metadata" value="{{ json_encode($array) }}" >
          <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> 

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <p>
            <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
              <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
            </button>
          </p>
    </form>
    </div>

  </div>
</div>

<script>
  $('document').ready(function(){

  	//start
    $(document).on("click","#topup", function(e){
      e.preventDefault();
      var fullname = $("#name").val();
      var indexnumber = $("#index").val();
      var amount = $("#total").val();
      var trid = $("#invoice_id").val();
      var _token = $('meta[name=csrf-token]').attr('content');

      $.ajax({
        beforeSend: function(){
          $.LoadingOverlay("show");
        },
        complete: function(){
          $.LoadingOverlay("hide");
        },
        url: '',
        type: 'POST',
        data: {_token : _token , fullname: fullname, amount: amount, indexnumber: indexnumber, trid: trid},
        success: function(data){ 
          submitforms();
        },
        error: function (data) {
          console.log('Error:', data);
          $("#msg").text(data.message).show();
        }
      });  

    });
          //end


          function submitforms(){
            document.getElementById("topupsubmit").click();
          }

          $(document).on('keyup', '#amount', function(event) {
            event.preventDefault();
            var amnt = $("#amount").val();
            $("#amnt").val(amnt*100);
        //alert(amnt);
        /* Act on the event */
      });



        });

      </script>