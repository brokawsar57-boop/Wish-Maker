<?php
require __DIR__ . '/config.php';
session_start();
if (isset($_GET['logout'])) { session_destroy(); header('Location: admin.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['login'])) {
    $u = $_POST['username'] ?? ''; $p = $_POST['password'] ?? '';
    if (hash_equals(ADMIN_USERNAME,$u) && hash_equals(ADMIN_PASSWORD,$p) && ADMIN_PASSWORD!=='CHANGE_THIS_TO_A_LONG_UNIQUE_PASSWORD') {
        session_regenerate_id(true); $_SESSION['wish_admin']=true; header('Location: admin.php'); exit;
    } else { $error='Login failed. Check credentials and make sure you changed the default password in config.php.'; }
}
$logged = !empty($_SESSION['wish_admin']);
if ($logged && isset($_GET['delete'])) {
    $slug = preg_replace('/[^a-f0-9]/','',$_GET['delete']);
    if ($slug!=='') { $st=db()->prepare('DELETE FROM wishes WHERE slug=?'); $st->execute([$slug]); }
    header('Location: admin.php?deleted=1'); exit;
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>WishMaker Admin</title><link rel="stylesheet" href="style.css"></head><body><header class="top"><a class="brand" href="index.php">✦ Wish<span>Maker</span></a><a href="index.php">View site</a></header><main class="wrap">
<?php if(!$logged): ?><section class="panel login"><div class="eyebrow">PRIVATE AREA</div><h1>Admin Login</h1><?php if($error): ?><p class="error"><?= esc($error) ?></p><?php endif; ?><form method="post"><input type="hidden" name="login" value="1"><label>Username<input name="username" required autocomplete="username"></label><label>Password<input name="password" type="password" required autocomplete="current-password"></label><button class="btn">Sign in</button></form><p class="small">Set a unique admin password in config.php before using this panel.</p></section>
<?php else: $rows=db()->query('SELECT slug,occasion,recipient,sender,theme,created_at FROM wishes ORDER BY id DESC LIMIT 200')->fetchAll(); ?><section class="panel"><div class="admin-head"><div><div class="eyebrow">CONTROL CENTER</div><h1>Wish Manager</h1></div><a href="admin.php?logout=1">Log out</a></div><p><?= count($rows) ?> latest wishes shown (maximum 200).</p><?php if(isset($_GET['deleted'])): ?><p class="success">Wish deleted.</p><?php endif; ?><div class="table-wrap"><table><thead><tr><th>Recipient</th><th>Occasion</th><th>Created</th><th>Actions</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= esc($r['recipient']) ?><br><small><?= esc($r['sender']) ?></small></td><td><?= esc($r['occasion']) ?></td><td><?= esc($r['created_at']) ?></td><td><a href="wish.php?id=<?= esc($r['slug']) ?>" target="_blank">View</a> · <a onclick="return confirm('Delete this wish permanently?')" href="admin.php?delete=<?= esc($r['slug']) ?>">Delete</a></td></tr><?php endforeach; ?></tbody></table></div><p class="small">For safety, keep admin.php and config.php private to your own use. Do not share your admin password.</p></section><?php endif; ?><footer>WishMaker Admin</footer></main></body></html>
