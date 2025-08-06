
<style>

.share {
    display: flex;
}
.share__list {
    display: flex;
    gap: 0.3em;
}

.share__list > .share__item {
    list-style: none;
}

a.share__link {
    display: flex;
    align-items: center;
    gap: 0.4em;
    padding: 0.2em;
    font-size: 0.9em;
    text-decoration: none;
}

a.share__link:hover {
    background-color: #eee;
}

.share__link > svg {
    width: 1.3em;
}

</style>

<div class="share">
    <span><?= t('plain.contact.share') ?>:</span>
    <ul class="share__list">
        <?php foreach ($shares as $share): ?>   
            <li class="share__item" style="color:<?= $share->color() ?>">
                <a class="share__link" title="<?= $share->label(); ?>" href="<?= $share->share(); ?>" style="fill:<?= $share->color() ?>">
                    <?= $share->svg(); ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>