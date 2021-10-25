@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    @include('admin.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h4 class="mb-3">Add Product</h4>
      <form class="needs-validation text-black" novalidate="">
        <div class="row g-3">
          <div class="col-12">
            <div class="input-group mb-3 px-2 py-2 shadow-sm">
              <input type="text" class="form-control border-0" id="name" placeholder="Enter Product Name" value="" required="">
            </div>
            <div class="invalid-feedback">
              Please enter product name.
            </div>
          </div>

          <div class="col-12">
            <div class="input-group mb-3 px-2 py-2 shadow-sm">
              <textarea type="text" class="form-control border-0" id="description" placeholder="Enter Product Description" value="" required=""></textarea>
              <div class="invalid-feedback">
                Please enter product description.
              </div>
            </div>
          </div>

          <div class="col-12">
            <div class="input-group mb-3 px-2 py-2 shadow-sm">
              <select class="form-select border-0" id="category" required="">
                <option value="">Select Product Category</option>
                @foreach($categories as $category)
                  <option class="text-capitalize" value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
              </select>
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>
          </div>
          
          <div class="col-12">
            <div class="row py-4">
              <div class="col-12">
                  <div class="input-group mb-3 px-2 py-2 shadow-sm">
                      <input id="upload" type="file" onchange="readURL(this);" class="form-control border-0">
                      <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose file</label>
                      <div class="input-group-append">
                          <label for="upload" class="btn btn-light m-0 px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                      </div>
                  </div>

                  <div class="image-area mt-4"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block h-50"></div>
              </div>
          </div>

        </div>
        <button class="btn btn-primary btn-sm" type="submit">Submit</button>
      </form>
    </main>
  </div>
</div>

<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#imageResult').attr('src', e.target.result);};
        reader.readAsDataURL(input.files[0]);
    }
  }

  $(function () {
    $('#upload').on('change', function () {
      readURL(input);
    });
  });

  var input = document.getElementById( 'upload' );
  var infoArea = document.getElementById( 'upload-label' );

  input.addEventListener( 'change', showFileName );
  function showFileName( event ) {
    var input = event.srcElement;
    var fileName = input.files[0].name;
    infoArea.textContent = 'File name: ' + fileName;
  }
</script>
@endsection