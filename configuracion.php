<?php
session_start();
function db(): PDO {
  static $p; if ($p) return $p;
  $new = !file_exists(__DIR__.'/aqua.sqlite');
  $p = new PDO('sqlite:'.__DIR__.'/aqua.sqlite');
  $p->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $p->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  if ($new) seed($p);
  return $p;
}
function seed(PDO $p) {
  $p->exec("CREATE TABLE usuarios(id INTEGER PRIMARY KEY,nombre,email,telefono,rol,estado);
  CREATE TABLE instalaciones(id INTEGER PRIMARY KEY,nombre,tipo,direccion,responsable_id INT,estado);
  CREATE TABLE medidores(id INTEGER PRIMARY KEY,codigo,serie,instalacion_id INT,estado,instalado);
  CREATE TABLE lecturas(id INTEGER PRIMARY KEY,fecha,medidor_id INT,consumo REAL,obs,por,variacion REAL);
  CREATE TABLE alertas(id INTEGER PRIMARY KEY,titulo,detalle,nivel,info,fecha,estado DEFAULT 'pendiente');
  CREATE TABLE mensual(mes,m3);CREATE TABLE por_inst(nombre,m3,var);
  CREATE TABLE config(k PRIMARY KEY,v);");
  $ins = fn($t,$rows)=>array_map(fn($r)=>$p->prepare("INSERT INTO $t VALUES(".implode(',',array_fill(0,count($r),'?')).")")->execute($r),$rows);
  $ins('usuarios',[[1,'Laura Martínez','laura.martinez@losolivos.co','310 456 7890','Administradora','Activo'],[2,'Carlos Rodríguez','carlos.rodriguez@losolivos.co','311 234 5678','Operador','Activo'],[3,'Ana López','ana.lopez@losolivos.co','315 678 9012','Residente','Activo'],[4,'Juan Pérez','juan.perez@losolivos.co','300 987 6543','Residente','Activo'],[5,'María García','maria.garcia@losolivos.co','320 123 4567','Operadora','Inactivo'],[6,'Diego Ramírez','diego.ramirez@losolivos.co','312 567 8901','Residente','Activo']]);
  $ins('instalaciones',[[1,'Torre Norte','Edificio','Calle 85 # 12-30, Bogotá',2,'Activa'],[2,'Torre Sur','Edificio','Calle 85 # 12-32, Bogotá',1,'Activa'],[3,'Apto. 301 · Torre Norte','Apartamento','Calle 85 # 12-30, Apto. 301',3,'Activa'],[4,'Apto. 502 · Torre Sur','Apartamento','Calle 85 # 12-32, Apto. 502',4,'Activa'],[5,'Edificio Central','Edificio','Carrera 15 # 93-45, Bogotá',5,'Activa'],[6,'Oficinas Aqua','Empresa','Avenida 19 # 100-20, Bogotá',6,'Inactiva']]);
  $ins('medidores',[[1,'MED-001','AQ-2024-0001',3,'Activo','15 ene 2024'],[2,'MED-018','AQ-2024-0018',4,'Activo','10 feb 2024'],[3,'MED-043','AQ-2024-0043',5,'Activo','03 mar 2024'],[4,'MED-062','AQ-2025-0062',6,'Activo','21 ene 2025'],[5,'MED-097','AQ-2025-0097',1,'Sin conexión','09 jun 2025'],[6,'MED-128','AQ-2026-0128',2,'Mantenimiento','12 ene 2026']]);
  $ins('lecturas',[[1,'2026-06-30',1,24.8,'','Carlos Rodríguez',37.8],[2,'2026-06-30',2,18.2,'','Carlos Rodríguez',-12.0],[3,'2026-06-29',3,86.5,'','Laura Martínez',-4.1],[4,'2026-06-29',4,42.1,'','Laura Martínez',-6.5],[5,'2026-06-28',5,21.4,'','Carlos Rodríguez',2.4],[6,'2026-06-27',6,16.8,'','Carlos Rodríguez',-3.2]]);
  $ins('alertas',[[1,'Consumo inusual','Torre Norte · Apto. 301 · MED-001','Crítica','+37,8 % vs. mes anterior','Hace 20 min','pendiente'],[2,'Posible fuga de agua','Edificio Central · MED-043','Crítica','+42,3 % vs. promedio diario','Hace 1 h','pendiente'],[3,'Medidor sin conexión','Torre Norte · Apto. 604 · MED-097','Advertencia','Sin comunicación desde hace 24 h','Hace 2 h','pendiente'],[4,'Consumo en aumento','Oficinas Aqua · MED-062','Advertencia','+24,1 % vs. promedio diario','Hace 3 h','pendiente'],[5,'Lectura pendiente','Torre Sur · Apto. 108 · MED-128','Advertencia','Sin lectura del período actual','Hace 5 h','pendiente'],[6,'Consumo dentro del objetivo','Torre Sur · Apto. 502 · MED-018','Normal','−12,0 % frente al mes anterior','Hoy · 08:15','resuelta']]);
  $ins('mensual',[['Ene',14200],['Feb',13500],['Mar',15100],['Abr',14300],['May',13600],['Jun',12480]]);
  $ins('por_inst',[['Torre Norte',3240,-5.6],['Torre Sur',2860,-12.0],['Edificio Central',2240,-4.1],['Oficinas Aqua',1860,-6.5],['Otros',2280,-10.0]]);
  $ins('config',[['org','Residencial Los Olivos'],['nit','901.234.567-8'],['correo','administracion@losolivos.co'],['tel','601 345 6789'],['warn','20'],['crit','35'],['n1','1'],['n2','1'],['n3','0']]);
}
function h($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function nf($n,$d=0){return number_format((float)$n,$d,',','.');}
function cfg($k){static $c; $c=$c??array_column(db()->query("SELECT k,v FROM config")->fetchAll(),'v','k'); return $c[$k]??'';}
function badge($t){$m=['Activo'=>'ok','Activa'=>'ok','Inactivo'=>'mute','Inactiva'=>'mute','Sin conexión'=>'warn','Mantenimiento'=>'bad','Crítica'=>'bad','Advertencia'=>'warn','Normal'=>'ok'];return '<span class="b '.($m[$t]??'mute').'">• '.h($t).'</span>';}
function redirect($u){header("Location: $u");exit;}
