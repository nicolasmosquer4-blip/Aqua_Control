<?php require 'layout.php'; $d=db();
if($_SERVER['REQUEST_METHOD']=='POST'){
  $s=$d->prepare("INSERT OR REPLACE INTO config(k,v) VALUES(?,?)");
  foreach(['org','nit','correo','tel','warn','crit'] as $k)if(isset($_POST[$k]))$s->execute([$k,trim($_POST[$k])]);
  foreach(['n1','n2','n3'] as $k)$s->execute([$k,isset($_POST[$k])?'1':'0']);
  flash('Configuración guardada.');redirect('configuracion.php');
}
head('configuracion','Configuración','Personaliza tu sistema y administra tu cuenta.','<button class="btn" form="cfg" type="reset">Restablecer</button><button class="btn-p" form="cfg">Guardar cambios</button>'); ?>
<div class="tabs"><a class="on">General</a><a>Cuenta y seguridad</a><a>Integraciones</a></div>
<form id="cfg" method="post"><div class="grid g21"><div class="card"><h3>Datos generales</h3><p>Información de la organización y preferencias regionales.</p><div class="f" style="grid-template-columns:1fr 1fr">
<label>Nombre de la organización *<input name="org" required value="<?=h(cfg('org'))?>"></label><label>Identificación tributaria<input name="nit" value="<?=h(cfg('nit'))?>"></label>
<label>Correo de contacto *<input type="email" name="correo" required value="<?=h(cfg('correo'))?>"></label><label>Teléfono<input name="tel" value="<?=h(cfg('tel'))?>"></label></div><small class="sub">Zona horaria: Bogotá (GMT−5) · Idioma: Español · Unidad: m³</small></div>
<div class="card"><h3>Umbrales de alertas</h3><p>Comparación con el período anterior.</p><div class="f" style="grid-template-columns:1fr 1fr"><label>Advertencia a partir de (%)<input type="number" name="warn" min="1" value="<?=h(cfg('warn'))?>"></label><label>Crítica a partir de (%)<input type="number" name="crit" min="1" value="<?=h(cfg('crit'))?>"></label></div>
<div class="info" style="margin-top:16px"><b>Un monitoreo que se adapta a ti</b><br>Las desviaciones generan alertas para el equipo administrador.</div></div></div>
<div class="grid g21"><div class="card"><h3>Datos del administrador</h3><p>Gestiona tu información personal y el acceso a AquaControl.</p><div class="f" style="grid-template-columns:1fr 1fr"><label>Nombre completo *<input value="Laura Martínez" readonly></label><label>Correo electrónico *<input value="laura.martinez@losolivos.co" readonly></label><label>Teléfono<input value="310 456 7890" readonly></label><label>Rol de acceso<input value="Administradora · Solo lectura" readonly></label></div><small class="sub">Último acceso: 30 jun 2026, 08:45</small></div>
<div class="card"><h3>Notificaciones</h3><?php foreach(['n1'=>['Alertas críticas por correo','Recibe avisos para actuar a tiempo.'],'n2'=>['Resumen semanal','Un reporte cada lunes a las 08:00.'],'n3'=>['Lecturas registradas','Un aviso por cada nuevo registro.']] as $k=>[$t,$s]) echo '<label class="sw"><span><b>'.$t.'</b><small>'.$s.'</small></span><input type="checkbox" name="'.$k.'" '.(cfg($k)?'checked':'').'></label>' ?></div></div></form>
<div class="info">ⓘ Los cambios se aplicarán a toda la organización al guardar la configuración.</div>
<?php foot();
