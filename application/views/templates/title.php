<div class="container-title">
    <div class="x-large green"><strong><?php echo $title; ?></strong></div>
    <p class="title-links">
        <?php
        if (isset($object_name)) {
            echo '<a href="' . $baseDirectory . 'swift/getContainersList">Storages home</a>';
            echo ' :: ';
            echo '<a href="' . $baseDirectory . 'container/select/' . $container_name . '">' . $container_name . '</a>';
            echo ' :: ';
            echo 'Object: <strong>' . $object_name . '</strong> / ';
        } else if (isset($container_name)) {
            echo '<a href="' . $baseDirectory . 'swift/getContainersList">Storages home</a>';
            echo ' :: Container: ';
            echo '<strong>'.$container_name . '</strong> / ';
        }
        if ($title !== 'Openstack Authentication') {
            echo '<a href="' . $baseDirectory . 'auth/logout">Logout</a>';
        }
        ?>


    </p>
    <div class="fatal_error">
        <?php
        if (isset($fatalError) && $fatalError) {
            echo '<p>Fatal Error!</p>';
            echo '<p>' . $fatalError . '</p>';
        }
        ?>
    </div>
</div>
<div class="under_line"></div>