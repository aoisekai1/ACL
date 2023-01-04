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
                        <input type="text" name="code" class="form-control" id="inputNanme4">
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
                        <small id="emailHelp" class="form-text text-muted">Note: use "S" in back alias if sub menu example : TOS(label transaction order sub menu)</small>
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
                        <input type="text" name="status" class="form-control" id="inputPassword4">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Sub Status</label>
                        <input type="text" name="sub_status" class="form-control" id="inputPassword4">
                    </div>
                    <div class="col-6">
                        <label for="inputPassword4" class="form-label">Sort Menu</label>
                        <input type="text" name="label_sort" class="form-control" id="inputPassword4">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" onclick="store(event)">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
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