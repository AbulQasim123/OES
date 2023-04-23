@extends('layout/admin-layout')
@section('admin-space')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
<style>
    .form-control {
        border: 1px solid #eea;
        opacity: 0.4px;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Add Banner</h5>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#add_module_modal">
                        Add Banner
                    </button>
                </div>
            </div>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm table-hover" id="moduleList">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Test Name</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Title</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="uploadModuleList"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="add_module_modal" tabindex="-1" role="dialog">
    <form id="module_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Add Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="test_name">Test Name</label>
                        <input type="text" name="test_name" id="test_name" required class="form-control" placeholder="Test Name">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" required class="form-control" placeholder="Enter Subject">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" required class="form-control" placeholder="Enter Title">
                            </div>
                            <div class="col-md-6">
                                <label for="amount">Amount</label>
                                <input type="text" name="amount" id="amount" required class="form-control" placeholder="Enter Amount">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="Upload_module">Upload</button>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    $(document).ready(function() {
        $('#moduleList').DataTable();
        fetchModule();
        function fetchModule() {
            $.ajax({
                type: "get",
                url: "{{ route('fetch.module') }}",
                dataType: "JSON",
                success: function (response) {
                    $('#uploadModuleList').html(response.table_data);
                }
            });
        }
        $("#module_form").submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('upload.module') }}",
                type: "post",
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function() {
                    $('#Upload_module').html('Saving...');
                    $('#Upload_module').attr('disabled', true);
                },
                success: (response)=> {
                    if (response.status == true) {
                        // window.location.reload();
                        fetchModule();
                        $('#module_form')[0].reset();
                        $('#add_module_modal').modal('hide');
                        $('#Upload_module').html('Save');
                        $('#Upload_module').attr('disabled', false);
                        alert(response.msg);
                    } 
                },
                error: function () { 
                    console.log(response.response.JSON.message);
                }
            });
        });
    });
</script>
@endsection