@extends('layout/admin-layout')
@section('admin-space')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>

<style>
    #subject, #edit_subject {
        border: 1px solid black;
    }
    tr td #notfound{
        color: red;
        text-align: center;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Add Subject</h5>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addsubjectmodal">
                        Add Subject
                    </button>
                </div>
            </div>

        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm table-hover" id="subjecttable">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @php $x = 1 @endphp
                        @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $x++ }}</td>
                                <td>{{ $subject->subject }}</td>
                                <td>
                                    <button type="button" data-id="{{ $subject->id }}" data-subject="{{ $subject->subject }}" class="btn btn-info btn-sm editbutton" data-toggle="modal" data-target="#editsubjectmodal">
                                        Edit
                                    </button>
                                </td>
                                <td>
                                    <button type="button" data-id="{{ $subject->id }}" class="btn btn-danger btn-sm deletebutton" data-toggle="modal" data-target="#deletesubjectmodal">
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

<!-- Add Subject Modal -->
<div class="modal fade" id="addsubjectmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="addsubject">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Add Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subject">Subject Name</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject Name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Add</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Edit Subject Modal -->
<div class="modal fade" id="editsubjectmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="editsubject">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Edit Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_subject">Subject Name</label>
                        <input type="text" name="edit_subject" id="edit_subject" class="form-control" placeholder="Enter Subject Name" required>
                        <input type="hidden" name="edit_subjectid" id="edit_subjectid">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Add</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Delete Subject Modal -->
<div class="modal fade" id="deletesubjectmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="deletesubject">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Delete Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="color:black">Are your sure to want to delete this Subject?</p>
                    <input type="hidden" name="delete_subjectid" id="delete_subjectid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#subjecttable').DataTable();
        // Add Subject
        $("#addsubject").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ route('addSubject') }}",
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
        // Edit Subject
        $('.editbutton').click(function(e) {
            var subject_id = $(this).attr('data-id');
            var subject = $(this).attr('data-subject');
            $('#edit_subjectid').val(subject_id);
            $('#edit_subject').val(subject);
        });

        $("#editsubject").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ route('editSubject') }}",
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

        // Delete Subject 
        $('.deletebutton').click(function(e) {
            var subject_id = $(this).attr('data-id');
            $('#delete_subjectid').val(subject_id);
        });

        $("#deletesubject").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ route('deleteSubject') }}",
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