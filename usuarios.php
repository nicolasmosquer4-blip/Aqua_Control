<?php
require_once __DIR__.'/db.php';
function head(string $key,string $title,string $sub,string $actions=''){
  $nav=['index'=>['Dashboard','▦'],'usuarios'=>['Usuarios','☺'],'instalaciones'=>['Instalaciones','▤'],'medidores'=>['Medidores','◔'],'lecturas'=>['Lecturas de consumo','☰'],'alertas'=>['Alertas','♢'],'reportes'=>['Reportes','▥'],'configuracion'=>['Configuración','⚙']];
  $pend=db()->query("SELECT COUNT(*) FROM alertas WHERE estado='pendiente' AND nivel!='Normal'")->fetchColumn();
  echo '<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>AquaControl · '.h($title).'</title><link rel="stylesheet" href="assets/style.css"></head><body>';
  echo '<aside class="side"><div class="logo"><i>💧</i> AquaControl</div><small class="tag">GESTIÓN INTELIGENTE DEL AGUA</small><hr><small class="ws">ESPACIO DE TRABAJO</small><nav>';
  foreach($nav as $k=>[$l,$i]) echo '<a href="'.$k.'.php" class="'.($k==$key?'on':'').'"><span>'.$i.'</span>'.h($l).($k=='alertas'?'<em>'.$pend.'</em>':'').'</a>';
  echo '</nav><div class="tip"><b>Cada gota cuenta</b><p>Un 8,2 % menos de consumo frente al mes anterior.</p></div><a class="help">? Centro de ayuda</a></aside>';
  echo '<div class="main"><header class="top"><div><small>Organización</small><b>'.h(cfg('org')).' ⌄</b></div><div class="r"><span class="on">● Sistema en línea</span> 🔔 <div><b>Laura Martínez</b><small>Administradora</small></div></div></header><main>';
  echo '<small class="crumb">ADMINISTRACIÓN / '.h(mb_strtoupper($title)).'</small><div class="ph"><div><h1>'.h($title).'</h1><p>'.h($sub).'</p></div><div class="acts">'.$actions.'</div></div>';
  if(!empty($_SESSION['flash'])){echo '<div class="flash">'.h($_SESSION['flash']).'</div>';unset($_SESSION['flash']);}
}
function foot(){echo '</main><footer><span>AquaControl / Gestión inteligente del agua</span><span>Datos de demostración · Junio 2026</span></footer></div><script src="assets/app.js"></script></body></html>';}
function flash($m){$_SESSION['flash']=$m;}
function pager($n,$t){return '<div class="pg"><small>Mostrando 1–'.$n.' de '.$t.' registros</small><div><button class="btn">Anterior</button><b class="pn">1</b><button class="btn">Siguiente</button></div></div>';}
function line_chart(array $rows){ // SVG de línea
  $w=560;$h=170;$max=16000;$min=10000;$pts=[];$n=count($rows);
  foreach($rows as $i=>$r){$x=30+$i*($w-50)/($n-1);$y=$h-20-(($r['m3']-$min)/($max-$min))*($h-40);$pts[]=[$x,$y,$r['mes']];}
  $l=implode(' ',array_map(fn($p)=>round($p[0]).','.round($p[1]),$pts));
  $s='<svg viewBox="0 0 '.$w.' '.($h+10).'" class="chart"><polygon points="30,'.($h-20).' '.$l.' '.end($pts)[0].','.($h-20).'" fill="#e8f3fb"/><polyline points="'.$l.'" fill="none" stroke="#2196d3" stroke-width="3"/>';
  foreach($pts as $p)$s.='<circle cx="'.$p[0].'" cy="'.$p[1].'" r="4" fill="#fff" stroke="#2196d3" stroke-width="2"/><text x="'.$p[0].'" y="'.($h+5).'" text-anchor="middle" font-size="11" fill="#7b8a9a">'.$p[2].'</text>';
  return $s.'</svg>';
}
