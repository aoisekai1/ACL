@extends('template.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Edit</h5>
        <form class="row g-3 form-menu">
            <div class="col-12">
                <div class="row">
                    <!-- <input type="hidden" name="_method" value="PUT"> -->
                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" id="inputNanme4" value="{{$result->code}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="inputEmail4" class="form-label">Label</label>
                        <input type="text" name="label" class="form-control" id="inputEmail4" value="{{$result->label}}" >
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Group Code</label>
                        <input type="text" name="group_code" class="form-control" id="inputPassword4" value="{{$result->group_code}}" >
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Group Sub Menu</label>
                        <input type="text" name="group_smenu" class="form-control" id="inputPassword4" value="{{$result->group_smenu}}"  placeholder="Example: TO for menu and TOS for sub menu">
                        <small id="emailHelp" class="form-text text-muted">Note: if 1. input label: "", 2. input menu: TO (initial for "T" label transction and "O" menu order), 3. input sub menu: TOS (initial "S" is sub menu) </small>
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Class Name</label>
                        <input type="text" name="class_name" class="form-control" id="inputPassword4" value="{{$result->class_name}}" >
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Route</label>
                        <input type="text" name="url" class="form-control" id="inputPassword4" value="{{$result->url}}" placeholder="Example Input: '/menu/create'">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Status</label>
                        {{Form::select('status', STATUS(), $result->status, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Sub Status</label>
                        {{Form::select('sub_status', SUB_STATUS(), $result->sub_status, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Sort Menu</label>
                        <input type="text" name="label_sort" class="form-control" id="inputPassword4" value="{{$result->label_sort}}" >
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="inputPassword4">{{$result->description}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" onclick="handler_update(event)">Submit</button>
                <a href="{{route('menu.index')}}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    async function handler_update(){
        let form = document.querySelector('.form-menu');
        let url = "{{route('menu.update', $result->id)}}";
        await sendFormData(form, url,'PATCH');
    }
</script>
@endsection