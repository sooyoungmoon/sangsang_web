(() => {
  // 네비게이션: 스크롤 시 배경
  const nav = document.getElementById('nav');
  const onScroll = () => nav.classList.toggle('solid', scrollY > 60);
  addEventListener('scroll', onScroll, { passive: true }); onScroll();

  // 모바일 메뉴
  const burger = document.getElementById('burger'), menu = document.getElementById('menu');
  burger.addEventListener('click', () => {
    const open = menu.classList.toggle('open');
    burger.classList.toggle('x', open);
    burger.setAttribute('aria-expanded', open);
  });
  document.querySelectorAll('.has-sub > a').forEach(a => a.addEventListener('click', e => {
    if (matchMedia('(max-width:860px)').matches) { e.preventDefault(); a.parentNode.classList.toggle('open'); }
  }));

  // 히어로 슬라이드
  const slides = [...document.querySelectorAll('.hero-slides .slide')];
  const dots = document.getElementById('heroDots');
  if (slides.length > 1 && dots) {
    let i = 0, timer;
    slides.forEach((_, n) => {
      const b = document.createElement('button');
      b.setAttribute('aria-label', `${n + 1}번 풍경`);
      b.onclick = () => { go(n); restart(); };
      dots.appendChild(b);
    });
    const go = n => {
      slides[i].classList.remove('on'); dots.children[i].classList.remove('on');
      i = n; slides[i].classList.add('on'); dots.children[i].classList.add('on');
    };
    const restart = () => { clearInterval(timer); timer = setInterval(() => go((i + 1) % slides.length), 6500); };
    dots.children[0].classList.add('on'); restart();
  }

  // 스크롤 등장 애니메이션 + 숫자 카운트
  const io = new IntersectionObserver(entries => entries.forEach(en => {
    if (!en.isIntersecting) return;
    en.target.classList.add('in');
    const b = en.target.querySelector('[data-count]');
    if (b) {
      const end = +b.dataset.count, t0 = performance.now();
      const step = t => { const p = Math.min(1, (t - t0) / 1400); b.textContent = Math.round(end * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(step); };
      requestAnimationFrame(step);
    }
    io.unobserve(en.target);
  }), { threshold: .15 });
  document.querySelectorAll('.reveal').forEach((el, n) => { el.style.transitionDelay = (n % 3) * 90 + 'ms'; io.observe(el); });
})();
