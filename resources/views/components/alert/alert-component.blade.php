@if(session()->has('message'))
  <div class="card alert-success alert-dismissible mb-4 bg-light" role="alert">
    <p class="mb-0">{{ session()->get('message') }}</p>
  </div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible mb-4" role="alert">
  <p class="mb-0">{{ session()->get('error') }}</p>
</div>
@endif

@if($errors->any())
  <div class="alert alert-danger alert-dismissible mb-4" role="alert">
    <p class="mb-0">{!! implode('<br/>', $errors->all()) !!}</p>
  </div>
@endif
