function switch_edit_mode(button_element) {
    let split_id =  button_element.id.split('_');
    const ITEM_CODE = split_id[2];
    const DELETE_BUTTON = document.getElementById('delete_button_' + ITEM_CODE);
    const QUANTITY_INPUT = document.getElementById('quantity_input_' + ITEM_CODE);
    
    var quantity_validation = function() {
        $.ajax({
            type : "POST",  // type of method
            url  : "validate_quantity.php",  // your page
            data : { item_code : ITEM_CODE }, // passing the values
            // dataType: 'json',
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
    };
        
    if (split_id[0] == "edit"){
        button_element.innerHTML = 'Xong';
        button_element.id = "confirm_button_" + ITEM_CODE;
        
        DELETE_BUTTON.hidden = false;
        QUANTITY_INPUT.disabled = false;
        
        QUANTITY_INPUT.addEventListener("keyup", quantity_validation);

    } else if (split_id[0] == "confirm" && adjust_quantity(ITEM_CODE) == true) {
        button_element.innerHTML = 'Sửa';
        button_element.id = "edit_button_" + ITEM_CODE;
        
        DELETE_BUTTON.hidden = true;
        QUANTITY_INPUT.disabled = true;
        QUANTITY_INPUT.removeEventListener("keyup", quantity_validation);
    }
}

var delete_item = function(element) {
    const ITEM_CODE = element.id.split('_')[2];

    element.parentElement.parentElement.hidden = true;
    $.ajax({
        type : "POST",  // type of method
        url  : "delete_item.php",  // your page
        data : { item_code : ITEM_CODE }, // passing the values
        success: function(res){ 
            console.log(res); 
        }
    });

}

function adjust_quantity(item_code) {
    var new_quantity = document.getElementById('quantity_input_' + item_code).value;

    if(new_quantity.trim() == "") {
        document.getElementById("quantity_warning_" + item_code).innerHTML("Nhập trước khi xác nhận");
        return false;
    }

    $.ajax({
            type : "POST",  // type of method
            url  : "adjust_quantity.php",  // your page
            data : { item_code : item_code, new_quantity : new_quantity }, // passing the values
            success: function(res){ 
                console.log(res); 
            }
    });

    return true;
}

