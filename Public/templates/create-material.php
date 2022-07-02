<?php include __DIR__ . '/header.php'; ?>

<div class="container">
    <h1 class="my-md-5 my-4">Добавить материал</h1>
    <div class="row">
        <div class="col-lg-5 col-md-8">
            <form action="/material/create" method="post">
                <div class="form-floating mb-3">
                    <select class="form-select" name="type" id="floatingSelectType">
                        <option selected>Выберите тип</option>
                        <option value="Книга">Книга</option>
                        <option value="Статья">Статья</option>
                        <option value="Видео">Видео</option>
                        <option value="Сайт/Блог">Сайт/Блог</option>
                        <option value="Подборка">Подборка</option>
                        <option value="Ключевые идеи книги">Ключевые идеи книги</option>
                    </select>
                    <label for="floatingSelectType">Тип</label>
                    <div class="invalid-feedback">
                        Пожалуйста, выберите значение
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" name="category" id="floatingSelectCategory">
                        <option selected>
                            Выберите категорию
                        </option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->getId(); ?>">
                                <?php echo $category->getTitle(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="floatingSelectCategory">Категория</label>
                    <div class="invalid-feedback">
                        Пожалуйста, выберите значение
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="title" placeholder="Напишите название" id="floatingName">
                    <label for="floatingName">Название</label>
                    <div class="invalid-feedback">
                        Пожалуйста, заполните поле
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="authors" placeholder="Напишите авторов" id="floatingAuthor">
                    <label for="floatingAuthor">Авторы</label>
                    <div class="invalid-feedback">
                        Пожалуйста, заполните поле
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" name="description" placeholder="Напишите краткое описание" id="floatingDescription"
                              style="height: 100px"></textarea>
                    <label for="floatingDescription">Описание</label>
                    <div class="invalid-feedback">
                        Пожалуйста, заполните поле
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Добавить</button>
            </form>
        </div>
    </div>
</div>
</div>

<?php include __DIR__ . '/footer.html';
