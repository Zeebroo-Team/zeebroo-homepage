/* blog index and post pages */

/* blog category bar: arrow buttons, edge fades, wheel and drag to scroll sideways */
(function(){
  const wrap=document.querySelector('[data-cats]');
  if(!wrap)return;
  const bar=wrap.querySelector('.blog-cats');

  const sync=()=>{
    const max=bar.scrollWidth-bar.clientWidth;
    wrap.classList.toggle('can-prev',bar.scrollLeft>2);
    wrap.classList.toggle('can-next',bar.scrollLeft<max-2);
  };

  // open with the selected category in view
  const on=bar.querySelector('a.on');
  if(on&&on.offsetLeft+on.offsetWidth>bar.clientWidth)bar.scrollLeft=on.offsetLeft-bar.clientWidth/2+on.offsetWidth/2;

  wrap.addEventListener('click',e=>{
    const btn=e.target.closest('[data-cats-step]');
    if(btn)bar.scrollBy({left:+btn.dataset.catsStep*bar.clientWidth*.6,behavior:'smooth'});
  });

  // vertical wheel scrolls the bar sideways, until it reaches an end
  bar.addEventListener('wheel',e=>{
    if(Math.abs(e.deltaY)<=Math.abs(e.deltaX))return;
    const max=bar.scrollWidth-bar.clientWidth;
    if((e.deltaY<0&&bar.scrollLeft<=0)||(e.deltaY>0&&bar.scrollLeft>=max))return;
    e.preventDefault();
    bar.scrollLeft+=e.deltaY;
  },{passive:false});

  // click-and-drag with a mouse (touch already swipes natively)
  let startX=0,startLeft=0,down=false;
  bar.addEventListener('pointerdown',e=>{
    if(e.pointerType!=='mouse'||e.button!==0)return;
    down=true;startX=e.clientX;startLeft=bar.scrollLeft;
  });
  window.addEventListener('pointermove',e=>{
    if(!down)return;
    const dx=e.clientX-startX;
    if(Math.abs(dx)>5)bar.classList.add('dragging');
    if(bar.classList.contains('dragging'))bar.scrollLeft=startLeft-dx;
  });
  window.addEventListener('pointerup',()=>{
    down=false;
    // let the click that ends a drag fire first, so it doesn't follow a link
    setTimeout(()=>bar.classList.remove('dragging'));
  });

  bar.addEventListener('scroll',sync,{passive:true});
  window.addEventListener('resize',sync);
  sync();
})();

/* post page: reading progress bar tracks how far through the article you are */
(function(){
  const bar=document.querySelector('[data-progress]');
  const post=document.querySelector('[data-post]');
  if(!bar||!post)return;

  let ticking=false;
  const update=()=>{
    const r=post.getBoundingClientRect();
    const total=r.height-innerHeight;
    const p=total>0?Math.min(Math.max(-r.top/total,0),1):1;
    bar.style.setProperty('--p',p.toFixed(4));
    ticking=false;
  };
  const queue=()=>{if(!ticking){ticking=true;requestAnimationFrame(update)}};

  window.addEventListener('scroll',queue,{passive:true});
  window.addEventListener('resize',queue);
  update();
})();

/* post page: copy link button */
(function(){
  document.querySelectorAll('[data-copy]').forEach(btn=>{
    let timer;
    btn.addEventListener('click',async()=>{
      try{await navigator.clipboard.writeText(btn.dataset.copy)}catch(e){return}
      btn.classList.add('copied');
      clearTimeout(timer);
      timer=setTimeout(()=>btn.classList.remove('copied'),1600);
    });
  });
})();
