<section class="uk-section uk-section-xsmall" uk-height-viewport="expand: true">
  <div class="uk-container">
    <div class="uk-flex uk-flex-middle uk-margin" uk-grid>
      <div class="uk-width-expand">
        <ul class="uk-breadcrumb uk-margin-remove">
          <li><a href="<?= site_url('admin') ?>"><?= lang('dashboard') ?></a></li>
          <li><span>Itemlist</span></li>
        </ul>
        <h1 class="uk-h3 uk-text-bold uk-margin-remove">Ítems del juego</h1>
      </div>
    </div>

    <div class="uk-margin" uk-grid>
      <div class="uk-width-expand@s">

        <!-- Filtros -->
        <form method="get" class="uk-grid-small uk-margin-bottom" uk-grid>
          <div class="uk-width-1-3@s">
            <input class="uk-input" type="text" name="search" placeholder="Buscar nombre..." value="<?= html_escape($filters['search'] ?? '') ?>">
          </div>
          <div class="uk-width-1-6@s">
            <select class="uk-select" name="quality">
              <option value="">Rareza</option>
              <?php foreach (getItemQualityName() as $k => $v): ?>
                <option value="<?= $k ?>" <?= ($filters['quality'] !== '' && $filters['quality'] == $k) ? 'selected' : '' ?>><?= $v ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="uk-width-1-6@s">
            <input class="uk-input" type="number" name="min_level" placeholder="Nivel mínimo" value="<?= html_escape($filters['min_level'] ?? '') ?>">
          </div>
          <div class="uk-width-1-6@s">
            <button class="uk-button uk-button-primary" type="submit"><i class="fa fa-filter"></i> Filtrar</button>
          </div>
        </form>

        <!-- Tabla de ítems -->
        <div class="uk-card uk-card-default">
          <div class="uk-card-header">
            <h3 class="uk-card-title"><i class="fa-solid fa-cubes-stacked"></i> Lista de ítems</h3>
          </div>
          <div class="uk-card-body uk-padding-remove">
            <table class="uk-table uk-table-divider uk-table-small uk-table-hover uk-table-middle">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>Lvl Req</th>
                  <th>Rareza</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($items as $item): ?>
                  <tr>
                    <td><?= $item->entry ?></td>
                    <td>
                      <a href="https://wowhead.com/item=<?= $item->entry ?>" data-wowhead="item=<?= $item->entry ?>" target="_blank">
                        <?= $item->name ?>
                      </a>
                    </td>
                    <td><?= floor($item->BuyPrice / 10000) ?> 🪙</td>
                    <td><?= $item->RequiredLevel ?></td>
                    <td><?= getItemQualityName($item->Quality) ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Paginación -->
        <?php if ($total_pages > 1): ?>
<ul class="uk-pagination uk-flex-center uk-margin-top">

  <!-- Anterior -->
  <?php if ($current_page > 1): ?>
    <li>
      <a href="<?= site_url('itemlist/admin') . '?' . http_build_query(array_merge($filters, ['page' => $current_page - 1])) ?>">
        <span uk-pagination-previous></span>
      </a>
    </li>
  <?php endif ?>

  <?php
    $range = 2; // Cantidad de páginas a mostrar a cada lado
    $start = max(1, $current_page - $range);
    $end = min($total_pages, $current_page + $range);

    if ($start > 1) {
        echo '<li><a href="' . site_url('itemlist/admin') . '?' . http_build_query(array_merge($filters, ['page' => 1])) . '">1</a></li>';
        if ($start > 2) echo '<li class="uk-disabled"><span>…</span></li>';
    }

    for ($i = $start; $i <= $end; $i++):
  ?>
    <li class="<?= ($i == $current_page) ? 'uk-active' : '' ?>">
      <a href="<?= site_url('itemlist/admin') . '?' . http_build_query(array_merge($filters, ['page' => $i])) ?>"><?= $i ?></a>
    </li>
  <?php endfor ?>

  <?php
    if ($end < $total_pages) {
        if ($end < $total_pages - 1) echo '<li class="uk-disabled"><span>…</span></li>';
        echo '<li><a href="' . site_url('itemlist/admin') . '?' . http_build_query(array_merge($filters, ['page' => $total_pages])) . '">' . $total_pages . '</a></li>';
    }
  ?>

  <!-- Siguiente -->
  <?php if ($current_page < $total_pages): ?>
    <li>
      <a href="<?= site_url('itemlist/admin') . '?' . http_build_query(array_merge($filters, ['page' => $current_page + 1])) ?>">
        <span uk-pagination-next></span>
      </a>
    </li>
  <?php endif ?>

</ul>
<?php endif ?>


        <script src="https://wow.zamimg.com/widgets/power.js"></script>

      </div>
    </div>
  </div>
</section>
