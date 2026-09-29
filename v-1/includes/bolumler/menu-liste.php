<?php /** @var array $b */ ?>
<?= bolum_ac($b, 'menu-liste') ?>
  <div class="konteyner">
    <?php if (!empty($b['alt_baslik'])): ?>
      <p class="menu-liste__not"><?= e($b['alt_baslik']) ?></p>
    <?php endif; ?>

    <div class="menu-liste__ic">
      <nav class="menu-liste__gezinme" aria-label="Menü kategorileri">
        <?php foreach (($b['kategoriler'] ?? []) as $i => $k): ?>
          <a href="#kat-<?= $i ?>"><?= e($k['ad']) ?></a>
        <?php endforeach; ?>
      </nav>

      <div class="menu-liste__gruplar">
        <?php foreach (($b['kategoriler'] ?? []) as $i => $k): ?>
          <section class="menu-grup" id="kat-<?= $i ?>">
            <h2 class="menu-grup__baslik"><?= e($k['ad']) ?></h2>
            <ul class="menu-grup__liste">
              <?php foreach (($k['urunler'] ?? []) as $u): ?>
                <li class="urun" data-goster>
                  <?php if (!empty($u['gorsel'])): ?>
                    <button class="urun__gorsel" type="button" data-lightbox="<?= e(gorsel_url($u['gorsel'], 1440)) ?>" aria-label="<?= e($u['ad']) ?> görselini büyüt">
                      <?= gorsel($u['gorsel'], '72px', ['alt' => '', 'en' => 480, 'boy' => 480]) ?>
                    </button>
                  <?php else: ?>
                    <span class="urun__gorsel urun__gorsel--bos" aria-hidden="true"><span class="ikon ikon--sm">restaurant</span></span>
                  <?php endif; ?>
                  <div class="urun__govde">
                    <div class="urun__ust">
                      <h3 class="urun__ad"><?= e($u['ad']) ?></h3>
                    </div>
                    <?php if (!empty($u['aciklama'])): ?>
                      <p class="urun__aciklama"><?= e($u['aciklama']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($u['etiketler'])): ?>
                      <ul class="urun__etiketler">
                        <?php foreach ($u['etiketler'] as $et): ?>
                          <li class="rozet"><?= e($et) ?></li>
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
