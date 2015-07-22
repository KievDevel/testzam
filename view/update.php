<?php
/**
 * Created by Svyatoslav Svitlychnyi.
 * Date: 22.07.2015
 * Time: 0:26
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Notes</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        h1 {text-align: center}
        .bold {font-weight: bold}
    </style>
</head>
<body>
<section class="container">

    <div class="row">
        <div class="col-sm-12">
            <h1>Add record</h1>
            <form method="post" action="/update">
                <input type="hidden" name="id" value="<?= $this->data['id'] ?>">
                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input type="text" name="name" class="form-control" id="inputName" placeholder="Name" value="<?= $this->data['name'] ?>" required="">
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Email address</label>
                    <input type="email" name="email" class="form-control" id="inputEmail1" placeholder="Email" value="<?= $this->data['email'] ?>" required="">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Address</label>
                    <input type="text" name="address" class="form-control" id="inputAddress" placeholder="Address" value="<?= $this->data['address'] ?>" required="">
                </div>
                <div class="form-group">
                    <label for="inputPhone">Phone Number</label>
                    <input type="number" name="phone" class="form-control" id="inputPhone" placeholder="789933353" value="<?= $this->data['number'] ?>" required="">
                </div>
                <div class="form-group">
                    <label for="inputComment">Comment</label>
                    <input type="text" name="comment" class="form-control" id="inputComment" value="<?= $this->data['comment'] ?>" placeholder="Some text">
                </div>
                <button type="submit" class="btn btn-info">Submit</button>
            </form>
        </div>
    </div>
</section>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>