/* admin feature form: live icon previews, highlight repeater, previews of screenshots picked for upload */
(function(){
  const $$=(s,r=document)=>[...r.querySelectorAll(s)];

  /* icon inputs show the Font Awesome icon they name */
  document.addEventListener('input',e=>{
    const input=e.target.closest('[data-icon-input]');
    if(!input)return;
    const icon=input.parentElement.querySelector('[data-icon-preview]');
    const name=input.value.trim();
    icon.className='fa-solid '+(/^fa-[a-z0-9-]+$/.test(name)?name:'fa-question');
  });

  /* highlight rows: add from the <template>, remove with the row's x, capped at data-max */
  $$('[data-repeat]').forEach(box=>{
    const tpl=box.querySelector('template'), add=box.querySelector('[data-repeat-add]'), max=+box.dataset.max||99;
    let next=$$('[data-repeat-row]',box).length;
    const sync=()=>{add.hidden=$$('[data-repeat-row]',box).length>=max};
    add.onclick=()=>{
      add.insertAdjacentHTML('beforebegin',tpl.innerHTML.replaceAll('__i__',next++));
      sync();
      const rows=$$('[data-repeat-row]',box);
      rows[rows.length-1].querySelector('input[name$="[title]"]').focus();
    };
    box.addEventListener('click',e=>{
      const btn=e.target.closest('[data-repeat-remove]');
      if(!btn)return;
      btn.closest('[data-repeat-row]').remove();
      sync();
    });
    sync();
  });

  /* thumbnails of the screenshots picked for upload */
  $$('[data-multi-preview]').forEach(box=>{
    const input=box.querySelector('input[type=file]'), list=box.nextElementSibling;
    input.addEventListener('change',()=>{
      list.innerHTML='';
      [...input.files].forEach(f=>{
        const item=document.createElement('div'), img=document.createElement('img'), name=document.createElement('small');
        item.className='adm-shot';
        img.src=URL.createObjectURL(f);img.alt='';
        name.textContent=f.name;
        item.append(img,name);
        list.append(item);
      });
      list.hidden=!input.files.length;
    });
  });
})();
