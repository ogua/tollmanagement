@if(Admin::user()->id == '1')

<div class="alert alert-success">Approved Successfully!</div>


@else

<div class="alert alert-info">Your Profile Has Not Been Approved Yet</div>


@endif


<div class="box box-widget">
    <!-- /.box-header -->
    <div class="box-body">
      <img class="img-responsive pad" src="{{ $img }}" alt="Photo">
    </div>
  </div>  
