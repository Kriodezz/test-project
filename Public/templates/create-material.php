<?php include __DIR__ . '/header.php'; ?>

        <div class="container">
            <h1 class="my-md-5 my-4">Добавить материал</h1>
            <div class="row">
                <div class="col-lg-5 col-md-8">
                    <form>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelectType">
                                <option selected>Выберите тип</option>
                                <option value="0">Книга</option>
                                <option value="1">Статья</option>
                                <option value="2">Видео</option>
                                <option value="3">Сайт/Блог</option>
                                <option value="3">Подборка</option>
                                <option value="3">Ключевые идеи книги</option>
                            </select>
                            <label for="floatingSelectType">Тип</label>
                            <div class="invalid-feedback">
                                Пожалуйста, выберите значение
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelectCategory">
                                <option selected>Выберите категорию</option>
                                <option value="0">Деловые/Бизнес-процессы</option>
                                <option value="1">Деловые/Найм</option>
                                <option value="2">Деловые/Реклама</option>
                                <option value="3">Деловые/Управление бизнесом</option>
                                <option value="4">Деловые/Управление людьми</option>
                                <option value="5">Деловые/Управление проектами</option>
                                <option value="6">Детские/Воспитание</option>
                                <option value="7">Дизайн/Общее</option>
                                <option value="8">Дизайн/Logo</option>
                                <option value="9">Дизайн/Web дизайн</option>
                                <option value="10">Разработка/PHP</option>
                                <option value="11">Разработка/HTML и CSS</option>
                                <option value="12">Разработка/Проектирование</option>
                            </select>
                            <label for="floatingSelectCategory">Категория</label>
                            <div class="invalid-feedback">
                                Пожалуйста, выберите значение
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Напишите название" id="floatingName">
                            <label for="floatingName">Название</label>
                            <div class="invalid-feedback">
                                Пожалуйста, заполните поле
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Напишите авторов" id="floatingAuthor">
                            <label for="floatingAuthor">Авторы</label>
                            <div class="invalid-feedback">
                                Пожалуйста, заполните поле
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Напишите краткое описание" id="floatingDescription"
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
