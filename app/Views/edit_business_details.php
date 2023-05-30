<!-- edit_business_view.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Business Details</title>
    <style>
        label {
            color: brown;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-5">
                <h2>Edit Business Details</h2>
                <form action="<?php echo base_url('/update-business'); ?>" enctype="multipart/form-data" method="post">



                    <input type="hidden" name="id" placeholder="" value="<?php echo $business['id']; ?>" class="form-control">

                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="Name" value="<?php echo $business['name']; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="address">Address</label>
                        <input type="text" name="address" placeholder="Address" value="<?php echo $business['address']; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" placeholder="Phone" value="<?php echo $business['phone']; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" placeholder="Email" value="<?php echo $business['email']; ?>" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="logo">Business Logo</label>
                        <input type="file" name="logo" placeholder="Logo" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="gallery_images">Gallery Images</label>
                        <input type="file" name="gallery_images[]" multiple placeholder="Gallery Images" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="current_gallery">Current Gallery Images</label>
                        <div class="row">
                            <?php $galleryImages = json_decode($business['g_img_name'], true); ?>
                            <?php if ($galleryImages) : ?>
                                <?php foreach ($galleryImages as $image) : ?>
                                    <div class="col-md-3">
                                        <img src="<?php echo base_url('public/gallery/' . $image['g_img_name']); ?>" alt="Gallery Image" class="img-thumbnail">
                                        <div class="form-check mt-2">

                                            <input class="form-check-input" type="checkbox" name="remove_gallery_images[]" value="<?php echo $image['g_img_name']; ?>">

                                            <label class="form-check-label" for="remove_gallery_images[]">Remove</label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="col">
                                    <p>No gallery images available.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>