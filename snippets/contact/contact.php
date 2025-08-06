
<style>

.contact__list {
    display: flex;
    gap: 0.6em;
}

.contact__list > .contact__item {
    list-style: none;
}

a.contact__link {
    display: flex;
    border: 1px solid;
    border-radius: 0.9em;
    align-items: center;
    gap: 0.4em;
    padding: 0.2em 2em;
    font-size: 0.9em;
    text-decoration: none;
}

a.contact__link:hover {
    background-color: #eee;
}

.contact__link > svg {
    width: 1.3em;
}

</style>

<div>
    <ul class="contact__list">
        <?php foreach ($contacts as $contact): ?>   
            <li class="contact__item" style="color:<?= $contact->color() ?>">
                <a class="contact__link" href="<?= $contact->contact(); ?>" style="fill:<?= $contact->color() ?>">
                    <?= $contact->svg(); ?>
                    <?= $contact->label(); ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>