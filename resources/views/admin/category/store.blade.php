@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    @include('admin.sidebar')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h4 class="mb-3">Add Category</h4>
      <form id="addCategory" class="needs-validation text-black" novalidate="" action="{{url('/category/')}}" method="post">
        @csrf
        <div class="row g-3">
          <div class="col-12">
            <div class="input-group mb-3 px-2 py-2 shadow-sm">
              <input type="text" class="form-control border-0" name="name" placeholder="Enter Product Name" value="" required>
            </div>
          </div>

          <div class="col-12">
            <div class="input-group mb-3 px-2 py-2 shadow-sm">
              <textarea type="text" class="form-control border-0" name="description" placeholder="Enter Product Description" value="" required></textarea>
            </div>
          </div>
        </div>
        <button class="btn btn-primary btn-sm" type="submit" id="submit">Submit</button>
        @if($errors)
          <?= $errors ?>
        @endif
      </form>
    </main>
  </div>
</div>

@endsection