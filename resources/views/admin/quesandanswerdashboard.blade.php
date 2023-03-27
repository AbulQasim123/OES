@extends('layout/admin-layout')
@section('admin-space')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>

<style>
    #question,#answer {
        border: 1px solid black;
    }

    #answer {
        width: 400px;
        display: inline-block;
    }

    #is_correct {
        margin-bottom: -32px;
        margin-left: 10px;
    }

    tr td #notfound {
        color: red;
        text-align: center;
    }

    #Add_ans_field {
        margin-left: 15px;
    }

    #error_field {
        color: red;
    }
    .removebutton{
        height: 35px;
        margin-top: 38px;
    }
</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Add Q&A</h5>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addquesandansmodal">
                        Add Q&A
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm table-hover" id="subjecttable">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Question</th>
                        <th scope="col">Answers</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @php $x = 1 @endphp
                    @foreach($questions as $question)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $question->question }}</td>
                        <td>
                            <button type="button" data-id="{{ $question->id }}" class="btn btn-info btn-sm knowAnswer" data-toggle="modal" data-target="#know-ans-modal">
                                Know Answer
                            </button>
                        </td>
                        <td>
                            <button type="button" data-id="{{ $question->id }}" class="btn btn-info btn-sm editQuesbutton" data-toggle="modal" data-target="#editques_modal">
                                Edit
                            </button>
                        </td>
                        <td>
                            <button type="button" data-id="{{ $question->id }}" class="btn btn-danger btn-sm deleteQuesbutton" data-toggle="modal" data-target="#deletequesmodal">
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

<!-- Add Q&A Modal -->
<div class="modal fade" id="addquesandansmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="addques_and_ans">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Add Q&A</h5>
                    <button type="button" id="Add_ans_field" class="btn btn-primary btn-sm"> <span class="fa fa-plus"></span> Add Answer</button>
                    <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                    <div class="modal-body">
                        <div class="text-center" id="error_field"></div>
                        <div class="row">
                            <div class="col">
                                <!-- <div class="form-group"> -->
                                    <label for="question">Enter Question</label>
                                    <input type="text" name="question" id="question" class="form-control" placeholder="Enter Question" required>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closemodal btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Add</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Show Answer Modal -->
<div class="modal fade" id="know-ans-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Know Your Answer</h5>
                <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm table-hover" id="subjecttable">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Answer</th>
                            <th scope="col">Correct</th>
                        </tr>
                    </thead>
                    <tbody id="knowanswertable"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closemodal btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete Q&A Modal -->
<div class="modal fade" id="deletequesmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form id="delete_ques">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Delete Q&A</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="color:black">Are your sure to want to delete this Q&A?</p>
                    <input type="hidden" name="delete_quesid" id="delete_quesid">
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
        // Form Submission
        $('#addques_and_ans').submit(function(e) {
            e.preventDefault();
            if ($('.add_answers').length < 2) {
                $('#error_field').text('Please Add minimum two answer field');
                setTimeout(() => {
                    $('#error_field').text('');
                }, 3000);
            } else {
                var checkiscorrect = false;
                for (let i = 0; i < $('.is_correct').length; i++) {
                    if ($(".is_correct:eq(" + i + ")").prop("checked") == true) {
                        checkiscorrect = true;
                        $(".is_correct:eq(" + i + ")").val($(".is_correct:eq(" + i + ")").next().find('input').val());
                    }
                }
                if (checkiscorrect) {
                    var formdata = $(this).serialize();
                    $.ajax({
                        url: "{{ route('Addquesand') }}",
                        type: "post",
                        data: formdata,
                        success: function(response) {
                            console.log(response);
                            if (response.status == true) {
                                // window.location.reload();
                            } else {
                                alert(response.msg);
                            }
                        }
                    });
                } else {
                    $('#error_field').text('Please Select Anyone correct Answer');
                    setTimeout(() => {
                        $('#error_field').text('');
                    }, 3000);
                }
            }
        });
        // Add Answer field
        $('#Add_ans_field').click(function() {
            if ($('.add_answers').length >= 4) {
                $('#error_field').text('You can Add four Answer field');
                setTimeout(() => {
                    $('#error_field').text('');
                }, 3000);
            } else {
                var html = `
                    <div class="row add_answers">
                        <input type="radio" name="is_correct" id="is_correct" class="is_correct">
                        <div class="col">
                            <label for="answer">Enter Answer</label>
                            <input type="text" name="answer[]" id="answer" class="form-control" placeholder="Enter Answer" required>
                        </div>
                        <button type="button" class="btn btn-danger removebutton"><span class="fa fa-remove"></span></button>
                    </div>`;
                $('.modal-body').append(html);
            }
        })
        $('.closemodal').click(function(e) {
            $('.add_answers').remove();
        });
        // Remove Answer Field
        $(document).on('click', '.removebutton', function() {
            // $('.add_answers').remove();
            $(this).parent().remove();
        })

            // Know Ansawer modal
        $('.knowAnswer').click(function () { 
            var questions = @json($questions);
            var ques_id = $(this).attr('data-id');
            var html = '';

            console.log(questions);
            for(let i = 0; i < questions.length; i++ ){
                if (questions[i]['id'] == ques_id) {
                    var answerLength = questions[i]['answers'].length;
                    for (let j = 0; j < answerLength; j++) {
                        let is_correct = 'NO';
                        if (questions[i]['answers'][j]['is_correct'] == 1) {
                            is_correct = 'Yes';
                        }
                        html += `<tr>
                                    <td>`+(j+1)+`</td>
                                    <td>`+questions[i]['answers'][j]['answer']+`</td>
                                    <td>`+is_correct+`</td>
                                </tr>`;
                    }
                    break;
                }
            }
            $('#knowanswertable').html(html);
        })

            // Delete Q&A 
        $('.deleteQuesbutton').click(function(e) {
            var ques_id = $(this).attr('data-id');
            $('#delete_quesid').val(ques_id);
        });

        $("#delete_ques").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "{{ route('DeleteQuesAns') }}",
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