@if ($errors->any())
<div class="container pt-4 pb-2">
    <div class="row">
       <div class="col-12">
           <div class="alert alert-danger">
                   <ul>
                       @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                       @endforeach
                   </ul>
               </div>
       </div>
    </div>
</div>
@endif
