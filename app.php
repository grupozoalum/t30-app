<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>T30 — Panel de Operador</title>
<style>
:root{
  --rosa:#E4007E;--rosa-fuerte:#FF3DA0;
  --azul:#3D63FF;--azul-suave:#1B3C7B;
  --ambar:#FFA20B;--verde:#22C55E;--rojo:#F2485B;
  --fondo:#080B14;--sup:#111726;--sup2:#161E32;--sup3:#1C2540;
  --borde:#232C46;--borde-suave:#1A2138;
  --txt:#EDF1FA;--txt2:#8B98BC;--txt3:#586182;
  --radio:10px;--radio-chico:6px;
  --mono:ui-monospace,SFMono-Regular,"SF Mono",Menlo,Consolas,monospace;
}
*{box-sizing:border-box}
html{color-scheme:dark}
body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:var(--fondo);color:var(--txt);-webkit-font-smoothing:antialiased}
button,input,select{font-family:inherit}
:focus-visible{outline:2px solid var(--rosa-fuerte);outline-offset:2px;border-radius:4px}
@media (prefers-reduced-motion:reduce){*{animation-duration:.001ms !important;transition-duration:.001ms !important}}

/* ── estructura ── */
.app{display:flex;min-height:100vh}
.sidebar{width:220px;flex:none;background:var(--sup);border-right:1px solid var(--borde-suave);display:flex;flex-direction:column;padding:1.3rem 1rem;gap:1.6rem;position:sticky;top:0;height:100vh}
.marca{display:flex;align-items:baseline;gap:.35rem;font-weight:800;font-size:1.15rem;letter-spacing:-.01em;padding:0 .3rem}
.marca em{color:var(--ambar);font-style:normal;font-weight:600;color:var(--txt2)}
.marca b{color:var(--rosa)}
.nav-lista{display:flex;flex-direction:column;gap:.2rem}
.nav-btn{display:flex;align-items:center;gap:.7rem;background:none;border:0;color:var(--txt2);font-weight:600;font-size:14px;cursor:pointer;padding:.6rem .7rem;border-radius:var(--radio-chico);text-align:left;transition:background-color .15s,color .15s}
.nav-btn svg{flex:none;width:18px;height:18px;stroke:currentColor}
.nav-btn:hover{background:var(--sup2);color:var(--txt)}
.nav-btn.activa{background:linear-gradient(90deg,rgba(228,0,126,.16),rgba(228,0,126,0));color:var(--txt);box-shadow:inset 2px 0 0 var(--rosa)}
.sidebar-pie{margin-top:auto;display:flex;flex-direction:column;gap:.5rem;padding:0 .3rem;border-top:1px solid var(--borde-suave);padding-top:1rem}
.estado-conexion{display:flex;align-items:center;gap:.45rem;font-size:12px;color:var(--txt2)}
.punto-vivo{width:8px;height:8px;border-radius:50%;background:var(--verde);box-shadow:0 0 0 0 rgba(34,197,94,.5);animation:pulso 2s infinite}
@keyframes pulso{0%{box-shadow:0 0 0 0 rgba(34,197,94,.45)}70%{box-shadow:0 0 0 6px rgba(34,197,94,0)}100%{box-shadow:0 0 0 0 rgba(34,197,94,0)}}
.reloj{font-family:var(--mono);font-size:12px;color:var(--txt3)}

.area-principal{flex:1;min-width:0;display:flex;flex-direction:column}
.topbar{display:flex;align-items:center;gap:1rem;padding:1.1rem 1.8rem;border-bottom:1px solid var(--borde-suave);background:linear-gradient(180deg,rgba(255,255,255,.02),transparent)}
.topbar h1{font-size:1.05rem;margin:0;font-weight:700}
.topbar .pista-top{color:var(--txt3);font-size:12.5px}

.cont{max-width:1240px;width:100%;margin:0 auto;padding:1.6rem 1.8rem 4rem}
.pagina{display:none}
.pagina.viva{display:block;animation:aparecer .18s ease-out}
@keyframes aparecer{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:none}}

.panel{background:var(--sup);border:1px solid var(--borde-suave);border-radius:var(--radio);padding:1.3rem 1.4rem;margin-bottom:1.3rem}
.panel-cab{display:flex;align-items:baseline;justify-content:space-between;gap:1rem;margin-bottom:.9rem}
.panel h2{margin:0;font-size:1rem;font-weight:700;display:flex;align-items:center;gap:.55rem}
.panel h2 svg{width:17px;height:17px;stroke:var(--txt2);flex:none}
.panel.panel-urgente{border-color:rgba(242,72,91,.4);box-shadow:0 0 0 1px rgba(242,72,91,.12)}
.contador{background:var(--sup3);color:var(--txt2);font-size:11.5px;font-weight:700;padding:.15rem .5rem;border-radius:99px;font-family:var(--mono)}
.pista{color:var(--txt3);font-size:12.5px;margin:.4rem 0 0}
.vacio{color:var(--txt3);font-size:13.5px;padding:1.1rem 0;text-align:center;border:1px dashed var(--borde);border-radius:var(--radio-chico)}

/* ── tira de estadísticas ── */
.fila-resumen{display:grid;grid-template-columns:repeat(4,1fr);gap:.8rem;margin-bottom:1.4rem}
.tarjetita{background:var(--sup);border:1px solid var(--borde-suave);border-left:3px solid var(--borde);border-radius:var(--radio-chico);padding:.9rem 1.1rem}
.tarjetita b{display:block;font-size:1.7rem;font-family:var(--mono);font-weight:700;line-height:1.15}
.tarjetita span{color:var(--txt3);font-size:12px}
.tarjetita.ok{border-left-color:var(--verde)}
.tarjetita.ok b{color:var(--verde)}
.tarjetita.alerta2{border-left-color:var(--ambar)}
.tarjetita.alerta2 b{color:var(--ambar)}
.tarjetita.urgente{border-left-color:var(--rojo);background:rgba(242,72,91,.06)}
.tarjetita.urgente b{color:var(--rojo)}
.tarjetita.urgente{animation:latido 1.6s ease-in-out infinite}
@keyframes latido{0%,100%{box-shadow:0 0 0 0 rgba(242,72,91,0)}50%{box-shadow:0 0 0 4px rgba(242,72,91,.12)}}

/* ── tablas ── */
table{width:100%;border-collapse:collapse;font-size:13.5px}
thead th{position:sticky;top:0;background:var(--sup);z-index:1}
th,td{text-align:left;padding:.65rem .55rem;border-bottom:1px solid var(--borde-suave);vertical-align:top}
th{color:var(--txt3);font-weight:700;font-size:11px;letter-spacing:.03em}
tbody tr:hover{background:rgba(255,255,255,.02)}
.dato-num{font-family:var(--mono);font-size:12.8px;color:var(--txt2)}

