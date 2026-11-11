<?php require 'layout.php'; $d=db();
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(($_POST['accion']??'')=='del'){$d->prepare("DELETE FROM usuarios WHERE id=?")->execute([$_POST['id']]);flash('Usuario eliminado.');}
  elseif(trim($_POST['nombre']??'')&&filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL)){
    $v=[trim($_POST['nombre']),$_POST['email'],trim($_POST['telefono']),$_POST['rol'],$_POST['estado']];
    if(!empty($_POST['id'])){$d->prepare("UPDATE usuarios SET nombre=?,email=?,telefono=?,rol=?,estado=? WHERE id=?")->execute([...$v,$_POST['id']]);flash('Usuario actualizado.');}
    else{$d->prepare("INSERT INTO usuarios(nombre,email,telefono,rol,estado) VALUES(?,?,?,?,?)")->execute($v);flash('Invitación enviada a '.$_POST['email'].'.');}
  } else flash('Revisa los campos obligatorios.');
  redirect('usuarios.php');
}
$q=trim($_GET['q']??'');$rol=$_GET['rol']??'';$est=$_GET['estado']??'';
$sql="SELECT * FROM usuarios WHERE (nombre LIKE :q OR email LIKE :q)".($rol?" AND rol LIKE :r":"").($est?" AND estado=:e":"");
$st=$d->prepare($sql);$st->bindValue(':q',"%$q%");if($rol)$st->bindValue(':r',"$rol%");if($est)$st->bindValue(':e',$est);$st->execute();$rows=$st->fetchAll();
$ed=null;if(isset($_GET['edit'])){$s=$d->prepare("SELECT * FROM usuarios WHERE id=?");$s->execute([$_GET['edit']]);$ed=$s->fetch();}
head('usuarios','Usuarios','Administra los accesos y el equipo de tu organización.','<a class="btn" href="#">↓ Exportar</a><a class="btn-p" href="#form">+ Nuevo usuario</a>'); ?>
<div class="card"><h3>Todos los usuarios <small class="sub"><?=count($rows)?></small></h3>
<form class="tools" method="get"><input name="q" placeholder="⌕ Buscar por nombre o correo" value="<?=h($q)?>">
<select name="rol" onchange="this.form.submit()"><option value="">Todos los roles</option><?php foreach(['Administrador','Operador','Residente'] as $r)echo '<option '.($rol==$r?'selected':'').'>'.$r.'</option>'?></select>
<select name="estado" onchange="this.form.submit()"><option value="">Estado: todos</option><option <?=$est=='Activo'?'selected':''?>>Activo</option><option <?=$est=='Inactivo'?'selected':''?>>Inactivo</option></select></form>
<table><tr><th>Nombre</th><th>Correo electrónico</th><th>Teléfono</th><th>Rol</th><th>Estado</th><th>Acciones</th></tr>
<?php foreach($rows as $u): ?><tr><td><b><?=h($u['nombre'])?></b></td><td><?=h($u['email'])?></td><td><?=h($u['telefono'])?></td><td><?=h($u['rol'])?></td><td><?=badge($u['estado'])?></td>
<td><a href="?edit=<?=$u['id']?>#form">Editar</a> <button class="del" data-open="dlgDel" data-id="<?=$u['id']?>" data-nombre="<?=h($u['nombre'])?>" data-info="<?=h($u['email'].' · '.$u['rol'])?>">🗑</button></td></tr><?php endforeach ?></table>
<?=pager(count($rows),24)?></div>
<div class="card" id="form"><h3><?=$ed?'Editar usuario':'Registrar usuario'?></h3><p>Completa los datos para enviar una invitación de acceso.</p>
<form class="f" method="post"><input type="hidden" name="id" value="<?=h($ed['id']??'')?>">
<label>Nombre completo *<input name="nombre" required placeholder="Ej. Carlos Rodríguez" value="<?=h($ed['nombre']??'')?>"></label>
<label>Correo electrónico *<input type="email" name="email" required placeholder="nombre@empresa.com" value="<?=h($ed['email']??'')?>"></label>
<label>Teléfono<input name="telefono" placeholder="Ej. 310 456 7890" value="<?=h($ed['telefono']??'')?>"></label>
<label>Rol de acceso *<select name="rol" required><option value="">Selecciona un rol</option><?php foreach(['Administradora','Operador','Operadora','Residente'] as $r)echo '<option '.(($ed['rol']??'')==$r?'selected':'').'>'.$r.'</option>'?></select></label>
<label>Estado *<select name="estado"><option>Activo</option><option <?=($ed['estado']??'')=='Inactivo'?'selected':''?>>Inactivo</option></select></label>
<div class="fa"><a class="btn" href="usuarios.php">Cancelar</a><button class="btn-p"><?=$ed?'Guardar cambios':'Enviar invitación'?></button></div></form></div>
<dialog id="dlgDel"><form method="post"><input type="hidden" name="accion" value="del"><input type="hidden" name="id" data-fill="id">
<span class="b bad" style="font-size:22px">🗑</span><h2>¿Eliminar este usuario?</h2><p class="sub"><b data-fill="nombre"></b> dejará de tener acceso a AquaControl. Sus lecturas y registros históricos se conservarán.</p>
<div class="box"><b data-fill="nombre"></b><br><small data-fill="info"></small></div><small style="color:var(--bad)">Esta acción no se puede deshacer.</small>
<div class="ft"><button class="btn" data-close>Cancelar</button><button class="btn-d">Eliminar usuario</button></div></form></dialog>
<?php foot();
