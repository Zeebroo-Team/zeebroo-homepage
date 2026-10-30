/* Docs admin: page sections (add, remove, reorder, anchors), the component toolbar, screenshot upload,
   live preview, and the common-task page → section dropdowns */
(()=>{
  const $$=(s,r=document)=>[...r.querySelectorAll(s)];
  const slug=s=>s.toLowerCase().normalize('NFKD').replace(/[̀-ͯ]/g,'').replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'');
  const esc=s=>s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');

  /* icon inputs show the Font Awesome icon they name */
  document.addEventListener('input',e=>{
    const input=e.target.closest('[data-icon-input]');
    if(!input)return;
    const icon=input.parentElement.querySelector('[data-icon-preview]'), name=input.value.trim();
    icon.className='fa-solid '+(/^fa-[a-z0-9-]+$/.test(name)?name:'fa-question');
  });

  /* section rows: add from the <template>, remove, move up / down; the anchor follows the heading until edited by hand */
  $$('[data-repeat]').forEach(box=>{
    const tpl=box.querySelector('template'), add=box.querySelector('[data-repeat-add]'), max=+box.dataset.max||99;
    let next=Date.now();
    const sync=()=>{add.hidden=$$('[data-repeat-row]',box).length>=max};
    add.onclick=()=>{
      add.insertAdjacentHTML('beforebegin',tpl.innerHTML.replaceAll('__i__',next++));
      sync();
      const rows=$$('[data-repeat-row]',box);
      rows[rows.length-1].querySelector('[data-section-heading]').focus();
    };
    box.addEventListener('click',e=>{
      const remove=e.target.closest('[data-repeat-remove]'), move=e.target.closest('[data-section-move]');
      if(remove&&confirm('Remove this section and its content?')){remove.closest('[data-repeat-row]').remove();sync()}
      if(move){
        const row=move.closest('[data-repeat-row]');
        const other=move.dataset.sectionMove==='up'?row.previousElementSibling:row.nextElementSibling;
        if(other&&other.matches('[data-repeat-row]'))move.dataset.sectionMove==='up'?other.before(row):other.after(row);
        row.scrollIntoView({block:'nearest',behavior:'smooth'});
      }
    });
    box.addEventListener('input',e=>{
      const row=e.target.closest('[data-doc-section]');
      if(!row)return;
      const anchor=row.querySelector('[data-section-anchor]');
      if(e.target.matches('[data-section-anchor]'))anchor.dataset.touched='1';
      if(e.target.matches('[data-section-heading]')){
        row.querySelector('[data-section-title]').textContent=e.target.value.trim()||'New section';
        if(!anchor.dataset.touched&&!anchor.defaultValue)anchor.value=slug(e.target.value);
      }
    });
    sync();
  });

  /* component toolbar: the same markup the live guide uses, inserted at the cursor */
  const snippets={
    paragraph:'<p>Text</p>',
    list:'<ul>\n  <li>First point</li>\n  <li>Second point</li>\n</ul>',
    steps:'<div class="doc-steps">\n  <div class="doc-step">\n    <div class="step-num">1</div>\n    <div class="step-body">\n      <strong>Step title</strong>\n      <p>What to do.</p>\n    </div>\n  </div>\n  <div class="doc-step">\n    <div class="step-num">2</div>\n    <div class="step-body">\n      <strong>Step title</strong>\n      <p>What to do.</p>\n    </div>\n  </div>\n</div>',
    tip:'<div class="callout tip">\n  <div class="callout-icon"><i class="fa-solid fa-lightbulb"></i></div>\n  <div class="callout-body">\n    <strong>Tip</strong>\n    Helpful advice.\n  </div>\n</div>',
    note:'<div class="callout note">\n  <div class="callout-icon"><i class="fa-solid fa-circle-info"></i></div>\n  <div class="callout-body">\n    <strong>Note</strong>\n    Something to keep in mind.\n  </div>\n</div>',
    warn:'<div class="callout warn">\n  <div class="callout-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>\n  <div class="callout-body">\n    <strong>Warning</strong>\n    What can go wrong.\n  </div>\n</div>',
    table:'<table class="data-table">\n  <thead><tr><th>Column</th><th>Column</th></tr></thead>\n  <tbody>\n    <tr><td>Value</td><td>Value</td></tr>\n  </tbody>\n</table>',
    shortcuts:'<div class="shortcut-table">\n  <div class="shortcut-row">\n    <span class="shortcut-label">Action</span>\n    <span class="shortcut-keys"><kbd>Ctrl</kbd> + <kbd>S</kbd></span>\n  </div>\n</div>',
    kbd:'<kbd>F2</kbd>',
    ui:'<span class="ui">Button name</span>',
    tab:'<span class="tab-label">Tab name</span>',
  };
  const insert=(area,text)=>{
    const start=area.selectionStart, end=area.selectionEnd;
    area.setRangeText(text,start,end,'end');
    area.focus();
    area.dispatchEvent(new Event('input',{bubbles:true}));
  };
  const figure=(url,caption)=>'<figure class="screenshot-figure">\n  <img src="'+esc(url)+'" alt="'+esc(caption)+'" loading="lazy">\n  <figcaption class="screenshot-caption">'+esc(caption)+'</figcaption>\n</figure>';
  const upload=area=>{
    const picker=document.createElement('input');
    picker.type='file';picker.accept='image/jpeg,image/png,image/webp,image/gif';
    picker.onchange=async()=>{
      const file=picker.files[0];
      if(!file)return;
      const body=new FormData();
      body.append('image',file);
      body.append('_token',area.form.querySelector('input[name=_token]').value);
      try{
        const res=await fetch(window.ZB_DOC_IMAGE_URL,{method:'POST',body,headers:{Accept:'application/json'}});
        const data=await res.json();
        if(!res.ok)throw new Error(data.message||'Upload failed');
        insert(area,figure(data.url,prompt('Caption for this screenshot','')||''));
      }catch(err){alert('The screenshot could not be uploaded: '+err.message)}
    };
    picker.click();
  };
  document.addEventListener('click',e=>{
    const btn=e.target.closest('[data-snippet]');
    if(!btn)return;
    const area=btn.closest('.adm-field').querySelector('[data-doc-html]');
    btn.dataset.snippet==='screenshot'?upload(area):insert(area,snippets[btn.dataset.snippet]);
  });
  document.addEventListener('keydown',e=>{
    if(e.key==='Tab'&&e.target.matches('[data-doc-html]')){e.preventDefault();insert(e.target,'  ')}
  });

  /* preview: intro, sections and outro of the open language, in the live site's styles */
  const frame=document.querySelector('[data-doc-preview]');
  if(frame){
    const styles=JSON.parse(frame.dataset.styles).map(href=>'<link rel="stylesheet" href="'+esc(href)+'">').join('');
    const render=()=>{
      const lang=document.documentElement.dataset.adminLang||'en', form=frame.closest('form');
      /* a Sinhala field left empty shows the English one, as on the live site */
      const pick=(own,en)=>own.value.trim()||en.value;
      const page=name=>pick(form.querySelector('[name="'+name+(lang==='si'?'_si':'')+'"]'),form.querySelector('[name="'+name+'"]'));
      let html=page('intro');
      $$('[data-doc-section]',form).forEach(row=>{
        const field=key=>pick(row.querySelector('[name$="['+key+(lang==='si'?'_si':'')+']"]'),row.querySelector('[name$="['+key+']"]'));
        const anchor=row.querySelector('[data-section-anchor]').value||slug(field('heading'));
        html+=row.querySelector('input[type=checkbox][name$="[is_custom]"]').checked
          ?field('body')
          :'<div class="doc-sec"><h3 id="'+esc(anchor)+'">'+esc(field('heading'))+'</h3>'+field('body')+'</div>';
      });
      html+=page('outro');
      frame.srcdoc='<!doctype html><html lang="'+lang+'-LK"><head><meta charset="utf-8"><base target="_blank">'+styles
        +'<style>body{background:#fff;padding:24px}</style></head><body><div class="doc-prose">'+html+'</div></body></html>';
    };
    document.querySelector('[data-doc-preview-refresh]').onclick=render;
    $$('[data-lang-tab]').forEach(t=>t.addEventListener('click',()=>setTimeout(render)));
    let timer;
    frame.closest('form').addEventListener('input',()=>{clearTimeout(timer);timer=setTimeout(render,600)});
    render();
  }

  /* common task form: only the chosen page's sections can be picked */
  const pageSelect=document.querySelector('[data-task-page]'), anchorSelect=document.querySelector('[data-task-anchor]');
  if(pageSelect&&anchorSelect){
    pageSelect.addEventListener('change',()=>{
      $$('option[data-page]',anchorSelect).forEach(o=>{const other=o.dataset.page!==pageSelect.value;o.hidden=other;o.disabled=other});
      anchorSelect.value='';
    });
  }
})();
