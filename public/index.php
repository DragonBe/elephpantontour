<?php
//ini_set('display_errors', true);
//error_reporting(E_ALL|E_STRICT|E_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Overview of photos of the php elephpant mascotte in the wild">
        <meta name="keywords" content="php, elephpant, photo, twitter">

        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>The PHP #elephpant in the wild | Elephpant On Tour</title>

        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="container">
            <div class="row">
                <h1>Elephpant on Tour<br><small>The wonderful adventures of #elephpant</small></h1>
            </div>

            <?php
                $horder = new \ElephpantOnTour\Horder();
                $flickrImages = $horder->getFlickr()->fetch();
                $i = 0;
            ?>
            <div class="row media-middle">
                <?php foreach ($flickrImages as $flickrImage): ?>
                    <?php $i++; ?>

                    <div class="col-sm-6 col-md-4 col-xs-4">
                        <div class="thumbnail">
                            <a href="<?php echo $flickrImage['imageRef'] ?>" title="<?php echo $flickrImage['imageTitle'] ?> by <?php echo $flickrImage['authorName'] ?>" rel="nofollow">
                                <img src="<?php echo $flickrImage['imageLink'] ?>" class="img-responsive img-rounded">
                            </a>
                            <div class="caption text-center">
                                <p><a href="<?php echo $flickrImage['imageRef'] ?>" title="<?php echo $flickrImage['imageTitle'] ?> by <?php echo $flickrImage['authorName'] ?>" rel="nofollow">
                                    <?php echo $flickrImage['imageTitle'] ?>
                                </a> by <a href="<?php echo $flickrImage['authorLink'] ?>" title="<?php echo $flickrImage['authorName'] ?>" rel="nofollow">
                                    <?php echo $flickrImage['authorName'] ?>
                                </a></p>
                            </div>
                        </div>
                    </div>

                    <?php if (0 === ($i % 3)): ?>
            </div>
            <div class="row media-middle">
                    <?php endif ?>

                <?php endforeach ?>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </body>
</html>
