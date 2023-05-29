<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Codeigniter Auth User Registration Example</title>
    <style>
        label {
            color: brown;
        }
    </style>
</head>

<body>

    <?php $session = session();
    $id = $session->get('id');
    // print_r($id);
    // die(); 
    ?>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-5">
                <h2>Add Business</h2>
                <?php if (session('msg')) : ?>
                    <div class="alert alert-success mt-3">
                        <?= session('msg') ?>
                    </div>
                <?php endif ?>
                <form action="<?php echo base_url(); ?>/BusinessController/add_business" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="user_id" placeholder="" value="<?= $id ?>" class="form-control">

                    <div class="form-group mb-3">
                        <label for="name">Name</label><br>
                        <input type="text" name="name" placeholder="Name" value="" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="address">Address</label><br>
                        <input type="text" name="address" placeholder="Address" value="" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone">Phone</label><br>
                        <input type="text" name="phone" placeholder="Phone" value="" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label><br>
                        <input type="email" name="email" placeholder="email" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="logo">Business Logo</label><br>
                        <input type="file" name="logo" placeholder="Logo" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="gallery_images">Gallery Images</label><br>
                        <input type="file" name="gallery_images[]" multiple placeholder="Gallery Images" value="" class="form-control">
                    </div>


                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">Signup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>