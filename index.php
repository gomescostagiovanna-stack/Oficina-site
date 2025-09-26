<?php
// Arquivo: index.php
include "db.php";
include "header.php";

$stmt = $pdo->query("SELECT * FROM sobre ORDER BY created_at DESC LIMIT 1");
$sobre = $stmt->fetch(PDO::FETCH_ASSOC);

if ($sobre):
?>
    <h2><?php echo htmlspecialchars($sobre['titulo']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($sobre['descricao'])); ?></p>
    <?php if (!empty($sobre['foto_path'])): ?>
        <img src="<?php echo $sobre['foto_path']; ?>" alt="Foto" width="300">
    <?php endif; ?>
<?php else: ?>
    <p>Nenhum conteúdo cadastrado ainda.</p>
<?php endif; ?>

<?php include "footer.php"; ?>
