<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/style.css">
    <script src="static/js/script.js"></script>
    <script src="static/js/validation.js"></script>
    <title>Book-store</title>
</head>
<body>
    <div class="form-container">
        <h1>Добавить книгу</h1>
        <form action="submit-form.php" method="POST">
            <div class="form-row">
                <div class="form-input-group">
                    <label for="book">Название книги:</label>
                    <input type="text" id="book" name="book" class="form-input" required>
                </div>
                <div class="form-input-group">
                    <label for="author">Автор:</label>
                    <input type="text" id="author" name="author" class="form-input" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-input-group">
                    <label for="year">Год издания:</label>
                    <input type="number" id="year" name="year" min="1900" max="2025" class="form-input" required>
                </div>
                <div class="form-input-group">
                    <label for="publisher">Издательство:</label>
                    <input type="text" id="publisher" name="publisher" class="form-input" required>
                </div>
            </div>

            <div class="form-input-group">
                <div class="dropdown">
                    <button class="dropdown-button" id="drop-button-genre">Выберите жанры</button>
                    <div class="dropdown-menu" id="dropdown-menu-genre">
                        <label><input type="checkbox" name="genre[]" value="Фантастика"> Фантастика</label>
                        <label><input type="checkbox" name="genre[]" value="Роман"> Роман</label>
                        <label><input type="checkbox" name="genre[]" value="Драма"> Драма</label>
                        <label><input type="checkbox" name="genre[]" value="Новелла"> Новелла</label>
                        <label><input type="checkbox" name="genre[]" value="Комедия"> Комедия</label>
                        <label><input type="checkbox" name="genre[]" value="Поэзия"> Поэзия</label>
                        <label><input type="checkbox" name="genre[]" value="Трагедия"> Трагедия</label>
                        <label><input type="checkbox" name="genre[]" value="Детектив"> Детектив</label>
                        <label><input type="checkbox" name="genre[]" value="Сатира"> Сатира</label>
                        <label><input type="checkbox" name="genre[]" value="Ужасы"> Ужасы</label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-input-group">
                    <label for="isbn">ISBN:</label>
                    <input type="text" id="isbn" name="isbn" class="form-input" minlength="13" required>
                </div>
                <div class="form-input-group">
                    <label for="pages">Количество страниц:</label>
                    <input type="number" id="pages" name="pages" min="1" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-input-group">
                    <label for="age">Возрастное ограничение:</label>
                    <div class="dropdown">
                        <button class="dropdown-button" id="drop-button-age">
                            <span id="selected-option"></span>
                        </button>
                        <div class="dropdown-menu" id="dropdown-menu-age">
                            <label onclick="Select_Option('0+')"><input type="radio" value="0+"> 0+</label>
                            <label onclick="Select_Option('6+')"><input type="radio" value="6+"> 6+</label>
                            <label onclick="Select_Option('12+')"><input type="radio" value="12+"> 12+</label>
                            <label onclick="Select_Option('14+')"><input type="radio" value="14+"> 14+</label>
                            <label onclick="Select_Option('16+')"><input type="radio" value="16+"> 16+</label>
                            <label onclick="Select_Option('18+')"><input type="radio" value="18+"> 18+</label>
                        </div>
                    </div>
                    <input type="hidden" id="selected-age" name="age">
                </div>
                <div class="form-input-group">
                    <label for="release_date">Дата поступления в продажу:</label>
                    <input type="date" id="release_date" name="release_date" class="form-input" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-input-group">
                        <label for="weight">Вес книги (грамм):</label>
                        <input type="number" id="weight" name="weight" min="0.01" step="0.01" class="form-input" required>
                </div>
                <div class="form-input-group">
                    <label for="price">Стоимость:</label>
                    <input type="number" id="price" name="price" min="0.01" step="0.01" class="form-input" required>
                </div>
            </div>

            <div class="form-input-group">
                <label for="summary">Описание:</label>
                <textarea id="summary" name="summary" class="form-input"></textarea>
            </div>

            <div class="form-buttons">
                <button type="reset" class="btn-reset">Очистить</button>
                <button type="submit" class="btn-submit">Сохранить</button>
            </div>
        </form>
    </div>
    <a href="/view-book.php" class="link-go">Перейти к книгам 🕮</a>
</body>
</html>
