/* admin: Quill rich-text editor that writes its HTML back into the hidden description textarea */
(function(){
  document.querySelectorAll('[data-editor]').forEach(box=>{
    const field=document.querySelector(box.dataset.editor);
    const quill=new Quill(box,{
      theme:'snow',
      placeholder:'Write the post…',
      modules:{toolbar:[
        [{header:[2,3,4,false]}],
        ['bold','italic','underline','strike'],
        [{list:'ordered'},{list:'bullet'}],
        ['blockquote','code-block','link','image'],
        [{align:[]}],
        ['clean'],
      ]},
    });
    if(field.value)quill.clipboard.dangerouslyPasteHTML(field.value);
    const sync=()=>{field.value=quill.getText().trim()===''&&!box.querySelector('img')?'':quill.root.innerHTML};
    quill.on('text-change',sync);
    field.form.addEventListener('submit',sync);
  });
})();
