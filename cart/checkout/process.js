/**
 * @param {*} student_id 
 * @param {*} start_datetime 
 * @param {*} end_datetime 
 * @param {*} class_code 
 * @param {*} note 
 * 
 * Process a request/order submission with 2 steps: create a new request/order and create new request/order details in database. 
 * If step 2 is failed, the request/order deletion step will be done.
 */
function process_request_submission(student_id, start_datetime, end_datetime, class_code, note) {
    $(document).ready(function() {
        var $ajax_request = $.ajax({
            type : "POST",
            url  : "../../request/make_new_request.php",
            data : { student_id : student_id, 
                    start_datetime : start_datetime,
                    end_datetime : end_datetime,
                    class_code : class_code,
                    note : note,
            },
            dataType : "json"
        });

        $ajax_request.done(function(response) {
            console.log(response);
            if (response['hasSucceeded'] === true) {
                request_details_insertion(student_id, response['request_number'], response['message']);
            } else {
                $("#notification").css("color", "red");
                $("#notification").html(response['message']);
            }
    
            // remove 1 time for one of the notifications shown above.
            setTimeout(function() {
                $("#notification").html("");
            }, 3000);
        });

        $ajax_request.fail(function() {
            $("#notification").css("color", "red");
            $("#notification").html("Gửi yêu cầu thất bại.");
        });
    });
}

function request_details_insertion(student_id, request_number, first_message) {
    if (student_id == "" || request_number == "") {
        return;
    }

    $(document).ready(function() {
        var $ajax_request = $.ajax({
            type : "POST",
            url  : "../../request/create_request_details.php",
            data : { student_id : student_id, request_number : request_number },
            dataType : "json"
        });
    
        $ajax_request.done(function(response) {
            if (response['hasSucceeded'] === true) {
                $("#notification").css("color", "green");            
                $("#notification").html(first_message + ". Đợi 2 giây để chuyển hướng");
                $("#checkout_info input[name='submit']").prop('disabled', true);
                setTimeout(function() {
                    window.location.href = "../../request";
                }, 1500);
            } else {
                delete_lastest_request(student_id);
            }
        });
    
        $ajax_request.fail(function() {
            $("#notification").css("color", "red");            
            $("#notification").html(first_message + ". \nGửi yêu cầu thất bại.");
        });
    });
}

function delete_lastest_request(student_id, first_message) {
    if (student_id == "") {
        return;
    }

    $(document).ready(function() {
        var $ajax_request = $.ajax({
            type : "POST",
            url  : "../../request/delete_lastest_request.php",
            data : { student_id : student_id },
            dataType : "json",
        });

        $ajax_request.done(function(response) {
            console.log(response);
            $("#notification").css("color", "red");
            $("#notification").html(
                first_message
                + ". deletion result is " + response['hasSucceeded'] 
                + ". " + response['message']);
        });

        $ajax_request.fail(function() {
            $("#notification").css("color", "red");            
            $("#notification").html(first_message + ". \nGửi yêu cầu thất bại.");
        });
    
    });    
}

function process_order_submission(student_id, payment_method, note) {
    $(document).ready(function() {
        var $ajax_request = $.ajax({
            type : "POST",
            url  : "../../order/make_new_order.php",
            data : { student_id : student_id, 
                    payment_method : payment_method,
                    note : note,
            },
            dataType : "json",
            success : function(response) {
                console.log(response);
                if (response['hasSucceeded'] === true) {
                    order_details_insertion(student_id, response['order_number'], response['message']);
                } else {
                    $("#notification").css("color", "red");
                    $("#notification").html(response['message']);
                }

                // remove 1 time for one of the notifications shown above.
                setTimeout(function() {
                    $("#notification").html("");
                }, 3000);
            }
        });

        $ajax_request.fail(function() {
            $("#notification").css("color", "red");
            $("#notification").html("Gửi yêu cầu thất bại.");
        });
    });
}

function order_details_insertion(student_id, order_number, first_message) {
    if (student_id == "" || order_number == "") {
        return;
    }

    $(document).ready(function() {
        var $ajax_request = $.ajax({
            type : "POST",
            url  : "../../order/create_order_details.php",
            data : { student_id : student_id, order_number : order_number },
            dataType : "json"
        });

        $ajax_request.done(function(response) {
            if (response['hasSucceeded'] === true) {
                $("#notification").css("color", "green");            
                $("#notification").html(first_message + ". Đợi 2 giây để chuyển hướng");
                $("#checkout_info input[name='submit']").prop('disabled', true);
    
                setTimeout(function() {
                    window.location.href = "../../request";
                }, 1500);
            } else {
                delete_lastest_order(student_id, response['message']);
            }
        });
    
        $ajax_request.fail(function() {
            $("#notification").css("color", "red");            
            $("#notification").html(first_message + ". \nGửi yêu cầu thất bại.");
        });
 });
}

function delete_lastest_order(student_id, first_message) {
    if (student_id == "") {
        return;
    }

    $(document).ready(function() {
        var $ajax_request = $.ajax({
            type : "POST",
            url  : "../../order/delete_lastest_order.php",
            data : { student_id : student_id },
            dataType : "json",
        });

        $ajax_request.done(function(response) {
            console.log(response);
            $("#notification").css("color", "red");
            $("#notification").html(
                first_message
                + ". deletion result is " + response['hasSucceeded'] 
                + ". " + response['message']);
        });

        $ajax_request.fail(function() {
            $("#notification").css("color", "red");            
            $("#notification").html(first_message + ". \nGửi yêu cầu thất bại.");
        });
    
    });    
}