@extends('layouts.layout')
@section('content')
    <div class="main-section">
        <div class="form-items">
            <h3 class="text-left">
                Products
            </h3>
            <div class="text-right mb-3">
                <a href="{{route('products.create')}}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </a>
                <a href="{{route('logout')}}" class="btn btn-dark btn-sm">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                </a>
            </div>
            <div class="text-right mb-3">
                <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                        <input type="search" name="search" id="search" class="form-control" placeholder="Search Here">
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong> {{ session('success') }} </strong>
                </div>
            @endif
        </div>
        <table>
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Unique ID</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="products">
            @include('product.render')
            </tbody>
        </table>
        <div class="justify-content-center mt-3" id="pagination_section">
            {{ $products->links('pagination') }}
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="confirm_del">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" value="" id="item_delete_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Delete</h5>
                    </div>
                    <div class="modal-body">
                        <span>Are you sure you want to delete this item?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const debounce = (fn, delay) => {
                let timeOutID;
                return function (...args) {
                    if (timeOutID) {
                        clearTimeout(timeOutID);
                    }
                    timeOutID = setTimeout(() => {
                        fn(...args);
                    }, delay)
                }
            };

            document.getElementById('search').addEventListener('keyup', debounce(event => {
                search(event.target.value);
            }, 500));

            const search = (search) => {
                $.ajax({
                    url: '{{route('products.index')}}',
                    type: 'get',
                    data: {
                        _token: '{{csrf_token()}}',
                        search: search
                    },
                    success: function (data) {
                        if (data.status == "success") {
                            $("#products").html(data.html);
                            if (data.count == 0) {
                                $("#pagination_section").css("display", "none");
                            } else {
                                $("#pagination_section").css("display", "block");
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            })
                        }
                    }
                });
            };
        </script>
    @endpush
@endsection
