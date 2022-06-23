@extends('layouts.layout')
@section('content')
    <div class="main-section">
        <div class="form-items">
            <h3 class="text-left">Product Update</h3>
            <h3 class="text-right">
                <a href="{{route('products.index')}}" class="btn btn-primary btn-sm">
                    <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                </a>
                <a href="{{route('logout')}}" class="btn btn-dark btn-sm">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                </a>
            </h3>
        </div>
        <form action="{{route('products.update',$product)}}" method="post" enctype="multipart/form-data"
              autocomplete="off"
              id="product_store">
            {{csrf_field()}}
            @method('PUT')
            <div class="form-group">
                <label for="exampleInputName">Preview Image</label>
                <img src="{{url('/').'/'.$product['image']}}" alt="" style="width: 150px;height: 100px">
            </div>
            <div class="form-group">
                <label for="exampleInputName">Image</label>
                <input type="file" class="form-control" name="image" id="image" onchange="hide_error_msg(this.name)">
                <span id="image_err" class="validation_message"></span>
            </div>
            <div class="form-group">
                <label for="unique_id">Unique ID</label>
                <input type="text" class="form-control" value="{{$product['unique_id']}}" name="unique_id"
                       id="unique_id" readonly>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" placeholder="Please Enter Name" value="{{$product['name']}}"
                       name="name" id="name" onkeypress="hide_error_msg(this.name)">
                <span id="name_err" class="validation_message"></span>
            </div>
            <div class="field_wrapper">
                <label class="form-label" for="title">Select Size</label>
                @if(count($productSize) != 0)
                    @php $count = 0; @endphp
                    @foreach($productSize as $proSize)
                        <div style="display: flex;padding-bottom: 10px;">
                            <select class="form-control" name="size[]" style="margin-right: 5px;">
                                @if(!empty($sizes))
                                    @foreach($sizes as $size)
                                        <option value="{{$size['id']}}"
                                                @if($proSize['size_id'] == $size['id']) selected @endif>{{$size['size']}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="text" class="form-control" name="price[]" value="{{$proSize['cost']}}"
                                   onkeypress="validate(this.event)"
                                   placeholder="Price" required>
                            @if($count == 0)
                                <a href="javascript:void(0);" class="btn btn-success btn-md add_button"
                                   title="Add field"><i
                                        class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            @else
                                <a href="javascript:void(0);" class="btn btn-danger remove_button"><i
                                        class="fa fa-minus-circle" aria-hidden="true"></i></a>
                            @endif
                        </div>
                        @php $count++; @endphp
                    @endforeach
                @else
                    <div style="display: flex;padding-bottom: 10px;">
                        <select class="form-control" name="size[]" style="margin-right: 5px;">
                            @if(!empty($sizes))
                                @foreach($sizes as $size)
                                    <option value="{{$size['id']}}">{{$size['size']}}</option>
                                @endforeach
                            @endif
                        </select>
                        <input type="text" class="form-control" name="price[]" onkeypress="validate(this.event)"
                               placeholder="Price" required>
                        <a href="javascript:void(0);" class="btn btn-success btn-md add_button" title="Add field"><i
                                class="fa fa-plus-circle" aria-hidden="true"></i></a>
                    </div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function (e) {
                /*********************/
                var maxField = 10; //Input fields increment limitation
                var addButton = $('.add_button'); //Add button selector
                var wrapper = $('.field_wrapper'); //Input field wrapper
                var fieldHTML = '<div style="display: flex;padding-bottom: 10px;">\n' +
                    '<select class="form-control" name="size[]" style="margin-right: 5px;">\n' +
                    '                                            @if(!empty($sizes))\n' +
                    '                                                @foreach($sizes as $size)\n' +
                    '                                                    <option value="{{$size['id']}}">{{$size['size']}}</option>\n' +
                    '                                                @endforeach\n' +
                    '                                            @endif \n' +
                    '                                        </select>' +
                    '<input type="text" class="form-control agenda_details" required name="price[]" onkeypress="validate(this.event)" placeholder="Price">' +
                    '<a href="javascript:void(0);" class="btn btn-danger remove_button"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>' +
                    '            </div>';
                var x = 1;

                //Once add button is clicked
                $(addButton).click(function () {
                    if (x < maxField) {
                        x++;
                        $(wrapper).append(fieldHTML);
                    }
                });

                //Once remove button is clicked
                $(wrapper).on('click', '.remove_button', function (e) {
                    e.preventDefault();
                    $(this).parent('div').remove(); //Remove field html
                    x--; //Decrement field counter
                });

                $(document).on("submit", "#product_store", function (event) {
                    event.preventDefault();
                    $("#loader_run").show();
                    var url = $(this).attr("action");
                    $.ajax({
                        url: url,
                        type: $(this).attr("method"),
                        dataType: "JSON",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if (data.status == "success") {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: data.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(() => {
                                    window.location.replace('{{route('products.index')}}');
                                }, 1500);
                            }else if (data.status == "error") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.msg,
                                })
                            } else {
                                printErrorMsg(data.msg);
                            }
                            $("#loader_run").hide();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection