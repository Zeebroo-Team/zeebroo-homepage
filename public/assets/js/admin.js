/* admin: sidebar toggle, slug auto-fill, image preview, delete confirmation, character counters */
(function(){
  const $=s=>document.querySelector(s), $$=s=>[...document.querySelectorAll(s)];

  const burger=$('#admBurger');
  if(burger)burger.onclick=()=>document.body.classList.toggle('adm-open');

  /* same rules as Str::slug: lowercase ascii, words joined by "-" */
  const slugify=v=>v.normalize('NFKD').replace(/[̀-ͯ]/g,'').toLowerCase()
    .replace(/@/g,' at ').replace(/[^a-z0-9\s_-]/g,'').trim().replace(/[\s_-]+/g,'-').replace(/^-+|-+$/g,'');

  /* slug follows its source field until someone types in it; an existing slug starts in manual mode */
  $$('[data-slug-source]').forEach(slug=>{
    const src=$(slug.dataset.slugSource);
    if(!src)return;
    let manual=slug.value.trim()!=='';
    const sync=()=>{if(!manual)slug.value=slugify(src.value)};
    src.addEventListener('input',sync);
    slug.addEventListener('input',()=>{manual=slug.value.trim()!==''});
    slug.addEventListener('blur',()=>{slug.value=slugify(slug.value);if(!slug.value){manual=false;sync()}});
    const reset=slug.parentElement.querySelector('[data-slug-reset]');
    if(reset)reset.onclick=()=>{manual=false;sync();slug.focus()};
  });

  /* English / Sinhala tabs: one switch drives every language pane on the page. The language sits on <html>
     and CSS hides the other panes, so rows added later (highlights, new screenshots) follow it too */
  const langTabs=$$('[data-lang-tab]');
  if(langTabs.length){
    const root=document.documentElement;
    const showLang=lang=>{
      root.dataset.adminLang=lang;
      langTabs.forEach(t=>t.setAttribute('aria-selected',t.dataset.langTab===lang));
    };
    langTabs.forEach(t=>t.onclick=()=>showLang(t.dataset.langTab));
    /* flag tabs with validation errors and open the first one */
    const withErrors=[...new Set($$('[data-lang-pane]').filter(p=>p.querySelector('.adm-err')).map(p=>p.dataset.langPane))];
    langTabs.forEach(t=>t.classList.toggle('bad',withErrors.includes(t.dataset.langTab)));
    if(withErrors.length)showLang(withErrors[0]);
    /* a required field in a hidden pane would block submit silently, so reveal its pane */
    document.addEventListener('invalid',e=>{
      const pane=e.target.closest('[data-lang-pane]');
      if(pane&&pane.dataset.langPane!==(root.dataset.adminLang||'en'))showLang(pane.dataset.langPane);
    },true);
  }

  /* featured image preview */
  $$('[data-preview]').forEach(box=>{
    const input=box.querySelector('input[type=file]'), img=box.querySelector('img'), hint=box.querySelector('span');
    input.addEventListener('change',()=>{
      const f=input.files[0];
      if(!f)return;
      img.src=URL.createObjectURL(f);img.hidden=false;hint.hidden=true;
    });
  });

  $$('form[data-confirm]').forEach(f=>f.addEventListener('submit',e=>{if(!confirm(f.dataset.confirm))e.preventDefault()}));

  /* inline selects (enquiry status) save as soon as they change */
  $$('select[data-autosubmit]').forEach(s=>s.addEventListener('change',()=>s.form.requestSubmit()));

  /* notification bell: open/close, then poll every 30s and pop a toast when a new enquiry arrives */
  const bell=$('#admBell');
  if(bell){
    const btn=bell.querySelector('button'), menu=$('#admBellMenu'), count=bell.querySelector('.adm-bell-count'),
      list=bell.querySelector('.adm-bell-list'), navCount=$('#admEnquiryCount');
    const toggle=open=>{menu.hidden=!open;btn.setAttribute('aria-expanded',open)};
    btn.onclick=e=>{e.stopPropagation();toggle(menu.hidden)};
    document.addEventListener('click',e=>{if(!bell.contains(e.target))toggle(false)});
    document.addEventListener('keydown',e=>{if(e.key==='Escape')toggle(false)});

    const setCount=(el,n)=>{if(!el)return;el.textContent=n;el.hidden=!n};
    const toast=item=>{
      const t=document.createElement('a');
      t.className='adm-toast';t.href=item.url;
      t.innerHTML='<i class="fa-solid fa-bell"></i><span><b></b><small></small></span>';
      t.querySelector('b').textContent=item.text;t.querySelector('small').textContent=item.topic;
      document.body.append(t);
      setTimeout(()=>t.remove(),8000);
    };

    let lastId=null, first=true;
    const poll=async()=>{
      if(document.hidden)return;
      try{
        const r=await fetch(bell.dataset.feed,{headers:{Accept:'application/json'}});
        if(!r.ok)return;
        const d=await r.json();
        setCount(count,d.unread);setCount(navCount,d.new_enquiries);
        list.innerHTML=d.html;
        const id=d.latest?d.latest.id:null;
        if(!first&&id&&id!==lastId)toast(d.latest);
        lastId=id;first=false;
      }catch(e){}
    };
    poll();
    setInterval(poll,30000);
    document.addEventListener('visibilitychange',()=>{if(!document.hidden)poll()});
  }

  /* keyboard shortcuts: two-key sequences ("g e", "c p") taken from [data-key] links, "?" opens the list */
  const keyLinks=$$('[data-key]'), keysDialog=$('#admKeys');
  if(keysDialog){
    const list=$('#admKeysList'), seen=new Set();
    [...keyLinks.filter(a=>a.dataset.key.startsWith('c ')),...keyLinks.filter(a=>!a.dataset.key.startsWith('c '))].forEach(a=>{
      if(seen.has(a.dataset.key))return;
      seen.add(a.dataset.key);
      const dt=document.createElement('dt'), dd=document.createElement('dd');
      dt.innerHTML=a.dataset.key.split(' ').map(k=>'<kbd>'+k+'</kbd>').join(' ');
      dd.textContent=a.dataset.keyLabel||a.textContent.trim();
      list.append(dt,dd);
    });
    const dt=document.createElement('dt'), dd=document.createElement('dd');
    dt.innerHTML='<kbd>?</kbd>';dd.textContent='Show this list';list.append(dt,dd);
    const openKeys=()=>{if(!keysDialog.open)keysDialog.showModal()};
    keysDialog.querySelector('[data-close]').onclick=()=>keysDialog.close();
    keysDialog.addEventListener('click',e=>{if(e.target===keysDialog)keysDialog.close()});
    $$('[data-shortcut-help]').forEach(b=>b.onclick=openKeys);

    let prefix=null, timer;
    document.addEventListener('keydown',e=>{
      const t=e.target;
      if(e.ctrlKey||e.metaKey||e.altKey||t.isContentEditable||/^(INPUT|TEXTAREA|SELECT)$/.test(t.tagName))return;
      if(e.key==='?'){e.preventDefault();openKeys();return}
      const k=e.key.toLowerCase();
      if(prefix){
        const a=keyLinks.find(l=>l.dataset.key===prefix+' '+k);
        prefix=null;clearTimeout(timer);
        if(a){e.preventDefault();a.click()}
        return;
      }
      if(k==='g'||k==='c'){prefix=k;timer=setTimeout(()=>prefix=null,1200)}
    });
  }

  /* soft length hint for SEO fields */
  $$('[data-count]').forEach(el=>{
    const max=+el.dataset.count, out=document.createElement('small');
    out.className='adm-count';
    el.after(out);
    const upd=()=>{out.textContent=el.value.length+' / '+max+' recommended';out.classList.toggle('over',el.value.length>max)};
    el.addEventListener('input',upd);upd();
  });
})();
