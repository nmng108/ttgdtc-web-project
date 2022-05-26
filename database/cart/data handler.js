function switch_edit_mode(button_element) {
    let split_id =  button_element.id.split('_');
    const ITEM_CODE = split_id[2];
    const DELETE_BUTTON = document.getElementById('delete_button_' + ITEM_CODE);
    const QUANTITY_INPUT = document.getElementById('quantity_input_' + ITEM_CODE);
    
    var quantity_validation = function() {
        if (QUANTITY_INPUT.value === "0")  {
            $("#quantity_warning_" + ITEM_CODE).html("Số lượng tối thiểu là 1");
            button_element.disabled = true;
        } else if (QUANTITY_INPUT.value == "") {
            button_element.disabled = true;
        } else {
            $.ajax({
                type : "POST",  // type of method
                url  : "validate_quantity.php",  // your page
                data : { item_code : ITEM_CODE }, // passing the values
                success: function(res){ 
                    if (+res < +QUANTITY_INPUT.value) {
                        $("#quantity_warning_" + ITEM_CODE).html("Số lượng lớn hơn hiện có");
                        button_element.disabled = true;
                    } else {
                        $("#quantity_warning_" + ITEM_CODE).html("");
                        button_element.disabled = false;
                    }
                }
            });
        }
    };
        
    if (split_id[0] == "edit"){
        button_element.innerHTML = 'Xong';
        button_element.id = "confirm_button_" + ITEM_CODE;
        
        DELETE_BUTTON.hidden = false;
        QUANTITY_INPUT.disabled = false;
        
        QUANTITY_INPUT.addEventListener("keyup", quantity_validation);

    } else if (split_id[0] == "confirm") {
        var new_quantity = QUANTITY_INPUT.value;

        if(new_quantity.trim() == "") {
            document.getElementById("quantity_warning_" + ITEM_CODE).innerHTML("Nhập trước khi xác nhận");
            return;
        }
    
        $.ajax({
            type : "POST",  // type of method
            url  : "adjust_quantity.php",  // your page
            data : { item_code : ITEM_CODE, new_quantity : new_quantity }, // passing the values
            success: function(res){ 
                console.log(res); 
                if (res == true) {
                    button_element.innerHTML = 'Sửa';
                    button_element.id = "edit_button_" + ITEM_CODE;
                    
                    DELETE_BUTTON.hidden = true;
                    QUANTITY_INPUT.disabled = true;
                    QUANTITY_INPUT.removeEventListener("keyup", quantity_validation);
                }
            }
        });
    }
}

var delete_item = function(element) {
    const ITEM_CODE = element.id.split('_')[2];

    element.parentElement.parentElement.hidden = true;
    $.ajax({
        type : "POST",
        url  : "delete_item.php",
        data : { item_code : ITEM_CODE },
        dataType : "json",
        success: function(response){ 
            console.log(response);
            if ($response['hasSucceeded'] == true && response['itemCount'] == 0) {
                document.getElementById("category_" + response['category']).remove();
            }
        }
    });
}

// function adjust_quantity(button_element, quantity_validation) {
//     let split_id =  button_element.id.split('_');
//     const ITEM_CODE = split_id[2];
//     const DELETE_BUTTON = document.getElementById('delete_button_' + ITEM_CODE);
//     const QUANTITY_INPUT = document.getElementById('quantity_input_' + ITEM_CODE);
//     var new_quantity = QUANTITY_INPUT.value;

//     if(new_quantity.trim() == "") {
//         document.getElementById("quantity_warning_" + ITEM_CODE).innerHTML("Nhập trước khi xác nhận");
//         return;
//     }

//     $.ajax({
//         type : "POST",  // type of method
//         url  : "adjust_quantity.php",  // your page
//         data : { item_code : ITEM_CODE, new_quantity : new_quantity }, // passing the values
//         success: function(res){ 
//             console.log(res); 
//             if (res == true) {
//                 button_element.innerHTML = 'Sửa';
//                 button_element.id = "edit_button_" + ITEM_CODE;
                
//                 DELETE_BUTTON.hidden = true;
//                 QUANTITY_INPUT.disabled = true;
//                 QUANTITY_INPUT.removeEventListener("keyup", quantity_validation);
//             }
//         }
//     });
// }

/**
 * Use this function to validate the quantity(and more in the future) before entering checkout step.
 * @todo: make changes to this function in future updates.
 */
function process_cart(button_element, category) {
    // $.ajax({
    //     type : "POST",  // type of method
    //     url  : "adjust_quantity.php",  // your page
    //     data : { category : category }, // passing the values
    //     success: function(res){ 
    //         console.log(res); 
    //     }
    // });
    return true;

    // $.ajax({
    //     type : "POST",  // type of method
    //     url  : ".php",  // your page
    //     data : { item_code : item_code, new_quantity : new_quantity }, // passing the values
        
    //     success: function(res){ 
    //         console.log(res); 
    //     }
    // });
}

/**
 * Use this function to validate all quantities of the items(and maybe others) before submitting request/order.
 * @todo: make changes to this function in future updates.
 */
 function process_submission() {
    
    return true;
}