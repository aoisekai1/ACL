@extends('template.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Create</h5>
        <form class="row g-3 form-pu">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Code</label>
                        {{Form::select('privillage_group_code', $dd_privillage, null, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-6">
                        <label for="inputEmail4" class="form-label">User</label>
                        {{Form::select('user_code', $dd_user, null, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Status</label>
                        {{Form::select('status', STATUS(), null, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" onclick="store(event)">Submit</button>
                <a href="{{route('pu.show', $privillage_code)}}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    async function store(){
        let form = document.querySelector('.form-pu');
        let url = "{{route('pu.store')}}";
        let res = await sendFormData(form, url);
    }
</script>
@endsection