/* shared on every page: header, mega menu, footer year */
(function(){
  const $=s=>document.querySelector(s), $$=s=>[...document.querySelectorAll(s)];
  $('#yr').textContent=new Date().getFullYear();

  /* nav: border appears once the page leaves the top */
  const nav=$('#nav');
  new IntersectionObserver(([e])=>nav.classList.toggle('scrolled',!e.isIntersecting)).observe($('#topSentinel'));
  $('#burger').onclick=()=>{const o=nav.classList.toggle('open');$('#burger').setAttribute('aria-expanded',o)};
  $$('#navLinks a').forEach(a=>a.addEventListener('click',()=>nav.classList.remove('open')));

  /* mega menu: close after a pick until the pointer leaves */
  const modDD=$('#modDD');
  $$('#modDD a').forEach(a=>a.addEventListener('click',()=>{modDD.classList.add('shut');a.blur()}));
  modDD.addEventListener('mouseleave',()=>modDD.classList.remove('shut'));
})();
