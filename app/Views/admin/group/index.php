<?php include(VIEW_PATH . '/admin/partials/header.php') ?>
<ul>
    <?php foreach ($groups as $group): ?>
        <li>
            <form method="post" action="/admin/group/save/<?php echo $group['id'] ?>" autocomplete="off">
                <input type="text" name="name" value="<?php echo $group['name'] ?>" />
                <button type="submit">Save</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
<?php include(VIEW_PATH . '/admin/partials/footer.php') ?>