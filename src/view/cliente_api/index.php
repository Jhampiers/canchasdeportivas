<?php require __DIR__ . '/../layout/header.php'; ?>
<style>
  .cap-card{background:#fff;border-radius:14px;box-shadow:0 8px 24px rgba(15,23,42,.08);padding:16px;margin-bottom:16px}
  .cap-toolbar{display:flex;gap:10px;align-items:center;flex-wrap:wrap;justify-content:space-between}
  .cap-title{font-size:20px;font-weight:700}
  .cap-actions{display:flex;gap:10px;flex-wrap:wrap}
  .cap-input{padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;min-width:260px}
  .cap-select{padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;background:#fff}
  .cap-btn{display:inline-block;padding:10px 12px;border-radius:10px;border:1px solid #e5e7eb;background:#fff;cursor:pointer}
  .cap-btn.primary{background:#2563eb;color:#fff;border-color:#1d4ed8}
  .cap-btn.icon{display:inline-flex;align-items:center;gap:8px}
  .cap-badge{padding:4px 8px;border-radius:999px;font-size:12px;font-weight:600}
  .cap-ok{background:#dcfce7;color:#065f46}
  .cap-off{background:#fee2e2;color:#991b1b}
  .cap-pend{background:#fef3c7;color:#92400e}
  .cap-tablewrap{overflow:auto;border-radius:14px;background:#fff;box-shadow:0 8px 24px rgba(15,23,42,.08)}
  table.cap{width:100%;min-width:860px;border-collapse:collapse}
  table.cap thead tr{background:#f3f4f6}
  table.cap th, table.cap td{padding:12px 14px;border-bottom:1px solid #e5e7eb;text-align:left;font-size:14px}
  .cap-empty{padding:18px;text-align:center;color:#6b7280}
  @media (max-width:680px){ .cap-input{min-width:unset;width:100%} }
</style>

<div class="cap-card cap-toolbar">
  <div class="cap-title"><i class="fa-solid fa-building"></i> Clientes</div>
  <div class="cap-actions">
   
    <input id="qClientes" class="cap-input" placeholder="Buscar por RUC / Razón social...">
    <select id="fEstadoClientes" class="cap-select">
      <option value="">Todos</option>
      <option>Activo</option>
      <option>Inactivo</option>
      <option>Pendiente</option>
    </select>
    <a class="cap-btn primary icon" href="<?= BASE_URL ?>?c=clienteapi&a=create"><i class="fa-solid fa-plus"></i> Nuevo</a>
  </div>
</div>

<div class="cap-tablewrap">
  <table class="cap">
    <thead>
      <tr>
        <th>ID</th>
        <th>RUC</th>
        <th>Razón social</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Estado</th>
        <th>Fecha registro</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="tbodyClientes">
      <?php foreach ($clientes as $cl): ?>
        <?php
          // 🔹 IMPORTANTE: preparamos texto “plano” para búsqueda
          $texto = mb_strtolower(
            ($cl['ruc'] ?? '') . ' ' .
            ($cl['razon_social'] ?? '') . ' ' .
            ($cl['telefono'] ?? '') . ' ' .
            ($cl['correo'] ?? ''),
            'UTF-8'
          );
          $estado = strtolower($cl['estado'] ?? '');
          $badge = $estado==='activo' ? 'cap-ok' : ($estado==='inactivo' ? 'cap-off' : 'cap-pend');
        ?>
        <tr
          data-text="<?= htmlspecialchars($texto, ENT_QUOTES, 'UTF-8') ?>"   
          data-estado="<?= htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') ?>" 
        >
          <td><?= $cl['id'] ?></td>
          <td><?= htmlspecialchars($cl['ruc']) ?></td>
          <td><?= htmlspecialchars($cl['razon_social']) ?></td>
          <td><?= htmlspecialchars($cl['telefono']) ?></td>
          <td><?= htmlspecialchars($cl['correo']) ?></td>
          <td><span class="cap-badge <?= $badge ?>"><?= htmlspecialchars($cl['estado']) ?></span></td>
          <td><?= htmlspecialchars($cl['fecha_registro']) ?></td>
        <td>
  <a class="cap-btn" href="<?= BASE_URL ?>?c=clienteapi&a=show&id=<?= (int)$cl['id'] ?>">Ver</a>
  <a class="cap-btn" href="<?= BASE_URL ?>?c=clienteapi&a=edit&id=<?= (int)$cl['id'] ?>">Editar</a>
</td>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="cap-card cap-empty" id="emptyClientes" style="display:none">Sin resultados</div>

<script>
  // ---------- Filtro cliente-side robusto ----------
  const $q = document.getElementById('qClientes');
  const $f = document.getElementById('fEstadoClientes');
  const $rows = Array.from(document.querySelectorAll('#tbodyClientes tr'));
  const $empty = document.getElementById('emptyClientes');

  // Normaliza acentos y minúsculas
  function normalize(str){
    return (str || '')
      .toString()
      .normalize('NFD')
      .replace(/[\\u0300-\\u036f]/g, '') // quita acentos
      .toLowerCase();
  }

  function aplicarFiltro(){
    const q = normalize($q.value.trim());
    const est = normalize($f.value.trim());
    let visibles = 0;

    $rows.forEach(tr => {
      const text = normalize(tr.dataset.text || '');
      const estado = normalize(tr.dataset.estado || '');
      const matchText = !q || text.includes(q);
      const matchEstado = !est || estado === est;
      const show = matchText && matchEstado;
      tr.style.display = show ? '' : 'none';
      if (show) visibles++;
    });

    $empty.style.display = visibles ? 'none' : '';
  }

  // Pequeño debounce para no filtrar en cada tecla muy rápido
  function debounce(fn, delay){
    let t; return (...args)=>{ clearTimeout(t); t = setTimeout(()=>fn(...args), delay); };
  }

  $q.addEventListener('input', debounce(aplicarFiltro, 120));
  $f.addEventListener('change', aplicarFiltro);
  aplicarFiltro(); // primer render
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>



