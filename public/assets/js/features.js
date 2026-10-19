/* feature pages: reveal blocks as they scroll into view */
(function(){
  const els=document.querySelectorAll('.reveal');
  if(!('IntersectionObserver' in window)){els.forEach(el=>el.classList.add('in'));return}
  const io=new IntersectionObserver(es=>es.forEach(e=>{
    if(!e.isIntersecting)return;
    e.target.classList.add('in');
    io.unobserve(e.target);
  }),{threshold:.12,rootMargin:'0px 0px -40px 0px'});
  els.forEach(el=>io.observe(el));
})();

/* feature screenshots: open in a lightbox, arrow keys / buttons step through, click outside closes */
(function(){
  const box=document.getElementById('shotBox'), shots=[...document.querySelectorAll('[data-shot]')];
  if(!box||!shots.length||typeof box.showModal!=='function')return;
  const img=box.querySelector('img'), cap=box.querySelector('figcaption');
  let at=0;
  const show=k=>{
    at=(k+shots.length)%shots.length;
    img.src=shots[at].dataset.shot;
    img.alt=shots[at].querySelector('img').alt;
    cap.textContent=shots[at].dataset.caption||'';
  };
  shots.forEach((s,k)=>s.addEventListener('click',()=>{show(k);box.showModal()}));
  box.addEventListener('click',e=>{
    if(e.target===box||e.target.closest('[data-lb-close]'))return box.close();
    const step=e.target.closest('[data-lb-step]');
    if(step)show(at+ +step.dataset.lbStep);
  });
  box.addEventListener('keydown',e=>{
    if(shots.length<2)return;
    if(e.key==='ArrowRight')show(at+1);
    if(e.key==='ArrowLeft')show(at-1);
  });
})();
