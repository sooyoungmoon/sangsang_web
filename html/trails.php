<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/card.php';

$cat   = isset($_GET['cat'], $CATEGORIES[$_GET['cat']]) ? $_GET['cat'] : '';
$q     = trim((string)($_GET['q'] ?? ''));
$level = (int)($_GET['level'] ?? 0);
$sort  = $_GET['sort'] ?? 'default';
$page  = max(1, (int)($_GET['page'] ?? 1));
$per   = 12;

$list = array_filter($TRAILS, function ($t) use ($cat, $q, $level, $CATEGORIES) {
    if ($cat && $t['cat'] !== $cat) return false;
    if ($level && $t['level'] !== $level) return false;
    if ($q !== '') {
        $hay = $CATEGORIES[$t["cat"]]["name"] . " " . $t["title"] . " " . $t["loc"] . ' ' . $t['course'] . ' ' . $t['desc'] . ' ' . ($t['theme'] ?? '') . ' ' . $t['spots'];
        if (mb_stripos($hay, $q) === false) return false;
    }
    return true;
});
if ($sort === 'short') usort($list, fn($a, $b) => km_of($a['dist']) <=> km_of($b['dist']));
if ($sort === 'long')  usort($list, fn($a, $b) => km_of($b['dist']) <=> km_of($a['dist']));
if ($sort === 'easy')  usort($list, fn($a, $b) => $a['level'] <=> $b['level']);
$list  = array_values($list);
$total = count($list);
$pages = max(1, (int)ceil($total / $per));
$page  = min($page, $pages);
$show  = array_slice($list, ($page - 1) * $per, $per);

function qs(array $over): string {
    $p = array_merge(['cat'=>$_GET['cat'] ?? '', 'q'=>$_GET['q'] ?? '', 'level'=>$_GET['level'] ?? '', 'sort'=>$_GET['sort'] ?? ''], $over);
    return 'trails.php?' . http_build_query(array_filter($p, fn($v) => $v !== '' && $v !== null && $v !== 0));
}

$heroKey = $cat ? $CAT_IMG[$cat][0] : 'hero3';
$PAGE_TITLE = $cat ? $CATEGORIES[$cat]['name'] : '대전 도보여행길';
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero" style="--bg:url('<?= e(img($NATURE[$heroKey], 2000)) ?>')">
  <div class="wrap">
    <p class="kicker">DAEJEON WALKING TRAILS</p>
    <h1><?= $cat ? $CATEGORIES[$cat]['icon'] . ' ' . e($CATEGORIES[$cat]['name']) : '대전 도보여행길' ?></h1>
    <p><?= $cat ? e($CATEGORIES[$cat]['desc']) : '걷기만 해도 힐링되는 길, 함께 걸어볼래요?' ?></p>
  </div>
</section>

<section class="wrap list-wrap">
  <nav class="tabs" aria-label="카테고리">
    <a href="<?= e(qs(['cat'=>'', 'page'=>''])) ?>" class="<?= $cat === '' ? 'on' : '' ?>">전체</a>
    <?php foreach ($CATEGORIES as $k => $c): ?>
      <a href="<?= e(qs(['cat'=>$k, 'page'=>''])) ?>" class="<?= $cat === $k ? 'on' : '' ?>"><?= $c['icon'] ?> <?= e($c['name']) ?></a>
    <?php endforeach; ?>
  </nav>

  <form class="filters" method="get">
    <?php if ($cat): ?><input type="hidden" name="cat" value="<?= e($cat) ?>"><?php endif; ?>
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="길 이름·산·동네 검색">
    <select name="level">
      <option value="">난이도 전체</option>
      <?php foreach ([1,2,3,4] as $lv): ?>
        <option value="<?= $lv ?>" <?= $level === $lv ? 'selected' : '' ?>><?= level_label($lv) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="sort">
      <option value="default">기본순</option>
      <option value="short" <?= $sort === 'short' ? 'selected' : '' ?>>짧은 거리순</option>
      <option value="long"  <?= $sort === 'long'  ? 'selected' : '' ?>>긴 거리순</option>
      <option value="easy"  <?= $sort === 'easy'  ? 'selected' : '' ?>>쉬운 코스순</option>
    </select>
    <button class="btn btn-forest" type="submit">찾기</button>
  </form>

  <p class="count">전체 <b><?= $total ?></b>건 · <?= $page ?> / <?= $pages ?> 페이지</p>

  <?php if ($show): ?>
    <div class="grid"><?php foreach ($show as $t) trail_card($t); ?></div>
  <?php else: ?>
    <div class="empty">🌲 조건에 맞는 길이 없어요. 다른 검색어로 찾아보세요.</div>
  <?php endif; ?>

  <?php if ($pages > 1): ?>
  <nav class="pager" aria-label="페이지">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
      <a href="<?= e(qs(['page'=>$i])) ?>" class="<?= $i === $page ? 'on' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
  </nav>
  <?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
