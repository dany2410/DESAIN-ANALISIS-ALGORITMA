<?php
include "kmp.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pencarian Dokumen KMP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="wrapper">

    <!-- HEADER -->
    <div class="header">
        <h2>Aplikasi Pencarian Cepat Kata Kunci pada Dokumen Digital Berbasis String Matching</h2>

        <!-- FORM PENCARIAN -->
        <form method="get" class="search-box">
            <input 
                type="text" 
                name="keyword" 
                placeholder="Masukkan kata kunci..."
                value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
            >
            <button type="submit">Cari</button>
        </form>
    </div>

    <!-- KONTEN HASIL -->
    <div class="content">
    <?php
    if (!empty($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        $folder = "dataset/";
        $adaHasil = false;

        foreach (scandir($folder) as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === "txt") {

                $text = file_get_contents($folder . $file);
                $found = kmpSearch($text, $keyword);

                if (!empty($found)) {
                    $adaHasil = true;

                    $pos = $found[0];
                    $start = max(0, $pos - 40);
                    $snippet = substr($text, $start, 150);

                    // Amankan karakter HTML
                    $snippet = htmlspecialchars($snippet);

                    // Highlight keyword
                    $snippet = preg_replace(
                        "/(" . preg_quote($keyword, '/') . ")/i",
                        "<span class='highlight'>$1</span>",
                        $snippet
                    );

                    echo "<div class='result'>";
                    echo "<a class='filename' href='view.php?file=" 
                        . urlencode($file) . "&keyword=" 
                        . urlencode($keyword) . "'>📄 $file</a>";
                    echo "<div class='snippet'>... $snippet ...</div>";
                    echo "</div>";
                }
            }
        }

        if (!$adaHasil) {
            echo "<p><b>Dokumen dengan kata kunci <i>$keyword</i> tidak ditemukan.</b></p>";
        }
    }
    ?>
    </div>

</div>

</body>
</html>
