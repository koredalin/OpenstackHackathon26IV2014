
<div class="del">
    <p class="rad7">Delete object: <a href="<?php echo $baseDirectory; ?>object/delete/<?php echo $container_name.'/'.$object_name; ?>">
    <strong><?php echo $object_name; ?></strong></a></p>
</div>

<div class="under_line"></div>

<div class="obj_link">
    <p class="rad7">Save object to the server: <a href="<?php echo $baseDirectory; ?>object/downloadFile/<?php echo $container_name.'/'.$object_name.'/'.$file_name; ?>">
    <?php echo $object_name . ' >>> ' . $file_name; ?></a></p>
    <p><?php 
        if (substr_count($head_content, '------------------------------') == 0) {
            echo $head_content;
        } 
        ?>
    </p>
</div>

<div class="under_line"></div>

<div class="obj_link">
    <?php 
    if (isset($file_on_server) && $file_on_server) {
        echo '<p class="rad7"><a href="'. $baseDirectory.'temp_files/'.$file_on_server.'" target="_blank">Download your file</a></p>';
        echo '<div class="under_line"></div>';
    }
    ?>
</div>

<div class="height_distance"></div>