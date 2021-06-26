<ul class="nav nav-tabs mb-4">
    <?php $path = explode('/', \Config\Services::request()->detectPath() ?? '')[2] ?? '' ?>
    <li class="nav-item">
        <a class="nav-link <?= $path == 'detail' ? 'active' : '' ?>" href="/user/host/detail/<?= $host->id ?>">Detail</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $path == 'invoices' ? 'active' : '' ?>" href="/user/host/invoices/<?= $host->id ?>">Invoice</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $path == 'see' ? 'active' : '' ?>" href="/user/host/see/<?= $host->id ?>">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $path == 'dns' ? 'active' : '' ?>" href="/user/host/dns/<?= $host->id ?>">DNS</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $path == 'firewall' ? 'active' : '' ?>" href="/user/host/firewall/<?= $host->id ?>">Firewall</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $path == 'deploys' ? 'active' : '' ?>" href="/user/host/deploys/<?= $host->id ?>">Deploy</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $path == 'nginx' ? 'active' : '' ?>" href="/user/host/nginx/<?= $host->id ?>">Nginx</a>
    </li>
    <li class="nav-item ms-auto">
        <span class="nav-link"><a href="http://<?= $host->domain ?>" target="_blank" rel="noopener noreferrer"><?= $host->domain ?></a></span>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $path == 'upgrade' ? 'active' : '' ?>" href="/user/host/upgrade/<?= $host->id ?>">Upgrade</a>
    </li>
</ul>
