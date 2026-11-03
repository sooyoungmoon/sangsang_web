<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/card.php';

$featuredIds = [39, 24, 14, 38, 9, 41];
$featured = array_filter(array_map('find_trail', $featuredIds));
$totalKm = array_sum(array_map(fn($t) => km_of($t['dist']), $TRAILS));
$catCount = array_count_values(array_column($TRAILS, 'cat'));

/* 정기산행 일정 (대전 도보여행길 연계) */
$SCHEDULE = [
    ['date'=>'2026-10-25','day'=>'일','id'=>39,'meet'=>'장동산림욕장 주차장 09:00','note'=>'맨발 걷기 · 발 씻을 수건 지참'],
    ['date'=>'2026-11-01','day'=>'일','id'=>24,'meet'=>'윗말뫼 주차장 08:30','note'=>'억새 절정 · 도시락 지참'],
    ['date'=>'2026-11-08','day'=>'일','id'=>7,'meet'=>'구봉산 등산로 초입 09:00','note'=>'단풍 산행 · 구름다리'],
    ['date'=>'2026-11-15','day'=>'일','id'=>9,'meet'=>'갑동 버스정류장 08:30','note'=>'수통골 하산 후 뒤풀이'],
];

$GALLERY = ['hero1','autumn','lake','mist','forest','hero3','fall','field','valley','hero4','path','tree'];

require __DIR__ . '/includes/header.php';
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-slides">
    <?php foreach (['hero1','hero3','lake','autumn'] as $i => $k): ?>
      <div class="slide<?= $i === 0 ? ' on' : '' ?>" style="--bg:url('<?= e(img($NATURE[$k], 2000)) ?>')"></div>
    <?php endforeach; ?>
  </div>
  <div class="hero-shade"></div>
  <div class="hero-in wrap">
    <p class="hero-kicker">DAEJEON TRAIL CLUB · SINCE 2019</p>
    <h1>산을 타고,<br><span>길을 걷고,</span><br>함께 <b>GO!</b></h1>
    <p class="hero-sub">대전을 감싸는 둘레산길부터 대청호 오백리길까지 —<br>
      <strong><?= count($TRAILS) ?>개의 도보여행길</strong>을 산타GO와 함께 걸어요.</p>
    <div class="hero-btns">
      <a class="btn btn-sun" href="trails.php">도보여행길 둘러보기</a>
      <a class="btn btn-ghost" href="#schedule">이번 주 산행 일정</a>
    </div>
    <form class="hero-search" action="trails.php" method="get">
      <input type="search" name="q" placeholder="길 이름, 산, 동네로 검색 (예: 계족산, 대청호)" aria-label="도보여행길 검색">
      <button type="submit">검색</button>
    </form>
  </div>
  <div class="hero-dots" id="heroDots"></div>
  <svg class="hero-ridge" viewBox="0 0 1440 140" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0 140V90l120-40 110 30 140-70 120 55 90-25 150 60 130-80 160 70 120-35 130 40 170-60v115z" />
  </svg>
</section>

<!-- STATS -->
<section class="stats wrap">
  <div class="stat reveal"><b data-count="<?= count($TRAILS) ?>">0</b><span>도보여행길</span></div>
  <div class="stat reveal"><b data-count="<?= (int)round($totalKm) ?>">0</b><span>총 거리(km)</span></div>
  <div class="stat reveal"><b data-count="<?= count($CATEGORIES) ?>">0</b><span>테마 카테고리</span></div>
  <div class="stat reveal"><b data-count="128">0</b><span>함께 걷는 회원</span></div>
</section>

<!-- ABOUT -->
<section class="about wrap" id="about">
  <div class="about-photos reveal">
    <img class="p1" src="<?= e(img($NATURE['forest'], 900)) ?>" alt="햇살 가득한 숲" loading="lazy" onerror="this.remove()">
    <img class="p2" src="<?= e(img($NATURE['hero2'], 700)) ?>" alt="산과 호수" loading="lazy" onerror="this.remove()">
    <img class="p3" src="<?= e(img($NATURE['autumn'], 700)) ?>" alt="단풍 숲" loading="lazy" onerror="this.remove()">
  </div>
  <div class="about-text reveal">
    <p class="kicker">ABOUT 산타GO</p>
    <h2>걷기만 해도 힐링되는 길,<br>함께라서 더 멀리 갑니다</h2>
    <p>산타GO는 대전에 사는 평범한 사람들이 모여 매주 산과 숲길을 걷는 등산모임입니다.
      처음엔 동네 뒷산부터, 익숙해지면 대전둘레산길 12구간 완주까지.
      빠르게 오르기보다 오래 걷는 것을, 정상보다 풍경을 좋아합니다.</p>
    <ul class="about-list">
      <li><b>🥾 초보 환영</b> 난이도별 코스와 페이스 메이커</li>
      <li><b>🗺 대전 44개 길</b> 대전관광 공식 도보여행길 순례</li>
      <li><b>📸 기록과 추억</b> 매 산행 사진 앨범 공유</li>
    </ul>
  </div>
