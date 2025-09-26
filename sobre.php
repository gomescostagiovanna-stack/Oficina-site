<?php
// Arquivo: sobre.php
include "db.php";
include "header.php";

// Função para upload
function uploadFoto($file) {
    $allowed = ["jpg","jpeg","png","gif","webp"];
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        return false;
    }

    if ($file["size"] > 2 * 1024 * 1024) { // 7 MB
    return false;
}


    $newName = "uploads/" . uniqid() . "." . $ext;
    if (move_uploaded_file($file["tmp_name"], $newName)) {
        return $newName;
    }
    return false;
}

// Criar
if (isset($_POST['create'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $foto_path = "";

    if (!empty($_FILES['foto']['name'])) {
        $foto_path = uploadFoto($_FILES['foto']);
    }

    if ($titulo && $descricao) {
        $stmt = $pdo->prepare("INSERT INTO sobre (titulo, descricao, foto_path) VALUES (?, ?, ?)");
        $stmt->execute([$titulo, $descricao, $foto_path]);
        echo "<p>Registro criado com sucesso!</p>";
    } else {
        echo "<p>Preencha todos os campos obrigatórios.</p>";
    }
}

// Excluir
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM sobre WHERE id=?");
    $stmt->execute([$id]);
    echo "<p>Registro excluído!</p>";
}

// Editar (formulário)
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM sobre WHERE id=?");
    $stmt->execute([$id]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($editData):
?>
<h2>Editar Registro</h2>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
    <p>Título: <input type="text" name="titulo" value="<?php echo htmlspecialchars($editData['titulo']); ?>"></p>
    <p>Descrição:<br><textarea name="descricao"><?php echo htmlspecialchars($editData['descricao']); ?></textarea></p>
    <p>Foto: <input type="file" name="foto"></p>
    <p><button type="submit" name="update">Atualizar</button></p>
</form>
<?php
    endif;
}

// Atualizar
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $stmt = $pdo->prepare("SELECT foto_path FROM sobre WHERE id=?");
    $stmt->execute([$id]);
    $oldFoto = $stmt->fetchColumn();

    $foto_path = $oldFoto;
    if (!empty($_FILES['foto']['name'])) {
        $foto_path = uploadFoto($_FILES['foto']);
    }

    $stmt = $pdo->prepare("UPDATE sobre SET titulo=?, descricao=?, foto_path=? WHERE id=?");
    $stmt->execute([$titulo, $descricao, $foto_path, $id]);
    echo "<p>Registro atualizado!</p>";
}
?>

<h2>Criar Novo Registro</h2>
<form method="post" enctype="multipart/form-data">
    <p>Título: <input type="text" name="titulo"></p>
    <p>Descrição:<br><textarea name="descricao"></textarea></p>
    <p>Foto: <input type="file" name="foto"></p>
    <p><button type="submit" name="create">Salvar</button></p>
</form>

<h2>Registros Existentes</h2>
<?php
$stmt = $pdo->query("SELECT * FROM sobre ORDER BY created_at DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
?>
<div style="border:1px solid #e77777ff; margin:10px; padding:10px;">
    <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($row['descricao'])); ?></p>
    <?php if ($row['foto_path']): ?>
    <img src="<?php echo $row['foto_path']; ?>" width="200">
    <?php endif; ?>
    <p>
        <a href="?edit=<?php echo $row['id']; ?>">Editar</a> |
        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
    </p>
</div>
<?php endwhile; ?>

<?php include "footer.php"; ?>