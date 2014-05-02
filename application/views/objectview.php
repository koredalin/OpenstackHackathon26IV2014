
<div>
    <p>Delete object: <a href="<?php echo $baseDirectory; ?>object/delete/<?php echo $container_name.'/'.$object_name; ?>">
    <?php echo $object_name; ?></a></p>
</div>
<div class="under_line"></div>
<div>
    <p>Save object to the server: <a href="<?php echo $baseDirectory; ?>object/downloadFile/<?php echo $container_name.'/'.$object_name.'/'.$file_name; ?>">
    <?php echo $object_name . ' >>> ' . $file_name; ?></a></p>
    <p><?php echo $head_content; ?></p>
</div>
<div class="under_line"></div>
<div>
    <?php 
    if (isset($file_on_server) && $file_on_server) {
        echo '<p><a href="'. $baseDirectory.'temp_files/'.$file_on_server.'" target="_blank">Download your file</a></p>';
    }
    ?>
</div>
<div class="under_line"></div>