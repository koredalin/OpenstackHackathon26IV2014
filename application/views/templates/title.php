<div class="container-title">
    <p class="x-large green"><?php echo $title; ?></p>
    <p class="title-links">
        <?php
        if (isset($object_name)) {
            echo '<a href="' . $baseDirectory . 'swift/getContainersList">Storages home</a>';
            echo ' :: ';
            echo '<a href="' . $baseDirectory . 'container/select/' . $container_name . '">' . $container_name . '</a>';
            echo ' :: ';
            echo 'Object: ' . $object_name . ' / ';
        } else if (isset($container_name)) {
            echo '<a href="' . $baseDirectory . 'swift/getContainersList">Storages home</a>';
            echo ' :: Container: ';
            echo $container_name . ' / ';
        }
        if ($title !== 'Openstack authentication') {
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