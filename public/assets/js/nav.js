/* shared on every page: header, mega menu, footer year */
(function(){
  const $=s=>document.querySelector(s), $$=s=>[...document.querySelectorAll(s)];
  $('#yr').textContent=new Date().getFullYear();

  /* nav: border appears once the page leaves the top */
  const nav=$('#nav'), burger=$('#burger'), burgerIcon=burger.querySelector('i');
  new IntersectionObserver(([e])=>nav.classList.toggle('scrolled',!e.isIntersecting)).observe($('#topSentinel'));

  /* burger menu: swaps to a close icon, locks page scroll, closes on backdrop tap / Escape / resize to desktop */
  const dds=$$('.nav-dd'), mobile=matchMedia('(max-width:1080px)');
  const setMenu=open=>{
    nav.classList.toggle('open',open);
    document.body.classList.toggle('nav-lock',open);
    burger.setAttribute('aria-expanded',open);
    burger.setAttribute('aria-label',open?'Close menu':'Open menu');
    burgerIcon.className=open?'fa-solid fa-xmark':'fa-solid fa-bars';
    if(!open){dds.forEach(dd=>{dd.classList.remove('open');dd.querySelector('.nav-dd-t').setAttribute('aria-expanded',false)})}
  };
  burger.onclick=()=>setMenu(!nav.classList.contains('open'));
  nav.addEventListener('click',e=>{if(e.target===nav)setMenu(false)});
  document.addEventListener('keydown',e=>{if(e.key==='Escape'&&nav.classList.contains('open')){setMenu(false);burger.focus()}});
  mobile.addEventListener('change',e=>{if(!e.matches)setMenu(false)});

  /* mobile: "Modules"/"Industries"/"Pricing"/"More" expand their list in place instead of navigating; registered first so they can stop the close-on-click handlers */
  dds.forEach(dd=>{
    const t=dd.querySelector('.nav-dd-t');
    t.addEventListener('click',e=>{
      if(!mobile.matches)return;
      e.preventDefault();e.stopImmediatePropagation();
      dds.forEach(o=>{if(o!==dd){o.classList.remove('open');o.querySelector('.nav-dd-t').setAttribute('aria-expanded',false)}});
      t.setAttribute('aria-expanded',dd.classList.toggle('open'));
    });
  });
  $$('#navLinks a').forEach(a=>a.addEventListener('click',()=>setMenu(false)));

  /* back-to-top: appears after scrolling past ~600px */
  const toTop=$('#toTop');
  if(toTop){
    const syncToTop=()=>toTop.classList.toggle('show',scrollY>600);
    addEventListener('scroll',syncToTop,{passive:true});syncToTop();
    toTop.onclick=()=>scrollTo({top:0,behavior:matchMedia('(prefers-reduced-motion:reduce)').matches?'auto':'smooth'});
  }

  /* mega menus (desktop): close after a pick until the pointer leaves */
  dds.forEach(dd=>{
    dd.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{if(mobile.matches)return;dd.classList.add('shut');a.blur()}));
    dd.addEventListener('mouseleave',()=>dd.classList.remove('shut'));
  });
})();
