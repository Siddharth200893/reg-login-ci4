<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0
        }

        body {
            background-color: green
        }

        .card {
            width: 350px;
            background-color: #efefef;
            border: none;
            cursor: pointer;
            transition: all 0.5s;
        }

        .image img {
            transition: all 0.5s
        }

        .card:hover .image img {
            transform: scale(1.5)
        }

        .btn {
            height: 140px;
            width: 140px;
            border-radius: 50%
        }

        .name {
            font-size: 22px;
            font-weight: bold
        }

        .idd {
            font-size: 14px;
            font-weight: 600
        }

        .idd1 {
            font-size: 12px
        }

        .number {
            font-size: 22px;
            font-weight: bold
        }

        .follow {
            font-size: 12px;
            font-weight: 500;
            color: #444444
        }

        .btn1 {
            height: 40px;
            width: 150px;
            border: none;
            background-color: #000;
            color: #aeaeae;
            font-size: 15px
        }

        .text span {
            font-size: 13px;
            color: #545454;
            font-weight: 500
        }

        .icons i {
            font-size: 19px
        }

        hr .new1 {
            border: 1px solid
        }

        .join {
            font-size: 14px;
            color: #a0a0a0;
            font-weight: bold
        }

        .date {
            background-color: #ccc
        }

        a.btn1.btn-dark {
            text-align: center;
            padding: 8px 0;
            text-decoration: none;
        }

        .d-flex.mt-2 {
            justify-content: center;
        }
    </style>
</head>
<?php $session = session();
// $id = $session->get('id');
// $name = $session->get('name');
// $email = $session->get('email');
// $phone = $session->get('phone');
// print_r($userdetails);
// die();
?>

<body>
    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
        <div class="card p-4">
            <div class=" image d-flex flex-column justify-content-center align-items-center">
                <button class="btn btn-secondary">
                    <img src="https://i.imgur.com/wvxPV9S.png" height="100" width="100" />
                </button>

                <form name="profile_update_form" method="POST" action="<?php echo base_url(); ?>/update-profile">
                    <input type="hidden" name="id" class="name mt-3" value="<?= $userdetails['registrationid'] ?>">
                    <input type="text" name="name" class="name mt-3" value="<?= $userdetails['name'] ?>">
                    <input type="email" name="email" class="idd" value="<?= $userdetails['email'] ?>">

                    <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                        <input type="text" name="phone" class="idd1" value="<?= $userdetails['phone'] ?>">

                        <span><i class="fa fa-copy"></i></span>
                    </div>
                    <div class="d-flex flex-row justify-content-center align-items-center mt-3">
                        <span class="number">1069 <span class="follow">Followers</span></span>
                    </div>
                    <div class=" d-flex mt-2">
                        <button type="submit" class="btn1 btn-dark">Update Profile</button>
                        <!-- <a class="btn1 btn-dark" href="<? //php echo base_url('/update-profile'); 
                                                            ?>">Update Profile</a> -->
                    </div>
                </form>
                <div class="text mt-3">
                    <span>Eleanor Pena is a creator of minimalistic x bold graphics and digital artwork.<br><br> Artist/
                        Creative Director by Day #NFT minting@ with FND night.</span>
                </div>
                <div class="gap-3 mt-3 icons d-flex flex-row justify-content-center align-items-center">
                    <span><i class="fa fa-twitter"></i></span>
                    <span><i class="fa fa-facebook-f"></i></span>
                    <span><i class="fa fa-instagram"></i></span>
                    <span><i class="fa fa-linkedin"></i></span>
                </div>
                <div class=" px-2 rounded mt-4 date ">
                    <span class="join">Joined May,2021</span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>





<div class="container">
    <div class="row justify-content-md-center mt-5">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?php echo base_url('/add-business'); ?>">Add Business</a>
                    <div class="d-flex">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="<?php echo base_url('/logout'); ?>">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <h2 class="text-center mt-5">User Dashboard</h2>
        </div>
    </div>

</div>