<?php require 'layout.php'; $d=db();
$tot=$d->query("SELECT m3 FROM mensual WHERE mes='Jun'")->fetchColumn();
$inst=$d->query("SELECT COUNT(*) FROM instalaciones")->fetchColumn()+42;
$act=$d->query("SELECT COUNT(*) FROM medidores WHERE estado='Activo'")->fetchColumn()+120;
$pend=$d->query("SELECT COUNT(*) FROM alertas WHERE estado='pendiente' AND nivel!='Normal'")->fetchColumn();
$crit=$d->query("SELECT COUNT(*) FROM alertas WHERE estado='pendiente' AND nivel='Crítica'")->fetchColumn();
head('index','Dashboard','Una visión clara de cada gota.','<select class="btn"><option>Junio 2026</option></select><a class="btn-p" href="reportes.php">↓ Exportar</a>'); ?>
<div class="grid g4">
 <div class="card kpi"><small>Consumo total</small><div class="n"><?=nf($tot)?> <span>m³</span></div><span class="b ok">↘ 8,2 %</span> <small>vs. mayo 2026</small></div>
 <div class="card kpi"><small>Instalaciones registradas</small><div class="n"><?=$inst?></div><span class="b info">+ 3 nuevas</span> <small>este mes</small></div>
 <div class="card kpi"><small>Medidores activos</small><div class="n"><?=$act?> <span>/ 128</span></div><span class="b ok">96,9 %</span> <small>de disponibilidad</small></div>
 <div class="card kpi"><small>Alertas pendientes</small><div class="n"><?=$pend?></div><span class="b warn"><?=$crit?> críticas</span> <small>requieren atención</small></div>
</div>
<div class="grid g2">
 <div class="card"><h3>Evolución del consumo</h3><p>Consumo mensual en metros cúbicos</p><?=line_chart($d->query("SELECT * FROM mensual")->fetchAll())?></div>
 <div class="card"><h3>Consumo por instalación</h3><p>Las 5 instalaciones con mayor consumo</p>
 <?php foreach($d->query("SELECT * FROM por_inst")->fetchAll() as $i=>$r): ?>
  <div class="bar <?=$i?'':'top'?>"><span><?=h($r['nombre'])?></span><div><i style="width:<?=$r['m3']/3500*100?>%"></i></div><b><?=$r['m3']?></b></div>
 <?php endforeach ?><small class="sub">m³ · Junio 2026</small></div>
</div>
<div class="grid g2">
 <div class="card"><h3>Últimas lecturas</h3><table><tr><th>Instalación</th><th>Medidor</th><th>Fecha</th><th>Consumo</th></tr>
 <?php foreach($d->query("SELECT l.*,m.codigo,i.nombre inst FROM lecturas l JOIN medidores m ON m.id=l.medidor_id JOIN instalaciones i ON i.id=m.instalacion_id ORDER BY fecha DESC,l.id DESC LIMIT 4") as $r): ?>
  <tr><td><b><?=h($r['inst'])?></b></td><td><?=h($r['codigo'])?></td><td><?=date('d M Y',strtotime($r['fecha']))?></td><td><?=nf($r['consumo'],1)?> m³</td></tr>
 <?php endforeach ?></table><p style="text-align:right"><a href="lecturas.php">Ver historial →</a></p></div>
 <div class="card"><h3>Requieren tu atención <span class="b warn"><?=$pend?> pendientes</span></h3>
 <?php foreach($d->query("SELECT * FROM alertas WHERE estado='pendiente' AND nivel!='Normal' LIMIT 3") as $a): ?>
  <a class="al <?=h($a['nivel'])?>" href="alertas.php?id=<?=$a['id']?>"><div><b><?=h($a['titulo'])?></b><small><?=h($a['info'])?></small></div></a>
 <?php endforeach ?></div>
</div>
<?php foot();
