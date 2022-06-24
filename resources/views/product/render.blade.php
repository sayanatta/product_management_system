@if(count($products))
    @foreach($products as $product)
        <tr>
            <td>
                <img src="{{url('/').'/'.$product['image']}}" alt="" style="width: 150px">
            </td>
            <td>{{$product['name']}}</td>
            <td>{{$product['unique_id']}}</td>
            <td>
                <a href="{{route('products.edit',$product)}}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <a href="javascript:void(0)" data-toggle="modal" data-toggle="tooltip" title="Delete"
                   data-target="#deleteModal"
                   data-placement="bottom" title="Delete"
                   onclick="getDeleteRoute('{{route('products.destroy',$product)}}')"
                   class="btn btn-danger btn-sm">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    @endforeach
@else
    <div class="justify-content-center mt-3">
        <p>No Product Found</p>
    </div>
@endif
