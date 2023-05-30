<!-- business_view.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Business Details</title>
    <style>
        .business-container {
            padding: 20px;
            background-color: #f8f8f8;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .business-logo {
            max-width: 200px;
            height: auto;
        }

        .gallery-slider {
            max-width: 400px;
            margin-bottom: 20px;
        }

        .gallery-slider img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="business-container">
                    <h2 class="mb-4">Business Details</h2>
                    <div class="row mb-3">
                        <div class="col-md-3">Name:</div>
                        <div class="col-md-9"><?php echo $business['name']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">Address:</div>
                        <div class="col-md-9"><?php echo $business['address']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">Phone:</div>
                        <div class="col-md-9"><?php echo $business['phone']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">Email:</div>
                        <div class="col-md-9"><?php echo $business['email']; ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">Logo:</div>
                        <div class="col-md-9"><img class="business-logo" src="<?php echo base_url('public/logo/' . $business['l_img_name']); ?>" alt="Business Logo"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">Gallery Images:</div>
                        <div class="col-md-9">
                            <?php $galleryImages = json_decode($business['g_img_name'], true); ?>
                            <?php if (!empty($galleryImages)) : ?>
                                <div id="gallery-slider" class="gallery-slider carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php foreach ($galleryImages as $index => $image) : ?>
                                            <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                                                <img src="<?php echo base_url('public/gallery/' . $image['g_img_name']); ?>" alt="Gallery Image">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#gallery-slider" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#gallery-slider" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            <?php else : ?>
                                <p>No gallery images available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="<?php echo base_url('edit-business-details/' . md5($business['id'])); ?>" class="btn btn-primary">Edit Business</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>