@extends('template.master')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Form Create</h5>
        <form class="row g-3 form-menu">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <label for="inputNanme4" class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" id="inputNanme4" value="{{$code_menu}}" readonly>
                    </div>
                    <div class="col-6">
                        <label for="inputEmail4" class="form-label">Label</label>
                        <input type="text" name="label" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Group Code</label>
                        <input type="text" name="group_code" class="form-control" id="inputPassword4">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Group Sub Menu</label>
                        <input type="text" name="group_smenu" class="form-control" id="inputPassword4" placeholder="Example: TO for menu and TOS for sub menu">
                        <small id="emailHelp" class="form-text text-muted">Note: if 1. input label: "", 2. input menu: TO (initial for "T" label transction and "O" menu order), 3. input sub menu: TOS (initial "S" is sub menu) </small>
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Class Name</label>
                        <input type="text" name="class_name" class="form-control" id="inputPassword4">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Route</label>
                        <input type="text" name="url" class="form-control" id="inputPassword4" placeholder="Example Input: '/menu/create'">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Status</label>
                        {{Form::select('status', STATUS(), null, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Sub Status</label>
                        {{Form::select('sub_status', SUB_STATUS(), null, ['class' => 'form-control'])}}
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Sort Menu</label>
                        <input type="text" name="label_sort" class="form-control" id="inputPassword4">
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
        let form = document.querySelector('.form-menu');
        let url = "{{route('menu.store')}}";
        let res = await sendFormData(form, url);
    }
</script>
@endsection