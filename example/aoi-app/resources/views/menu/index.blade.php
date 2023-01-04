@extends ('template.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">List Menu</h5>
        <table class="table table-bordered table-hovered">
            <thead>
                <tr>
                    <th>No</th>
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
@endsection