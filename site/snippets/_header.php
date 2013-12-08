<!DOCTYPE html>
<html lang="en-gb">
<head>
<?
    // Specify a character set in HTTP header
    header("Content-Type: text/html; charset=UTF-8");

    // Specify an expires value in header
    $seconds_to_cache = 7200; // 120 minutes
    $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
    header("Expires: $ts");
    header("Pragma: cache");
    header("Cache-Control: max-age=$seconds_to_cache");

    // Compile and cache LESS CSS file
    function autoCompileLess($input, $output) {
        $inputFile = $_SERVER['DOCUMENT_ROOT'].$input;
        $outputFile = $_SERVER['DOCUMENT_ROOT'].$output;
        $cacheFile = $inputFile.".cache";

        if (file_exists($cacheFile)) {
            $cache = unserialize(file_get_contents($cacheFile));
        } else {
            $cache = $inputFile;
        }

        $less = new lessc;
        $newCache = $less->cachedCompile($cache);

        if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
            file_put_contents($cacheFile, serialize($newCache));
            file_put_contents($outputFile, $newCache['compiled']);
        }
    }

    autoCompileLess('/assets/styles/less/styles.less', '/assets/styles/styles.css');

    // Get modified file date
    function getFiledate($file, $format) {
        if (is_file($file)) {
            $filePath = $file;
            if (!realpath($filePath)) {
                $filePath = $_SERVER["DOCUMENT_ROOT"].$filePath;
            }
            $fileDate = filemtime($filePath);
            if ($fileDate) {
                $fileDate = date("$format",$fileDate);
                return $fileDate;
            }
            return false;
        }
        return false;
    }
?>
    <script>
        // Add a script element as a child of the body
        function downloadJSAtOnload() {
            var element = document.createElement("script");
            element.src = "/assets/scripts/scripts.<?= getFiledate('assets/scripts/scripts.js','YmdHis'); ?>.js";
            document.body.appendChild(element);
        }

        // Check for browser support of event handling capability
        if (window.addEventListener) {
            window.addEventListener("load", downloadJSAtOnload, false);
        } else if (window.attachEvent) {
            window.attachEvent("onload", downloadJSAtOnload);
        } else {
            window.onload = downloadJSAtOnload;
        }
    </script>

    <link rel="stylesheet" href="/assets/styles/styles.<?= getFiledate('assets/styles/styles.css','YmdHis'); ?>.css" />
    <link rel="icon" href="<?= url('assets/images/favicon.png') ?>" type="image/png"/>
    <link rel="apple-touch-icon-precomposed" href="<?= url('assets/images/apple-touch-icon.png') ?>"/>
    <link rel="license" href="<?= html($site->licenseurl) ?>"/>
    <link rel="author" href="<?= url('humans.txt') ?>"/>
 <!--link rel="webmention" href="<?= url('webmention/') ?>"/-->

    <meta charset="utf-8"/>
    <meta name="robots" content="index, follow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="application-name" content="<?= smartypants($site->shorttitle) ?>">
    <meta name="apple-mobile-web-app-title" content="<?= smartypants($site->shorttitle) ?>">
 <!--meta name="apple-mobile-web-app-capable" content="yes"-->

    <meta name="twitter:site" content="@bradshawsguide">
    <meta name="twitter:title" content="<?= html($page->title) ?>"/>
<?  if(($page->text) != ""): ?>
    <meta name="twitter:description" content="<?= truncate(excerpt($page->text, $length=300), 200) ?>"/>
<?  endif ?>
    <meta name="twitter:creator" content="@bradshawsguide">
<?  if($page->hasImages()): ?>
    <meta name="twitter:image:src" content="http://bradshawsguide.org<?= $page->images()->first()->url(); ?>">
<?  endif ?>
    <meta name="twitter:card" content="summary">

    <title><?php if ($page->isHomePage() == false) : ?><?= html($page->title) ?> - <?php endif ?><?= smartypants($site->title) ?></title>
</head>

<body>
    <header role="banner" id="top">
        <h1><a href="<?= url() ?>">Bradshaw&#8217;s <span>Guide</span></a></h1>
        <a href="#nav">Jump to navigation</a>
        <a href="#search">Jump to search</a>
    </header><!--/@banner-->

    <main role="main" id="main">
