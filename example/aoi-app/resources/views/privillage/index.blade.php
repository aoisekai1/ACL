@extends('template.master')
@section('content')
<div class="card">
    <div class="card-body">
       <div class="col-12">
            <h5 class="card-title">List Privillage Groups</h5>
            <div class="col-12">
                <a class="btn btn-primary" href="{{route('privillage.create')}}"><i class="bi bi-file-earmark"></i> New Input</a>
            </div>
            <div>&nbsp;</div>
            <div class="col-12">
                <table class="table table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th width="5">No</th>
                            <th class="text-center" width="10">Action</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $i => $r)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a class="btn btn-warning btn-sm" title="Edit" href="{{route('privillage.edit', $r->id)}}"><i class="bi bi-pencil-square"></i></a>
                                    <button class="btn btn-primary btn-sm" title="Button Active"><i class="bi bi-check"></i></button>
                                    <a class="btn btn-primary btn-sm" href="{{route('pu.show', $r->code)}}" title="Button Add Privillage User"><i class="bi bi-people-fill"></i></a>
                                    <a class="btn btn-primary btn-sm" href="{{route('pm.show', $r->code)}}" title="Button Add Privillage Menu"><i class="bi bi-card-list"></i></a>
                                    <button class="btn btn-danger btn-sm" data-title="{{$r->label}}" data-href="{{route('privillage.destroy', $r->id)}}" onclick="handler_delete(this)"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                            <td>{{$r->code}}</td>
                            <td>{{$r->label}}</td>
                            <td>{{STATUS($r->status)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
       </div> 
    </div>
</div>
@endsection
@section('script')
<script>
    async function handler_delete(event){
        let form = {};
        let url = event.getAttribute('data-href');
        await sendFormData(form, url, 'DELETE', {
            isJson:true,
            isAlert: true,
            alertTitle: "delete "+event.getAttribute('data-title')
        });
    }
</script>
@endsection