$(document).ready(function() {
    $('form').submit(function(event) {
        var obj_list = $('#obj_list').val();
        if (typeof obj_list !== "undefined" && obj_list) {
            obj_list = $.parseJSON(obj_list);
            if ($.inArray($('#new_object_name').val(), obj_list) > -1 && submit_count === 0) {
                ++submit_count;
                doObjectExist(event);
            }
        }
    });
});

var submit_count = 0;

function doObjectExist(event) {
    event.preventDefault();
    console.log('Object exist');
    $('.validation_fail').html(
        '<p>Object with that name exists! Press "Upload file" button again for rewriting the object.</p>'
    );

    return true;
}