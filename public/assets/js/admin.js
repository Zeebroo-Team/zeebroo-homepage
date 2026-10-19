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

  /* soft length hint for SEO fields */
  $$('[data-count]').forEach(el=>{
    const max=+el.dataset.count, out=document.createElement('small');
    out.className='adm-count';
    el.after(out);
    const upd=()=>{out.textContent=el.value.length+' / '+max+' recommended';out.classList.toggle('over',el.value.length>max)};
    el.addEventListener('input',upd);upd();
  });
})();
