<?php if ($this->Paginator->total() > 1) : ?>
    <nav class="admin-pagination" aria-label="Paginering">
        <ul>
            <?= $this->Paginator->prev('← Vorige') ?>
            <?= $this->Paginator->next('Volgende →') ?>
        </ul>
    </nav>
<?php endif; ?>
