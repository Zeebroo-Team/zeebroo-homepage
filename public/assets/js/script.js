const $=s=>document.querySelector(s), $$=s=>[...document.querySelectorAll(s)];
const fmt=n=>'Rs '+Math.round(n).toLocaleString('en-US');
const reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ---------- POS demo ---------- */
const P=[
  {n:'Fresh Bread Loaf',c:'Bakery',p:180,s:24,i:'fa-bread-slice',bg:'#FFF3DC',fg:'#B5730F'},
  {n:'Chocolate Cake Slice',c:'Bakery',p:450,s:8,i:'fa-cake-candles',bg:'#FBE9F0',fg:'#B8386A'},
  {n:'Ceylon Tea 100g',c:'Drinks',p:520,s:40,i:'fa-mug-hot',bg:'#E9F6EE',fg:'#1A8754'},
  {n:'Iced Coffee',c:'Drinks',p:390,s:15,i:'fa-mug-saucer',bg:'#F2ECE6',fg:'#7A5236'},
  {n:'Mineral Water 1L',c:'Drinks',p:120,s:60,i:'fa-bottle-water',bg:'#E6F2FE',fg:'#2470C7'},
  {n:'Cheddar Cheese',c:'Dairy',p:980,s:6,i:'fa-cheese',bg:'#FFF7D6',fg:'#A87F00'},
  {n:'Eggs, 10 pack',c:'Dairy',p:550,s:4,i:'fa-egg',bg:'#F3F1EC',fg:'#8C7756'},
  {n:'Vanilla Ice Cream',c:'Dairy',p:1150,s:10,i:'fa-ice-cream',bg:'#FDEDF3',fg:'#C24D7C'},
  {n:'Red Apples 1kg',c:'Fresh',p:890,s:18,i:'fa-apple-whole',bg:'#FDECEC',fg:'#CC3535'},
  {n:'Carrots 500g',c:'Fresh',p:260,s:30,i:'fa-carrot',bg:'#FFEFE2',fg:'#D25F12'},
];
const cats=['All','Bakery','Drinks','Dairy','Fresh'];
let cat='All', cart=new Map([[2,1],[0,2]]), method='Cash', sales=235, rev=753292;
const grid=$('#grid'), lines=$('#lines'), bubble=$('#bubble'), mascot=$('#mascot');

$('#cats').innerHTML=cats.map(c=>`<button role="tab" aria-selected="${c===cat}" class="${c===cat?'on':''}">${c}</button>`).join('');
$('#cats').onclick=e=>{const b=e.target.closest('button');if(!b)return;cat=b.textContent;$$('#cats button').forEach(x=>{x.classList.toggle('on',x===b);x.setAttribute('aria-selected',x===b)});filter()};

function renderGrid(){
  grid.innerHTML=P.map((p,k)=>`<button class="prod" data-k="${k}" style="--bg:${p.bg};--fg:${p.fg}" aria-label="Add ${p.n}, ${fmt(p.p)}">
    <div class="ic"><i class="fa-solid ${p.i}"></i></div><b>${p.n}</b>
    <small class="${p.s<5?'low':''}">${p.s<5?'Low stock: ':''}${p.s} left</small><em>${fmt(p.p)}</em></button>`).join('')+'<div class="nores" hidden>No products match. Try another search.</div>';
  filter();
}
function filter(){
  const q=$('#q').value.trim().toLowerCase();let shown=0;
  $$('.prod').forEach(el=>{const p=P[el.dataset.k],ok=(cat==='All'||p.c===cat)&&p.n.toLowerCase().includes(q);el.classList.toggle('hide',!ok);shown+=ok});
  $('.nores').hidden=shown>0;
}
$('#q').oninput=filter;
addEventListener('keydown',e=>{if(e.key==='F2'){const r=$('#app').getBoundingClientRect();if(r.top<innerHeight&&r.bottom>0){e.preventDefault();$('#q').focus()}}});

