<?php
require __DIR__ . '/includes/config.php';

$ok = false; $err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim((string)($_POST['name'] ?? ''));
    $phone = preg_replace('/[^0-9\-]/', '', (string)($_POST['phone'] ?? ''));
    $level = trim((string)($_POST['level'] ?? ''));
    if ($name === '' || strlen($phone) < 9) {
        $err = '이름과 연락처를 정확히 입력해 주세요.';
    } else {
        // 신청 내역을 CSV로 저장 (data/ 폴더 쓰기 권한 필요)
        $fp = @fopen(__DIR__ . '/data/members.csv', 'a');
        if ($fp) { fputcsv($fp, [date('Y-m-d H:i'), $name, $phone, $level]); fclose($fp); $ok = true; }
        else $err = '저장에 실패했어요. 잠시 후 다시 시도해 주세요.';
    }
}
$PAGE_TITLE = '가입 신청';
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero tall" style="--bg:url('<?= e(img($NATURE['hero1'], 2000)) ?>')">
  <div class="wrap">
    <h1><?= $ok ? '환영합니다! 🎉' : '가입 신청' ?></h1>
    <p><?= $ok ? e($name) . '님, 산행 전날 연락드릴게요. 길 위에서 만나요!' : e($err ?: '아래 홈 화면에서 신청해 주세요.') ?></p>
    <p style="margin-top:24px"><a class="btn btn-sun" href="index.php">홈으로</a> <a class="btn btn-ghost" href="trails.php">도보여행길 보기</a></p>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
