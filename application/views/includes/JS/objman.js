$(document).ready(function() {
    $('#upload_file_submit_btn').on('click', function(event) {
        doObjectExist(event);
    });

    $('#create_container_btn').on('click', function(event) {
        doContainerExist(event);
    });
});

var exists = [];

function doContainerExist(event) {
    var cont_list = $('#cont_list').val();
        if (typeof cont_list !== "undefined" && cont_list) {
            cont_list = $.parseJSON(cont_list);
            var new_container_name = $('#new_container_name').val();
            if ($.inArray(new_container_name, cont_list) > -1) {
                haltPost(event);
                $('.validation_fail').html(
                        '<p>Container with that name exists!</p>'
                        );
            }
        }
}

function doObjectExist(event) {
    var obj_list = $('#obj_list').val();
        if (typeof obj_list !== "undefined" && obj_list) {
            obj_list = $.parseJSON(obj_list);
            var new_object_name = $('#new_object_name').val();
            if ($.inArray(new_object_name, obj_list) > -1 && $.inArray(new_object_name, exists) === -1) {
                exists.push(new_object_name);
                haltPost(event);
                $('.validation_fail').html(
                        '<p>Object with that name exists! Press "Upload file" button again for rewriting the object.</p>'
                        );
            }
        }
}

function haltPost(event) {
    event.preventDefault();
    console.log(exists);

    return true;
}