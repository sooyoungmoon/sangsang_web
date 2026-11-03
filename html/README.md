# 산타GO 등산모임 · 대전 도보여행길 (PHP)

## 실행
PHP 8.0 이상, DB 불필요.

```bash
cd santago
php -S localhost:8000      # 브라우저에서 http://localhost:8000
```
일반 호스팅(Apache/Nginx + PHP)에는 폴더째 업로드하면 됩니다.
가입 신청은 `data/members.csv`에 저장되므로 `data/` 폴더에 쓰기 권한을 주세요.

## 구성
| 파일 | 내용 |
|---|---|
| `index.php` | 메인: 자연 사진 슬라이드, 통계, 모임소개, 6개 테마, 추천 길, 정기산행, 갤러리, 가입 |
| `trails.php` | 도보여행길 목록 (카테고리 탭·검색·난이도·정렬·페이지) |
| `trail.php?id=` | 상세: 거리/시간/난이도, 코스 타임라인, 주변 명소, 코스 지도 |
| `join.php` | 가입 신청 처리 |
| `data/trails.php` | 대전관광 도보여행길 44건 데이터 |
| `includes/config.php` | 사이트 정보, **메뉴(대전 도보여행길·대전관광)**, 사진 목록 |

## 수정 포인트
- 메뉴: `includes/config.php`의 `$MENU`
- 정기산행 일정: `index.php`의 `$SCHEDULE`
- 사진 교체: `$NATURE` 배열 (Unsplash 사진 ID 또는 직접 URL로 바꿔도 됨)
- 난이도(`level` 1~4)는 거리·소요시간 기준으로 임의 지정한 값입니다.

출처: 대전관광 도보여행길 https://daejeontour.co.kr/work_djt
