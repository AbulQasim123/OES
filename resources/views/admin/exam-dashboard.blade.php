@extends('layout/admin-layout')
@section('admin-space')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>

<style>
    #exam, #subject_id, #date, #time, #attempt, #editexamname, #editsubject_id, #editexamdate, #editexamtime, #editexamattempt{
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
                    <h5 class="card-title">Add Exams</h5>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addexammodal">
                        Add Exams
                    </button>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div align="center" id="msg"></div>
            <table class="table table-bordered table-sm table-hover" id="examtable">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Exam Name</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col">Attempt</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @php $x = 1 @endphp
                    @foreach($exams as $exam)
                        <tr>
                            <td>{{ $x++ }}</td>
                            <td>{{ $exam->exam_name }}</td>
                            <td>{{ $exam->subjects[0]['subject'] }}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->time }}</td>
                            <td>{{ $exam->attempt }}</td>
                            <td>
                                <button type="button" data-id="{{ $exam->id }}" class="btn btn-info btn-sm editbutton" data-toggle="modal" data-target="#editexammodal">
                                    Edit
                                </button>
                            </td>
                            <td>
                                <button type="button" data-id="{{ $exam->id }}" class="btn btn-danger btn-sm deletebutton" data-toggle="modal" data-target="#deleteexammodal">
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

<!-- Add Exam Modal -->
<div class="modal fade" id="addexammodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="addexam">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Add Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exam">Exam Name</label>
                        <input type="text" name="exam" id="exam" class="form-control" placeholder="Enter Exam Name">
                        <label for="subject_id">Select Subject</label>
                        <select name="subject_id" id="subject_id" required class="form-control">
                            <option value="">Select Subject</option>
                            @if(count($subjects) > 0)
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                @endforeach
                            @endif
                        </select>
                        <label for="date">Select Date</label>
                        <input type="date" name="date" id="date" class="form-control" required min="@php echo date('Y-m-d') @endphp">
                        <label for="time">Enter Time</label>
                        <input type="time" name="time" id="time" class="form-control" required>
                        <label for="attempt">Enter Attempt</label>
                        <input type="number" name="attempt" id="attempt" class="form-control" required min="1">
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
<!-- Edit Exam Modal -->
<div class="modal fade" id="editexammodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="editexam">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Edit Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="editexamid" id="editexamid">
                        <label for="editexamname">Exam Name</label>
                        <input type="text" name="editexamname" id="editexamname" class="form-control" placeholder="Enter Exam Name">
                        <label for="editsubject_id">Select Subject</label>
                        <select name="editsubject_id" id="editsubject_id" required class="form-control">
                            <option value="">Select Subject</option>
                            @if(count($subjects) > 0)
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                @endforeach
                            @endif
                        </select>
                        <label for="editexamdate">Select Date</label>
                        <input type="date" name="editexamdate" id="editexamdate" class="form-control" required min="@php echo date('Y-m-d') @endphp">
                        <label for="editexamtime">Enter Time</label>
                        <input type="time" name="editexamtime" id="editexamtime" class="form-control" required>
                        <label for="editexamattempt">Enter Attempt</label>
                        <input type="number" name="editexamattempt" id="editexamattempt" class="form-control" required min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Delete Subject Modal -->
<div class="modal fade" id="deleteexammodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="deleteexam">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Delete Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="color:black">Are your sure to want to delete thid Exam?</p>
                    <input type="hidden" name="delete_examid" id="delete_examid">
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
        $('#examtable').DataTable();
            // Add Subject
        $("#addexam").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ route('addExam') }}",
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
            // Fetch Edit exam data
        $('.editbutton').click(function(e) {
            var exam_id = $(this).attr('data-id');
            $('#editexamid').val(exam_id);
            var url = "{{ route('getExamDetail','id') }}";
            url = url.replace('id',exam_id);
            $.ajax({
                url: url,
                type: "get",
                success: function (response) {
                    if(response.status == true){
                        var exam = response.data;
                        $('#editexamname').val(exam[0].exam_name);
                        $('#editsubject_id').val(exam[0].subject_id);
                        $('#editexamdate').val(exam[0].date);
                        $('#editexamtime').val(exam[0].time);
                        $('#editexamattempt').val(exam[0].attempt);

                    }else{
                        alert(data.msg);
                    }
                }
            });
        });

        $("#editexam").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ route('editExam') }}",
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

            // Delete Exam
        $('.deletebutton').click(function(e) {
            var exam_id = $(this).attr('data-id');
            $('#delete_examid').val(exam_id);
        });

        $("#deleteexam").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ route('deleteExam') }}",
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