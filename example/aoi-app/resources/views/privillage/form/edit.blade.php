@extends('template.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Edit</h5>
        <form class="row g-3 form-privillage">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" id="inputNanme4" value="{{$result->code}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="inputEmail4" class="form-label">Label</label>
                        <input type="text" name="label" class="form-control" id="inputEmail4" value="{{$result->label}}">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Status</label>
                        {{Form::select('status', STATUS(), $result->status, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" onclick="store(event)">Submit</button>
                <a href="{{route('privillage.index')}}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    async function store(){
        let form = document.querySelector('.form-privillage');
        let url = "{{route('privillage.update', $result->id)}}";
        let res = await sendFormData(form, url, 'PATCH');
    }
</script>
@endsection