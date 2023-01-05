@extends('template.master')
@section('content')
<div class="card">
    <div class="card-body">
       <div class="col-12">
            <h5 class="card-title">List Privillage Menu {{$privillage->label}}</h5>
            <div class="col-12">
                <form class="row g-3 form-pm">
                    <div class="col-12">
                        <div class="row">
                            <input type="hidden" name="privillage_group_code" class="form-control" value="{{$privillage_code}}">
                            <div class="col-6">
                                <label for="inputNanme4" class="form-label">Menu</label>
                                {{Form::select('menu_code', $dd_menu, null, ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-primary" onclick="store(event)">Add</button>
                    </div>
                </form>
            </div>
            <div>&nbsp;</div>
            <div class="col-12">
                <table class="table table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th width="5">No</th>
                            <th class="text-center" width="10">Action</th>
                            <th>Menu</th>
                            <th>Privillage Group</th>
                            <th width="100" class="text-center">Read</th>
                            <th width="100" class="text-center">Insert</th>
                            <th width="100" class="text-center">Update</th>
                            <th width="100" class="text-center">Delete</th>
                            <th width="100" class="text-center">Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $i => $r)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="btn btn-warning btn-sm btn-access-all{{$r->id}}" data-title="{{$r->menu}}" data-id="{{$r->id}}" onclick="unAccessAllPerMenu(this)" title="Un Access All"><i class="bi bi-check"></i></button>
                                    <button class="btn btn-primary btn-sm btn-access-all{{$r->id}}" data-title="{{$r->menu}}" data-id="{{$r->id}}" onclick="accessAllPerMenu(this)" title="Access All"><i class="bi bi-check-all"></i></button>
                                    <button class="btn btn-danger btn-sm" data-title="{{$r->menu}}" data-href="{{route('pm.destroy', $r->id)}}" onclick="handler_delete(this)"><i class="bi bi-trash"></i></button>
                                </div>
                            </td>
                            <td>{{$r->menu}}</td>
                            <td>{{$r->label}}</td>
                            <td class="text-center">
                                <input data-url="{{route('pm.update', $r->id)}}" type="checkbox" onclick="handlerChecked(this)" name="is_read" class="icheckbox{{$r->id}} checkbox-size" {{$r->is_read == 1 ? 'checked':''}}>
                            </td>
                            <td class="text-center">
                                <input data-url="{{route('pm.update', $r->id)}}" type="checkbox" onclick="handlerChecked(this)" name="is_insert" class="icheckbox{{$r->id}} checkbox-size" {{$r->is_insert == 1 ? 'checked':''}}>
                            </td>
                            <td class="text-center">
                                <input data-url="{{route('pm.update', $r->id)}}" type="checkbox" onclick="handlerChecked(this)" name="is_update" class="icheckbox{{$r->id}} checkbox-size" {{$r->is_update == 1 ? 'checked':''}}>
                            </td>
                            <td class="text-center">
                                <input data-url="{{route('pm.update', $r->id)}}" type="checkbox" onclick="handlerChecked(this)" name="is_delete" class="icheckbox{{$r->id}} checkbox-size" {{$r->is_delete == 1 ? 'checked':''}}>
                            </td>
                            <td class="text-center">
                                <input data-url="{{route('pm.update', $r->id)}}" type="checkbox" onclick="handlerChecked(this)" name="is_approved" class="icheckbox{{$r->id}} checkbox-size" {{$r->is_approved == 1 ? 'checked':''}}>
                            </td>
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
    async function accessAllPerMenu(event){
        let id = event.getAttribute('data-id');
        let obj = manageAccessAll(id, true);
        let form = obj['fname'];
        let url = obj['url'];
        let res = await sendFormData(form, url, 'PATCH', {
            isJson:true,
            isAlert: true,
            alertTitle: 'give all access for menu '+event.getAttribute('data-title')
        });
        if(res.error == 0){
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    }
    async function unAccessAllPerMenu(event){
        let id = event.getAttribute('data-id');
        let obj = manageAccessAll(id);
        let form = obj['fname'];
        let url = obj['url'];
        let res = await sendFormData(form, url, 'PATCH', {
            isJson:true,
            isAlert: true,
            alertTitle: 'uncheck all access for menu '+event.getAttribute('data-title')
        });
        if(res.error == 0){
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    }
    function manageAccessAll(id, isCheckAll=false){
        let fname = {};
        let url = "";
        let valChecked = isCheckAll ? 1:0; 
        let icheckbox = document.querySelectorAll('.icheckbox'+id);
        icheckbox.forEach(element => {
            let iname = element.getAttribute('name');
            fname[iname]=valChecked;
            url = element.getAttribute('data-url');
        });
        if(url == ""){
            console.log('Url is not set');
            return false;
        }
        return {
            fname: fname,
            url: url
        }
    }
    async function handlerChecked(event){
        let form = {};
        let fname = event.getAttribute('name');
        if(event.checked){
            form[`${fname}`] = 1;
        }else{
            form[`${fname}`] = 0;
        }
        let url = event.getAttribute('data-url');
        let res = await sendFormData(form, url, 'PATCH', {
            isJson:true
        });
    }
    async function store(){
        let form = document.querySelector('.form-pm');
        let url = "{{route('pm.store')}}";
        let res = await sendFormData(form, url);
    }
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