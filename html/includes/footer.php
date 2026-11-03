</main>
<footer class="foot">
  <div class="foot-bg" style="--bg:url('<?= e(img($NATURE['hero4'], 1800)) ?>')"></div>
  <div class="wrap foot-in">
    <div>
      <a class="logo logo-lg" href="index.php"><span class="logo-mt">⛰</span>산타<b>GO</b></a>
      <p class="foot-slogan"><?= e($SITE['slogan']) ?></p>
    </div>
    <div class="foot-cols">
      <div>
        <h4>도보여행길</h4>
        <?php foreach ($CATEGORIES as $k => $c): ?>
          <a href="trails.php?cat=<?= e($k) ?>"><?= e($c['name']) ?></a>
        <?php endforeach; ?>
      </div>
      <div>
        <h4>대전관광</h4>
        <a href="<?= DJT ?>/festival_djt" target="_blank" rel="noopener">축제·행사 ↗</a>
        <a href="<?= DJT ?>/sights_djt" target="_blank" rel="noopener">명소 ↗</a>
        <a href="<?= DJT ?>/recommend_djt" target="_blank" rel="noopener">추천코스 ↗</a>
        <a href="<?= DJT ?>/td_info_djt" target="_blank" rel="noopener">관광안내소 ↗</a>
      </div>
      <div>
        <h4>문의</h4>
        <a href="mailto:<?= e($SITE['email']) ?>"><?= e($SITE['email']) ?></a>
        <a href="<?= e($SITE['kakao']) ?>">카카오 오픈채팅</a>
      </div>
    </div>
  </div>
  <div class="wrap foot-copy">
    도보여행길 정보 출처: <a href="<?= DJT ?>/work_djt" target="_blank" rel="noopener">대전관광 도보여행길</a> (대전광역시) ·
    사진: Unsplash · © <?= date('Y') ?> <?= e($SITE['name']) ?>
  </div>
</footer>
<script src="assets/app.js"></script>
</body>
</html>
