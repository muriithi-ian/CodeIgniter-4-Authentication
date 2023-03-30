<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Ci 4 Authentication</title>
    <link rel="stylesheet" href="<?= base_url('bootstrap-4/css/bootstrap.min.css') ?>">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 " style="margin-top: 70px">
            <h4>Sign In - Ci 4 Authentication</h4>
            <hr>
           <form action="<?= route_to('check') ?>" method="post" autocomplete="off">
           <?php $validation = \Config\Services::validation(); ?>
               <?= csrf_field(); ?>
               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
               <?php endif ?>

                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter your email" value="<?= set_value('email') ?>">
                    <small class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : '' ?></small>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" value="<?= set_value('password') ?>">
                    <small class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?></small>
                </div>             
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <div>
                    <a href="<?= route_to('register') ?>">I don't have account. Create new account</a>
                </div>
           </form>
        </div>
    </div>
</div>
    
</body>
</html>