grid.onclick=e=>{
  const b=e.target.closest('.prod');if(!b)return;
  const k=+b.dataset.k;
  if((cart.get(k)||0)>=P[k].s)return;
  cart.set(k,(cart.get(k)||0)+1);
  bubble.classList.add('hide');
  if(!reduce)fly(b.querySelector('.ic'),P[k]);
  renderCart();
};
function fly(from,p){
  const a=from.getBoundingClientRect(), t=$('#count').getBoundingClientRect();
  const d=document.createElement('div');d.className='fly';d.style.cssText=`left:${a.left+a.width/2-20}px;top:${a.top+a.height/2-20}px;background:${p.bg};color:${p.fg}`;
  d.innerHTML=`<i class="fa-solid ${p.i}"></i>`;document.body.appendChild(d);
  const dx=t.left+t.width/2-(a.left+a.width/2), dy=t.top+t.height/2-(a.top+a.height/2);
  d.animate([{transform:'translate(0,0) scale(1)'},{transform:`translate(${dx*.5}px,${dy-80}px) scale(1.1)`,offset:.5},{transform:`translate(${dx}px,${dy}px) scale(.3)`,opacity:.4}],{duration:650,easing:'cubic-bezier(.5,0,.5,1)'}).onfinish=()=>{d.remove();const c=$('#count');c.classList.add('bump');setTimeout(()=>c.classList.remove('bump'),250)};
}
function totals(){
  let sub=0,qty=0;cart.forEach((q,k)=>{sub+=P[k].p*q;qty+=q});
  const disc=sub>=2000?Math.round(sub*.05):0; // demo rule: 5% off over Rs 2,000
  return {sub,disc,tot:sub-disc,qty};
}
function renderCart(){
  const t=totals();
  lines.innerHTML=cart.size?[...cart].map(([k,q])=>{const p=P[k];return `<div class="line" style="--bg:${p.bg};--fg:${p.fg}">
    <span class="ic"><i class="fa-solid ${p.i}"></i></span><div><b>${p.n}</b><small>${fmt(p.p*q)}</small></div>
    <div class="qty"><button data-k="${k}" data-d="-1" aria-label="Remove one ${p.n}"><i class="fa-solid fa-minus"></i></button><span>${q}</span><button data-k="${k}" data-d="1" aria-label="Add one ${p.n}"><i class="fa-solid fa-plus"></i></button></div></div>`}).join('')
    :`<div class="empty"><i class="fa-solid fa-cart-plus"></i>The cart is empty. Tap a product to start a sale.</div>`;
  $('#count').textContent=t.qty;
  $('#sub').textContent=fmt(t.sub);
  $('#disc').textContent=t.disc?'-'+fmt(t.disc)+' (5% over Rs 2,000)':'Rs 0';
  $('#tot').textContent=fmt(t.tot);
  $('#chargeAmt').textContent=fmt(t.tot);
  $('#charge').disabled=!t.qty;
}
lines.onclick=e=>{
  const b=e.target.closest('button[data-k]');if(!b)return;
  const k=+b.dataset.k, q=(cart.get(k)||0)+(+b.dataset.d);
  if(q>P[k].s)return;
  q<=0?cart.delete(k):cart.set(k,q);renderCart();
};
$('#pay').onclick=e=>{const b=e.target.closest('button');if(!b)return;method=b.dataset.m;$$('#pay button').forEach(x=>x.classList.toggle('on',x===b))};

function countTo(el,to,pre=''){
  const from=+el.dataset.v||0;el.dataset.v=to;
  if(reduce){el.textContent=pre+Math.round(to).toLocaleString('en-US');return}
  const t0=performance.now(),D=900;
  (function step(t){const k=Math.min(1,(t-t0)/D),e=1-Math.pow(1-k,3);el.textContent=pre+Math.round(from+(to-from)*e).toLocaleString('en-US');if(k<1)requestAnimationFrame(step)})(t0);
}
$('#stSales').dataset.v=sales;$('#stRev').dataset.v=rev;

$('#charge').onclick=()=>{
  const t=totals();if(!t.qty)return;
  const now=new Date(), no=String(1000+sales).padStart(6,'0');
  $('#receipt').innerHTML=`<h4>ZEEBROO MART</h4><div class="c">Colombo 03, Branch 1</div><div class="c">${now.toLocaleDateString('en-GB')} ${now.toLocaleTimeString('en-GB',{hour:'2-digit',minute:'2-digit'})}</div><div class="c">Receipt #${no}</div><hr>`+
    [...cart].map(([k,q])=>`<div class="r"><span>${q}x ${P[k].n}</span><span>${(P[k].p*q).toLocaleString('en-US')}</span></div>`).join('')+
    `<hr><div class="r"><span>Subtotal</span><span>${t.sub.toLocaleString('en-US')}</span></div>`+(t.disc?`<div class="r"><span>Discount</span><span>-${t.disc.toLocaleString('en-US')}</span></div>`:'')+
    `<div class="r tot"><span>TOTAL</span><span>${fmt(t.tot)}</span></div><div class="r"><span>Paid by ${method}</span><span>OK</span></div><hr><div class="c">Thank you, come again!</div><div class="barcode"></div>`;
  $('#rwrap').classList.add('show');
  cart.forEach((q,k)=>P[k].s-=q);
  sales++;rev+=t.tot;
  countTo($('#stSales'),sales);countTo($('#stRev'),rev);
  bubble.innerHTML=`Ka-ching! <b>${fmt(t.tot)}</b> sold.`;bubble.classList.remove('hide');
  if(!reduce){mascot.classList.remove('cheer');void mascot.offsetWidth;mascot.classList.add('cheer')}
  setTimeout(()=>bubble.classList.add('hide'),3000);
  setTimeout(()=>$('#newSale').focus({preventScroll:true}),1500);
};
$('#newSale').onclick=()=>{$('#rwrap').classList.remove('show');cart.clear();renderGrid();renderCart()};
renderGrid();renderCart();

