<?php if (!empty($errors)) { ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error) { ?>
            <?php echo $error . '<br>'; ?>
        <?php } ?>
    </div>
<?php } ?>

<form action="" method="post" enctype="multipart/form-data">
    <?php if ($imagePath) { ?>
        <img style="width:100px;" src="/<?php echo $imagePath ?>">
    <?php } ?>

    <div class="form-group">
        <label for="Image">Product Image</label><br>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="Title">Product Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
    </div>

    <div class="form-group">
        <label for="Description">Product Description</label>
        <textarea class="form-control" name="description"><?php echo $description ?></textarea>
    </div>

    <div class="form-group">
        <label for="Price">Product Price</label>
        <input type="text" step=".01" class="form-control" name="price" value="<?php echo $price ?>">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>