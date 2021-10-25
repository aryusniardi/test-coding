@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    @include('admin.sidebar')

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between">
        <h3 class="display-6 fw-bold">Categories</h3>
        <a class="nav-link d-flex align-items-center" href="/category/add" role="button" href="">
          Tambah Category <span class="mx-2"><i class="bi bi-plus-lg"></i></span>
        </a>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Description</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody class="text-capitalize">
            @foreach($categories as $category)
              <tr>
                <td>{{$category['id']}}</td>
                <td>{{$category['name']}}</td>
                <td>{{$category['description']}}</td>
                <td>
                  <div class="d-flex justify-content-evenly">
                    <button type="button" class="btn btn-sm btn-warning">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{$category['id']}}">Delete</button>
                  </div>
                </td>
              </tr>
              <!-- Modal -->
              <div class="modal fade" id="deleteCategoryModal{{$category['id']}}" tabindex="-1" aria-labelledby="deleteCategoryModal{{$category['id']}}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body">
                      Are you sure to delete Category {{$category['name']}}
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <form method="POST" action="/admin/category/<?=$category['id']?>/delete">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-outline-danger" >Delete</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
@endsection