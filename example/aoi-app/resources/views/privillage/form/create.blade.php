@extends('template.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Create</h5>
        <form class="row g-3 form-privillage">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" id="inputNanme4" value="{{$code}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="inputEmail4" class="form-label">Label</label>
                        <input type="text" name="label" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Status</label>
                        {{Form::select('status', STATUS(), null, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" onclick="store(event)">Submit</button>
                <a href="{{route('menu.index')}}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    async function store(){
        let form = document.querySelector('.form-privillage');
        let url = "{{route('privillage.store')}}";
        let res = await sendFormData(form, url);
    }
</script>
@endsection