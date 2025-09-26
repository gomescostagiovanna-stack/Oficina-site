<?php
// Arquivo: galeria.php
include "db.php";
include "header.php";

$stmt = $pdo->query("SELECT foto_path FROM sobre WHERE foto_path IS NOT NULL AND foto_path != '' ORDER BY created_at DESC");
$fotos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Galeria</h2>";

if ($fotos):
    foreach ($fotos as $foto):
        echo "<img src='{$foto['foto_path']}' width='150' style='margin:5px;'>";
    endforeach;
else:
    echo "<p>Nenhuma foto cadastrada.</p>";
endif;

include "footer.php";
?>
