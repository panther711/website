<?php snippet('head') ?>

<section class="c-page">
<?php
pattern('common/page/header', [
    'title' => $page->title()
]);

$companies = $page->children();

foreach (alphabetise($companies) as $letter => $items):
    pattern('common/index', [
        'items' => $items,
        'letter' => $letter
    ]);
endforeach;
?>
</section>

<?php snippet('foot') ?>
