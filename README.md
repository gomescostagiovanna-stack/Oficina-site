# Oficina de Artes - Site em PHP

## Requisitos
- XAMPP (Apache + MySQL)
- PHP 7.4+ ou 8.x
- MySQL

## Como rodar
1. Copie a pasta `oficina-site` para `C:\xampp\htdocs\`.
2. Crie o banco de dados:
   - Acesse [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
   - Vá em **Importar** e carregue o arquivo `sql/create_db.sql`.
3. No navegador, abra:
http://localhost/oficina-site/index.php
4. Use a página `sobre.php` para criar os conteúdos.

## Estrutura de Arquivos
- `db.php`: Conexão PDO com MySQL.
- `header.php`: Cabeçalho + menu.
- `footer.php`: Rodapé.
- `index.php`: Home (mostra último registro).
- `sobre.php`: CRUD (criar, editar, excluir).
- `galeria.php`: Mostra imagens cadastradas.
- `contato.php`: Página vazia.
- `uploads/`: Pasta para salvar fotos (manter vazia no início).
- `sql/create_db.sql`: Script para criar banco e tabela.
