<?php include __DIR__ . '/header.php'; ?>

<!--Страница добавления и редактирования материала -->

<!-- В зависимости от того, создаётся новый материал или редактируется старый,
переменные $act, $action и $button принимают соответствующие значения -->

<!-- В случае не прохождения валидации данных, сведения об ошибках
передаются в переменную $exceptions и выводятся под соответствующими полями -->

<div class="container">
    <h1 class="my-md-5 my-4"><?php echo $act; ?> материал</h1>
    <div class="row">
        <div class="col-lg-5 col-md-8">
            <form action="<?php echo $action; ?>" method="post">
                <div class="form-floating mb-3">
                    <select class="form-select" name="type" id="floatingSelectType">
                        <option selected>
                            <?php echo $_POST['type'] ?? 'Выберите тип'; ?>
                        </option>
                        <option value="Книга">Книга</option>
                        <option value="Статья">Статья</option>
                        <option value="Видео">Видео</option>
                        <option value="Сайт/Блог">Сайт/Блог</option>
                        <option value="Подборка">Подборка</option>
                        <option value="Ключевые идеи книги">Ключевые идеи книги</option>
                    </select>
                    <label for="floatingSelectType">Тип</label>
                    <?php if (isset($exceptions['type'])) { ?>
                        <p class="text-danger">Пожалуйста, выберите тип</p>
                    <?php } ?>
                    <div class="invalid-feedback">
                        Пожалуйста, выберите значение
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" name="category" id="floatingSelectCategory">
                        <option selected>
                            <?php echo $_POST['category'] ?? 'Выберите категорию'; ?>
                        </option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->getTitle(); ?>">
                                <?php echo $category->getTitle(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="floatingSelectCategory">Категория</label>
                    <?php if (isset($exceptions['category'])) { ?>
                        <p class="text-danger">Пожалуйста, выберите категорию</p>
                    <?php } ?>
                    <div class="invalid-feedback">
                        Пожалуйста, выберите значение
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text"
                           class="form-control"
                           name="title"
                           value="<?php echo $_POST['title'] ?? ''; ?>"
                           placeholder="Напишите название"
                           id="floatingName">
                    <label for="floatingName">Название</label>
                    <?php if (isset($exceptions['title'])) { ?>
                        <p class="text-danger">Пожалуйста, введите название</p>
                    <?php } ?>
                    <div class="invalid-feedback">
                        Пожалуйста, заполните поле
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text"
                           class="form-control"
                           name="authors"
                           value="<?php echo $_POST['authors'] ?? ''; ?>"
                           placeholder="Напишите авторов"
                           id="floatingAuthor">
                    <label for="floatingAuthor">Авторы</label>
                    <?php if (isset($exceptions['authors'])) {
                        foreach ($exceptions['authors'] as $e): ?>
                        <p class="text-danger">
                            <?php echo $e; ?>
                        </p>
                    <?php endforeach; } ?>
                    <div class="invalid-feedback">
                        Пожалуйста, заполните поле
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control"
                              name="description"
                              placeholder="Напишите краткое описание"
                              id="floatingDescription"
                              style="height: 100px"
                    ><?php echo $_POST['description'] ?? ''; ?></textarea>
                    <label for="floatingDescription">Описание</label>
                    <div class="invalid-feedback">
                        Пожалуйста, заполните поле
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">
                    <?php echo $button; ?>
                </button>
            </form>
        </div>
    </div>
</div>
</div>

<?php include __DIR__ . '/footer.html';