/* ---------- roles ---------- */
const roles=[
  {n:'Nimali',r:'Cashier',p:[['Ring up sales',1],['Issue refunds',0],['View reports',0]]},
  {n:'Kasun',r:'Manager',p:[['Ring up sales',1],['Edit stock',1],['View reports',1]]},
  {n:'Ayesha',r:'Accountant',p:[['Pay bills',1],['View reports',1],['Edit stock',0]]},
];
$('#roles').innerHTML=roles.map(o=>`<div class="role"><div class="role-h"><span class="av">${o.n[0]}</span><div><b>${o.n}</b><small>${o.r}</small></div></div>`+
  o.p.map(([l,v])=>`<div class="perm"><span>${l}</span><button class="sw" role="switch" aria-checked="${!!v}" aria-label="${o.n}: ${l}"></button></div>`).join('')+`</div>`).join('');
$('#roles').onclick=e=>{const s=e.target.closest('.sw');if(s)s.setAttribute('aria-checked',s.getAttribute('aria-checked')!=='true')};

/* ---------- modules (core features from the admin panel, rendered into #modData) ---------- */
if($('#modData')){
const M=JSON.parse($('#modData').textContent);
const esc=v=>String(v??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[c]);
const on=M.map(()=>true);let sel=0;
$('#modList').innerHTML=M.map((m,k)=>`<div class="mod-row${k?'':' sel'}" data-k="${k}" role="option" aria-selected="${!k}" tabindex="0"><span class="mi"><i class="fa-solid ${esc(m.i)}"></i></span><div><b>${esc(m.t)}</b><small>${esc(m.s)}</small></div><button class="sw" role="switch" aria-checked="true" aria-label="Enable ${esc(m.t)}"></button><span class="bar"></span></div>`).join('');
M.forEach(m=>{if(m.img)new Image().src=m.img});
function showMod(k){
  const m=M[k],img=$('#modImg'),changed=sel!==k;sel=k;
  $$('.mod-row').forEach((r,i)=>{r.classList.toggle('sel',i===k);r.setAttribute('aria-selected',i===k)});
  $('#modView').classList.toggle('off',!on[k]);
  $('#modStatus').textContent=on[k]?'Installed':'Turned off';
  $('#modTitle').textContent=m.t;$('#modDesc').textContent=m.d||'';
  const more=$('#modMore');more.href=m.u;more.setAttribute('aria-label','Learn more about '+m.t);
  img.alt='Zeebroo zebra illustration for '+m.t;
  const swap=()=>{img.hidden=!m.img;if(m.img)img.src=m.img};
  if(changed&&!reduce){img.classList.add('swap');setTimeout(()=>{swap();img.classList.remove('swap')},180)}else swap();
}
$('#modList').onclick=e=>{
  const row=e.target.closest('.mod-row');if(!row)return;const k=+row.dataset.k;
  const s=e.target.closest('.sw');
  if(s){on[k]=!on[k];s.setAttribute('aria-checked',on[k]);row.classList.toggle('off',!on[k])}
  showMod(k);
};
$('#modList').onkeydown=e=>{const row=e.target.closest('.mod-row');if(row&&(e.key==='Enter'||e.key===' ')&&e.target===row){e.preventDefault();showMod(+row.dataset.k)}};
showMod(0);
/* autoplay: the active row's progress bar is the timer; hover pauses, a click hands control to the visitor */
const mods=$('.mods');let auto=!reduce;
if(auto){
  new IntersectionObserver(([e])=>mods.classList.toggle('cycling',auto&&e.isIntersecting),{threshold:.4}).observe(mods);
  mods.addEventListener('animationend',e=>{if(e.target.classList.contains('bar'))showMod((sel+1)%M.length)});
  mods.addEventListener('mouseenter',()=>mods.classList.add('paused'));
  mods.addEventListener('mouseleave',()=>mods.classList.remove('paused'));
  mods.addEventListener('focusin',()=>mods.classList.add('paused'));
  mods.addEventListener('focusout',()=>mods.classList.remove('paused'));
  $('#modList').addEventListener('click',()=>{auto=false;mods.classList.remove('cycling')},true);
}
}

