<?php require __DIR__ . '/../layout/header.php'; ?>

<h2 style="margin:0 0 14px 0">Panel</h2>

<div class="grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem">
  
  <!-- Total -->
  <div class="card kpi" style="display:flex;align-items:center;gap:1rem;padding:1.2rem;border:1px solid #e5e7eb;border-radius:12px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,0.05)">
    <div style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:10px;background:rgba(37,99,235,.1);color:#2563eb">
      <!-- icono chart -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m4 0V9a2 2 0 00-2-2h-1m-6 10v-4a2 2 0 00-2-2H7a2 2 0 00-2 2v4" />
      </svg>
    </div>
    <div>
      <h3 style="margin:0;font-size:14px;color:#6b7280;font-weight:500">Total Canchas</h3>
      <strong style="font-size:20px;color:#111827"><?= $total ?></strong>
    </div>
  </div>

  <!-- Disponibles -->
  <div class="card kpi" style="display:flex;align-items:center;gap:1rem;padding:1.2rem;border:1px solid #e5e7eb;border-radius:12px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,0.05)">
    <div style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:10px;background:rgba(16,185,129,.1);color:#10b981">
      <!-- icono check -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
    </div>
    <div>
      <h3 style="margin:0;font-size:14px;color:#6b7280;font-weight:500">Disponibles</h3>
      <strong style="font-size:20px;color:#111827"><?= $dispon ?></strong>
    </div>
  </div>

  <!-- Cerradas -->
  <div class="card kpi" style="display:flex;align-items:center;gap:1rem;padding:1.2rem;border:1px solid #e5e7eb;border-radius:12px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,0.05)">
    <div style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:10px;background:rgba(239,68,68,.1);color:#ef4444">
      <!-- icono x-circle -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </div>
    <div>
      <h3 style="margin:0;font-size:14px;color:#6b7280;font-weight:500">Cerradas</h3>
      <strong style="font-size:20px;color:#111827"><?= $cerradas ?></strong>
    </div>
  </div>

  <!-- Mantenimiento -->
  <div class="card kpi" style="display:flex;align-items:center;gap:1rem;padding:1.2rem;border:1px solid #e5e7eb;border-radius:12px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,0.05)">
    <div style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:10px;background:rgba(245,158,11,.15);color:#f59e0b">
      <!-- icono wrench -->
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h2l1 2h4l1-2h2l-2 6h-4l-2-6zm12 6h4v2h-4v-2z" />
      </svg>
    </div>
    <div>
      <h3 style="margin:0;font-size:14px;color:#6b7280;font-weight:500">Mantenimiento</h3>
      <strong style="font-size:20px;color:#111827"><?= $mant ?></strong>
    </div>
  </div>

</div>



<div class="card" style="margin-top:16px">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
    <strong>Últimos registros</strong>
    <a class="btn" href="<?= BASE_URL ?>?c=cancha&a=index">Ver todas</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>Nombre</th><th>Ubicación</th><th>Estado</th><th>Precio</th><th>Fecha</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($ultimas as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['nombre']) ?></td>
        <td><?= htmlspecialchars($r['ubicacion']) ?></td>
        <td>
          <?php $cls = $r['estado']==='Disponible'?'ok':($r['estado']==='Cerrado'?'closed':'maint'); ?>
          <span class="tag <?= $cls ?>"><?= htmlspecialchars($r['estado']) ?></span>
        </td>
        <td>S/ <?= number_format($r['precio_hora'],2) ?></td>
        <td><?= htmlspecialchars($r['fecha_registro']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  const serie = <?= json_encode($serie, JSON_UNESCAPED_UNICODE) ?>;
  const labels = serie.map(x => x.d);
  const data   = serie.map(x => Number(x.c));

  const ctx = document.getElementById('regChart');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Canchas',
        data,
        tension: .35,
        borderWidth: 2,
        fill: true
      }]
    },
    options: {
      plugins: { legend: { display:false }},
      scales: { y: { beginAtZero:true } }
    }
  });
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
