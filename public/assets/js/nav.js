/* shared on every page: header, mega menu, footer year */
(function(){
  const $=s=>document.querySelector(s), $$=s=>[...document.querySelectorAll(s)];
  $('#yr').textContent=new Date().getFullYear();

  /* nav: border appears once the page leaves the top */
  const nav=$('#nav');
  new IntersectionObserver(([e])=>nav.classList.toggle('scrolled',!e.isIntersecting)).observe($('#topSentinel'));
  $('#burger').onclick=()=>{const o=nav.classList.toggle('open');$('#burger').setAttribute('aria-expanded',o)};

  /* mobile: "Modules" expands its list in place instead of navigating; registered first so it can stop the close-on-click handlers */
  const modDD=$('#modDD'), ddT=$('#modDD .nav-dd-t'), mobile=matchMedia('(max-width:920px)');
  ddT.addEventListener('click',e=>{
    if(!mobile.matches)return;
    e.preventDefault();e.stopImmediatePropagation();
    ddT.setAttribute('aria-expanded',modDD.classList.toggle('open'));
  });
  $$('#navLinks a').forEach(a=>a.addEventListener('click',()=>nav.classList.remove('open')));

  /* mega menu: close after a pick until the pointer leaves */
  $$('#modDD a').forEach(a=>a.addEventListener('click',()=>{modDD.classList.add('shut');a.blur()}));
  modDD.addEventListener('mouseleave',()=>modDD.classList.remove('shut'));
})();
