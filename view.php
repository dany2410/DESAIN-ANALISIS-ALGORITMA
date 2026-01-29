<?php
$file = $_GET['file'] ?? '';
$keyword = $_GET['keyword'] ?? '';
$folder = "dataset/";

$path = realpath($folder . $file);
$base = realpath($folder);


if (!$path || strpos($path, $base) !== 0) {
    die("File tidak valid.");
}

$content = file_get_contents($path);
$content = htmlspecialchars($content);

/* Highlight keyword */
if (!empty($keyword)) {
    $content = preg_replace(
        "/(" . preg_quote($keyword, '/') . ")/i",
        "<span class='highlight'>$1</span>",
        $content
    );
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Dokumen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="wrapper">

    <div class="header">
        <h2>📄 <?= htmlspecialchars($file) ?></h2>
        <p>Kata kunci: <b><?= htmlspecialchars($keyword) ?></b></p>
    </div>

    <div class="content">
        <div class="result">
            <pre><?= $content ?></pre>
        </div>

        
        <a 
            href="index.php?keyword=<?= urlencode($keyword) ?>" 
            class="back"
        >
            ⬅ Kembali ke pencarian
        </a>
    </div>

</div>

</body>
</html>
