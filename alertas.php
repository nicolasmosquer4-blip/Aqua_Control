<?php require 'layout.php'; $d=db();
if($_SERVER['REQUEST_METHOD']=='POST'){$d->prepare("UPDATE alertas SET estado='resuelta' WHERE id=?")->execute([$_POST['id']]);flash('Alerta marcada como resuelta.');redirect('alertas.php');}
$f=$_GET['nivel']??'';$rows=$d->query("SELECT * FROM alertas".($f?" WHERE nivel=".$d->quote($f):"")." ORDER BY estado='resuelta',id")->fetchAll();
$c=fn($n)=>$d->query("SELECT COUNT(*) FROM alertas WHERE nivel='$n'")->fetchColumn();
$sel=null;foreach($rows as $r)if($r['id']==($_GET['id']??($rows[0]['id']??0)))$sel=$r;
head('alertas','Alertas','Detecta desviaciones y actúa a tiempo.','<a class="btn" href="configuracion.php">Configurar umbrales</a>'); ?>
<div class="grid g3"><div class="card kpi"><span class="n" style="font-size:28px"><?=$c('Crítica')?></span> <b>Alertas críticas</b><br><small>Variaciones superiores al <?=cfg('crit')?> %</small></div>
<div class="card kpi"><span class="n" style="font-size:28px"><?=$c('Advertencia')?></span> <b>Advertencias</b><br><small>Requieren revisión preventiva</small></div>
<div class="card kpi"><span class="n" style="font-size:28px"><?=$c('Normal')+7?></span> <b>Registros normales</b><br><small>Dentro del rango esperado</small></div></div>
<div class="grid" style="grid-template-columns:3fr 2fr"><div class="card"><h3>Actividad reciente</h3><p><?=count($rows)?> registros</p>
<div class="tabs"><a class="<?=$f?'':'on'?>" href="alertas.php">Todas</a><a class="<?=$f=='Crítica'?'on':''?>" href="?nivel=Crítica">Críticas</a><a class="<?=$f=='Advertencia'?'on':''?>" href="?nivel=Advertencia">Advertencias</a><a class="<?=$f=='Normal'?'on':''?>" href="?nivel=Normal">Normales</a></div>
<?php foreach($rows as $r): ?><a class="al <?=h($r['nivel'])?>" href="?id=<?=$r['id']?>"><div><b><?=h($r['titulo'])?></b><small><?=h($r['detalle'])?></small><small style="color:var(--<?=['Crítica'=>'bad','Advertencia'=>'warn','Normal'=>'ok'][$r['nivel']]?>)"><?=h($r['info'])?></small></div><div class="x"><?=badge($r['nivel'])?><small><?=h($r['fecha'])?></small></div></a><?php endforeach ?></div>
<div class="card"><?php if($sel): ?><?=badge($sel['nivel'])?> <small style="float:right">ALR-<?=str_pad($sel['id'],3,'0',STR_PAD_LEFT)?></small><h2><?=h($sel['titulo'])?></h2><p><?=h($sel['detalle'])?></p><hr style="border:0;border-top:1px solid var(--line)">
<b>Detalle</b><p class="sub"><?=h($sel['info'])?></p><div class="info"><b>Acción recomendada</b><br>Verifica posibles fugas y confirma la lectura con el responsable de la instalación.</div><br>
<form method="post" class="fa"><input type="hidden" name="id" value="<?=$sel['id']?>"><a class="btn">Asignar revisión</a><button class="btn-p" <?=$sel['estado']=='resuelta'?'disabled':''?>><?=$sel['estado']=='resuelta'?'Resuelta':'Marcar resuelta'?></button></form><?php endif ?></div></div>
<?php foot();
