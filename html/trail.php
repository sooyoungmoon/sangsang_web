<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/card.php';

$t = find_trail((int)($_GET['id'] ?? 0));
if (!$t) { http_response_code(404); $PAGE_TITLE = '길을 찾을 수 없어요'; require __DIR__ . '/includes/header.php';
    echo '<section class="wrap empty" style="margin:160px auto">🌲 해당 도보여행길이 없습니다. <a href="trails.php">목록으로</a></section>';
    require __DIR__ . '/includes/footer.php'; exit; }

$c = $CATEGORIES[$t['cat']];
$stops = preg_split('/\s*(?:→|–)\s*/u', $t['course']);
$related = array_slice(array_values(array_filter($TRAILS, fn($x) => $x['cat'] === $t['cat'] && $x['id'] !== $t['id'])), 0, 3);
$PAGE_TITLE = $t['title'];
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero tall" style="--bg:url('<?= e(img(trail_photo($t), 2000)) ?>')">
  <div class="wrap">
    <a class="crumb" href="trails.php?cat=<?= e($t['cat']) ?>"><?= $c['icon'] ?> <?= e($c['name']) ?></a>
    <?php if (!empty($t['theme'])): ?><p class="kicker"><?= e($t['theme']) ?></p><?php endif; ?>
    <h1><?= e($t['title']) ?></h1>
    <p>📍 <?= e($t['loc']) ?></p>
  </div>
</section>

<section class="wrap detail">
  <div class="facts">
    <div><span>거리</span><b><?= e($t['dist']) ?></b></div>
    <div><span>소요시간</span><b><?= e($t['time']) ?></b></div>
    <div><span>난이도</span><b class="lvtxt lv<?= (int)$t['level'] ?>"><?= level_label((int)$t['level']) ?></b></div>
    <div><span>테마</span><b><?= e($c['name']) ?></b></div>
  </div>

  <div class="detail-grid">
    <article>
      <h2>길 이야기</h2>
      <p class="lead"><?= e($t['desc']) ?></p>

      <h2>코스</h2>
      <?php if (count($stops) > 1): ?>
        <ol class="route">
          <?php foreach ($stops as $i => $s): ?>
            <li class="<?= $i === 0 ? 'start' : ($i === count($stops) - 1 ? 'end' : '') ?>"><?= e($s) ?></li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?><p><?= e($t['course']) ?></p><?php endif; ?>

      <?php if ($t['spots']): ?>
        <h2>주변 명소</h2>
        <div class="spots"><?php foreach (explode(',', $t['spots']) as $s): ?><span><?= e(trim($s)) ?></span><?php endforeach; ?></div>
      <?php endif; ?>
    </article>

    <aside>
      <figure class="map">
        <a href="<?= DJT . e($t['map']) ?>" target="_blank" rel="noopener">
          <img src="<?= DJT . e($t['map']) ?>" alt="<?= e($t['title']) ?> 코스 지도" loading="lazy" onerror="this.closest('figure').remove()">
        </a>
        <figcaption>코스 지도 · 대전관광</figcaption>
      </figure>
      <a class="btn btn-forest block" href="<?= DJT ?>/work_djt/<?= (int)$t['id'] ?>" target="_blank" rel="noopener">대전관광 원문 보기 ↗</a>
      <a class="btn btn-sun block" href="index.php#join">이 길 함께 걷기 신청</a>
      <div class="tip">🎒 <b>준비물</b> 물 1L 이상, 간식, 바람막이, 등산화<?= $t['level'] >= 3 ? ', 스틱·헤드랜턴' : '' ?></div>
    </aside>
  </div>

  <?php if ($related): ?>
    <div class="sec-head"><h2>같은 테마의 다른 길</h2></div>
    <div class="grid"><?php foreach ($related as $r) trail_card($r); ?></div>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