select{background:#0a0f1c;color:var(--txt);border:1px solid var(--borde);border-radius:var(--radio-chico);padding:.4rem .5rem}
.btn{background:var(--rosa);color:#fff;border:0;padding:.5rem .95rem;border-radius:var(--radio-chico);font-weight:700;cursor:pointer;font-size:13px;transition:filter .15s,transform .1s}
.btn:hover{filter:brightness(1.1)}
.btn:active{transform:scale(.98)}
.btn-ok{background:var(--verde)}
.btn-secundario{background:transparent;border:1px solid var(--borde);color:var(--txt2)}
.btn-secundario:hover{color:var(--txt);border-color:var(--txt2)}
.btn-sm{padding:.35rem .65rem;font-size:12px}

.sello{display:inline-block;padding:.2rem .6rem;border-radius:99px;font-size:11px;font-weight:700}
.sello-buscando,.sello-asignado,.sello-en_curso{background:rgba(255,162,11,.16);color:var(--ambar)}
.sello-completado{background:rgba(34,197,94,.16);color:var(--verde)}
.sello-cancelado{background:rgba(242,72,91,.16);color:var(--rojo)}

/* ── unidades: grid del dashboard ── */
.grid-unidades{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:.7rem}
.unidad-card{background:var(--sup2);border:1px solid var(--borde-suave);border-left:3px solid var(--borde);border-radius:var(--radio-chico);padding:.8rem;display:flex;flex-direction:column;gap:.3rem}
.unidad-card b{font-size:1rem;font-family:var(--mono)}
.unidad-card small{color:var(--txt3)}
.unidad-card.inactiva{opacity:.4}
.unidad-card.ocupado{border-left-color:var(--ambar)}
.unidad-card.disponible{border-left-color:var(--verde)}

/* ── unidades: tarjetas-formulario ── */
.tabla-unidades{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1rem}
.tarjeta-unidad{background:var(--sup2);border:1px solid var(--borde-suave);border-radius:var(--radio);padding:1.1rem;display:flex;flex-direction:column;gap:.4rem}
.tarjeta-unidad label{font-size:11px;color:var(--txt3);margin-top:.3rem;text-transform:none}
.tarjeta-unidad input[type=text]{background:#0a0f1c;border:1px solid var(--borde);color:var(--txt);padding:.55rem;border-radius:var(--radio-chico);font-family:var(--mono);font-size:13px}
.tarjeta-unidad input[type=text]:focus{border-color:var(--rosa)}
.tarjeta-unidad .btn{margin-top:.7rem}
.cab-unidad{display:flex;justify-content:space-between;align-items:center}
.cab-unidad b{font-family:var(--mono);font-size:1.05rem}
.switch{display:flex;align-items:center;gap:.4rem;font-size:12px;color:var(--txt2);cursor:pointer}
.switch input{accent-color:var(--rosa)}
.estado-actual{font-size:12px;color:var(--txt3);margin-top:.3rem;display:flex;align-items:center;gap:.4rem}

/* ── toasts ── */
.toast-pila{position:fixed;right:1.1rem;bottom:1.1rem;display:flex;flex-direction:column;gap:.5rem;z-index:100;max-width:320px}
.toast{background:var(--sup3);border:1px solid var(--borde);border-left:3px solid var(--azul);color:var(--txt);padding:.7rem .9rem;border-radius:var(--radio-chico);font-size:13px;box-shadow:0 8px 24px rgba(0,0,0,.35);opacity:0;transform:translateY(6px);transition:opacity .2s,transform .2s}
.toast.mostrar{opacity:1;transform:none}
.toast-exito{border-left-color:var(--verde)}
.toast-error{border-left-color:var(--rojo)}

/* ── responsive: la barra lateral se vuelve barra inferior ── */
@media (max-width:860px){
  .app{flex-direction:column}
  .sidebar{width:100%;height:auto;position:sticky;bottom:0;top:auto;order:2;flex-direction:row;align-items:center;padding:.5rem .7rem;gap:.5rem;border-right:0;border-top:1px solid var(--borde-suave)}
  .marca,.sidebar-pie{display:none}
  .nav-lista{flex-direction:row;flex:1;justify-content:space-around}
  .nav-btn{flex-direction:column;gap:.2rem;font-size:11px;padding:.4rem .6rem}
  .nav-btn.activa{box-shadow:inset 0 2px 0 var(--rosa)}
  .area-principal{order:1}
  .cont{padding:1.1rem 1rem 1.4rem}
  .fila-resumen{grid-template-columns:repeat(2,1fr)}
  .topbar{padding:.9rem 1rem}
}

/* ── taquilla ── */
.taq-caja{display:flex;gap:.6rem;align-items:stretch;flex-wrap:wrap}
.taq-caja input{flex:1;min-width:220px;background:#0a0f1c;color:var(--txt);border:1px solid var(--borde);
  border-radius:var(--radio-chico);padding:.75rem .8rem;font-family:var(--mono);font-size:1.05rem;letter-spacing:.06em}
.taq-caja input:focus{border-color:var(--rosa)}
.taq-video{width:100%;max-width:360px;border-radius:var(--radio);border:1px solid var(--borde);display:block;background:#000}
.taq-lector{display:none;margin-top:1rem}
.taq-lector.viva{display:block}
.taq-res{margin-top:1.2rem;border:1px solid var(--borde);border-radius:var(--radio);padding:1.1rem 1.2rem;background:var(--sup2)}
.taq-res.ok{border-color:rgba(34,197,94,.5);box-shadow:0 0 0 1px rgba(34,197,94,.15)}
.taq-res.mal{border-color:rgba(242,72,91,.5);box-shadow:0 0 0 1px rgba(242,72,91,.15)}
.taq-res h3{margin:0 0 .2rem;font-size:1.35rem}
.taq-res dl{display:grid;grid-template-columns:auto 1fr;gap:.35rem .9rem;margin:.9rem 0 0;font-size:13.5px}
.taq-res dt{color:var(--txt3)}
.taq-res dd{margin:0;font-weight:600}
.taq-veredicto{font-size:1.05rem;font-weight:800;display:flex;align-items:center;gap:.5rem}
.taq-veredicto.ok{color:var(--verde)}
.taq-veredicto.mal{color:var(--rojo)}
.taq-recientes{margin-top:1rem;font-size:12.5px;color:var(--txt3)}

/* ── métricas ── */
.metricas{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:.8rem;margin-bottom:1.3rem}
.metrica{background:var(--sup);border:1px solid var(--borde-suave);border-radius:var(--radio);padding:.9rem 1.1rem}
.metrica b{display:block;font-size:1.5rem;font-family:var(--mono);font-weight:700;line-height:1.2}
.metrica span{color:var(--txt3);font-size:11.5px}
.metrica em{font-style:normal;font-size:11px;font-weight:700;margin-left:.35rem}
.metrica em.sube{color:var(--verde)} .metrica em.baja{color:var(--rojo)}

.barras{display:flex;align-items:flex-end;gap:3px;height:78px;margin-top:.5rem}
.barra{flex:1;background:var(--sup3);border-radius:3px 3px 0 0;position:relative;min-height:2px;transition:background .15s}
.barra:hover{background:var(--rosa)}
.barra[data-hoy="1"]{background:var(--rosa)}
.barras-pie{display:flex;justify-content:space-between;color:var(--txt3);font-size:10.5px;margin-top:.35rem}

/* ── filtros ── */
.filtros{display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;margin-bottom:.9rem}
.filtros input[type=text],.filtros input[type=date],.filtros select{
  background:#0a0f1c;color:var(--txt);border:1px solid var(--borde);
  border-radius:var(--radio-chico);padding:.45rem .55rem;font-size:13px}
.filtros input[type=text]{flex:1;min-width:180px}
.filtros input:focus,.filtros select:focus{border-color:var(--rosa)}
.filtros label{color:var(--txt3);font-size:11.5px;display:flex;align-items:center;gap:.35rem}

.acciones-fila{display:flex;gap:.3rem;flex-wrap:wrap}

@media (max-width:860px){
  .metricas{grid-template-columns:repeat(2,1fr)}
  .tabla-desliza{overflow-x:auto;-webkit-overflow-scrolling:touch}
  .tabla-desliza table{min-width:720px}
}

/* ── aviso de fallo de lectura ── */
.franja-error{background:rgba(242,72,91,.12);border:1px solid rgba(242,72,91,.45);
  border-radius:var(--radio);padding:.9rem 1.1rem;margin-bottom:1.2rem;font-size:13.5px;display:none}
.franja-error.viva{display:block}
.franja-error b{display:block;color:var(--rojo);margin-bottom:.25rem;font-size:14px}
.franja-error code{background:#0a0f1c;padding:.1rem .35rem;border-radius:4px;font-family:var(--mono);font-size:12px}

/* ── sugerencia de unidad ── */
.sugerida{display:flex;align-items:center;gap:.4rem;margin-top:.35rem;font-size:11.5px;color:var(--txt3)}
.sugerida b{font-family:var(--mono);color:var(--verde)}

/* ── chips de vuelo / equipaje ── */
.chip{display:inline-flex;align-items:center;gap:.25rem;font-size:10.5px;font-weight:700;
  padding:.12rem .45rem;border-radius:99px;margin-right:.25rem;white-space:nowrap}
.chip-vuelo{background:rgba(61,99,255,.18);color:#7d9bff}
.chip-carga{background:rgba(255,162,11,.16);color:var(--ambar)}

/* ── estado en taquilla ── */
.taq-chip{display:inline-flex;align-items:center;gap:.3rem;font-size:10.5px;font-weight:700;padding:.15rem .5rem;
  border-radius:99px;white-space:nowrap;background:var(--sup3);color:var(--txt2)}
.taq-chip i{width:6px;height:6px;border-radius:50%;background:currentColor;flex:none}
.taq-chip.ok{background:rgba(34,197,94,.14);color:var(--verde)}
.taq-chip.espera{background:rgba(255,162,11,.14);color:var(--ambar)}
.taq-chip.mal{background:rgba(242,72,91,.14);color:var(--rojo)}
.taq-chip b{font-family:var(--mono);font-weight:700}
.taq-motivo{display:block;color:var(--txt3);font-size:11.5px;margin-top:.3rem;max-width:340px}

/* ── métricas por unidad ── */
.mini-stats{display:flex;gap:.9rem;margin-top:.5rem;padding-top:.5rem;border-top:1px solid var(--borde-suave)}
.mini-stat{flex:1}
.mini-stat b{display:block;font-family:var(--mono);font-size:1rem;font-weight:700}
.mini-stat span{color:var(--txt3);font-size:10.5px}
</style>
</head>
<body>

<!-- ═══════════ PANEL (sin login) ═══════════ -->
<div class="app" id="pantalla-panel">

  <aside class="sidebar" id="barra-nav">
    <div class="marca"><b>T30</b><em>Operador</em></div>
    <nav class="nav-lista">
      <button data-pagina="dashboard" class="nav-btn activa">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7.5" height="7.5" rx="1.5"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="1.5"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="1.5"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="1.5"/></svg>
        Panel
      </button>
      <button data-pagina="unidades" class="nav-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 13.5 5 8.8A2 2 0 0 1 6.9 7.4h10.2A2 2 0 0 1 19 8.8l1.5 4.7"/><rect x="2.5" y="13.5" width="19" height="5" rx="1.6"/><circle cx="7.3" cy="19" r="1.5"/><circle cx="16.7" cy="19" r="1.5"/></svg>
        Unidades
      </button>
      <button data-pagina="taquilla" class="nav-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><path d="M14 14h3v3h-3zM20 14v3M14 20h3M20 20v.01"/></svg>
        Taquilla
      </button>
      <button data-pagina="usuarios" class="nav-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 20a7.5 7.5 0 0 1 15 0"/></svg>
        Usuarios
      </button>
      <button data-pagina="historial" class="nav-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12.5" r="8.5"/><path d="M12 8v4.5l3 2"/><path d="M8.5 3.5 6 5.5"/></svg>
        Historial
      </button>
    </nav>
    <div class="sidebar-pie">
      <span class="estado-conexion" id="estado-conexion"><span class="punto-vivo"></span> En vivo</span>
      <span class="reloj" id="reloj-actual">--:--</span>
    </div>
  </aside>

  <div class="area-principal">
    <header class="topbar">
      <h1 id="titulo-pagina">Panel</h1>
      <span class="pista-top" id="pista-titulo">Vista general de viajes y unidades en tiempo real.</span>
    </header>

    <main class="cont">

      <!-- ── DASHBOARD ── -->
      <section class="pagina viva" id="pagina-dashboard">
        <div class="fila-resumen">
          <div class="tarjetita"><b id="r-activas">0</b><span>Unidades activas</span></div>
          <div class="tarjetita ok"><b id="r-disponibles">0</b><span>Disponibles</span></div>
          <div class="tarjetita alerta2"><b id="r-ocupadas">0</b><span>En viaje</span></div>
          <div class="tarjetita" id="r-alertas-caja"><b id="r-alertas">0</b><span>Alertas redondo</span></div>
        </div>

        <div class="franja-error" id="franja-error"></div>
        <div class="metricas" id="metricas"></div>

        <section class="panel">
          <div class="panel-cab">
            <h2><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V5M4 19h16"/><path d="M8 19v-6M12 19V9M16 19v-4M20 19V7"/></svg> Viajes por día <span class="contador">14 días</span></h2>
          </div>
          <div class="barras" id="barras"></div>
          <div class="barras-pie"><span id="barras-desde">—</span><span id="barras-hasta">hoy</span></div>
        </section>

        <section class="panel" id="panel-alertas" style="display:none">
          <div class="panel-cab">
            <h2><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18.5 16v-5.2a6.5 6.5 0 0 0-13 0V16L4 18.3h16z"/><path d="M9.5 21a2.6 2.6 0 0 0 5 0"/></svg> Alertas de viaje redondo</h2>
          </div>
          <p class="pista" style="margin:-.5rem 0 .8rem">Pasajeros esperando confirmación de regreso.</p>
          <table>
            <thead><tr><th>Hora</th><th>Pasajero</th><th>Teléfono</th><th>Origen → Destino</th><th>Notas</th><th></th></tr></thead>
            <tbody id="tbody-alertas"></tbody>
          </table>
        </section>

        <section class="panel panel-urgente" id="panel-taquilla" style="display:none">
          <div class="panel-cab">
            <h2><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M8 15h3"/></svg> Taquilla: requiere atención <span class="contador" id="cta-taquilla">0</span></h2>
          </div>
          <p class="pista" style="margin:-.5rem 0 .8rem">Viajes que no se pudieron registrar solos en el sistema de taquilla. Corrige lo que indica el motivo y usa <b>Reintentar</b>; si ya lo capturaste a mano en taquilla, usa <b>Ya quedó</b>.</p>
          <div class="tabla-desliza"><table>
            <thead><tr><th>Hora</th><th>Pasajero</th><th>Origen → Destino</th><th>Estado del viaje</th><th>Taquilla</th><th></th></tr></thead>
            <tbody id="tbody-taquilla"></tbody>
          </table></div>
        </section>

        <section class="panel">
          <div class="panel-cab">
            <h2><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 13.5 5 8.8A2 2 0 0 1 6.9 7.4h10.2A2 2 0 0 1 19 8.8l1.5 4.7"/><rect x="2.5" y="13.5" width="19" height="5" rx="1.6"/><circle cx="7.3" cy="19" r="1.5"/><circle cx="16.7" cy="19" r="1.5"/></svg> Viajes activos <span class="contador" id="cta-viajes">0</span></h2>
          </div>
          <p class="vacio" id="viajes-vacio">No hay viajes en curso ahora mismo.</p>
          <div class="tabla-desliza"><table id="tabla-viajes" style="display:none">
            <thead><tr><th>Hora</th><th>Pasajero</th><th>Origen → Destino</th><th>Servicio</th><th>Precio</th><th>Estado</th><th>Taquilla</th><th>Unidad</th><th>ETA / Cerca</th><th></th></tr></thead>
            <tbody id="tbody-viajes"></tbody>
          </table></div>
        </section>

        <section class="panel">
          <div class="panel-cab">
            <h2><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="13" rx="2"/><path d="M3 9h18"/><path d="M8 21h8"/></svg> Estado de las 10 unidades</h2>
          </div>
          <div class="grid-unidades" id="grid-unidades"></div>
          <p class="pista">Administra conductores y altas/bajas en <button class="nav-btn" data-pagina="unidades" style="display:inline-flex;background:none;border:0;color:var(--ambar);cursor:pointer;font:inherit;padding:0;box-shadow:none">Unidades</button>.</p>
        </section>
      </section>

      <!-- ── UNIDADES ── -->
      <section class="pagina" id="pagina-unidades">
        <section class="panel">
          <div class="panel-cab">
            <h2><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3.5 13.5 5 8.8A2 2 0 0 1 6.9 7.4h10.2A2 2 0 0 1 19 8.8l1.5 4.7"/><rect x="2.5" y="13.5" width="19" height="5" rx="1.6"/><circle cx="7.3" cy="19" r="1.5"/><circle cx="16.7" cy="19" r="1.5"/></svg> Flota — 10 unidades</h2>
          </div>
          <p class="pista" style="margin-bottom:1rem">Activa una unidad solo cuando ya tengas conductor asignado.</p>
          <div class="tabla-unidades" id="tabla-unidades-form"></div>
        </section>
      </section>

      <!-- ── TAQUILLA ── -->
      <section class="pagina" id="pagina-taquilla">
        <section class="panel">
          <div class="panel-cab">
            <h2><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><path d="M14 14h3v3h-3zM20 14v3M14 20h3M20 20v.01"/></svg> Identificar pasajero</h2>
          </div>
          <p class="pista" style="margin:-.5rem 0 .9rem">Dispara el lector de pistola sobre la credencial del pasajero, o teclea su id de usuario.</p>
          <div class="taq-caja">
            <input id="taq-entrada" placeholder="Lectura del QR o id de usuario" autocomplete="off" spellcheck="false" />
            <button class="btn" id="taq-buscar">Buscar</button>
            <button class="btn btn-secundario" id="taq-camara">Usar cámara</button>
          </div>
          <div class="taq-lector" id="taq-lector">
            <video class="taq-video" id="taq-video" muted playsinline></video>
            <button class="btn btn-secundario btn-sm" id="taq-cerrar-cam" style="margin-top:.6rem">Cerrar cámara</button>
          </div>
          <div id="taq-resultado"></div>
          <div class="taq-recientes" id="taq-recientes"></div>
        </section>
      </section>

      <!-- ── USUARIOS ── -->
      <section class="pagina" id="pagina-usuarios">
        <section class="panel">
          <div class="panel-cab">
            <h2><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 20a7.5 7.5 0 0 1 15 0"/></svg> Usuarios registrados <span class="contador" id="cta-usuarios">0</span></h2>
            <div style="display:flex;gap:.5rem">
              <button class="btn btn-secundario btn-sm" id="btn-usuarios-json">Descargar JSON</button>
              <button class="btn btn-sm" id="btn-usuarios-csv">Descargar CSV</button>
            </div>
          </div>
          <p class="pista" style="margin:-.5rem 0 .9rem">Sale de la colección <b>usuarios</b> de Firestore. Para bajar también las cuentas de Firebase Auth (correo verificado, último acceso, proveedor), usa el script de servidor que viene aparte.</p>
          <div class="tabla-desliza">
            <table>
              <thead><tr><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Ciudad</th><th>Viajes</th><th>Gastado</th><th>Taquilla</th><th>Alta</th></tr></thead>
              <tbody id="tbody-usuarios"><tr><td colspan="8" class="vacio" style="border:none">Cargando…</td></tr></tbody>
            </table>
          </div>
        </section>
      </section>

      <!-- ── HISTORIAL ── -->
      <section class="pagina" id="pagina-historial">
        <section class="panel">
          <div class="panel-cab">
            <h2><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12.5" r="8.5"/><path d="M12 8v4.5l3 2"/><path d="M8.5 3.5 6 5.5"/></svg> Historial <span class="contador" id="cta-historial">0</span></h2>
            <button class="btn btn-sm" id="btn-exportar-viajes">Descargar CSV</button>
          </div>
          <div class="filtros">
            <input type="text" id="f-texto" placeholder="Pasajero, ruta, folio, boleto o teléfono" autocomplete="off" />
            <select id="f-estado">
              <option value="">Todos los estados</option>
              <option value="completado">Completados</option>
              <option value="cancelado">Cancelados</option>
              <option value="buscando">Buscando</option>
              <option value="asignado">Asignados</option>
              <option value="en_curso">En curso</option>
            </select>
            <label>Desde <input type="date" id="f-desde" /></label>
            <label>Hasta <input type="date" id="f-hasta" /></label>
            <button class="btn btn-secundario btn-sm" id="f-limpiar">Limpiar</button>
          </div>
          <p class="pista" style="margin:-.4rem 0 .8rem" id="resumen-filtro"></p>
          <div class="tabla-desliza">
            <table>
              <thead><tr><th>Fecha</th><th>Folio</th><th>Boleto</th><th>Pasajero</th><th>Ruta</th><th>Servicio</th><th>Precio</th><th>Estado</th></tr></thead>
              <tbody id="tbody-historial"></tbody>
            </table>
          </div>
        </section>
      </section>

    </main>
  </div>
</div>

<div class="toast-pila" id="toast-pila" aria-live="polite"></div>

<script type="module">
/* ══════════════════════════════════════════════════════════════
   T30 · PANEL DE OPERADOR — conexión directa a Firebase (SDK JS)
   Mismo patrón que tu app: pegas firebaseConfig y listo.
   ══════════════════════════════════════════════════════════════ */
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
import {
  getFirestore, collection, doc, onSnapshot, updateDoc, addDoc, setDoc,
  query, serverTimestamp, getDoc, getDocs
} from "https://www.gstatic.com/firebasejs/11.0.2/firebase-firestore.js";

const firebaseConfig = {
  apiKey: "AIzaSyC32ooM1mBCSS6YF_vjN4HMrYPwHh2fFM4",
  authDomain: "t30-app.firebaseapp.com",
  projectId: "t30-app",
  storageBucket: "t30-app.firebasestorage.app",
  messagingSenderId: "118514630084",
  appId: "1:118514630084:web:216cf95b90c3f3b7793891",
  measurementId: "G-5EDWD45FCE"
};

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

const $ = (s, c = document) => c.querySelector(s);
const $$ = (s, c = document) => [...c.querySelectorAll(s)];
const esc = s => String(s ?? "").replace(/[&<>"']/g, c => ({ "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;" }[c]));
const dinero = n => "$" + Math.round(n || 0).toLocaleString("es-MX") + " MXN";
const fecha = ts => {
  if (!ts) return "—";
  const d = ts.toDate ? ts.toDate() : new Date(ts);
  return d.toLocaleDateString("es-MX", { day:"2-digit", month:"2-digit", year:"numeric", hour:"2-digit", minute:"2-digit" });
};

// Notificaciones no bloqueantes (reemplazan a alert() para avisos)
function toast(mensaje, tipo = "info") {
  const cont = $("#toast-pila");
  if (!cont) { alert(mensaje); return; }
  const el = document.createElement("div");
  el.className = "toast" + (tipo === "error" ? " toast-error" : tipo === "exito" ? " toast-exito" : "");
  el.textContent = mensaje;
  cont.appendChild(el);
  requestAnimationFrame(() => el.classList.add("mostrar"));
  setTimeout(() => {
    el.classList.remove("mostrar");
    setTimeout(() => el.remove(), 250);
  }, 3800);
}

// Sin login: arranca directo al abrir la página
iniciarEscuchas();

/* ══════════════════════════════════════════════════════════════
   NAVEGACIÓN
   ══════════════════════════════════════════════════════════════ */
const TITULOS = {
  dashboard: ["Panel", "Vista general de viajes y unidades en tiempo real."],
  unidades: ["Unidades", "Altas, bajas y datos de conductores de la flota."],
  taquilla: ["Taquilla", "Lee el pase del pasajero y registra su abordaje."],
  usuarios: ["Usuarios", "Padrón de cuentas registradas en la app."],
  historial: ["Historial", "Busca por pasajero, folio o fecha. Descarga lo que filtres."]
};
$$(".nav-btn").forEach(b => b.onclick = () => {
  const destino = b.dataset.pagina;
  $$(".nav-btn").forEach(o => o.classList.toggle("activa", o.dataset.pagina === destino));
  $$(".pagina").forEach(p => p.classList.toggle("viva", p.id === "pagina-" + destino));
  const t = TITULOS[destino];
  if (t) { $("#titulo-pagina").textContent = t[0]; $("#pista-titulo").textContent = t[1]; }
  // La taquilla trabaja con lector de pistola: el foco debe estar siempre en la caja.
  if (destino === "taquilla") setTimeout(() => $("#taq-entrada")?.focus(), 60);
  if (destino === "usuarios") cargarUsuarios(true);
});

// Reloj y estado de conexión en la barra lateral
function actualizarReloj() {
  const el = $("#reloj-actual");
  if (el) el.textContent = new Date().toLocaleTimeString("es-MX", { hour: "2-digit", minute: "2-digit", second: "2-digit" });
}
actualizarReloj();
setInterval(actualizarReloj, 1000);

/* ══════════════════════════════════════════════════════════════
   ESTADO EN MEMORIA (alimentado por onSnapshot en tiempo real)
   ══════════════════════════════════════════════════════════════ */
const E = { viajes: [], unidades: [], alertas: [], cargado: { viajes: false, alertas: false } };

function iniciarEscuchas() {
  // Viajes (todos; filtramos en JS por estado)
  onSnapshot(query(collection(db, "viajes")), snap => {
    E.viajes = snap.docs.map(d => ({ id: d.id, ...d.data() }));
    E.cargado.viajes = true;
    pintarDashboard();
    pintarHistorial();
    pintarUnidades();
  }, e => reportarFallo("viajes", e));

  // Unidades (crea las 10 la primera vez que no exista ninguna)
  onSnapshot(collection(db, "unidades"), async snap => {
    if (snap.empty) { await crearUnidades(); return; }
    E.unidades = snap.docs.map(d => ({ id: d.id, ...d.data() })).sort((a,b) => (a.numero||"").localeCompare(b.numero||""));
    pintarDashboard();
    pintarUnidades();
  }, e => reportarFallo("unidades", e));

  // Alertas de viaje redondo
  onSnapshot(collection(db, "alertas_redondo"), snap => {
    E.alertas = snap.docs.map(d => ({ id: d.id, ...d.data() }));
    E.cargado.alertas = true;
    pintarDashboard();
  }, e => reportarFallo("alertas_redondo", e));
}

/* Antes esto solo ponía un puntito rojo en la esquina. Si las reglas de
   Firestore niegan la lectura, el panel se quedaba vacío y la taquilla “no
   hacía nada” sin decir por qué. Ahora se explica en pantalla. */
function reportarFallo(coleccion, e) {
  console.error(coleccion + ":", e);
  marcarDesconectado();
  const caja = $("#franja-error");
  if (!caja) return;
  const permisos = /permission|insufficient|PERMISSION_DENIED/i.test(e?.code + " " + e?.message);
  caja.innerHTML = permisos
    ? '<b>Firestore está negando la lectura de «' + esc(coleccion) + '»</b>' +
      'El panel no tiene sesión iniciada, así que las reglas lo tratan como visitante. ' +
      'Mientras esto siga así la taquilla no va a encontrar ningún viaje. ' +
      'Revisa las reglas de la colección <code>' + esc(coleccion) + '</code> o protege este panel con ' +
      'autenticación en vez de dejarlo abierto.'
    : '<b>No se pudo leer «' + esc(coleccion) + '»</b>' + esc(e?.message || "Error desconocido");
  caja.classList.add("viva");
}

function marcarDesconectado() {
  const el = $("#estado-conexion");
  if (el) el.innerHTML = '<span class="punto-vivo" style="background:var(--rojo);animation:none"></span> Sin conexión';
}

let creandoUnidades = false;
async function crearUnidades() {
  // Ids fijos (T30-01…): si dos operadores abren el panel a la vez en un
  // proyecto vacío, escriben los mismos documentos en vez de crear 20 unidades.
  if (creandoUnidades) return;
  creandoUnidades = true;
  for (let i = 1; i <= 10; i++) {
    const numero = "T30-" + String(i).padStart(2, "0");
    await setDoc(doc(db, "unidades", numero), {
      numero,
      estado: "disponible",
      plazas: 4,
      activa: false,
      conductor: { nombre: "", telefono: "", auto: "", placas: "" },
      viajeActualId: null
    });
  }
}

/* ══════════════════════════════════════════════════════════════
   ESTADO EN TAQUILLA
   La función de Firebase registra cada viaje en el sistema de taquilla
   y deja el resultado en `viaje.terminal`. Aquí solo se muestra.
   ══════════════════════════════════════════════════════════════ */
const TAQ_PROBLEMA = ["incierto", "rechazado", "revisar", "sin_telefono", "sin_origen", "sin_destino",
  "telefono_duplicado", "cancelar_incierto", "cancelar_rechazado", "cancelar_revisar"];
const TAQ_TEXTO = {
  pendiente: "En cola", enviando: "Enviando", error: "Reintentando", cancelando: "Cancelando",
  cancelar_pendiente: "Cancelando", cancelar_error: "Reintentando cancelación", cancelado: "Cancelado en taquilla",
  incierto: "¿Salió el boleto?", rechazado: "Rechazado", revisar: "Revisar", omitido: "No se envió",
  sin_telefono: "Sin teléfono", sin_origen: "Origen fuera de catálogo", sin_destino: "Destino fuera de catálogo",
  telefono_duplicado: "Teléfono duplicado", cancelar_incierto: "¿Se canceló?",
  cancelar_rechazado: "Cancelación rechazada", cancelar_revisar: "Revisar cancelación"
};
const taqDe = v => (v?.terminal && typeof v.terminal === "object") ? v.terminal : {};
const boletoDe = v => taqDe(v).idBoleto != null ? String(taqDe(v).idBoleto) : "";
const terminalAIFA = v => v.terminalAIFA || (typeof v.terminal === "string" ? v.terminal : "");

function chipTaquilla(v) {
  const t = taqDe(v), e = t.estado;
  if (!e) return '<span class="taq-chip espera" title="La función aún no lo procesa. Si se queda así, revisa que esté desplegada."><i></i>Sin procesar</span>';
  const tono = e === "enviado" || e === "cancelado" ? "ok" : TAQ_PROBLEMA.includes(e) ? "mal" : e === "omitido" ? "" : "espera";
  const txt = e === "enviado"
    ? "Boleto <b>" + esc(boletoDe(v) || "—") + "</b>" + (t.simulado ? " · prueba" : "")
    : esc(TAQ_TEXTO[e] || e);
  return '<span class="taq-chip ' + tono + '" title="' + esc(t.error || "") + '"><i></i>' + txt + '</span>';
}

function pintarTaquilla() {
  const lista = E.viajes
    .filter(v => TAQ_PROBLEMA.includes(taqDe(v).estado) && !v.terminalRevisado)
    .sort((a, b) => (b.creadoEn?.seconds || 0) - (a.creadoEn?.seconds || 0));
  $("#panel-taquilla").style.display = lista.length ? "" : "none";
  $("#cta-taquilla").textContent = lista.length;
  $("#tbody-taquilla").innerHTML = lista.map(v => `
    <tr>
      <td>${esc(fecha(v.creadoEn))}</td>
      <td>${esc(v.pasajero?.nombre || "—")}<br><small class="dato-num">${esc(v.pasajero?.telefono || "")}</small></td>
      <td>${esc(v.origen?.texto || "")} → ${esc(v.destino?.texto || "")}</td>
      <td><span class="sello sello-${esc(v.estado)}">${esc(v.estado)}</span></td>
      <td>${chipTaquilla(v)}<span class="taq-motivo">${esc(taqDe(v).error || "")}</span></td>
      <td><div class="acciones-fila">
        <button class="btn btn-sm" data-taq-reintentar="${v.id}">Reintentar</button>
        <button class="btn btn-secundario btn-sm" data-taq-listo="${v.id}">Ya quedó</button>
      </div></td>
    </tr>`).join("");
  $$("[data-taq-reintentar]").forEach(b => b.onclick = async () => {
    const v = E.viajes.find(x => x.id === b.dataset.taqReintentar);
    const e = taqDe(v).estado;
    if ((e === "incierto" || e === "cancelar_incierto") &&
        !confirm("Antes de reintentar, revisa en taquilla que el boleto NO exista: podría salir duplicado. ¿Reintentar?")) return;
    try {
      await updateDoc(doc(db, "viajes", b.dataset.taqReintentar), { terminalReintentar: true, terminalRevisado: false });
      toast("Reintentando en taquilla…", "exito");
    } catch (err) { toast("Error: " + err.message, "error"); }
  });
  $$("[data-taq-listo]").forEach(b => b.onclick = async () => {
    try {
      await updateDoc(doc(db, "viajes", b.dataset.taqListo), { terminalRevisado: true });
      toast("Marcado como resuelto.", "exito");
    } catch (err) { toast("Error: " + err.message, "error"); }
  });
}

/* ══════════════════════════════════════════════════════════════
   DASHBOARD
   ══════════════════════════════════════════════════════════════ */
function pintarDashboard() {
  const viajesActivos = E.viajes
    .filter(v => ["buscando","asignado","en_curso"].includes(v.estado))
    .sort((a,b) => (b.creadoEn?.seconds||0) - (a.creadoEn?.seconds||0));

  const activas = E.unidades.filter(u => u.activa);
  const disponibles = activas.filter(u => u.estado === "disponible");
  const ocupadas = activas.filter(u => u.estado === "ocupado");
  const alertasPend = E.alertas.filter(a => (a.estado || "pendiente") === "pendiente")
    .sort((a,b) => (b.creadoEn?.seconds||0) - (a.creadoEn?.seconds||0));

  $("#r-activas").textContent = activas.length;
  $("#r-disponibles").textContent = disponibles.length;
  $("#r-ocupadas").textContent = ocupadas.length;
  $("#r-alertas").textContent = alertasPend.length;
  $("#r-alertas-caja").classList.toggle("urgente", alertasPend.length > 0);

  // Alertas
  $("#panel-alertas").style.display = alertasPend.length ? "" : "none";
  $("#panel-alertas").classList.toggle("panel-urgente", alertasPend.length > 0);
  $("#tbody-alertas").innerHTML = alertasPend.map(a => `
    <tr>
      <td>${esc(fecha(a.creadoEn))}</td>
      <td>${esc(a.nombre || "—")}</td>
      <td class="dato-num">${esc(a.telefono || "—")}</td>
      <td>${esc(a.origen || "")} → ${esc(a.destino || "")}</td>
      <td>${esc(a.notas || "")}</td>
      <td><button class="btn btn-ok btn-sm" data-atender="${a.id}">Marcar atendida</button></td>
    </tr>`).join("");
  $$("[data-atender]").forEach(b => b.onclick = () => atenderAlerta(b.dataset.atender));

  // Viajes activos
  $("#cta-viajes").textContent = viajesActivos.length;
  $("#viajes-vacio").style.display = viajesActivos.length ? "none" : "";
  $("#tabla-viajes").style.display = viajesActivos.length ? "" : "none";
  $("#tbody-viajes").innerHTML = viajesActivos.map(v => {
    const unidad = E.unidades.find(u => u.id === v.unidadId);
    const colUnidad = v.unidadId
      ? esc(unidad?.numero || v.unidadId)
      : (() => {
          const sug = unidadSugerida(v, disponibles);
          return `<select data-select-unidad="${v.id}"><option value="">Asignar unidad…</option>${
            disponibles.map(u => `<option value="${u.id}"${u.id === sug?.id ? " selected" : ""}>${esc(u.numero)} — ${esc(u.conductor?.nombre||"")}</option>`).join("")
          }</select> <button class="btn btn-sm" data-asignar="${v.id}">Asignar</button>` +
          (sug ? `<div class="sugerida">Sugerida <b>${esc(sug.numero)}</b> · ${esc(sug.razon)}</div>` : "");
        })();
    const colAccion = `<div class="acciones-fila">` + (v.unidadId
      ? `<button class="btn btn-ok btn-sm" data-liberar="${v.id}" data-unidad="${v.unidadId}">Marcar entregado</button>
         <button class="btn btn-secundario btn-sm" data-reasignar="${v.id}" data-unidad="${v.unidadId}">Reasignar</button>`
      : "") +
      `<button class="btn btn-secundario btn-sm" data-cancelar="${v.id}" data-unidad="${v.unidadId || ""}">Cancelar</button></div>`;
    const colEtaCerca = v.unidadId ? `
      <div style="display:flex;flex-direction:column;gap:.3rem">
        <div style="display:flex;gap:.3rem;align-items:center">
          <input type="text" inputmode="numeric" data-eta-input="${v.id}" value="${v.etaMin ?? ""}" placeholder="min" style="width:52px;background:#0a0f1c;color:var(--txt);border:1px solid var(--borde);border-radius:6px;padding:.3rem .35rem;font-size:12px;font-family:var(--mono)">
          <button class="btn btn-sm btn-secundario" data-guardar-eta="${v.id}">Guardar ETA</button>
        </div>
        ${v.estado === "asignado" ? `<button class="btn btn-sm ${v.cercano ? "btn-ok" : "btn-secundario"}" data-toggle-cercano="${v.id}" data-cercano-actual="${v.cercano ? "1" : "0"}">
          ${v.cercano ? "✓ Marcado cerca" : "Marcar cerca de llegar"}
        </button>
        <button class="btn btn-sm" data-en-curso="${v.id}">Marcar en curso</button>` : ""}
      </div>` : "<span class=\"pista\" style=\"margin:0\">Asigna una unidad primero</span>";
    return `<tr>
      <td>${esc(fecha(v.creadoEn))}</td>
      <td>${esc(v.pasajero?.nombre || "—")}<br><small class="dato-num">${esc(v.pasajero?.telefono || "")}</small></td>
      <td>${esc(v.origen?.texto || "")} → ${esc(v.destino?.texto || "")}${etiquetasViaje(v)}</td>
      <td>${esc(v.claseNombre || "")}</td>
      <td class="dato-num">${dinero(v.precio)}</td>
      <td><span class="sello sello-${esc(v.estado)}">${esc(v.estado)}</span></td>
      <td>${chipTaquilla(v)}</td>
      <td>${colUnidad}</td>
      <td>${colEtaCerca}</td>
      <td>${colAccion}</td>
    </tr>`;
  }).join("");

  $$("[data-asignar]").forEach(b => b.onclick = () => {
    const sel = $(`[data-select-unidad="${b.dataset.asignar}"]`);
    if (sel && sel.value) asignarUnidad(b.dataset.asignar, sel.value);
    else if (sel) toast("Elige una unidad de la lista antes de asignar.", "error");
  });
  $$("[data-liberar]").forEach(b => b.onclick = () => {
    if (confirm("¿La unidad ya dejó al pasajero? Quedará disponible de nuevo.")) {
      liberarUnidad(b.dataset.liberar, b.dataset.unidad);
    }
  });
  $$("[data-guardar-eta]").forEach(b => b.onclick = () => {
    const input = $(`[data-eta-input="${b.dataset.guardarEta}"]`);
    const min = parseInt(input?.value, 10);
    if (!min || min < 1) return toast("Escribe un número de minutos válido.", "error");
    guardarEta(b.dataset.guardarEta, min);
  });
  $$("[data-toggle-cercano]").forEach(b => b.onclick = () => {
    marcarCercano(b.dataset.toggleCercano, b.dataset.cercanoActual !== "1");
  });
  $$("[data-reasignar]").forEach(b => b.onclick = () => {
    if (confirm("¿Liberar la unidad y volver a poner el viaje en búsqueda?")) {
      reasignarViaje(b.dataset.reasignar, b.dataset.unidad);
    }
  });
  $$("[data-cancelar]").forEach(b => b.onclick = () => {
    if (confirm("¿Cancelar este viaje? El pasajero lo verá cancelado en su app.")) {
      cancelarViaje(b.dataset.cancelar, b.dataset.unidad);
    }
  });
  $$("[data-en-curso]").forEach(b => b.onclick = () => {
    if (confirm("¿El conductor ya recogió al pasajero? El viaje pasará a 'en curso'.")) {
      marcarEnCurso(b.dataset.enCurso);
    }
  });

  pintarTaquilla();
  pintarMetricas();
  revisarNovedades();
  reconciliarUnidades();

  // Grid de las 10 unidades
  $("#grid-unidades").innerHTML = E.unidades.map(u => `
    <div class="unidad-card ${!u.activa ? "inactiva" : esc(u.estado)}">
      <b>${esc(u.numero)}</b>
      ${!u.activa
        ? `<span class="sello sello-cancelado">Sin conductor</span>`
        : `<span class="sello sello-${u.estado === "disponible" ? "completado" : "buscando"}">${u.estado === "disponible" ? "Disponible" : "En viaje"}</span>
           <small>${esc(u.conductor?.nombre || "")}</small>
           <small class="dato-num">${esc(u.conductor?.placas || "")}</small>`}
    </div>`).join("");
}

/* Etiquetas de vuelo y carga: el operador necesita verlas de un vistazo
   para decidir qué unidad manda. */
function etiquetasViaje(v) {
  const t = [];
  if (v.vuelo) t.push(`<span class="chip chip-vuelo">✈ ${esc(v.vuelo)}${terminalAIFA(v) ? " · " + esc(terminalAIFA(v)) : ""}</span>`);
  const plazas = (v.pasajeros || 1) + Math.floor((v.maletas || 0) / 2);
  if (plazas > 4 || (v.maletas || 0) >= 3)
    t.push(`<span class="chip chip-carga">${v.pasajeros || 1}p · ${v.maletas || 0}m</span>`);
  return t.length ? `<div style="margin-top:.3rem">${t.join("")}</div>` : "";
}

/** Mejor unidad para un viaje: que quepa la gente y el equipaje, y entre las
    que caben, la que lleva más tiempo sin viaje. */
function unidadSugerida(v, disponibles) {
  if (!disponibles.length) return null;
  const plazas = (v.pasajeros || 1) + Math.floor((v.maletas || 0) / 2);
  const capacidad = u => +u.plazas || 4;
  const caben = disponibles.filter(u => capacidad(u) >= plazas);
  const lista = caben.length ? caben : disponibles;

  const ultimoUso = u => {
    const suyos = E.viajes.filter(x => x.unidadId === u.id && x.cerradoEn?.seconds);
    return suyos.length ? Math.max(...suyos.map(x => x.cerradoEn.seconds)) : 0;
  };
  const elegida = [...lista].sort((a, b) => ultimoUso(a) - ultimoUso(b))[0];
  const hechos = E.viajes.filter(x => x.unidadId === elegida.id && x.estado === "completado").length;
  return {
    ...elegida,
    razon: caben.length
      ? (hechos ? `${hechos} viaje(s) hoy, es la que lleva más tiempo parada` : "sin viajes todavía")
      : "ninguna cubre las plazas pedidas"
  };
}

async function asignarUnidad(viajeId, unidadId) {
  try {
    const unidad = E.unidades.find(u => u.id === unidadId);
    if (!unidad || unidad.estado !== "disponible") return toast("Esa unidad ya no está disponible.", "error");
    await updateDoc(doc(db, "viajes", viajeId), {
      unidadId, conductor: unidad.conductor || {}, estado: "asignado", etaMin: 5
    });
    await updateDoc(doc(db, "unidades", unidadId), { estado: "ocupado", viajeActualId: viajeId });
    toast(`Unidad ${unidad.numero} asignada.`, "exito");
  } catch (e) { toast("Error: " + e.message, "error"); }
}

async function liberarUnidad(viajeId, unidadId) {
  try {
    await updateDoc(doc(db, "viajes", viajeId), { estado: "completado", cerradoEn: serverTimestamp(), cercano: false });
    await updateDoc(doc(db, "unidades", unidadId), { estado: "disponible", viajeActualId: null });
    toast("Viaje marcado como entregado.", "exito");
  } catch (e) { toast("Error: " + e.message, "error"); }
}

async function guardarEta(viajeId, min) {
  try {
    await updateDoc(doc(db, "viajes", viajeId), { etaMin: min });
    toast("ETA actualizado.", "exito");
  } catch (e) { toast("Error: " + e.message, "error"); }
}

async function marcarCercano(viajeId, valor) {
  try {
    await updateDoc(doc(db, "viajes", viajeId), { cercano: valor });
  } catch (e) { toast("Error: " + e.message, "error"); }
}

async function marcarEnCurso(viajeId) {
  try {
    await updateDoc(doc(db, "viajes", viajeId), { estado: "en_curso", cercano: false });
  } catch (e) { toast("Error: " + e.message, "error"); }
}

async function atenderAlerta(id) {
  try {
    await updateDoc(doc(db, "alertas_redondo", id), {
      estado: "atendida", atendidaEn: serverTimestamp()
    });
    toast("Alerta atendida.", "exito");
  } catch (e) { toast("Error: " + e.message, "error"); }
}

/* ══════════════════════════════════════════════════════════════
   UNIDADES
   ══════════════════════════════════════════════════════════════ */
/** Rendimiento de la unidad hoy: sirve para repartir el trabajo parejo. */
function statsUnidad(u) {
  const hoy0 = inicioDia(new Date());
  const suyos = E.viajes.filter(v => v.unidadId === u.id && (v.creadoEn?.seconds || 0) * 1000 >= hoy0);
  const hechos = suyos.filter(v => v.estado === "completado");
  const ingreso = hechos.reduce((a, v) => a + (v.precio || 0), 0);
  const cancel = suyos.filter(v => v.estado === "cancelado").length;
  return `<div class="mini-stats">
    <div class="mini-stat"><b>${hechos.length}</b><span>viajes hoy</span></div>
    <div class="mini-stat"><b>${dinero(ingreso)}</b><span>generado</span></div>
    <div class="mini-stat"><b>${cancel}</b><span>cancelados</span></div>
  </div>`;
}

function pintarUnidades() {
  $("#tabla-unidades-form").innerHTML = E.unidades.map(u => `
    <form class="tarjeta-unidad" data-form-unidad="${u.id}">
      <div class="cab-unidad">
        <b>${esc(u.numero)}</b>
        <label class="switch"><input type="checkbox" name="activa" ${u.activa ? "checked" : ""}><span>Activa</span></label>
      </div>
      <label>Nombre del conductor</label>
      <input type="text" name="nombre" value="${esc(u.conductor?.nombre || "")}" placeholder="Nombre completo">
      <label>Teléfono</label>
      <input type="text" name="telefono" value="${esc(u.conductor?.telefono || "")}" placeholder="771 000 0000">
      <label>Vehículo</label>
      <input type="text" name="auto" value="${esc(u.conductor?.auto || "")}" placeholder="Nissan Versa gris">
      <label>Placas</label>
      <input type="text" name="placas" value="${esc(u.conductor?.placas || "")}" placeholder="HGT-30-01">
      <label>Plazas para pasajeros</label>
      <input type="text" name="plazas" inputmode="numeric" value="${esc(u.plazas ?? 4)}" placeholder="4">
      <div class="estado-actual">Estado actual:
        <span class="sello sello-${u.estado === "disponible" ? "completado" : "buscando"}">${esc(u.estado || "")}</span>
      </div>
      ${statsUnidad(u)}
      <button class="btn" type="submit">Guardar</button>
    </form>`).join("");

  $$("[data-form-unidad]").forEach(f => f.onsubmit = async ev => {
    ev.preventDefault();
    const id = f.dataset.formUnidad;
    const fd = new FormData(f);
    try {
      await updateDoc(doc(db, "unidades", id), {
        conductor: {
          nombre: (fd.get("nombre") || "").trim(),
          telefono: (fd.get("telefono") || "").trim(),
          auto: (fd.get("auto") || "").trim(),
          placas: (fd.get("placas") || "").trim()
        },
        activa: fd.get("activa") === "on",
        plazas: Math.min(8, Math.max(1, parseInt(fd.get("plazas"), 10) || 4))
      });
      toast("Unidad guardada.", "exito");
    } catch (e) { toast("Error: " + e.message, "error"); }
  });
}

/* ══════════════════════════════════════════════════════════════
   HISTORIAL
   ══════════════════════════════════════════════════════════════ */
function pintarHistorial() {
  const f = {
    texto: ($("#f-texto")?.value || "").trim().toLowerCase(),
    estado: $("#f-estado")?.value || "",
    desde: $("#f-desde")?.value || "",
    hasta: $("#f-hasta")?.value || ""
  };
  const desdeMs = f.desde ? new Date(f.desde + "T00:00:00").getTime() : null;
  const hastaMs = f.hasta ? new Date(f.hasta + "T23:59:59").getTime() : null;

  const viajes = E.viajes
    .filter(v => {
      if (f.estado) { if (v.estado !== f.estado) return false; }
      else if (!["completado","cancelado"].includes(v.estado)) return false;

      if (desdeMs || hastaMs) {
        const ms = (v.creadoEn?.seconds || 0) * 1000;
        if (desdeMs && ms < desdeMs) return false;
        if (hastaMs && ms > hastaMs) return false;
      }
      if (f.texto) {
        const heno = [
          v.pasajero?.nombre, v.pasajero?.telefono, v.folio || folioDe(v.id), boletoDe(v),
          v.origen?.texto, v.destino?.texto, v.claseNombre
        ].filter(Boolean).join(" ").toLowerCase();
        if (!heno.includes(f.texto)) return false;
      }
      return true;
    })
    .sort((a,b) => (b.creadoEn?.seconds||0) - (a.creadoEn?.seconds||0));

  HISTORIAL_FILTRADO = viajes;
  $("#cta-historial").textContent = viajes.length;

  const cobrado = viajes.filter(v => v.estado === "completado").reduce((a,v) => a + (v.precio||0), 0);
  $("#resumen-filtro").textContent = viajes.length
    ? `${viajes.length} viaje(s) · ${dinero(cobrado)} cobrados en los completados`
    : "";

  const mostrar = viajes.slice(0, 300);
  $("#tbody-historial").innerHTML = mostrar.length ? mostrar.map(v => `
    <tr>
      <td>${esc(fecha(v.creadoEn))}</td>
      <td class="dato-num">${esc(v.folio || folioDe(v.id))}</td>
      <td>${boletoDe(v) ? '<span class="dato-num">' + esc(boletoDe(v)) + '</span>' : chipTaquilla(v)}</td>
      <td>${esc(v.pasajero?.nombre || "—")}</td>
      <td>${esc(v.origen?.texto || "")} → ${esc(v.destino?.texto || "")}</td>
      <td>${esc(v.claseNombre || "")}</td>
      <td class="dato-num">${dinero(v.precio)}</td>
      <td><span class="sello sello-${esc(v.estado)}">${esc(v.estado)}</span></td>
    </tr>`).join("") + (viajes.length > mostrar.length
      ? `<tr><td colspan="8" class="pista">Se muestran ${mostrar.length} de ${viajes.length}. Afina los filtros o descarga el CSV.</td></tr>`
      : "")
    : `<tr><td colspan="8" class="vacio" style="border:none">Ningún viaje coincide con el filtro.</td></tr>`;
}

let HISTORIAL_FILTRADO = [];

/* Los filtros se repintan solos; el texto espera a que dejes de teclear. */
let temporizadorFiltro;
["#f-texto","#f-estado","#f-desde","#f-hasta"].forEach(sel => {
  const el = $(sel);
  if (!el) return;
  const disparar = () => { clearTimeout(temporizadorFiltro); temporizadorFiltro = setTimeout(pintarHistorial, 180); };
  el.addEventListener(el.tagName === "SELECT" || el.type === "date" ? "change" : "input", disparar);
});
$("#f-limpiar").onclick = () => {
  ["#f-texto","#f-estado","#f-desde","#f-hasta"].forEach(sel => { const e = $(sel); if (e) e.value = ""; });
  pintarHistorial();
};

$("#btn-exportar-viajes").onclick = () => {
  const filas = HISTORIAL_FILTRADO.length ? HISTORIAL_FILTRADO : E.viajes;
  if (!filas.length) return toast("No hay viajes que exportar.", "error");
  const cols = ["folio","boleto","estado_taquilla","fecha","pasajero","telefono","origen","destino","servicio","km","minutos","precio","pago","estado","unidad","abordaje"];
  const celda = x => {
    const t = x == null ? "" : String(x);
    return /[",;\r\n]/.test(t) ? '"' + t.replace(/"/g, '""') + '"' : t;
  };
  const iso = ts => ts?.toDate ? ts.toDate().toISOString() : "";
  const lineas = [cols.join(",")].concat(filas.map(v => [
    v.folio || folioDe(v.id), boletoDe(v), taqDe(v).estado || "", iso(v.creadoEn), v.pasajero?.nombre, v.pasajero?.telefono,
    v.origen?.texto, v.destino?.texto, v.claseNombre, v.km, v.min, v.precio, v.pago, v.estado,
    E.unidades.find(u => u.id === v.unidadId)?.numero || "", iso(v.abordadoEn)
  ].map(celda).join(",")));
  bajarArchivo("viajes-" + hoy() + ".csv", "\uFEFF" + lineas.join("\r\n"), "text/csv;charset=utf-8");
  toast(`Descargando ${filas.length} viajes.`, "exito");
};

/* ══════════════════════════════════════════════════════════════
   MÉTRICAS
   ══════════════════════════════════════════════════════════════ */
const DIA = 864e5;
const inicioDia = d => { const x = new Date(d); x.setHours(0,0,0,0); return x.getTime(); };

function pintarMetricas() {
  const cont = $("#metricas");
  if (!cont) return;
  const hoy0 = inicioDia(new Date());
  const ayer0 = hoy0 - DIA;

  const enRango = (v, desde, hasta) => {
    const ms = (v.creadoEn?.seconds || 0) * 1000;
    return ms >= desde && ms < hasta;
  };
  const hechos = E.viajes.filter(v => v.estado === "completado");
  const hoyHechos = hechos.filter(v => enRango(v, hoy0, hoy0 + DIA));
  const ayerHechos = hechos.filter(v => enRango(v, ayer0, hoy0));

  const suma = l => l.reduce((a,v) => a + (v.precio||0), 0);
  const ingresoHoy = suma(hoyHechos), ingresoAyer = suma(ayerHechos);
  const delta = ingresoAyer ? Math.round((ingresoHoy - ingresoAyer) / ingresoAyer * 100) : null;

  const semana = E.viajes.filter(v => enRango(v, hoy0 - 6*DIA, hoy0 + DIA));
  const cancelados = semana.filter(v => v.estado === "cancelado").length;
  const tasaCancel = semana.length ? Math.round(cancelados / semana.length * 100) : 0;
  const ticket = hoyHechos.length ? Math.round(ingresoHoy / hoyHechos.length) : 0;
  const esperando = E.viajes.filter(v => v.estado === "buscando").length;

  const flecha = delta == null ? "" :
    `<em class="${delta >= 0 ? "sube" : "baja"}">${delta >= 0 ? "▲" : "▼"} ${Math.abs(delta)}%</em>`;

  cont.innerHTML =
    `<div class="metrica"><b>${dinero(ingresoHoy)}${flecha}</b><span>Ingresos de hoy</span></div>` +
    `<div class="metrica"><b>${hoyHechos.length}</b><span>Viajes completados hoy</span></div>` +
    `<div class="metrica"><b>${dinero(ticket)}</b><span>Ticket promedio hoy</span></div>` +
    `<div class="metrica"><b>${tasaCancel}%</b><span>Cancelación (7 días)</span></div>` +
    `<div class="metrica"><b>${esperando}</b><span>Esperando unidad</span></div>`;

  pintarBarras();
}

function pintarBarras() {
  const cont = $("#barras");
  if (!cont) return;
  const hoy0 = inicioDia(new Date());
  const dias = [];
  for (let i = 13; i >= 0; i--) {
    const d0 = hoy0 - i * DIA;
    const n = E.viajes.filter(v => {
      const ms = (v.creadoEn?.seconds || 0) * 1000;
      return ms >= d0 && ms < d0 + DIA;
    }).length;
    dias.push({ d0, n, hoy: i === 0 });
  }
  const tope = Math.max(1, ...dias.map(d => d.n));
  cont.innerHTML = dias.map(d =>
    `<div class="barra" data-hoy="${d.hoy ? 1 : 0}" style="height:${Math.max(2, d.n / tope * 100)}%" ` +
    `title="${new Date(d.d0).toLocaleDateString("es-MX",{weekday:"short",day:"numeric",month:"short"})}: ${d.n} viaje(s)"></div>`
  ).join("");
  $("#barras-desde").textContent =
    new Date(dias[0].d0).toLocaleDateString("es-MX", { day: "numeric", month: "short" });
}

/* ══════════════════════════════════════════════════════════════
   RECONCILIACIÓN DE UNIDADES
   ──────────────────────────────────────────────────────────────
   El estado de la unidad es dato derivado: la verdad está en el viaje.
   Si alguien cierra el viaje por otro camino (el pasajero desde su app,
   una cancelación, un viaje borrado), la unidad se quedaba ocupada para
   siempre y la flota se secaba sola. Esto lo corrige en cuanto pasa.
   ══════════════════════════════════════════════════════════════ */
const ABIERTOS = ["buscando", "asignado", "en_curso"];
let reconciliando = false;

async function reconciliarUnidades() {
  if (reconciliando || !E.cargado.viajes || !E.unidades.length) return;

  const porId = new Map(E.viajes.map(v => [v.id, v]));
  const arreglos = [];

  for (const u of E.unidades) {
    if (u.estado !== "ocupado") continue;
    const v = u.viajeActualId ? porId.get(u.viajeActualId) : null;
    // Ocupada sin viaje, con un viaje que ya no existe, o con uno ya cerrado.
    if (!v || !ABIERTOS.includes(v.estado)) {
      arreglos.push({ unidad: u, motivo: !u.viajeActualId ? "sin viaje asignado"
        : !v ? "el viaje ya no existe" : "el viaje quedó " + v.estado });
    }
  }
  if (!arreglos.length) return;

  reconciliando = true;
  try {
    for (const a of arreglos) {
      await updateDoc(doc(db, "unidades", a.unidad.id), { estado: "disponible", viajeActualId: null });
      console.info(`unidad ${a.unidad.numero} liberada: ${a.motivo}`);
    }
    toast(arreglos.length === 1
      ? `Unidad ${arreglos[0].unidad.numero} liberada (${arreglos[0].motivo}).`
      : `${arreglos.length} unidades liberadas automáticamente.`, "exito");
  } catch (e) {
    console.error("reconciliación:", e);
  } finally {
    reconciliando = false;
  }
}

/* ══════════════════════════════════════════════════════════════
   ACCIONES DE DESPACHO
   ══════════════════════════════════════════════════════════════ */
async function reasignarViaje(viajeId, unidadId) {
  try {
    if (unidadId) await updateDoc(doc(db, "unidades", unidadId), { estado: "disponible", viajeActualId: null });
    await updateDoc(doc(db, "viajes", viajeId), { unidadId: null, conductor: null, estado: "buscando", cercano: false });
    toast("Unidad liberada. El viaje volvió a búsqueda.", "exito");
  } catch (e) { toast("Error: " + e.message, "error"); }
}

async function cancelarViaje(viajeId, unidadId) {
  try {
    if (unidadId) await updateDoc(doc(db, "unidades", unidadId), { estado: "disponible", viajeActualId: null });
    await updateDoc(doc(db, "viajes", viajeId), { estado: "cancelado", cerradoEn: serverTimestamp(), cercano: false });
    const v = E.viajes.find(x => x.id === viajeId);
    toast(boletoDe(v) ? "Viaje cancelado. También se cancela el boleto " + boletoDe(v) + " en taquilla." : "Viaje cancelado.", "exito");
  } catch (e) { toast("Error: " + e.message, "error"); }
}

/* ══════════════════════════════════════════════════════════════
   AVISOS — en un despacho nadie mira la pantalla fijo
   ══════════════════════════════════════════════════════════════ */
let vistosViajes = null, vistasAlertas = null, vistosTaquilla = null, tituloBase = document.title, parpadeo = null;

function sonarAviso(agudo = false) {
  try {
    const ac = new (window.AudioContext || window.webkitAudioContext)();
    const o = ac.createOscillator(), g = ac.createGain();
    o.type = "sine";
    o.frequency.value = agudo ? 980 : 660;
    g.gain.setValueAtTime(0.0001, ac.currentTime);
    g.gain.exponentialRampToValueAtTime(0.16, ac.currentTime + 0.02);
    g.gain.exponentialRampToValueAtTime(0.0001, ac.currentTime + 0.38);
    o.connect(g); g.connect(ac.destination);
    o.start(); o.stop(ac.currentTime + 0.4);
    setTimeout(() => ac.close(), 700);
  } catch {}
}

function avisarTitulo(texto) {
  clearInterval(parpadeo);
  let on = false;
  parpadeo = setInterval(() => {
    document.title = (on = !on) ? texto : tituloBase;
  }, 1100);
}
// Al volver a la pestaña se apaga el parpadeo.
document.addEventListener("visibilitychange", () => {
  if (!document.hidden) { clearInterval(parpadeo); document.title = tituloBase; }
});

function revisarNovedades() {
  // Cada colección se estrena por separado. Si tomáramos la foto de todas en el
  // primer repintado, la colección que llegue después sonaría como novedad y el
  // operador tendría una falsa alarma cada vez que abre el panel.
  if (E.cargado.viajes) {
    const pendientes = E.viajes.filter(v => v.estado === "buscando").map(v => v.id);
    if (vistosViajes === null) {
      vistosViajes = new Set(pendientes);
    } else {
      const nuevos = pendientes.filter(id => !vistosViajes.has(id));
      if (nuevos.length) {
        sonarAviso(false);
        toast(nuevos.length === 1 ? "Viaje nuevo esperando unidad." : `${nuevos.length} viajes nuevos esperando unidad.`, "exito");
        if (document.hidden) avisarTitulo(`(${pendientes.length}) Viaje nuevo — T30`);
      }
      vistosViajes = new Set(pendientes);
    }
  }

  // Un viaje que no se pudo registrar en taquilla: alguien tiene que verlo ya.
  if (E.cargado.viajes) {
    const mal = E.viajes.filter(v => TAQ_PROBLEMA.includes(taqDe(v).estado) && !v.terminalRevisado).map(v => v.id);
    if (vistosTaquilla === null) vistosTaquilla = new Set(mal);
    else {
      const nuevos = mal.filter(id => !vistosTaquilla.has(id));
      if (nuevos.length) {
        sonarAviso(true);
        toast(nuevos.length === 1 ? "Un viaje no se pudo registrar en taquilla." : nuevos.length + " viajes no se pudieron registrar en taquilla.", "error");
        if (document.hidden) avisarTitulo("(!) Revisar taquilla — T30");
      }
      vistosTaquilla = new Set(mal);
    }
  }

  if (E.cargado.alertas) {
    const alertas = E.alertas.filter(a => (a.estado || "pendiente") === "pendiente").map(a => a.id);
    if (vistasAlertas === null) {
      vistasAlertas = new Set(alertas);
    } else {
      const nuevas = alertas.filter(id => !vistasAlertas.has(id));
      if (nuevas.length) {
        sonarAviso(true);
        toast("Alerta de viaje redondo.", "error");
        if (document.hidden) avisarTitulo("(!) Alerta redondo — T30");
      }
      vistasAlertas = new Set(alertas);
    }
  }
}
/* ══════════════════════════════════════════════════════════════
   TAQUILLA — lectura del pase y registro de abordaje
   ══════════════════════════════════════════════════════════════ */
const ALFA_FOLIO = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";

/** Misma fórmula que la app del pasajero: no la cambies en un solo lado. */
function folioDe(viajeId) {
  if (!viajeId) return "T30-XXXXXX";
  let a = 0x811c9dc5, b = 0x9e3779b9;
  for (let i = 0; i < viajeId.length; i++) {
    const c = viajeId.charCodeAt(i);
    a = Math.imul(a ^ c, 0x01000193) >>> 0;
    b = Math.imul(b ^ c, 0x85ebca6b) >>> 0;
    b = ((b << 13) | (b >>> 19)) >>> 0;
  }
  let out = "";
  for (let i = 0; i < 3; i++) { out += ALFA_FOLIO[a & 31]; a >>>= 5; }
  for (let i = 0; i < 3; i++) { out += ALFA_FOLIO[b & 31]; b >>>= 5; }
  return "T30-" + out;
}

/** Acepta la credencial de usuario (T30U|2|uid|codigo), el pase antiguo
    (T30|1|folio|viajeId|uid) o un folio tecleado.
    Los lectores de pistola mandan los caracteres como si fueran un teclado
    estadounidense: con una distribucion en español la barra «|» sale
    convertida en otra cosa. Por eso no partimos por «|», sino por cualquier
    cosa que no sea letra, numero o guion, y reconocemos las piezas por forma. */
function interpretarLectura(txt) {
  const limpio = (txt || "").trim();
  if (!limpio) return null;

  const piezas = limpio.split(/[^A-Za-z0-9-]+/).filter(Boolean);
  const esFolio = p => /^T30-[A-HJ-NP-Z2-9]{6}$/i.test(p);

  // ── Credencial de usuario: lo que emite la app nueva.
  if (/^T30U$/i.test(piezas[0] || "")) {
    // El uid de Firebase ronda los 28 caracteres; el codigo son 8.
    const uid = piezas.slice(1).find(p => p.length >= 20) || "";
    const codigo = piezas.slice(1).filter(p => p !== uid && p.length >= 6).pop() || "";
    return { tipo: "usuario", uid, codigo: codigo.toUpperCase() };
  }

  // ── uid tecleado a mano, sin prefijo.
  if (piezas.length === 1 && /^[A-Za-z0-9]{20,}$/.test(piezas[0])) {
    return { tipo: "usuario", uid: piezas[0], codigo: "" };
  }

  // ── Pase antiguo, ligado al viaje. Se conserva por compatibilidad.
  if (piezas.length >= 3 && /^T30$/i.test(piezas[0])) {
    const folio = piezas.find(esFolio) || "";
    // El id de Firestore es largo y no es el folio.
    const resto = piezas.filter(p => p !== folio && !/^T30$/i.test(p) && p.length > 2);
    const viajeId = resto.find(p => p.length >= 15) || "";
    const uid = resto.filter(p => p !== viajeId).pop() || "";
    if (folio || viajeId) return { tipo: "viaje", viajeId, folio: folio.toUpperCase(), uid, origen: "qr" };
  }

  let folio = limpio.toUpperCase().replace(/[^A-Z0-9-]/g, "");
  if (!folio.startsWith("T30-")) folio = "T30-" + folio.replace(/^T30-?/, "");
  return { tipo: "viaje", viajeId: "", folio, uid: "", origen: "manual" };
}

const ESTADOS_VIVOS = ["buscando", "asignado", "en_curso", "programado"];

/* Margen por si el reloj del telefono va desfasado respecto al del panel. */
const GRACIA_SESION = 15000;

/** Punto de entrada de toda lectura: credencial de usuario o pase antiguo. */
async function identificar(txt) {
  const lect = interpretarLectura(txt);
  if (!lect) return;

  // El pase viejo sigue funcionando mientras haya apps sin actualizar.
  if (lect.tipo !== "usuario") return buscarPase(lect);

  if (!lect.uid) return pintarIdentidad(null, "El QR no trae el id del usuario.");

  let perfil = null, sesion = null;
  try {
    const [p, ss] = await Promise.all([
      getDoc(doc(db, "usuarios", lect.uid)),
      getDoc(doc(db, "sesionesQR", lect.uid))
    ]);
    if (p.exists()) perfil = { uid: p.id, ...p.data() };
    if (ss.exists()) sesion = ss.data();
  } catch (e) {
    return pintarIdentidad(null, "No se pudo leer el padron: " + e.message);
  }

  if (!perfil) return pintarIdentidad(null, "No hay ningun usuario registrado con ese id.");

  let aviso = "";
  if (!lect.codigo) {
    aviso = "Lectura sin codigo de sesion: identidad sin verificar.";
  } else if (!sesion || sesion.codigo !== lect.codigo) {
    aviso = "El codigo no coincide con la sesion activa. Pide que abra su credencial otra vez.";
  } else if (Number(sesion.expira || 0) + GRACIA_SESION < Date.now()) {
    aviso = "El codigo ya caduco. Puede ser una captura de pantalla.";
  }

  pintarIdentidad(perfil, aviso);
}

/** Muestra en pantalla quien es la persona que acaba de escanear. */
function pintarIdentidad(u, aviso) {
  const c = $("#taq-resultado");

  if (!u) {
    c.innerHTML = '<div class="taq-res mal">' +
      '<div class="taq-veredicto mal">✕ Sin identificar</div>' +
      '<p class="pista">' + esc(aviso || "") + '</p></div>';
    toast(aviso || "Sin coincidencia.", "error");
    return;
  }

  const ok = !aviso;
  // Los viajes vigentes ya no vienen en el QR: los busca el panel por uid.
  const suyos = E.viajes.filter(v => v.uid === u.uid && ESTADOS_VIVOS.includes(v.estado));
  const abordable = suyos.find(v => !v.abordadoEn);

  c.innerHTML = '<div class="taq-res ' + (ok ? "ok" : "mal") + '">' +
    (ok
      ? '<div class="taq-veredicto ok">✓ Identidad verificada</div>'
      : '<div class="taq-veredicto mal">! Identidad sin verificar</div>') +
    '<h3>' + esc(u.nombre || "Sin nombre") + '</h3>' +
    '<span class="dato-num">' + esc(u.uid) + '</span>' +
    '<dl>' +
      '<dt>Correo</dt><dd class="dato-num">' + esc(u.correo || u.email || "—") + '</dd>' +
      '<dt>Telefono</dt><dd class="dato-num">' + esc(u.telefono || "—") + '</dd>' +
      '<dt>Ciudad</dt><dd>' + esc(u.ciudad || "—") + '</dd>' +
      '<dt>Viajes</dt><dd class="dato-num">' + (u.viajes || 0) + '</dd>' +
      '<dt>Alta</dt><dd>' + esc(fecha(u.creadoEn || u.alta)) + '</dd>' +
      '<dt>Viaje vigente</dt><dd>' + (suyos.length
        ? esc(suyos[0].origen?.texto || "—") + ' → ' + esc(suyos[0].destino?.texto || "—") +
          (boletoDe(suyos[0]) ? ' · boleto <span class="dato-num">' + esc(boletoDe(suyos[0])) + '</span>' : '')
        : "Ninguno") + '</dd>' +
    '</dl>' +
    (aviso ? '<p class="pista" style="color:var(--ambar)">' + esc(aviso) + '</p>' : "") +
    (ok && abordable
      ? '<button class="btn btn-ok" style="margin-top:.9rem" data-abordar="' + abordable.id + '">Registrar abordaje</button>'
      : "") +
  '</div>';

  const b = $("[data-abordar]");
  if (b) b.onclick = () => registrarAbordaje(abordable);

  toast(ok ? "Identificado: " + (u.nombre || u.uid) : aviso, ok ? "exito" : "error");
}

/** Compatibilidad: busca el viaje del pase antiguo. Recibe la lectura ya
    interpretada, no el texto crudo. */
async function buscarPase(lect) {
  if (!lect) return;

  let viaje = null, aviso = "";

  if (lect.viajeId) {
    viaje = E.viajes.find(v => v.id === lect.viajeId);
    if (!viaje) {
      // Puede ser un viaje fuera de la escucha en vivo: lo pedimos directo.
      try {
        const d = await getDoc(doc(db, "viajes", lect.viajeId));
        if (d.exists()) viaje = { id: d.id, ...d.data() };
      } catch (e) { console.warn(e); }
    }
    if (viaje && lect.uid && viaje.uid && viaje.uid !== lect.uid) {
      pintarPase(null, "El QR no corresponde al pasajero de ese viaje.");
      return;
    }
  } else {
    const coinciden = E.viajes.filter(v => (v.folio || folioDe(v.id)) === lect.folio);
    if (coinciden.length > 1) {
      // Con folio tecleado puede haber empate: nos quedamos con el vigente.
      const vivos = coinciden.filter(v => ESTADOS_VIVOS.includes(v.estado));
      viaje = vivos[0] || coinciden[0];
      if (vivos.length > 1) aviso = "Hay " + vivos.length + " viajes con ese folio. Verifica el nombre del pasajero.";
    } else {
      viaje = coinciden[0] || null;
    }
  }

  pintarPase(viaje, viaje ? aviso : "No encontramos ningún viaje con «" + esc(lect.folio || lect.viajeId) + "».");
}

function pintarPase(v, aviso) {
  const c = $("#taq-resultado");
  if (!v) {
    c.innerHTML = '<div class="taq-res mal"><div class="taq-veredicto mal">✕ Sin coincidencia</div>' +
      '<p class="pista">' + esc(aviso || "") + '</p></div>';
    toast(aviso || "Sin coincidencia.", "error");
    return;
  }
  const vigente = ESTADOS_VIVOS.includes(v.estado);
  const unidad = E.unidades.find(u => u.id === v.unidadId);
  const veredicto = v.abordadoEn
    ? ['<div class="taq-veredicto mal">! Ya registrado</div>', "mal"]
    : vigente
      ? ['<div class="taq-veredicto ok">✓ Pase válido</div>', "ok"]
      : ['<div class="taq-veredicto mal">✕ Viaje ' + esc(v.estado || "") + '</div>', "mal"];

  c.innerHTML = '<div class="taq-res ' + veredicto[1] + '">' +
    veredicto[0] +
    '<h3>' + esc(v.pasajero?.nombre || "Sin nombre") + '</h3>' +
    '<span class="dato-num">' + esc(v.folio || folioDe(v.id)) + (boletoDe(v) ? ' · boleto ' + esc(boletoDe(v)) : '') + '</span>' +
    '<dl>' +
      '<dt>Ruta</dt><dd>' + esc(v.origen?.texto || "—") + ' → ' + esc(v.destino?.texto || "—") + '</dd>' +
      '<dt>Servicio</dt><dd>' + esc(v.claseNombre || "—") + '</dd>' +
      '<dt>Grupo</dt><dd>' + (v.pasajeros || 1) + ' pasajero(s) · ' + (v.maletas || 0) + ' maleta(s)</dd>' +
      (v.vuelo ? '<dt>Vuelo</dt><dd class="dato-num">' + esc(v.vuelo) + (terminalAIFA(v) ? ' · ' + esc(terminalAIFA(v)) : '') + '</dd>' : "") +
      '<dt>Teléfono</dt><dd class="dato-num">' + esc(v.pasajero?.telefono || "—") + '</dd>' +
      '<dt>Total</dt><dd class="dato-num">' + dinero(v.precio) + '</dd>' +
      '<dt>Pago</dt><dd>' + (v.pago === "tarjeta" ? "Tarjeta" : "Efectivo") + '</dd>' +
      '<dt>Estado</dt><dd><span class="sello sello-' + esc(v.estado) + '">' + esc(v.estado) + '</span></dd>' +
      (unidad ? '<dt>Unidad</dt><dd class="dato-num">' + esc(unidad.numero) + '</dd>' : "") +
      '<dt>Solicitado</dt><dd>' + esc(fecha(v.creadoEn)) + '</dd>' +
      (v.abordadoEn ? '<dt>Abordaje</dt><dd>' + esc(fecha(v.abordadoEn)) + '</dd>' : "") +
    '</dl>' +
    (aviso ? '<p class="pista" style="color:var(--ambar)">' + esc(aviso) + '</p>' : "") +
    (vigente && !v.abordadoEn
      ? '<button class="btn btn-ok" style="margin-top:.9rem" data-abordar="' + v.id + '">Registrar abordaje</button>'
      : "") +
    '</div>';

  const b = $("[data-abordar]");
  if (b) b.onclick = () => registrarAbordaje(v);
}

async function registrarAbordaje(v) {
  try {
    await updateDoc(doc(db, "viajes", v.id), { abordadoEn: serverTimestamp() });
    toast("Abordaje registrado: " + (v.pasajero?.nombre || v.id), "exito");
    recientes.unshift({ nombre: v.pasajero?.nombre || "—", folio: v.folio || folioDe(v.id), hora: new Date() });
    recientes.length = Math.min(recientes.length, 8);
    pintarRecientes();
    $("#taq-resultado").innerHTML = "";
    $("#taq-entrada").value = "";
    $("#taq-entrada").focus();
  } catch (e) { toast("Error: " + e.message, "error"); }
}

const recientes = [];
function pintarRecientes() {
  $("#taq-recientes").innerHTML = recientes.length
    ? "Últimos abordajes: " + recientes.map(r =>
        esc(r.nombre) + " (" + esc(r.folio) + ") " + r.hora.toLocaleTimeString("es-MX", { hour: "2-digit", minute: "2-digit" })
      ).join(" · ")
    : "";
}

$("#taq-buscar").onclick = () => identificar($("#taq-entrada").value);
$("#taq-entrada").addEventListener("keydown", ev => {
  // El lector de pistola escribe la lectura y manda Enter: esto lo cubre.
  if (ev.key === "Enter") { ev.preventDefault(); identificar($("#taq-entrada").value); }
});

/* ─── Cámara (opcional; requiere BarcodeDetector) ───────── */
let camaraStream = null, camaraCorriendo = false;

$("#taq-camara").onclick = async () => {
  if (!("BarcodeDetector" in window)) {
    toast("Este navegador no trae lector de códigos. Usa Chrome o un lector de pistola.", "error");
    return;
  }
  try {
    camaraStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
    const video = $("#taq-video");
    video.srcObject = camaraStream;
    await video.play();
    $("#taq-lector").classList.add("viva");
    camaraCorriendo = true;
    const detector = new BarcodeDetector({ formats: ["qr_code"] });
    const tick = async () => {
      if (!camaraCorriendo) return;
      try {
        const codigos = await detector.detect(video);
        if (codigos.length) {
          const txt = codigos[0].rawValue;
          cerrarCamara();
          $("#taq-entrada").value = txt;
          identificar(txt);
          return;
        }
      } catch {}
      setTimeout(tick, 220);
    };
    tick();
  } catch (e) { toast("No se pudo abrir la cámara: " + e.message, "error"); }
};

function cerrarCamara() {
  camaraCorriendo = false;
  camaraStream?.getTracks().forEach(t => t.stop());
  camaraStream = null;
  $("#taq-lector").classList.remove("viva");
}
$("#taq-cerrar-cam").onclick = cerrarCamara;

/* ══════════════════════════════════════════════════════════════
   USUARIOS — padrón y descarga
   ══════════════════════════════════════════════════════════════ */
let USUARIOS = null;

async function cargarUsuarios(forzar = false) {
  if (USUARIOS && !forzar) return;
  try {
    const snap = await getDocs(collection(db, "usuarios"));
    USUARIOS = snap.docs.map(d => ({ uid: d.id, ...d.data() }));
    pintarUsuarios();
  } catch (e) {
    $("#tbody-usuarios").innerHTML =
      '<tr><td colspan="8" class="vacio" style="border:none">No se pudo leer la colección: ' + esc(e.message) + '</td></tr>';
  }
}

/** ¿Ya está dado de alta en taquilla? */
function clienteTaquilla(u) {
  const t = u.terminal || {};
  const tel = String(u.telefono || "").replace(/\D/g, "").slice(-10);
  if (t.conflicto) return '<span class="taq-chip mal" title="' + esc(t.error || "") + '"><i></i>Teléfono duplicado</span>';
  if (t.idCliente != null) return '<span class="taq-chip ok"><i></i>Cliente <b>' + esc(t.idCliente) + '</b>' + (t.simulado ? " · prueba" : "") + '</span>';
  if (tel.length !== 10) return '<span class="taq-chip"><i></i>Sin teléfono</span>';
  if (t.error) return '<span class="taq-chip mal" title="' + esc(t.error) + '"><i></i>Error</span>';
  return '<span class="taq-chip espera"><i></i>Pendiente</span>';
}

function pintarUsuarios() {
  $("#cta-usuarios").textContent = USUARIOS.length;
  $("#tbody-usuarios").innerHTML = USUARIOS.length
    ? USUARIOS.map(u => '<tr>' +
        '<td>' + esc(u.nombre || "—") + '</td>' +
        '<td class="dato-num">' + esc(u.correo || u.email || "—") + '</td>' +
        '<td class="dato-num">' + esc(u.telefono || "—") + '</td>' +
        '<td>' + esc(u.ciudad || "—") + '</td>' +
        '<td class="dato-num">' + (u.viajes || 0) + '</td>' +
        '<td class="dato-num">' + dinero(u.gastado) + '</td>' +
        '<td>' + clienteTaquilla(u) + '</td>' +
        '<td>' + esc(fecha(u.creadoEn || u.alta)) + '</td>' +
      '</tr>').join("")
    : '<tr><td colspan="8" class="vacio" style="border:none">Todavía no hay usuarios registrados.</td></tr>';
}

function bajarArchivo(nombre, contenido, tipo) {
  const url = URL.createObjectURL(new Blob([contenido], { type: tipo }));
  const a = document.createElement("a");
  a.href = url; a.download = nombre;
  document.body.appendChild(a); a.click(); a.remove();
  setTimeout(() => URL.revokeObjectURL(url), 2000);
}

const hoy = () => new Date().toISOString().slice(0, 10);

$("#btn-usuarios-json").onclick = async () => {
  await cargarUsuarios();
  if (!USUARIOS) return;
  bajarArchivo("usuarios-" + hoy() + ".json", JSON.stringify(USUARIOS, null, 2), "application/json");
  toast("Descargando " + USUARIOS.length + " usuarios.", "exito");
};

$("#btn-usuarios-csv").onclick = async () => {
  await cargarUsuarios();
  if (!USUARIOS) return;
  const cols = ["uid", "nombre", "apellidop", "apellidom", "correo", "telefono", "ciudad", "viajes", "gastado", "puntos", "saldo", "idClienteTaquilla", "creadoEn"];
  const celda = val => {
    if (val == null) return "";
    if (val?.toDate) val = val.toDate().toISOString();
    const t = String(typeof val === "object" ? JSON.stringify(val) : val);
    return /[",;\n]/.test(t) ? '"' + t.replace(/"/g, '""') + '"' : t;
  };
  const filas = [cols.join(",")].concat(
    USUARIOS.map(u => cols.map(k => celda(
      k === "correo" ? (u.correo ?? u.email) : k === "idClienteTaquilla" ? u.terminal?.idCliente : u[k]
    )).join(","))
  );
  // BOM para que Excel abra bien los acentos
  bajarArchivo("usuarios-" + hoy() + ".csv", "\uFEFF" + filas.join("\r\n"), "text/csv;charset=utf-8");
  toast("Descargando " + USUARIOS.length + " usuarios.", "exito");
};

</script>
</body>
</html>