/* ---------- finance map ---------- */
(function(){
  const L=[['Electricity Bill','Overdue',1],['Gas Bill','5,000.00, overdue',1],['Telephone Bill','Overdue',1],['Waste Bill','2,999.97, overdue',1],['Water Bill','Overdue',1],['Enterprise Loan','20,023.96 / month',0],['Car Rental','48,815.95 / month',0]];
  const R=[['POS Sales','Sales transactions'],['Quotations','Web panel'],['Invoices','Web panel'],['Credit Recovery','Outstanding credits']];
  let s='';
  const node=(x,y,w,h,t,sub,id,od)=>`<g class="nd${od?' od':''}" data-id="${id}" tabindex="0"><rect x="${x}" y="${y}" width="${w}" height="${h}" rx="${h/2}"/><text x="${x+26}" y="${y+h/2-3}">${t}</text><text class="s" x="${x+26}" y="${y+h/2+15}">${sub}</text></g>`;
  L.forEach((n,i)=>{const y=24+i*76+28;s+=`<path class="wire" id="wl${i}" d="M250 ${y} C 300 ${y}, 290 280, 330 280"/><path class="pulse ex" d="M330 280 C 290 280, 300 ${y}, 250 ${y}" style="animation-delay:${-i*.2}s"/>`});
  R.forEach((n,i)=>{const y=110+i*96+28;s+=`<path class="wire" id="wr${i}" d="M930 280 C 965 280, 955 ${y}, 990 ${y}"/><path class="pulse inc" d="M990 ${y} C 955 ${y}, 965 280, 930 280" style="animation-delay:${-i*.3}s"/>`});
  s+=`<path class="wire" d="M545 280 L500 280"/><path class="pulse ex" d="M545 280 L500 280"/><path class="wire" d="M780 280 L735 280"/><path class="pulse inc" d="M780 280 L735 280"/>`;
  L.forEach((n,i)=>s+=node(20,24+i*76,230,56,n[0],n[1],'l'+i,n[2]));
  R.forEach((n,i)=>s+=node(990,110+i*96,230,56,n[0],n[1],'r'+i));
  s+=`<g class="nd hub"><rect x="330" y="244" width="170" height="72" rx="36" style="stroke:#FF7A7E"/><text x="415" y="274" text-anchor="middle" style="fill:#FF7A7E">Expenses</text><text class="s" x="415" y="296" text-anchor="middle">106,839.88 / month</text></g>`;
  s+=`<g class="nd hub"><rect x="545" y="244" width="190" height="72" rx="36" style="fill:#FFCB2F;stroke:#FFCB2F"/><text x="640" y="287" text-anchor="middle" style="fill:#121212">Your business</text></g>`;
  s+=`<g class="nd hub"><rect x="780" y="244" width="150" height="72" rx="36" style="stroke:#4ADE80"/><text x="855" y="274" text-anchor="middle" style="fill:#4ADE80">Income</text><text class="s" x="855" y="296" text-anchor="middle">4 streams</text></g>`;
  const f=$('#flow');f.innerHTML=s;
  f.querySelectorAll('.nd[data-id]').forEach(g=>{
    const w=f.querySelector('#w'+g.dataset.id), hl=v=>{g.classList.toggle('hl',v);w.classList.toggle('hl',v)};
    g.addEventListener('mouseenter',()=>hl(true));g.addEventListener('mouseleave',()=>hl(false));
    g.addEventListener('focus',()=>hl(true));g.addEventListener('blur',()=>hl(false));
  });
})();

/* ---------- manifesto words (revealed by CSS scroll timeline where supported) ---------- */
const mf=$('#manifesto');
mf.innerHTML=mf.innerHTML.split('<br>').map(l=>l.split(' ').map(w=>`<span class="w">${w}</span>`).join(' ')).join('<br>');

/* ---------- reveal, counters, step markers ---------- */
const io=new IntersectionObserver(es=>es.forEach(e=>{
  if(!e.isIntersecting)return;
  e.target.classList.add('in');
  e.target.querySelectorAll('[data-count]').forEach(el=>countTo(el,+el.dataset.count,el.dataset.pre||''));
  io.unobserve(e.target);
}),{threshold:.18,rootMargin:'0px 0px -40px 0px'});
$$('.reveal').forEach(el=>io.observe(el));
const so=new IntersectionObserver(es=>es.forEach(e=>e.isIntersecting&&e.target.classList.add('in')),{rootMargin:'0px 0px -45% 0px'});
$$('.step').forEach(el=>so.observe(el));
