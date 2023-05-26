<!-- gallery_view.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Gallery View</title>
    <style>
        .gallery-container {
            padding: 20px;
            background-color: #f8f8f8;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .gallery-image {
            max-width: 300px;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-8">
                <div class="gallery-container">
                    <h2 class="mb-4">Gallery View</h2>
                    <div class="row">
                        <?php $galleryImages = json_decode($business['g_img_name'], true); ?>
                        <?php if ($galleryImages) : ?>
                            <?php foreach ($galleryImages as $image) : ?>
                                <div class="col-md-4">
                                    <img class="gallery-image" src="<?php echo base_url('public/gallery/' . $image['g_img_name']); ?>" alt="Gallery Image">
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="col">
                                <p>No gallery images available.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>