</section>

<!-- CATEGORIES -->
<section class="cats">
  <div class="wrap">
    <div class="sec-head reveal">
      <p class="kicker">DAEJEON TRAILS</p>
      <h2>대전 도보여행길 6가지 테마</h2>
      <p>대전관광이 소개하는 공식 도보여행길을 테마별로 모았어요.</p>
    </div>
    <div class="cat-grid">
      <?php foreach ($CATEGORIES as $k => $c): $ph = $NATURE[$CAT_IMG[$k][0]]; ?>
        <a class="cat reveal" href="trails.php?cat=<?= e($k) ?>" style="--bg:url('<?= e(img($ph, 900)) ?>')">
          <span class="cat-icon"><?= $c['icon'] ?></span>
          <h3><?= e($c['name']) ?></h3>
          <p><?= e($c['desc']) ?></p>
          <span class="cat-n"><?= $catCount[$k] ?? 0 ?>개 코스 →</span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FEATURED -->
<section class="wrap featured">
  <div class="sec-head reveal">
    <p class="kicker">PICK OF THE SEASON</p>
    <h2>가을에 꼭 걸어야 할 길</h2>
  </div>
  <div class="grid">
    <?php foreach ($featured as $t) trail_card($t); ?>
  </div>
  <div class="center"><a class="btn btn-forest" href="trails.php">44개 길 전체 보기</a></div>
</section>

<!-- PARALLAX QUOTE -->
<section class="quote" style="--bg:url('<?= e(img($NATURE['mist'], 2000)) ?>')">
  <blockquote class="reveal">
    “산은 오르는 것이 아니라<br>천천히 걸어 들어가는 것이다.”
    <cite>— 산타GO 첫 산행 날, 식장산 해돋이 전망대에서</cite>
  </blockquote>
</section>

<!-- SCHEDULE -->
<section class="wrap schedule" id="schedule">
  <div class="sec-head reveal">
    <p class="kicker">UPCOMING</p>
    <h2>다가오는 정기산행</h2>
  </div>
  <div class="sch-list">
    <?php foreach ($SCHEDULE as $s): $t = find_trail($s['id']); if (!$t) continue;
      [$y,$mo,$d] = explode('-', $s['date']); ?>
      <a class="sch reveal" href="trail.php?id=<?= (int)$t['id'] ?>">
        <div class="sch-date"><b><?= (int)$mo ?>.<?= $d ?></b><span><?= e($s['day']) ?>요일</span></div>
        <div class="sch-img" style="--bg:url('<?= e(img(trail_photo($t), 500)) ?>')"></div>
        <div class="sch-info">
          <h3><?= e($t['title']) ?></h3>
          <p><?= e($t['dist']) ?> · <?= e($t['time']) ?> · <?= level_label((int)$t['level']) ?></p>
          <p class="muted">⏰ <?= e($s['meet']) ?> &nbsp;·&nbsp; <?= e($s['note']) ?></p>
        </div>
        <span class="sch-go">참가 →</span>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- GALLERY -->
<section class="gallery" id="gallery">
  <div class="wrap">
    <div class="sec-head reveal">
      <p class="kicker">GALLERY</p>
      <h2>우리가 걸어온 풍경</h2>
    </div>
    <div class="masonry">
      <?php foreach ($GALLERY as $i => $k): ?>
        <figure class="reveal"><img src="<?= e(img($NATURE[$k], 700)) ?>" alt="산행 풍경 <?= $i + 1 ?>" loading="lazy" onerror="this.parentNode.remove()"></figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- JOIN -->
<section class="join" id="join" style="--bg:url('<?= e(img($NATURE['hero4'], 2000)) ?>')">
  <div class="wrap join-in reveal">
    <h2>이번 주말, 같이 걸을래요?</h2>
    <p>회비 없음 · 매주 일요일 아침 · 초보부터 종주러까지</p>
    <form class="join-form" method="post" action="join.php">
      <input name="name" required placeholder="이름">
      <input name="phone" required placeholder="연락처" inputmode="tel">
      <select name="level">
        <option>등산 처음이에요</option><option>가끔 다녀요</option><option>둘레산길 완주가 목표!</option>
      </select>
      <button class="btn btn-sun" type="submit">가입 신청</button>
    </form>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
