:root{--navy:#143a5c;--blue:#2196d3;--bg:#f3f6f9;--line:#e6ecf1;--txt:#143a5c;--mut:#7b8a9a;--ok:#1f8a5b;--okb:#e8f6ee;--warn:#b26a1a;--warnb:#fdf1e3;--bad:#b84a4a;--badb:#fdeaea}
*{box-sizing:border-box}body{margin:0;font:14px Inter,system-ui,sans-serif;color:var(--txt);background:var(--bg);display:flex;min-height:100vh}
.side{width:208px;background:var(--navy);color:#cfe0ee;padding:20px 12px;display:flex;flex-direction:column;position:sticky;top:0;height:100vh}
.logo{font-size:20px;font-weight:700;color:#fff;padding:0 8px}.logo i{background:#1f5a85;border-radius:8px;padding:4px 6px;font-style:normal;margin-right:6px}
.tag,.ws{font-size:9px;letter-spacing:.5px;padding:0 8px;display:block;margin-top:14px}.side hr{border:0;border-top:1px solid #2a5073;margin:14px 8px}
nav{margin-top:10px}nav a,.help{display:flex;gap:12px;align-items:center;padding:12px;border-radius:8px;color:#cfe0ee;text-decoration:none;margin-bottom:4px}nav a.on{background:#1f5a85;color:#fff;font-weight:600;box-shadow:inset 3px 0 #7fd0f5}
nav em{margin-left:auto;background:#e07b2a;color:#fff;font-style:normal;font-size:11px;padding:2px 7px;border-radius:5px}
.tip{margin-top:auto;background:#1d4d74;border-radius:10px;padding:16px;color:#fff}.tip p{font-size:11px;color:#bcd2e4;margin:6px 0 0}
.main{flex:1;min-width:0}.top{height:70px;background:#fff;border-bottom:1px solid var(--line);display:flex;justify-content:space-between;align-items:center;padding:0 28px}
.top small{display:block;color:var(--mut);font-size:11px}.top .r{display:flex;gap:20px;align-items:center}.top .on{color:var(--mut);font-size:12px}.top .on:first-letter{color:#22a06b}
main{padding:24px 28px}.crumb{color:var(--mut);font-size:11px}.ph{display:flex;justify-content:space-between;align-items:flex-start;margin:14px 0 24px}
h1{font-size:30px;margin:0}.ph p{color:var(--mut);margin:6px 0 0}.acts{display:flex;gap:12px}
.btn,.btn-p,.btn-d{border:1px solid var(--line);background:#fff;color:var(--txt);padding:10px 16px;border-radius:6px;font:inherit;cursor:pointer;text-decoration:none;display:inline-block}
.btn-p{background:var(--blue);border-color:var(--blue);color:#fff}.btn-d{background:var(--bad);border-color:var(--bad);color:#fff}
.card{background:#fff;border:1px solid var(--line);border-radius:10px;padding:20px;margin-bottom:20px}.card h3{margin:0 0 4px;font-size:17px}.card>p,.sub{color:var(--mut);font-size:12px;margin:2px 0 14px}
.grid{display:grid;gap:20px;margin-bottom:20px}.g4{grid-template-columns:repeat(4,1fr)}.g3{grid-template-columns:repeat(3,1fr)}.g2{grid-template-columns:3fr 2fr}.g21{grid-template-columns:2fr 1fr}.grid .card{margin:0}
.kpi small{color:var(--mut)}.kpi .n{font-size:32px;font-weight:700;margin:8px 0}.kpi .n span{font-size:14px;color:var(--mut);font-weight:400}
.b{display:inline-block;font-size:11px;padding:4px 9px;border-radius:5px}.b.ok{background:var(--okb);color:var(--ok)}.b.warn{background:var(--warnb);color:var(--warn)}.b.bad{background:var(--badb);color:var(--bad)}.b.mute{background:#eef1f4;color:var(--mut)}.b.info{background:#e8f3fb;color:var(--blue)}
table{width:100%;border-collapse:collapse}th{background:#f7f9fb;color:var(--mut);font-weight:400;text-align:left;padding:12px 8px;font-size:12px}td{padding:10px 8px;border-bottom:1px solid var(--line);font-size:13px}tr:hover td{background:#f5f9fc}td a{color:var(--blue);text-decoration:none}
.bar{display:flex;align-items:center;gap:12px;margin:14px 0;font-size:13px}.bar span{width:100px}.bar div{flex:1;height:10px;background:#eef3f7;border-radius:5px}.bar i{display:block;height:100%;background:#8fcbe8;border-radius:5px}.bar.top i{background:var(--blue)}
.chart{width:100%}.al{display:flex;gap:12px;padding:10px 0;border-bottom:1px solid var(--line);text-decoration:none;color:inherit}.al:before{content:"";width:4px;border-radius:2px;background:var(--bad)}.al.Advertencia:before{background:var(--warn)}.al.Normal:before{background:var(--ok)}.al small{display:block;color:var(--mut)}.al .x{margin-left:auto;text-align:right}
form.f{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}form.f label{font-weight:600;font-size:12px;display:block}input,select,textarea{width:100%;padding:11px;border:1px solid var(--line);border-radius:6px;font:inherit;margin-top:6px;background:#fff;color:var(--txt)}
.span2{grid-column:span 2}.fa{display:flex;gap:12px;align-items:end;justify-content:flex-end}.fa>*{flex:1}.tools{display:flex;gap:12px;margin-bottom:12px}.tools input{margin:0;flex:1}.tools select{width:200px;margin:0}
.pg{display:flex;justify-content:space-between;align-items:center;margin-top:14px;color:var(--mut)}.pn{background:#e8f3fb;color:var(--blue);padding:10px 14px;border-radius:6px;margin:0 8px}
.del{background:none;border:0;color:var(--bad);cursor:pointer;font-size:15px}.flash{background:var(--okb);color:var(--ok);padding:12px 16px;border-radius:8px;margin-bottom:16px}
.note{background:var(--warnb);color:var(--warn);padding:10px 14px;border-radius:6px;font-size:12px;margin-top:12px}.info{background:#eaf3fa;padding:14px;border-radius:8px;font-size:12px;color:var(--mut)}
.tabs{display:flex;gap:30px;border-bottom:1px solid var(--line);margin-bottom:20px}.tabs a{padding:12px 0;color:var(--mut);text-decoration:none}.tabs a.on{color:var(--blue);border-bottom:2px solid var(--blue)}
.sw{display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid var(--line)}.sw small{display:block;color:var(--mut)}.sw input{width:42px;height:22px;margin:0;accent-color:var(--blue)}
dl{display:grid;grid-template-columns:140px 1fr;gap:12px;color:var(--mut)}dd{margin:0;color:var(--txt);font-weight:600}
dialog{border:0;border-radius:16px;padding:32px;width:500px;box-shadow:0 20px 60px #0004}dialog::backdrop{background:#143a5c66}dialog h2{margin:12px 0 6px}dialog .box{background:#f3f6f9;padding:16px;border-radius:8px;margin:16px 0}dialog .ft{display:flex;gap:12px;justify-content:flex-end;margin-top:16px}
footer{display:flex;justify-content:space-between;color:var(--mut);font-size:11px;padding:20px 28px;border-top:1px solid var(--line);margin:0 28px}
@media(max-width:900px){.side{display:none}.g4,.g3,.g2,.g21,form.f{grid-template-columns:1fr}}
