<!DOCTYPE html>
<html lang="<?= lang('Interface.code') ?>">

<?= view('user/head') ?>

<body>
  <?= view('user/navbar') ?>

  <div class="container">
    <?php /** @var \App\Entities\Domain $domain */ ?>
    <h1 class="mb-2">Detail Domain</h1>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <form method="post" class="my-2">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="pay">
              <input type="submit" class="btn btn-primary" value="<?= lang('Host.finishPayment') ?>">
            </form>
            <div class="input-group mb-3">
              <h3><?= ucfirst($domain->status) ?></h3>
              <?php if ($domain->status === 'pending') : ?>
                <a href="/user/domain/invoices/<?= $domain->id ?>" class="ms-auto btn btn-primary"><?= lang('Host.finishPayment') ?></a>
              <?php elseif ($domain->status === 'active') : ?>
                <a href="http://<?= $domain->name ?>" target="_blank" rel="noopener noreferrer" class="ms-auto btn btn-primary"><?= lang('Host.openWebsite') ?></a>
              <?php endif ?>
            </div>
          </div>

        </div>
      </div>
    </div>
    <a href="/user/domain" class="mt-3 btn btn-secondary">Kembali</a>
  </div>

</body>

</html>