<?php
declare(strict_types=1);
require_once __DIR__ . '/../data/trails.php';

$SITE = [
    'name'    => '산타GO 등산모임',
    'slogan'  => '산을 타고, 길을 걷고, 함께 GO!',
    'region'  => '대전',
    'email'   => 'hello@santago.kr',
    'kakao'   => '#',
];

/* 화려한 자연 이미지 (Unsplash, 로딩 실패 시 CSS 그라데이션으로 대체) */
function img(string $id, int $w = 1600): string {
    return "https://images.unsplash.com/{$id}?auto=format&fit=crop&w={$w}&q=80";
}
$NATURE = [
    'hero1'  => 'photo-1506905925346-21bda4d32df4', // 구름 위 산 능선 일출
    'hero2'  => 'photo-1464822759023-fed622ff2c3b', // 설산과 호수
    'hero3'  => 'photo-1470071459604-3b5ec3a7fe05', // 안개 낀 초록 언덕
    'hero4'  => 'photo-1469474968028-56623f02e42e', // 노을 진 산
    'forest' => 'photo-1441974231531-c6227db76b6e', // 햇살 숲
    'path'   => 'photo-1447752875215-b2761acb3c5d', // 숲속 길
    'lake'   => 'photo-1501785888041-af3ef285b470', // 호수와 산
    'autumn' => 'photo-1507041957456-9c397ce39c97', // 단풍 숲
    'field'  => 'photo-1472214103451-9374bd1c798e', // 초원
    'road'   => 'photo-1500530855697-b586d89ba3ee', // 산길 도로
    'fall'   => 'photo-1433086966358-54859d0ed716', // 폭포
    'mist'   => 'photo-1418065460487-3e41a6c84dc5', // 안개 숲
    'valley' => 'photo-1426604966848-d7adac402bff', // 계곡
    'tree'   => 'photo-1502082553048-f009c37129b9', // 들판의 나무
];
/* 카테고리별 대표 사진 */
$CAT_IMG = [
    'dulle' => ['hero1','hero4','valley','mist'],
    'daecheong' => ['lake','hero2','field','fall'],
    'science' => ['forest','tree','path'],
    'walk' => ['path','autumn','forest','field','tree'],
    'baram' => ['field','road','tree','hero3'],
    'bike' => ['road','lake','field'],
];

/* 메뉴: 대전관광 자료 메뉴 포함 */
$MENU = [
    ['label'=>'홈', 'href'=>'index.php'],
    ['label'=>'모임소개', 'href'=>'index.php#about'],
    ['label'=>'대전 도보여행길', 'href'=>'trails.php', 'children'=>
        array_merge([['label'=>'전체 보기 (44)', 'href'=>'trails.php']],
            array_map(fn($k,$c)=>['label'=>$c['icon'].' '.$c['name'], 'href'=>'trails.php?cat='.$k], array_keys($CATEGORIES), $CATEGORIES))],
    ['label'=>'정기산행', 'href'=>'index.php#schedule'],
    ['label'=>'대전관광', 'href'=>DJT, 'children'=>[
        ['label'=>'대전잇슈',    'href'=>DJT.'/issue_djt', 'ext'=>true],
        ['label'=>'축제·행사',   'href'=>DJT.'/festival_djt', 'ext'=>true],
        ['label'=>'이달의 대전', 'href'=>DJT.'/month_djt', 'ext'=>true],
        ['label'=>'추천코스',    'href'=>DJT.'/recommend_djt', 'ext'=>true],
        ['label'=>'명소',        'href'=>DJT.'/sights_djt', 'ext'=>true],
        ['label'=>'숙박',        'href'=>DJT.'/hotel_djt', 'ext'=>true],
        ['label'=>'관광안내소',  'href'=>DJT.'/td_info_djt', 'ext'=>true],
        ['label'=>'도보여행길 원문', 'href'=>DJT.'/work_djt', 'ext'=>true],
    ]],
    ['label'=>'갤러리', 'href'=>'index.php#gallery'],
];

function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function trail_photo(array $t): string {
    global $CAT_IMG, $NATURE;
    $pool = $CAT_IMG[$t['cat']] ?? ['forest'];
    return $NATURE[$pool[$t['id'] % count($pool)]];
}
function level_label(int $lv): string {
    return [1=>'쉬움',2=>'보통',3=>'다소 힘듦',4=>'힘듦'][$lv] ?? '보통';
}
function find_trail(int $id): ?array {
    global $TRAILS;
    foreach ($TRAILS as $t) if ($t['id'] === $id) return $t;
    return null;
}
/* "1시간 20분" → 분 */
function km_of(string $d): float { return preg_match('/([\d.]+)\s*km/', $d, $m) ? (float)$m[1] : 0; }
