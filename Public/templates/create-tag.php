<?php include __DIR__ . '/header.php'; ?>

    <!-- Страница создания и редактирования тегов -->

    <!-- В зависимости от того, создаётся новый тег или редактируется старый,
    переменные $act, $action и $button принимают соответствующие значения -->

    <!-- В случае не прохождения валидации данных, сведения об ошибках
    передаются в переменную $exceptions и выводятся под соответствующими полями -->
    <div class="container">
        <h1 class="my-md-5 my-4"><?php echo $act; ?> тег</h1>
        <div class="row">
            <div class="col-lg-5 col-md-8">
                <form action="<?php echo $action; ?>" method="post">
                    <div class="form-floating mb-3">
                        <input type="text"
                               name="tag"
                               value="<?php if ($act === 'Добавить') {
                                   echo $_POST['tag'] ?? '';
                               } else {
                                   echo $_POST['tag'] ?? $tag->getTitle();
                               } ?>"
                               class="form-control"
                               placeholder="Напишите название"
                               id="floatingName">
                        <label for="floatingName">Название</label>
                        <?php if (isset($exceptions['tag'])) {
                            foreach ($exceptions['tag'] as $e): ?>
                                <p class="text-danger">
                                    <?php echo $e; ?>
                                </p>
                            <?php endforeach;
                        } ?>
                        <div class="invalid-feedback">
                            Пожалуйста, заполните поле
                        </div>
                    </div>
                    <button
                            class="btn btn-primary"
                            type="submit"><?php echo $button; ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.html';
