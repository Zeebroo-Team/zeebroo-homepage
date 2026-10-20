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

  /* screenshots picked for upload: each pick adds to the queue (capped at data-max), every card gets a caption and an x to drop it */
  $$('[data-multi-preview]').forEach(box=>{
    const input=box.querySelector('input[type=file]'), list=box.nextElementSibling, max=+box.dataset.max||12;
    let queue=[];
    const render=()=>{
      const dt=new DataTransfer();
      queue.forEach(q=>dt.items.add(q.file));
      input.files=dt.files;
      list.innerHTML='';
      queue.forEach((q,i)=>{
        const item=document.createElement('div'), img=document.createElement('img'), cap=document.createElement('input'), foot=document.createElement('div'), name=document.createElement('small'), rm=document.createElement('button');
        item.className='adm-shot';
        img.src=q.url;img.alt='';
        cap.type='text';cap.name='new_screenshot_captions['+i+']';cap.maxLength=255;cap.placeholder='Caption (optional)';cap.value=q.caption;
        cap.setAttribute('aria-label','Caption');
        cap.oninput=()=>{q.caption=cap.value};
        foot.className='adm-shot-f';
        name.textContent=q.file.name;
        rm.type='button';rm.className='adm-shot-x';rm.title='Remove';rm.innerHTML='<i class="fa-solid fa-xmark"></i>';
        rm.onclick=()=>{URL.revokeObjectURL(q.url);queue.splice(i,1);render()};
        foot.append(name,rm);
        item.append(img,cap,foot);
        list.append(item);
      });
      list.hidden=!queue.length;
    };
    input.addEventListener('change',()=>{
      const picked=[...input.files], room=max-queue.length;
      if(picked.length>room){alert('Up to '+max+' screenshots per upload, so only the first '+Math.max(room,0)+' were added.')}
      picked.slice(0,Math.max(room,0)).forEach(file=>queue.push({file,url:URL.createObjectURL(file),caption:''}));
      render();
    });
  });
})();
