<?php
$time_start = microtime(true);
date_default_timezone_set("Europe/Sofia");

$dir = dirname(__FILE__);
require $dir.'/../includes/functions.php';
require $dir.'/../classes/mysqli_class/MysqliDb.php';

$db = new MysqliDb (Array (
    'host' => 'localhost',
    'username' => 'koceto1_koceto',
    'password' => '@ntomov1985',
    'db'=> 'koceto1_koceto',
    'port' => 3306,
    //    'prefix' => 'my_',
    'charset' => 'utf8')
);


$db->join("imdb i", "c.id=i.cinemacity_id", "LEFT");
$db->orderBy('create_at');
$cols = ["c.id","c.info", "c.feature_img", "c.feature_name", "c.feature_alt_name", "c.feature_primer", "c.create_at", "i.info AS imdb_info", "i.id AS imdb_id"];
$movies = $db->get ("cinemacity c", null, $cols);

/*
require $dir.'/../classes/image_cache/src/ImageCache/ImageCache.php';
foreach ($movies as $movie) {
    if($movie['imdb_id']>0) {
        image_cache_file('imdb', $movie['imdb_id']);
    }
}
*/
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movies</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            var icons = {
                header: "ui-icon-circle-arrow-e",
                activeHeader: "ui-icon-circle-arrow-s"
            };
            $( "#accordion" ).accordion({
                icons: icons,
                heightStyle: "content"
            });
        } );
    </script>
    <style>
        img{
            width:100%;
            max-width:200px;
        }
    </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
    <body>
        <div id="accordion" class="container-fluid">
            <?php
            if(is_array($movies) and count($movies)>0) {
                $i = 0;
                foreach ($movies as $movie) {
                    $imdbInfo = '';
                    if ($movie['imdb_info']) {
                        $imdbInfo = get_unserialized_info($movie['imdb_info']);
                    }
                    ?>
                    <h3><?=++$i?>. <?= $movie['feature_name'] . ' / ' . $movie['feature_alt_name'] ?></h3>
                    <div>
                        <div class="row">
                            <div class="col-sm-4">
                                <img src="../images/cinemacity/<?= $movie['id'] ?>/<?=$movie['id'] ?>.jpg" alt="<?=$movie['feature_name']?>">
                            </div>
                            <div class="col-sm-4">
                                БГ премиера: <?=$movie['feature_primer'] ?>
                            </div>
                        </div>
                        <?php if($movie['imdb_id']>0) { ?>
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="../images/imdb/<?= $movie['imdb_id'] ?>/<?=$movie['imdb_id'] ?>.jpg" alt="<?=$imdbInfo['feature_name']?>">
                                </div>
                                <div class="col-sm-4">
                                    <?=$imdbInfo['ReleaseDate']['name']?>: <?=$imdbInfo['ReleaseDate']['value']?>
                                </div>
                                <div class="col-sm-4">
                                    <?=$imdbInfo['Awards']['name']?>: <?=$imdbInfo['Awards']['value']?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <?=$imdbInfo['CountryLinked']['name']?>: <?=$imdbInfo['CountryLinked']['value']?>
                                </div>
                                <div class="col-sm-4">
                                    <?=$imdbInfo['CastAndCharacterLinked']['name']?>: <?=strip_tags($imdbInfo['CastAndCharacterLinked']['value'])?>
                                </div>
                                <div class="col-sm-4">
                                    <?=$imdbInfo['Genre']['name']?>: <?=$imdbInfo['Genre']['value']?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </body>
</html>