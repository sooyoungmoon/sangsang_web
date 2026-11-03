<?php
/** @var string $PAGE_TITLE */
$PAGE_TITLE = isset($PAGE_TITLE) ? $PAGE_TITLE . ' | ' . $SITE['name'] : $SITE['name'] . ' · 대전 도보여행길';
$current = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
?><!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($PAGE_TITLE) ?></title>
<meta name="description" content="대전의 산과 호수, 숲길을 함께 걷는 산타GO 등산모임 — 대전둘레산길·대청호 오백리길 등 44개 도보여행길 안내">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Gowun+Dodum&family=Noto+Sans+KR:wght@400;500;700;900&display=swap">
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="page-<?= e(pathinfo($current, PATHINFO_FILENAME)) ?>">

<header class="nav" id="nav">
  <div class="nav-in">
    <a class="logo" href="index.php"><span class="logo-mt">⛰</span>산타<b>GO</b></a>
    <button class="burger" aria-label="메뉴 열기" aria-expanded="false" id="burger"><span></span><span></span><span></span></button>
    <nav class="menu" id="menu">
      <ul>
      <?php foreach ($MENU as $m): $has = !empty($m['children']); ?>
        <li class="<?= $has ? 'has-sub' : '' ?>">
          <a href="<?= e($m['href']) ?>" <?= str_starts_with($m['href'], 'http') ? 'target="_blank" rel="noopener"' : '' ?>><?= e($m['label']) ?><?= $has ? ' <i class="caret">▾</i>' : '' ?></a>
          <?php if ($has): ?>
          <ul class="sub">
            <?php foreach ($m["children"] as $ch): ?>
              <li><a href="<?= e($ch["href"]) ?>" <?= !empty($ch["ext"]) ? 'target="_blank" rel="noopener"' : '' ?>><?= e($ch["label"]) ?><?= !empty($ch["ext"]) ? ' <small>↗</small>' : '' ?></a></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      </ul>
      <a class="btn btn-sun nav-cta" href="index.php#join">가입하기</a>
    </nav>
  </div>
</header>
<main>
