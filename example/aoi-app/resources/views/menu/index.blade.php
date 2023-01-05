@extends ('template.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">List Menu</h5>
        <div class="col-12">
            <a class="btn btn-primary" href="{{route('menu.create')}}"><i class="bi bi-file-earmark"></i> New Input</a>
        </div>
        <div>&nbsp;</div>
        <div class="col-12">
            <table class="table table-bordered table-hovered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Action</th>
                        <th>Label</th>
                        <th>Group Menu</th>
                        <th>Group Sub Menu</th>
                        <th>Class Name</th>
                        <th>Status</th>
                        <th>Sub Status</th>
                        <th>Sort Menu</th>
                        <th>Url</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $i => $r)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a class="btn btn-warning btn-sm" href="{{route('menu.edit', $r->id)}}"><i class="bi bi-pencil-square"></i></a>
                                <button class="btn btn-danger btn-sm" title="{{$r->label}}" data-href="{{route('menu.destroy', $r->id)}}" onclick="delete_handler(this)"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                        <td>{{$r->label}}</td>
                        <td>{{$r->group_code}}</td>
                        <td>{{$r->group_smenu}}</td>
                        <td>{{$r->class_name}}</td>
                        <td>{{STATUS($r->status)}}</td>
                        <td>{{$r->sub_menu}}</td>
                        <td>{{$r->label_sort}}</td>
                        <td>{{$r->url}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    async function delete_handler(event){
        let form = {};
        let url = event.getAttribute('data-href');
        await sendFormData(form, url, 'DELETE', {
            isJson:true,
            isAlert: true,
            alertTitle: "delete "+event.getAttribute('title')
        });
    }
</script>
@endsection