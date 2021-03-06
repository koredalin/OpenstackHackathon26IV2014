        
<?php
if (!isset($objects_list) || empty($objects_list)) {
    echo '<div class="del"><p class="rad7">Delete container: <a href="' . $baseDirectory . 'container/delete/' . $container_name . '"><strong>' . $container_name . '</strong></a></p></div>';
}
else {
    echo "<input type='hidden' id='obj_list' value='".json_encode($objects_list)."'>";
}
?>
<div class="under_line"></div>
<div>
    <form action="<?php echo $baseDirectory; ?>container/uploadFile/<?php echo $container_name; ?>" method="POST" enctype="multipart/form-data">
        <div>
                <td colspan="3">Select a file for upload: </td>
        </div>
        <div>
            <span><input type="file" name="file_upload_name" value="Choose the file"></span>
                <span>
                    <input type="hidden" name="MAX_FILE_SIZE" value="25000" />
                    <input type="text" name="object_name" placeholder="Object's name" id="new_object_name">
                </span>
                <span>
                    <button type="submit" id="upload_file_submit_btn">Upload file</button>
                </span>
        </div>
    </form>

</div>

<div class="validation_fail">
    <?php
        if (isset($validation_error) && $validation_error) {
            echo '<p>' . $validation_error . '</p>';
        }
    ?>
</div>

<div class="under_line"></div>

<?php
if (isset($upload_result) && !empty($upload_result)) {
    if (array_search(false, $upload_result)) {
        echo '<div class="upload_fail"><p>';
        foreach ($upload_result as $key => $value) {
            echo $key . ' => ' . $value . ' | ';
        }
        echo '</p></div>';
    } else {
        echo '<div class="upload_success"><p>';
        echo 'File uploaded!';
        echo '</p></div>';
    }
}
?>

<div class="auto_scroll-container">
    <div>
        <p>Container's content:</p>
    </div>
    <div class="list">
        <?php
        if ($object_links) {
            echo $object_links;
        } else {
            echo '<p>The container is empty.</p>';
        }
        ?>
    </div>
</div>

<div class="height_distance"></div>