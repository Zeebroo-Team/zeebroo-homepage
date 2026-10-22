/* docs: button labels follow the page language (English or Sinhala) */
const docsText=document.documentElement.lang==='si'
  ?{copy:'පිටපත් කරන්න',copied:'පිටපත් විය',link:'මෙම කොටසට සබැඳිය පිටපත් කරන්න',linkCopied:'සබැඳිය පිටපත් විය'}
  :{copy:'Copy',copied:'Copied',link:'Copy a link to this section',linkCopied:'Link copied'};

/* docs: chapter list is always open on desktop and a collapsible menu on smaller screens */
(function(){
  const menu=document.querySelector('[data-docs-menu]');
  if(!menu)return;
  const wide=matchMedia('(min-width:1081px)');
  const sync=()=>{menu.open=wide.matches};
  sync();
  wide.addEventListener('change',sync);
  menu.querySelector('summary').addEventListener('click',e=>{if(wide.matches)e.preventDefault()});
})();

/* docs: highlight the "On this page" link for the section being read */
(function(){
  const links=[...document.querySelectorAll('[data-toc]')];
  const targets=links.map(a=>document.getElementById(a.dataset.toc)).filter(Boolean);
  if(!targets.length)return;
  const mark=id=>links.forEach(a=>a.classList.toggle('on',a.dataset.toc===id));
  const update=()=>{
    let current=targets[0];
    for(const t of targets){if(t.getBoundingClientRect().top<=140)current=t}
    mark(current.id);
  };
  update();
  addEventListener('scroll',update,{passive:true});
})();

/* docs home and API overview: filter cards by every word typed; "/" jumps to the search box */
(function(){
  const input=document.querySelector('[data-search-input]');
  if(!input)return;
  const items=[...document.querySelectorAll('[data-search-item]')];
  const blocks=[...document.querySelectorAll('[data-search-block]')];
  const intro=document.querySelector('[data-search-intro]'), empty=document.querySelector('[data-search-empty]');
  input.addEventListener('input',()=>{
    const words=input.value.toLowerCase().trim().split(/\s+/).filter(Boolean);
    items.forEach(c=>{c.hidden=!words.every(w=>c.dataset.search.includes(w))});
    blocks.forEach(b=>{b.hidden=!b.querySelector('[data-search-item]:not([hidden])')});
    if(intro)intro.hidden=words.length>0;
    if(empty)empty.hidden=items.some(c=>!c.hidden);
  });
  addEventListener('keydown',e=>{
    if(e.key!=='/'||e.ctrlKey||e.metaKey||e.altKey||e.target.closest('input,textarea,select,[contenteditable]'))return;
    e.preventDefault();
    input.focus();
  });
})();

/* API reference: copy button on every code sample */
(function(){
  const label=(icon,text)=>`<i class="${icon}"></i> ${text}`;
  document.querySelectorAll('.doc-api pre.code-block').forEach(pre=>{
    const wrap=document.createElement('div');
    wrap.className='doc-code-wrap';
    pre.replaceWith(wrap);
    wrap.append(pre);
    const btn=document.createElement('button');
    btn.type='button';
    btn.className='doc-copy';
    btn.innerHTML=label('fa-regular fa-copy',docsText.copy);
    btn.addEventListener('click',()=>{
      navigator.clipboard?.writeText(pre.innerText).then(()=>{
        btn.classList.add('copied');
        btn.innerHTML=label('fa-solid fa-check',docsText.copied);
        setTimeout(()=>{btn.classList.remove('copied');btn.innerHTML=label('fa-regular fa-copy',docsText.copy)},1600);
      });
    });
    wrap.append(btn);
  });
})();

/* user guide: a link button beside every section heading copies a direct link to that section */
(function(){
  document.querySelectorAll('[data-toc]').forEach(a=>{
    const target=document.getElementById(a.dataset.toc);
    const heading=target&&(target.matches('h2,h3')?target:target.querySelector('h2,h3'));
    if(!heading||!target.closest('.doc-prose:not(.doc-api)'))return;
    const btn=document.createElement('button');
    btn.type='button';
    btn.className='doc-anchor';
    btn.title=docsText.link;
    btn.setAttribute('aria-label',docsText.link);
    btn.innerHTML='<i class="fa-solid fa-link"></i>';
    btn.addEventListener('click',()=>{
      const url=location.href.split('#')[0]+'#'+target.id;
      history.replaceState(null,'','#'+target.id);
      navigator.clipboard?.writeText(url).then(()=>{
        btn.classList.add('copied');
        btn.title=docsText.linkCopied;
        btn.innerHTML='<i class="fa-solid fa-check"></i>';
        setTimeout(()=>{btn.classList.remove('copied');btn.title=docsText.link;btn.innerHTML='<i class="fa-solid fa-link"></i>'},1600);
      });
    });
    heading.append(btn);
  });
})();

/* user guide: print the chapter (navigation is hidden by the print styles) */
document.querySelector('[data-docs-print]')?.addEventListener('click',()=>print());

/* docs: screenshots open full size in a dialog; click outside, the close button or Esc closes it */
(function(){
  const box=document.getElementById('docsZoom'), doc=document.querySelector('[data-doc]');
  if(!box||!doc||typeof box.showModal!=='function')return;
  const img=box.querySelector('img');
  doc.addEventListener('click',e=>{
    const shot=e.target.closest('.screenshot-figure img, .wizard-step-shot img');
    if(!shot)return;
    img.src=shot.currentSrc||shot.src;
    img.alt=shot.alt;
    box.showModal();
  });
  box.addEventListener('click',e=>{
    if(e.target===box||e.target.closest('[data-zoom-close]'))box.close();
  });
})();
