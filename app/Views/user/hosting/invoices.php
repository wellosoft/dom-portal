<!DOCTYPE html>
<html lang="<?= lang('Interface.code') ?>">

<?= view('user/head') ?>

<body>
  <?= view('user/navbar') ?>
  <div class="container">
    <h1 class="mb-3"><?= lang('Hosting.manageInvoice') ?></h1>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div><?= lang('Hosting.statusInvoice') ?></div>
            <div class="input-group mb-3">
              <h3><?= ucfirst($data->status) ?></h3>
            </div>
            <?php if ($current && $current->status === 'pending') : ?>
              <?php if (lang('Interface.code') == 'en') : ?>
                <p><i>Please <a href="https://api.whatsapp.com/send?phone=6289514631927&text=Hello,+I+want+to+proceed+my+purchase+with+ID+<?= $data->purchase_id ?>">request support</a> to finish payment.</i></p>
              <?php else : ?>
                <form method="post" class="my-2">
                  <input type="hidden" name="action" value="pay">
                  <input type="submit" class="btn btn-primary" value="<?= lang('Hosting.finishPayment') ?>">
                </form>
              <?php endif ?>
              <p>
                <?php $money = format_money($current->metadata->price) ?>
                <?php ($current->liquid ? lang('Hosting.formatInvoiceAlt', [
                  "<b>$current->plan</b>",
                  "<b>$data->domain</b>",
                ]) : lang('Hosting.formatInvoice', [
                  "<b>$current->plan</b>",
                ])) . lang("Hosting.formatInvoiceSum", ["<b>$money</b>"]) ?>
              </p>
              <p>
                <?= lang('Hosting.cancelInvoiceHint') ?>
              </p>
              <form method="post" class="my-2">
                <input type="hidden" name="action" value="cancel">
                <input type="submit" class="btn btn-danger" value="<?= lang('Hosting.cancelInvoice') ?>" onclick="return confirm('<?= lang('Hosting.cancelInvoceConfirm') ?>')">
              </form>
            <?php endif ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h3>Arsip Langganan</h3>
            <?php foreach ($history as $item) : ?>
              <div class="card">
                <div class="card-body">
                  <div class="d-flex">
                    <div><b><?= $item->metadata->_issued ?> | Rp. <?= $item->metadata->price ?></b></div>
                    <div class="ml-auto"><?= ucfirst($item->status) ?></div>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
    <a href="/user/hosting/detail/<?= $data->hosting_id ?>" class="mt-3 btn btn-secondary"><?= lang('Interface.back') ?></a>
  </div>

</body>

</html>