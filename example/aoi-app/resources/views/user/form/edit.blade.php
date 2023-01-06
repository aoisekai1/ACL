@extends('template.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Edit User</h5>
        <form class="row g-3 form-user">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" id="inputNanme4" value="{{$result->code}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="inputEmail4" class="form-label">Name</label>
                        <input type="text" name="username" class="form-control" id="inputEmail4" value="{{$result->username}}">
                    </div>
                    <div class="col-6">
                        <label for="inputEmail4" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="inputEmail4" value="{{$result->password}}">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Role</label>
                        {{Form::select('role_code', $dd_role, $result->role_code, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Status</label>
                        {{Form::select('is_active', STATUS(), $result->is_active, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" onclick="store(event)">Submit</button>
                <a href="{{route('user.index')}}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    async function store(){
        let form = document.querySelector('.form-user');
        let url = "{{route('user.update', $result->id)}}";
        let res = await sendFormData(form, url, 'PATCH');
    }
</script>
@endsection