<!DOCTYPE html>
<html lang="<?= lang('Interface.code') ?>">

<?= view('user/head') ?>

<body>
  <?= view('user/navbar') ?>

  <div class="container">
    <h1 class="mb-4">Server Status</h1>
    <?php foreach ($servers as $server) : $stat = $server->stat ? $server->stat->metadata : null; $stat_update = $server->stat ? humanize($server->stat->updated_at) : null ?>
    <h3> <?= $server->description ?> Server &mdash; <?= $server->alias ?>.domcloud.id &mdash; *<?= $server->domain ?></h3>
    <div class="row mb-3">
      <?php if ($stat) : ?>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <table class="table table-sm">
                <tbody>
                  <tr>
                    <td class="text-center">
                      <?= $server->ip ?> &mdash; <?= $stat->host->os ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">
                      <?= $stat->load[7] ?>&nbsp;cores, <?= $stat->procs ?>&nbsp;processes, <?= $stat->fcount->doms ?>&nbsp;hosts, <?= $stat->fcount->dbs ?>&nbsp;databases
                    </td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-sm">
                <tr>
                  <td width="100px">Memory</td>
                  <td>
                    <div class="progress my-1">
                      <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: <?= 100 * ($stat->mem[0] - $stat->mem[1]) / $stat->mem[0] ?>%"></div>
                      <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: <?= 100 * ($stat->mem[4]) / $stat->mem[0] ?>%"></div>
                    </div>
                  </td>
                  <td width="150px" class="text-end">
                    <?= format_bytes(($stat->mem[0] - $stat->mem[1]) * 1024) ?> /
                    <?= format_bytes($stat->mem[0] * 1024) ?>
                  </td>
                </tr>
                <tr>
                  <td>Disk</td>
                  <td>
                    <div class="progress my-1">
                      <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: <?= 100 * ($stat->disk_total - $stat->disk_free) / $stat->disk_total ?>%"></div>
                    </div>
                  </td>
                  <td class="text-end">
                    <?= format_bytes($stat->disk_total - $stat->disk_free) ?> /
                    <?= format_bytes($stat->disk_total) ?>
                  </td>
                </tr>
              </table>
              <div class="d-flex">
                <div class="me-auto">
                  <a href="//status.domcloud.id" title="See status page">
                    <img src="https://img.shields.io/uptimerobot/ratio/<?= $server->status ?>" alt="">
                  </a>
                </div>
                <div class="text-muted text-end">
                  <small><?= lang('Interface.lastUpdated') ?> <?= $stat_update ?></small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title">
                <h5>Servers</h5>
              </div>
              <table class="table table-sm">
                <?php foreach ($stat->status as $ss) : ?>
                  <tr>
                    <td><?= $ss->name ?></td>
                    <td><?= $ss->status ? '✅' : '🛑' ?></td>
                  </tr>
                <?php endforeach ?>
              </table>
            </div>
          </div>
        </div>
      <?php endif ?>
    </div>
    <?php endforeach ?>
  </div>
</body>

</html>