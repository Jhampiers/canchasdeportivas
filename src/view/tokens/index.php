<?php require __DIR__ . '/../layout/header.php'; ?>
<style>
  .cap-wrap{padding:16px}
  .cap-card{background:#fff;border-radius:14px;box-shadow:0 8px 24px rgba(15,23,42,.08);padding:16px;margin-bottom:16px}
  .cap-toolbar{display:flex;gap:10px;align-items:center;flex-wrap:wrap;justify-content:space-between}
  .cap-title{font-size:20px;font-weight:700}
  .cap-actions{display:flex;gap:10px;flex-wrap:wrap}
  .cap-input{padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;min-width:260px}
  .cap-select{padding:10px 12px;border:1px solid #e5e7eb;border-radius:12px;background:#fff}
  .cap-btn{display:inline-block;padding:10px 12px;border-radius:10px;border:1px solid #e5e7eb;background:#fff;cursor:pointer;text-decoration:none;color:#111827}
  .cap-btn.primary{background:#2563eb;color:#fff;border-color:#1d4ed8}
  .cap-tablewrap{overflow:auto;border-radius:14px;background:#fff;box-shadow:0 8px 24px rgba(15,23,42,.08)}
  table.cap{width:100%;min-width:900px;border-collapse:collapse}
  table.cap thead tr{background:#f3f4f6}
  table.cap th, table.cap td{padding:12px 14px;border-bottom:1px solid #e5e7eb;text-align:left;font-size:14px}
  .cap-badge{padding:4px 8px;border-radius:999px;font-size:12px;font-weight:600}
  .ok{background:#dcfce7;color:#065f46} .off{background:#fee2e2;color:#991b1b} .pend{background:#fef3c7;color:#92400e}
  .cap-empty{padding:18px;text-align:center;color:#6b7280}
</style>

<div class="cap-wrap">
  <div class="cap-card cap-toolbar">
    <div class="cap-title"><i class="fa-solid fa-key"></i> Tokens</div>
    <div class="cap-actions">
      <input id="qTok" class="cap-input" placeholder="Buscar por Cliente / Token...">
      <select id="fTok" class="cap-select">
        <option value="">Todos</option>
        <option value="activo">Activo</option>
        <option value="inactivo">Inactivo</option>
        <option value="pendiente">Pendiente</option>
      </select>
      <a class="cap-btn primary" href="<?= BASE_URL ?>?c=token&a=create">+ Nuevo</a>
    </div>
  </div>

  <div class="cap-tablewrap">
    <table class="cap">
      <thead>
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Token</th>
          <th>Estado</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tbodyTok">
        <?php foreach($tokens as $t): ?>
          <?php
            $estado = strtolower($t['estado'] ?? '');
            $badge = $estado==='activo' ? 'ok' : ($estado==='inactivo' ? 'off' : 'pend');
            $text = mb_strtolower(($t['razon_social'] ?? '').' '.($t['token'] ?? ''), 'UTF-8');
          ?>
          <tr data-text="<?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8') ?>" data-estado="<?= htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') ?>">
            <td><?= (int)$t['id'] ?></td>
            <td><?= htmlspecialchars($t['razon_social']) ?></td>
            <td><code><?= htmlspecialchars($t['token']) ?></code></td>
            <td><span class="cap-badge <?= $badge ?>"><?= htmlspecialchars($t['estado']) ?></span></td>
            <td><?= htmlspecialchars($t['fecha_reg']) ?></td>
            <td>
              <a class="cap-btn" href="<?= BASE_URL ?>?c=token&a=show&id=<?= (int)$t['id'] ?>">Ver</a>
              <a class="cap-btn" href="<?= BASE_URL ?>?c=token&a=edit&id=<?= (int)$t['id'] ?>">Editar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div id="tokEmpty" class="cap-card cap-empty" style="display:none">Sin resultados</div>
</div>

<script>
  const $q=document.getElementById('qTok');
  const $f=document.getElementById('fTok');
  const $rows=[...document.querySelectorAll('#tbodyTok tr')];
  const $empty=document.getElementById('tokEmpty');
  const norm=s=>(s||'').toString().normalize('NFD').replace(/[\u0300-\u036f]/g,'').toLowerCase();
  function apply(){
    const q=norm($q.value.trim()), est=norm($f.value.trim()); let vis=0;
    $rows.forEach(tr=>{
      const text=norm(tr.dataset.text||''), estado=norm(tr.dataset.estado||'');
      const show=(!q||text.includes(q))&&(!est||estado===est);
      tr.style.display=show?'':'none'; if(show) vis++;
    });
    $empty.style.display = vis?'none':'';
  }
  const deb=(fn,ms)=>{let t;return(...a)=>{clearTimeout(t);t=setTimeout(()=>fn(...a),ms)}};
  $q.addEventListener('input',deb(apply,120)); $f.addEventListener('change',apply); apply();
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
