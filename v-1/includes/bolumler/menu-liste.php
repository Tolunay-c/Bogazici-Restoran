<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'menu-list') ?>
  <div class="container">
    <?php if (!empty($b['alt_baslik'])): ?>
      <p class="menu-list__note"><?= e($b['alt_baslik']) ?></p>
    <?php endif; ?>

    <div class="menu-list__inner">
      <nav class="menu-list__nav" aria-label="Menü kategorileri">
        <?php foreach (($b['kategoriler'] ?? []) as $i => $k): ?>
          <a href="#kat-<?= $i ?>"><?= e($k['ad']) ?></a>
        <?php endforeach; ?>
      </nav>

      <div class="menu-list__groups">
        <?php foreach (($b['kategoriler'] ?? []) as $i => $k): ?>
          <section class="menu-group" id="kat-<?= $i ?>">
            <h2 class="menu-group__title"><?= e($k['ad']) ?></h2>
            <ul class="menu-group__list">
              <?php foreach (($k['urunler'] ?? []) as $u): ?>
                <li class="menu-item" data-goster>
                  <?php if (!empty($u['gorsel'])): ?>
                    <button class="menu-item__image" type="button" data-lightbox="<?= e(gorsel_url($u['gorsel'], 1440)) ?>" aria-label="<?= e($u['ad']) ?> görselini büyüt">
                      <?= gorsel($u['gorsel'], '88px', ['alt' => '', 'en' => 480, 'boy' => 480]) ?>
                    </button>
                  <?php else: ?>
                    <span class="menu-item__image menu-item__image--empty" aria-hidden="true"><span class="icon icon--sm">restaurant</span></span>
                  <?php endif; ?>
                  <div class="menu-item__body">
                    <div class="menu-item__top">
                      <h3 class="menu-item__name"><?= e($u['ad']) ?></h3>
                    </div>
                    <?php if (!empty($u['aciklama'])): ?>
                      <p class="menu-item__desc"><?= e($u['aciklama']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($u['etiketler'])): ?>
                      <ul class="menu-item__tags">
                        <?php foreach ($u['etiketler'] as $et): ?>
                          <li class="badge"><?= e($et) ?></li>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
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
