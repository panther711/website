<dl class="c-route" id="<?= $route->uid() ?>">
    <dt class="c-route__title"><?= html::a($route->url(), $route->currentTitle()) ?></dt>
    <dd class="c-route__desc"><?= kirbytextRaw($route->title()) ?></dd>
</dl>
