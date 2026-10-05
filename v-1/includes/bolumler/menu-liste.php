<?php
/** @var array $b */
// Ürünü olmayan kategoriler (henüz içerik girilmemiş) sitede gösterilmez; panelde durur.
$kategoriler = array_filter($b['kategoriler'] ?? [], static function ($k): bool { return !empty($k['urunler']); });
?>
<?= bolum_ac($b, 'menu-list') ?>
  <div class="container">
    <?php if (!empty($b['alt_baslik'])): ?>
      <p class="menu-list__note"><?= e($b['alt_baslik']) ?></p>
    <?php endif; ?>

    <div class="menu-list__inner">
      <nav class="menu-list__nav" aria-label="Menü kategorileri">
        <?php foreach ($kategoriler as $i => $k): ?>
          <a href="#kat-<?= $i ?>"><?= e($k['ad']) ?></a>
        <?php endforeach; ?>
      </nav>

      <div class="menu-list__groups">
        <?php foreach ($kategoriler as $i => $k): ?>
          <section class="menu-group" id="kat-<?= $i ?>">
            <h2 class="menu-group__title"><?= e($k['ad']) ?></h2>
            <ul class="menu-group__list">
              <?php foreach (($k['urunler'] ?? []) as $u): ?>
                <li class="menu-item<?= empty($u['gorsel']) ? ' menu-item--text' : '' ?>" data-goster>
                  <?php if (!empty($u['gorsel'])): ?>
                    <button class="menu-item__image" type="button" data-lightbox="<?= e(gorsel_url($u['gorsel'], 1440)) ?>" aria-label="<?= e($u['ad']) ?> görselini büyüt">
                      <?= gorsel($u['gorsel'], '88px', ['alt' => '', 'en' => 480, 'boy' => 480]) ?>
                    </button>
                  <?php endif; ?>
                  <div class="menu-item__body">
                    <div class="menu-item__top">
                      <h3 class="menu-item__name"><?= e($u['ad']) ?></h3>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          </section>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
