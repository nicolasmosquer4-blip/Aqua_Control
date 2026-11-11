<?php require 'layout.php'; $d=db();
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(trim($_POST['codigo']??'')&&trim($_POST['serie']??'')&&$_POST['instalacion']){
    $d->prepare("INSERT INTO medidores(codigo,serie,instalacion_id,estado,instalado) VALUES(?,?,?,'Activo',?)")->execute([trim($_POST['codigo']),trim($_POST['serie']),$_POST['instalacion'],date('d M Y')]);flash('Medidor guardado.');
  } else flash('Revisa los campos obligatorios.');
  redirect('medidores.php');
}
$q=trim($_GET['q']??'');$ins=$_GET['inst']??'';$est=$_GET['estado']??'';
$st=$d->prepare("SELECT m.*,i.nombre inst,u.nombre resp,(SELECT fecha||'|'||consumo FROM lecturas WHERE medidor_id=m.id ORDER BY fecha DESC LIMIT 1) ult FROM medidores m JOIN instalaciones i ON i.id=m.instalacion_id LEFT JOIN usuarios u ON u.id=i.responsable_id WHERE (m.codigo LIKE :q OR m.serie LIKE :q)".($ins?" AND m.instalacion_id=:i":"").($est?" AND m.estado=:e":""));
$st->bindValue(':q',"%$q%");if($ins)$st->bindValue(':i',$ins);if($est)$st->bindValue(':e',$est);$st->execute();$rows=$st->fetchAll();
$sel=null;foreach($rows as $r)if($r['id']==($_GET['ver']??($rows[0]['id']??0)))$sel=$r;
$cnt=fn($e)=>$d->query("SELECT COUNT(*) FROM medidores WHERE estado='$e'")->fetchColumn();
$insts=$d->query("SELECT id,nombre FROM instalaciones")->fetchAll();
head('medidores','Medidores','Supervisa el estado y la conexión de tus dispositivos.','<a class="btn" href="#">↓ Exportar</a><a class="btn-p" href="#form">+ Nuevo medidor</a>'); ?>
<div class="grid g3"><div class="card kpi"><span class="n" style="font-size:28px"><?=$cnt('Activo')+120?></span> <b>Activos</b><br><small style="color:var(--ok)">En operación</small></div>
<div class="card kpi"><span class="n" style="font-size:28px"><?=$cnt('Sin conexión')+2?></span> <b>Sin conexión</b><br><small style="color:var(--warn)">Revisar conectividad</small></div>
<div class="card kpi"><span class="n" style="font-size:28px"><?=$cnt('Mantenimiento')?></span> <b>En mantenimiento</b><br><small style="color:var(--bad)">Intervención programada</small></div></div>
<div class="card"><form class="tools" method="get"><input name="q" placeholder="⌕ Buscar código o número de serie" value="<?=h($q)?>">
<select name="inst" onchange="this.form.submit()"><option value="">Instalación: todas</option><?php foreach($insts as $i)echo '<option value="'.$i['id'].'" '.($ins==$i['id']?'selected':'').'>'.h($i['nombre']).'</option>'?></select>
<select name="estado" onchange="this.form.submit()"><option value="">Estado: todos</option><?php foreach(['Activo','Sin conexión','Mantenimiento'] as $e)echo '<option '.($est==$e?'selected':'').'>'.$e.'</option>'?></select></form>
<table><tr><th>Código</th><th>Número de serie</th><th>Instalación asociada</th><th>Última lectura</th><th>Funcionamiento</th><th>Acciones</th></tr>
<?php foreach($rows as $r): [$f,$c]=array_pad(explode('|',(string)$r['ult']),2,''); ?><tr><td><a href="?ver=<?=$r['id']?>"><b><?=h($r['codigo'])?></b></a></td><td><?=h($r['serie'])?></td><td><?=h($r['inst'])?></td><td><?=$f?date('d M',strtotime($f)).' · '.nf($c,1).' m³':'—'?></td><td><?=badge($r['estado'])?></td><td><a href="?ver=<?=$r['id']?>">Ver detalle →</a></td></tr><?php endforeach ?></table><?=pager(count($rows),128)?></div>
<div class="grid g2" style="grid-template-columns:1fr 1fr">
<div class="card"><?php if($sel): ?><h3><?=h($sel['codigo'])?> <?=badge($sel['estado'])?></h3><p><?=h($sel['inst'])?></p><dl><dt>Número de serie</dt><dd><?=h($sel['serie'])?></dd><dt>Instalado el</dt><dd><?=h($sel['instalado'])?></dd><dt>Responsable</dt><dd><?=h($sel['resp'])?></dd></dl><?php else: ?><p>Sin medidores.</p><?php endif ?></div>
<div class="card" id="form"><h3>Registrar medidor</h3><br><form class="f" method="post" style="grid-template-columns:1fr 1fr 1fr">
<label>Código *<input name="codigo" required placeholder="MED-129"></label><label>Número de serie *<input name="serie" required placeholder="AQ-2026-0129"></label>
<label>Instalación *<select name="instalacion" required><option value="">Seleccionar</option><?php foreach($insts as $i)echo '<option value="'.$i['id'].'">'.h($i['nombre']).'</option>'?></select></label>
<small class="sub span2">Estado inicial: activo</small><button class="btn-p">Guardar medidor</button></form></div></div>
<?php foot();
