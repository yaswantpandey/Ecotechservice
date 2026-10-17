<?php
/** @var array $report  table => [exists, missing[], rows] */
/** @var array $logLines */
/** @var array|null $results */
$problems = 0;
foreach ($report as $r) {
    if (!$r['exists'] || $r['missing']) $problems++;
}
$tracksRows = $report['internship_tracks']['rows'] ?? null;
?>

<?php if ($results): ?>
<div class="a-card a-card-pad" style="margin-bottom:1.25rem">
  <h2 class="s-h3" style="margin-bottom:.75rem">Repair results</h2>
  <ul style="list-style:none;margin:0;padding:0">
    <?php foreach ($results as [$kind, $msg]): ?>
    <li style="padding:.45rem 0;border-bottom:1px solid var(--rule)">
      <span class="s-tag <?= $kind === 'ok' ? 's-tag--signal' : 's-tag--danger' ?>"><?= $kind === 'ok' ? 'Done' : 'Failed' ?></span>
      <span class="s-small" style="margin-left:.5rem"><?= Security::e($msg) ?></span>
    </li>
    <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>

<div class="a-stats" style="margin-bottom:1.25rem">
  <div class="a-stat"><b><?= count($report) ?></b><span>Internship tables expected</span></div>
  <div class="a-stat"><b><?= $problems ?></b><span>Tables missing or incomplete</span></div>
  <div class="a-stat"><b><?= $tracksRows === null ? '&mdash;' : (int) $tracksRows ?></b><span>Internship tracks in database</span></div>
  <div class="a-stat"><b><?= count($logLines) ?></b><span>Recent logged errors</span></div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
  <div class="lg:col-span-8">
    <div class="a-card">
      <div class="a-card-head">
        <h2>Internship schema</h2>
        <?php if ($problems === 0 && (int) $tracksRows > 0): ?>
          <span class="s-tag s-tag--signal">All present</span>
        <?php else: ?>
          <span class="s-tag s-tag--danger">Needs repair</span>
        <?php endif; ?>
      </div>
      <div class="a-table-wrap">
        <table class="a-table">
          <thead><tr><th>Table</th><th>Status</th><th>Missing columns</th><th class="a-right">Rows</th></tr></thead>
          <tbody>
            <?php if (!$report): ?>
            <tr><td colspan="4" class="a-empty">Migration file app/schema/internship_migration.sql was not found on the server.</td></tr>
            <?php endif; ?>
            <?php foreach ($report as $table => $r): ?>
            <tr>
              <td class="s-mono"><?= Security::e($table) ?></td>
              <td>
                <?php if (!$r['exists']): ?>
                  <span class="s-tag s-tag--danger">Missing</span>
                <?php elseif ($r['missing']): ?>
                  <span class="s-tag s-tag--danger">Incomplete</span>
                <?php else: ?>
                  <span class="s-tag s-tag--signal">OK</span>
                <?php endif; ?>
              </td>
              <td class="s-small"><?= $r['missing'] ? Security::e(implode(', ', $r['missing'])) : '&mdash;' ?></td>
              <td class="a-right s-mono"><?= $r['rows'] === null ? '&mdash;' : (int) $r['rows'] ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="a-card" style="margin-top:1.25rem">
      <div class="a-card-head"><h2>Recent internship errors</h2><span class="s-small s-mute">from logs/error.log</span></div>
      <div class="a-card-pad">
        <?php if (!$logLines): ?>
          <p class="s-small s-mute" style="margin:0">No internship database errors logged (or logs/error.log does not exist on the server).</p>
        <?php else: ?>
          <pre class="s-mono" style="margin:0;white-space:pre-wrap;word-break:break-word;font-size:.75rem;line-height:1.5"><?php foreach ($logLines as $l) echo Security::e($l), "\n"; ?></pre>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="lg:col-span-4">
    <div class="a-card a-card-pad">
      <h2 class="s-h3" style="margin-bottom:.6rem">Repair</h2>
      <p class="s-small" style="color:var(--ink-2)">Creates anything missing from the internship migration:</p>
      <ul class="s-small" style="list-style:none;margin:.5rem 0 1rem;padding:0;color:var(--ink-2)">
        <li style="padding:.3rem 0">&mdash; tables that do not exist</li>
        <li style="padding:.3rem 0">&mdash; columns missing from existing tables</li>
        <li style="padding:.3rem 0">&mdash; the 11 default tracks, only if the tracks table is empty</li>
      </ul>
      <p class="s-small s-mute">Nothing is dropped, renamed or overwritten. Safe to run more than once.</p>
      <form method="POST" action="<?= url('admin/database/repair') ?>" style="margin-top:1rem"
            onsubmit="return confirm('Create the missing internship tables and columns now?');">
        <?= Security::csrfField() ?>
        <button type="submit" class="s-btn s-btn--block"<?= $report ? '' : ' disabled' ?>>Repair database</button>
      </form>
    </div>
  </div>
</div>
