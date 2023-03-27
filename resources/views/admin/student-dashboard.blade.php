@extends('layout/admin-layout')
@section('admin-space')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>

<style>
    #student_name, #student_email, #edit_student_name, #edit_student_email {
        border: 1px solid black;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Add Students</h5>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addstudentmodal">
                        Add Students
                    </button>
                </div>
            </div>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm table-hover" id="studenttable">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Roll</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @php $x = 1 @endphp
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $x++ }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->type }}</td>
                            <td>
                                <button type="button" data-id="{{ $student->id }}" data-name="{{ $student->name }}" data-email="{{ $student->email }}" class="btn btn-info btn-sm editbutton" data-toggle="modal" data-target="#editstudentmodal">
                                    Edit
                                </button>
                            </td>
                            <td>
                                <button type="button" data-id="{{ $student->id }}" class="btn btn-danger btn-sm deletebutton" data-toggle="modal" data-target="#deletestudentmodal">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addstudentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="student_modal">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="student_name">Student Name</label>
                        <input type="text" name="student_name" id="student_name" required class="form-control" placeholder="Enter Student Name">
                    </div>
                    <div class="form-group">
                        <label for="student_email">Student Email</label>
                        <input type="text" name="student_email" id="student_email" required class="form-control" placeholder="Enter Student Email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="add_btn">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Edit Student Modal -->
<div class="modal fade" id="editstudentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="edit_student_modal">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_student_name">Student Name</label>
                        <input type="text" name="edit_student_name" id="edit_student_name" required class="form-control" placeholder="Enter Student Name">
                        <input type="hidden" name="edit_student_id" id="edit_student_id">
                    </div>
                    <div class="form-group">
                        <label for="edit_student_email">Student Email</label>
                        <input type="text" name="edit_student_email" id="edit_student_email" required class="form-control" placeholder="Enter Student Email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="update_btn">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Delete Student Modal -->
<div class="modal fade" id="deletestudentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="delete_student_modal">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Delete Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_student_id" id="delete_student_id">
                    <p>Are you sure to want to Delete this Student?</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    $(document).ready(function() {
        $('#studenttable').DataTable();
        // Add Student
        $("#student_modal").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ route('AddStudent') }}",
                type: "post",
                data: formdata,
                beforeSend:function(){
                    $('#add_btn').html('Saving...');
                    $('#add_btn').attr('disabled',true);
                },
                success: function(response) {
                    if (response.status == true) {
                        window.location.reload();
                        $('#add_btn').html('Save');
                        $('#add_btn').attr('disabled',false);
                    } else {
                        alert(response.msg);
                    }
                }
            });
        });

            // Edit Student
        $('.editbutton').click(function(e) {
            var student_id = $(this).attr('data-id');
            var student_name = $(this).attr('data-name');
            var student_email = $(this).attr('data-email');
            $('#edit_student_id').val(student_id);
            $('#edit_student_name').val(student_name);
            $('#edit_student_email').val(student_email);
        });

        $("#edit_student_modal").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            // debugger;
            $.ajax({
                url: "{{ route('EditStudent') }}",
                type: "POST",
                data: formdata,
                success: function(response) {
                    console.log(response);
                    if (response.status == true) {
                        window.location.reload();
                    } else {
                        alert(response.msg);
                    }
                }
            });
        });

            // Delete Student 
        $('.deletebutton').click(function(e) {
            var del_subject_id = $(this).attr('data-id');
            $('#delete_student_id').val(del_subject_id);
        });

        $("#delete_student_modal").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ route('DeleteStudent') }}",
                type: "post",
                data: formdata,
                success: function(response) {
                    if (response.status == true) {
                        window.location.reload();
                    } else {
                        alert(response.msg);
                    }
                },
            });
        });
    });
</script>
@endsection