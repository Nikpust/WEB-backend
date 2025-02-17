<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/style.css">
    <script src="static/script.js"></script>
    <title>Book-store</title>
</head>
<body>
    <div class="form-container">
        <h1>Добавить книгу</h1>
        <form action="submit-form.php" method="post">
            <div class="form-input-group">
                <label for="book">Название книги:</label>
                <input type="text" id="book" name="book" class="form-input" required>
            </div>
            <div class="form-input-group">
                <label for="author">Автор:</label>
                <input type="text" id="author" name="author" class="form-input" required>
            </div>
            <div class="form-input-group">
                <div class="dropdown">
                    <button class="dropdown-button" id="dropdownButton">Выберите жанры</button>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <label><input type="checkbox" name="genre[]" value="Фантастика"> Фантастика</label>
                        <label><input type="checkbox" name="genre[]" value="Роман"> Роман</label>
                        <label><input type="checkbox" name="genre[]" value="Драма"> Драма</label>
                        <label><input type="checkbox" name="genre[]" value="Новелла"> Новелла</label>
                        <label><input type="checkbox" name="genre[]" value="Комедия"> Комедия</label>
                        <label><input type="checkbox" name="genre[]" value="Поэзия"> Поэзия</label>
                        <label><input type="checkbox" name="genre[]" value="Трагедия"> Трагедия</label>
                    </div>
                </div>
            </div>
            <div class="form-input-group">
                <label for="year">Год издания:</label>
                <input type="number" id="year" name="year" min="1900" max="2025" class="form-input" required>
            </div>
            <div class="form-input-group">
                <label for="publisher">Издательство:</label>
                <input type="text" id="publisher" name="publisher" class="form-input" required>
            </div>
            <div class="form-input-group">
                <label for="price">Стоимость:</label>
                <input type="text" id="price" name="price" class="form-input" required>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn-submit">Сохранить</button>
                <button type="reset" class="btn-reset">Отмена</button>
            </div>
        </form>
    </div>
</body>
</html>