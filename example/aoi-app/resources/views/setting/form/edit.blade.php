@extends('template.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Create</h5>
        <form class="row g-3 form-setting">
            <div class="col-12">
                <div class="col-12">
                    <div class="">
                        <div class="col-6">
                            <label for="inputNanme4" class="form-label">Is Maintenance</label>
                            {{Form::select('is_maintenance', STATUS(), $result ? $result->is_maintenance: null, ['class' => 'form-control'])}}
                        </div>
                        <div class="col-6">
                            <label for="inputEmail4" class="form-label">Link Maintenance</label>
                            <input type="text" name="link_maintenance" class="form-control" id="inputNanme4" value="{{$result ? $result->link_maintenance: null}}">
                        </div>
                        <div class="col-6">
                            <label for="inputPassword4" class="form-label">Role Access All</label>
                            {{Form::select('role_code_access_all', $dd_role, $result ? $result->role_code_access_all: null, ['class' => 'form-control'])}}
                        </div>
                        <div class="col-6">
                            <label for="inputPassword4" class="form-label">Default Redirect</label>
                            <input type="text" name="default_redirect" class="form-control" id="inputNanme4" value="{{$result ? $result->default_redirect: null}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                @if(!$result)
                    <button type="button" class="btn btn-primary" onclick="handlerStore(event)">Save Change</button>
                @else
                    <button type="button" class="btn btn-primary" onclick="handlerUpdate(event)">Save Change</button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    async function handlerUpdate(){
        let form = document.querySelector('.form-setting');
        let url = "{{route('setting.update', $result ? $result->id:"")}}";
        let res = await sendFormData(form, url, 'PATCH');
    }
    async function handlerStore(){
        let form = document.querySelector('.form-setting');
        let url = "{{route('setting.store')}}";
        let res = await sendFormData(form, url);
    }
</script>
@endsection