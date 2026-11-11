document.querySelectorAll('[data-open]').forEach(b=>b.onclick=e=>{e.preventDefault();const d=document.getElementById(b.dataset.open);
 Object.entries(b.dataset).forEach(([k,v])=>{d.querySelectorAll('[data-fill="'+k+'"]').forEach(n=>n.tagName=='INPUT'?n.value=v:n.textContent=v)});d.showModal()});
document.querySelectorAll('[data-close]').forEach(b=>b.onclick=e=>{e.preventDefault();b.closest('dialog').close()});
const auto=document.querySelector('dialog[data-auto]');if(auto)auto.showModal();
