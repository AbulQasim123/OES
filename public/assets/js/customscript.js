$(document).ready(function () {
        // Registration form
    // $("#addsubject").submit(function (event) {
    //     event.preventDefault();
    //     var formdata = $(this).serialize();
    //     $.ajax({
    //         method: "POST",
    //         url: "http://127.0.0.1:4200/api/register",
    //         data: formdata,
    //         success: function (response) {
    //             // console.log(response);
    //             if (response.msg) {
    //                 $("#register_form")[0].reset();
    //                 $(".error").html("");
    //                 $("#result").html(response.msg +'<a class="close" style="cursor: pointer" data-dismiss="alert">&times;</a>'
    //                 );
    //                 $("#result").css("display", "block");
    //             } else {
    //                 printErrorMessage(response);
    //             }
    //         },
    //     });
    // });
    // function printErrorMessage(msg) {
    //     $(".error").text("");
    //     $.each(msg, function (key, value) {
    //         if (key == "password") {
    //             if (value.length > 1) {
    //                 $(".password_err").text(value[0]);
    //                 $(".conf_pass_err").text(value[1]);
    //             } else {
    //                 if (value[0].includes("Confirm Password")) {
    //                     $(".conf_pass_err").text(value);
    //                 } else {
    //                     $(".password_err").text(value);
    //                 }
    //             }
    //         } else {
    //             $("." + key + "_err").text(value);
    //         }
    //     });
    // }

    //     // Login Form
    // $('#login_form').submit(function(event){
    //     event.preventDefault();
        
    // })
});
