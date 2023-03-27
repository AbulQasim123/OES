<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
        // Add Subject
    public function AddSubject(Request $request){
        try {
            Subject::insert([
                'subject' => $request->subject,
            ]);
            return response()->json(['status' => true, 'msg' => 'Subject Added Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }
        // Edit Subject
    public function EditSubject(Request $request){
        try {
            $subject = Subject::find($request->edit_subjectid);
            $subject->subject = $request->edit_subject;
            $subject->save();
            return response()->json(['status' => true, 'msg' => 'Subject Updated Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }
        // Delete Subject
    public function DeleteSubject(Request $request){
        try {
            Subject::where('id',$request->delete_subjectid)->delete();
            return response()->json(['status' => true, 'msg' => 'Subject Deleted Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

        // Exam Dashboard load
    public function ExamDashboard(){
        $subjects = Subject::all();
        $exams = Exam::with('subjects')->get();
        return view('/admin/exam-dashboard',['subjects'=> $subjects,'exams'=> $exams]);
    }
        // Add Exam model
    public function addExam(Request $request){
        try {
            Exam::insert([
                'exam_name' => $request->exam,
                'subject_id' => $request->subject_id,
                'date' => $request->date,
                'time' => $request->time,
                'attempt' => $request->attempt,
            ]);
            return response()->json(['status' => true, 'msg' => 'Exam Added Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        } 
    }
        // Get Exam Details
    public function GetExamDetail($id){
        try {
            $exams = Exam::where('id',$id)->get();
            return response()->json(['status' => true, 'data' => $exams]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

        // Edit Subject
    public function EditExam(Request $request){
        try {
            $exam = Exam::find($request->editexamid);
            $exam->exam_name = $request->editexamname;
            $exam->subject_id = $request->editsubject_id;
            $exam->date = $request->editexamdate;
            $exam->time = $request->editexamtime;
            $exam->attempt = $request->editexamattempt;
            $exam->save();
            return response()->json(['status' => true, 'msg' => 'Exam Updated Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

        // Delete Exam
    public function DeleteExam(Request $request){
        try {
            Exam::where('id',$request->delete_examid)->delete();
            return response()->json(['status' => true, 'msg' => 'Exam Deleted Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

        // Question And Answer Dashboard
    public function QuesAnsDashboard(){
        $questions = Question::with('answers')->get();
        return view('/admin/quesandanswerdashboard',compact('questions'));
    }

        // Add Question And Answer
    public function AddQuesAns(Request $request){
        try {
            $question_id = Question::insertGetId([
                'question' => $request->question,
            ]);

            foreach($request->answer as $ans){
                $is_corrects = 0;
                if($request->is_correct == $ans){
                    $is_corrects = 1;
                }

                Answer::insert([
                    'question_id' => $question_id,
                    'answer' => $ans,
                    'is_correct' => $is_corrects,
                ]);
            }
            return response()->json(['status' => true, 'msg' => 'Question And Answer Added Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }
        // Delete Question And Answer
    public function DeleteQuesAns(Request $request){
        try {
            Question::where('id',$request->delete_quesid)->delete();
            Answer::where('question_id',$request->delete_quesid)->delete();
            return response()->json(['status' => true, 'msg' => 'Question And Answer Deleted Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

        // Student Dashboard
    public function StudentDashoard(){
        $students = User::where('type', auth()->user()->type =  "Student")->get();
        return view('/admin/student-dashboard',compact('students'));
    }

        // Add Students
    public function AddStudent(Request $request){
        try {
            $password = Str::random(8);
            // $password = 'nitu123';
            User::insert([
                'name' => $request->student_name,
                'email' => $request->student_email,
                'password' => Hash::make($password),
                'type' => 'Student'
            ]);
            
            $url = URL::to('/');
            $data['name'] = $request->student_name;
            $data['email'] = $request->student_email;
            $data['password'] = $password;
            $data['url'] = $url;
            $data['title'] = 'Here is About Your!';
            $data['body'] = "Let's short look of your Credentials.";

            Mail::send('mail.studentcredential', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return response()->json(['status' => true, 'msg' => 'Student Added Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }
        // Edit Students
    public function EditStudent(Request $request){
        try {
            $user = User::find($request->edit_student_id);
            $user->name = $request->edit_student_name;
            $user->email = $request->edit_student_email;
            $user->save();
                // Both are correct for update record
            // DB::table('users')
            //     ->where('id', $request->edit_student_id)
            //     ->update([
            //         'name' => $request->edit_student_name,
            //         'email' => $request->edit_student_email,
            //     ]);

            $url = URL::to('/');
            $data['name'] = $request->student_name;
            $data['email'] = $request->student_email;
            $data['url'] = $url;
            $data['title'] = 'Here is About Your!';
            $data['body'] = "Your updated profile Credentials.";

            Mail::send('mail.updatestudent', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });

            return response()->json(['status' => true, 'msg' => 'Student updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

        // Delete Students
    public function DeleteStudent(Request $request){
        try {
            User::where('id', $request->delete_student_id)->delete();
            return response()->json(['status' => true, 'msg' => 'Student Deleted Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'msg' => $e->getMessage()]);
        }
    }
}
