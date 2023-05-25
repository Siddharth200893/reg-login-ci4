<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Codeigniter Login with Email/Password Example</title>
    <style>
        a.btn.btn-primary {
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-5">

                <h2>Login in</h2>

                <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-warning">
                        <?= session()->getFlashdata('msg') ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo base_url(); ?>/SigninController/loginAuth" method="post">
                    <div class="form-group mb-3">
                        <input type="email" name="email" placeholder="Email" value="" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Signin</button>
                    </div>
                </form>
                <div class="d-grid">
                    <a class="btn btn-primary" href="<?php echo base_url('/signup'); ?>">Sign Up</a>
                </div>
            </div>

        </div>
    </div>
</body>

</html>