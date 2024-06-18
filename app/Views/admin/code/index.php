<?php include(VIEW_PATH . '/admin/partials/header.php') ?>
<ul class="table">
    <li>
        <div class="table-row table-header">
            <p>Group</p>
            <p>Exchange</p>
            <p>Name</p>
            <p>Des</p>
            <p></p>
        </div>
    </li>
    <?php foreach ($codes as $code): ?>
        <li>
            <form method="post" action="/admin/code/save/<?php echo $code['id'] ?>" autocomplete="off">
                <div class="table-row">
                    <p>
                        <select>
                            <?php foreach ($groups as $group): ?>
                                <option value="<?php echo $group['id'] ?>"
                                    <?php echo $code['groupId'] == $group['id'] ? 'selected' : '' ?>
                                ><?php echo $group['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <select>
                            <?php foreach ($exchanges as $exchange): ?>
                                <option value="<?php echo $exchange ?>"
                                    <?php echo $code['exchange'] == $exchange ? 'selected' : '' ?>
                                ><?php echo $exchange ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p><input type="text" name="name" value="<?php echo $code['name'] ?>" /></p>
                    <p><input type="text" name="des" value="<?php echo $code['des'] ?>" /></p>
                    <p><button type="submit" class="btn">Save</button>
                        <a class="btn" href="/admin/code/delete/<?php echo $code['id'] ?>">Delete</a></p>
                </div>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
<?php include(VIEW_PATH . '/admin/partials/footer.php') ?>