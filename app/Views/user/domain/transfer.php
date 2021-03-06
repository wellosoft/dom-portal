<!DOCTYPE html>
<html lang="<?= lang('Interface.code') ?>">

<?= view('user/head') ?>

<body>
  <?= view('user/navbar') ?>
  <div class="container">
    <h1>Transfer Domain</h1>
    <?= isset($validation) ? $validation->listErrors() : '' ?>
    <form method="POST" name="box">
      <?= csrf_field() ?>
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Data Domain</h3>
              <div class="mb-3">
                <label class="form-label d-flex align-items-center"><?= lang('Host.findDomain') ?>
                  <button type="button" id="domainBioModalBtn" class="ms-auto btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#domainBioModal">
                    <?= lang('Domain.fillBiodata') ?>
                  </button>
                </label>
                <div class="input-group">
                  <input id="domain_bio" hidden name="domain[bio]" required>
                  <input name="domain[name]" id="domain_name" class="form-control" pattern="^[-\w]+$" required oninput="recalculate()">
                  <select class="form-select" name="domain[scheme]" id="domain_scheme" required style="max-width: 120px" onchange="recalculate()">
                    <?php foreach ($schemes as $s) : if ($s->price_local) : ?>
                        <option value="<?= $s->id ?>"><?= $s->alias ?></option>
                    <?php endif;
                    endforeach; ?>
                  </select>
                  <input onclick="checkDomain()" type="button" value="<?= lang('Domain.check') ?>" class="btn btn-primary">
                </div>
              </div>
              <div class="mb-3">
                <label><?= lang('Host.yearDuration') ?></label>
                <div class="input-group">
                  <input name="years" class="form-control" type="number" min="1" max="5" value="1" required onchange="recalculate()">
                </div>
              </div>
              <div class="mb-3">
                <label>Kode Transfer (EPP)</label>
                <div class="input-group">
                  <input name="domain[secret]" class="form-control" type="text" required>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex">
                <h5 id="domainname"></h5>
                <div class="ms-auto" id="outstat">-</div>
              </div>
              <div class="d-flex">
                <h6><?= lang('Host.domainPrice') ?></h6>
                <div class="ms-auto" id="outprice">-</div>
              </div>
              <div class="d-flex">
                <h6><?= lang('Host.transactionCost') ?></h6>
                <div class="ms-auto" id="outtip">-</div>
              </div>
              <hr>
              <div class="d-flex">
                <h6><?= lang('Host.totalPayment') ?></h6>
                <div class="ms-auto" id="outtotal">-</div>
              </div>
              <div class="d-flex">
                <h6><?= lang('Host.expirationDate') ?></h6>
                <div class="ms-auto" id="outexp">-</div>
              </div>
              <?php if (lang('Interface.code') == 'id') : ?>
                <p><i><small>Pastikan bahwa anda memiliki hak akses untuk mentransfer domain dari layanan lain. Kami akan menjangkau anda apabila transfer domain gagal setelah pembayaran, namun apabila anda gagal untuk membuktikan kepemilikan domain melalui EPP code atau syarat dokumen yang ada, kami tidak dapat membantu anda. Secara ToS anda tidak akan mendapatkan kembalian/refund dalam pembelian domain dalam situasi apapun.</small></i></p>
              <?php else : ?>
                <p><i><small>Make sure that you have access rights to transfer the domain from another service. We will reach out to you if the domain transfer fails after payment, but if you fail to prove domain ownership through the EPP code or existing document requirements, we cannot help you. By ToS you will not get a refund in the purchase of a domain under any circumstances.</small></i></p>
              <?php endif ?>
              <input type="submit" id="submitBtn" class="btn btn-primary btn-block" value="<?= lang('Host.orderNow') ?>">
            </div>
          </div>
        </div>
      </div>

    </form>
  </div>

  <?= view('user/modals/domainbio') ?>

  <script id="schemes" type="application/json">
    <?= json_encode($schemes) ?>
  </script>
  <script>
    let schemes, activedomain = null;
    const currency = '<?= lang('Interface.currency') ?>';
    const digits = '<?= lang('Interface.currency') === 'usd' ? 2 : 0 ?>';
    const formatter = new Intl.NumberFormat('<?= lang('Interface.codeI8LN') ?>', {
      style: 'currency',
      currency: currency,
      maximumFractionDigits: digits,
      minimumFractionDigits: digits,
    });

    window.addEventListener('DOMContentLoaded', (event) => {
      schemes = JSON.parse($('#schemes').html()).reduce((a, b) => (a[b.id] = b, a), {});
      recalculate();
    });

    function recalculate() {
      var tip = {
        'usd': 0.3,
        'idr': 5000
      } [currency];
      var form = window.box;

      var schdata = schemes[form.domain_scheme.value];
      var years = form.years.value;

      var exp = new Date(Date.now() + 1000 * 86400 * 365 * years);
      var price = schdata[`renew_${currency}`] * (years);

      if (currency === 'usd') {
        var value = price;
        tip = Math.round((value + tip) / (1 - 0.044) * 100) / 100 - value; // paypal fee
      }

      $('#domainname').text(activedomain && activedomain.domain);
      $('#outstat').text(activedomain && activedomain.status);
      $('#outprice').text(formatter.format(price));
      $('#outtip').text(formatter.format(tip));
      $('#outtotal').text(formatter.format(tip + price));
      $('#outexp').text(exp.toISOString().substr(0, 10));

      var valid = form.checkValidity();
      $('#submitBtn')
        .toggleClass('btn-outline-warning', !valid)
        .toggleClass('btn-primary', valid);
    }
  </script>
</body>

</html>