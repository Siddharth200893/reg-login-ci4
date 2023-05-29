<!-- business_details.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <title>Business Details</title>
</head>

<body>
    <?php $session = session();
    $id = $session->get('id'); ?>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-12">
                <h2>Business Details</h2>
                <table id="businessTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Logo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($business as $businesses) : ?>
                            <tr>
                                <td><?php echo $businesses['name']; ?></td>
                                <td><?php echo $businesses['address']; ?></td>
                                <td><?php echo $businesses['phone']; ?></td>
                                <td><?php echo $businesses['email']; ?></td>
                                <td><img src="<?php echo base_url('public/logo/' . $businesses['l_img_name']); ?>" alt="Business Logo" style="width: 50px; height: 50px;"></td>
                                <td>
                                    <a href="<?php echo base_url('view_business_details/' . md5($businesses['id']));
                                                ?>" class="btn btn-primary">View Details</a>

                                </td>
                            </tr>
                        <?php
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#businessTable').DataTable();
        });
    </script>
</body>

</html>