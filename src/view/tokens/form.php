<?php require __DIR__ . '/../layout/header.php'; ?>
<style>
  .cap-wrap{padding:16px}
  .cap-card{background:#fff;border-radius:14px;box-shadow:0 8px 24px rgba(15,23,42,.08);padding:16px;margin-bottom:16px}
  .cap-title{font-size:20px;font-weight:700;margin-bottom:10px}
  .grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
  .grid .full{grid-column:1/-1}
  label{display:block;margin:6px 0 6px 2px;font-weight:600}
  input,select{width:100%;padding:11px 12px;border-radius:12px;border:1px solid #e5e7eb;background:#fff}
  .actions{display:flex;gap:10px;margin-top:12px;flex-wrap:wrap}
  .btn{display:inline-block;padding:10px 12px;border-radius:10px;border:1px solid #e5e7eb;background:#fff;cursor:pointer;text-decoration:none;color:#111827}
  .btn.primary{background:#2563eb;color:#fff;border-color:#1d4ed8}
  .btn.gray{background:#f3f4f6}
  .alert{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:10px;border-radius:10px;margin-bottom:12px}
  @media (max-width:760px){ .grid{grid-template-columns:1fr} }
</style>

<div class="cap-wrap">
  <div class="cap-card">
    <div class="cap-title"><?= !empty($isEdit) ? 'Editar token' : 'Nuevo token' ?></div>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>?c=token&a=<?= !empty($isEdit)?'update':'store' ?>">
      <?php if(!empty($isEdit)): ?>
        <input type="hidden" name="id" value="<?= (int)$token['id'] ?>">
      <?php endif; ?>

      <div class="grid">
        <div class="full">
          <label>Cliente *</label>
          <select name="id_client_api" id="id_client_api" required>
            <option value="">-- Seleccione --</option>
            <?php foreach ($clients as $c): ?>
              <?php $sel = (!empty($token['id_client_api']) && (int)$token['id_client_api']===(int)$c['id']) ? 'selected':''; ?>
              <option value="<?= (int)$c['id'] ?>" <?= $sel ?>>
                <?= htmlspecialchars($c['razon_social'].' — '.$c['ruc']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="full">
          <label>Token *</label>
          <div style="display:flex;gap:8px;align-items:center">
            <input id="tokVal" name="token" required value="<?= htmlspecialchars($token['token'] ?? '') ?>">
            <button class="btn gray" type="button" onclick="genToken()">Generar</button>
          </div>
        </div>

        <div class="full">
          <label>Estado</label>
          <?php $est = $token['estado'] ?? 'Activo'; ?>
          <select name="estado">
            <option <?= $est==='Activo'?'selected':'' ?>>Activo</option>
            <option <?= $est==='Inactivo'?'selected':'' ?>>Inactivo</option>
            <option <?= $est==='Pendiente'?'selected':'' ?>>Pendiente</option>
          </select>
        </div>
      </div>

      <div class="actions">
        <button class="btn primary" type="submit">Guardar</button>
        <a class="btn" href="<?= BASE_URL ?>?c=token&a=index">Cancelar</a>
      </div>
    </form>
  </div>
</div>

<script>
  function genToken(){
    let id= document.getElementById('id_client_api').value;
    const rnd = crypto.getRandomValues(new Uint8Array(16));
    const hex = [...rnd].map(b=>b.toString(16).padStart(2,'0')).join('');
    document.getElementById('tokVal').value = 'tok_' + hex+'-'+id;
  }
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
