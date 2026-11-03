<?php
function trail_card(array $t): void {
    global $CATEGORIES;
    $c = $CATEGORIES[$t['cat']]; ?>
  <article class="card reveal" data-cat="<?= e($t['cat']) ?>">
    <a href="trail.php?id=<?= (int)$t['id'] ?>" class="card-img">
      <img src="<?= e(img(trail_photo($t), 800)) ?>" alt="<?= e($t['title']) ?> 풍경" loading="lazy" onerror="this.remove()">
      <span class="chip"><?= $c['icon'] ?> <?= e($c['name']) ?></span>
      <span class="lv lv<?= (int)$t['level'] ?>"><?= level_label((int)$t['level']) ?></span>
    </a>
    <div class="card-body">
      <?php if (!empty($t['theme'])): ?><em class="theme"><?= e($t['theme']) ?></em><?php endif; ?>
      <h3><a href="trail.php?id=<?= (int)$t['id'] ?>"><?= e($t['title']) ?></a></h3>
      <p class="loc">📍 <?= e($t['loc']) ?></p>
      <p class="desc"><?= e($t['desc']) ?></p>
      <ul class="meta">
        <li><b>거리</b><?= e($t['dist']) ?></li>
        <li><b>소요</b><?= e($t['time']) ?></li>
      </ul>
    </div>
  </article>
<?php }
