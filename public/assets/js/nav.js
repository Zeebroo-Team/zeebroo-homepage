/* shared on every page: header, mega menu, footer year */
(function(){
  const $=s=>document.querySelector(s), $$=s=>[...document.querySelectorAll(s)];
  $('#yr').textContent=new Date().getFullYear();

  /* nav: border appears once the page leaves the top */
  const nav=$('#nav');
  new IntersectionObserver(([e])=>nav.classList.toggle('scrolled',!e.isIntersecting)).observe($('#topSentinel'));
  $('#burger').onclick=()=>{const o=nav.classList.toggle('open');$('#burger').setAttribute('aria-expanded',o)};

  /* mobile: "Modules"/"Industries" expand their list in place instead of navigating; registered first so they can stop the close-on-click handlers */
  const dds=$$('.nav-dd'), mobile=matchMedia('(max-width:920px)');
  dds.forEach(dd=>{
    const t=dd.querySelector('.nav-dd-t');
    t.addEventListener('click',e=>{
      if(!mobile.matches)return;
      e.preventDefault();e.stopImmediatePropagation();
      dds.forEach(o=>{if(o!==dd){o.classList.remove('open');o.querySelector('.nav-dd-t').setAttribute('aria-expanded',false)}});
      t.setAttribute('aria-expanded',dd.classList.toggle('open'));
    });
  });
  $$('#navLinks a').forEach(a=>a.addEventListener('click',()=>nav.classList.remove('open')));

  /* mega menus: close after a pick until the pointer leaves */
  dds.forEach(dd=>{
    dd.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{dd.classList.add('shut');a.blur()}));
    dd.addEventListener('mouseleave',()=>dd.classList.remove('shut'));
  });
})();
