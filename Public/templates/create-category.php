<?php include __DIR__ . '/header.php'; ?>

    <div class="container">
        <h1 class="my-md-5 my-4"><?php echo $act; ?> категорию</h1>
        <div class="row">
            <div class="col-lg-5 col-md-8">
                <form action="<?php echo $action; ?>" method="post">
                    <div class="form-floating mb-3">
                        <input type="text"
                               name="category"
                               value="<?php if ($act === 'Добавить') {
                                   echo $_POST['category'] ?? '';
                               } else {
                                   echo $_POST['category'] ?? $category->getTitle();
                               } ?>"
                               class="form-control"
                               placeholder="Напишите название"
                               id="floatingName">
                        <label for="floatingName">Название</label>
                        <?php if (isset($exceptions['category'])) {
                            foreach ($exceptions['category'] as $e): ?>
                                <p class="text-danger">
                                    <?php echo $e; ?>
                                </p>
                            <?php endforeach;
                        } ?>
                        <div class="invalid-feedback">
                            Пожалуйста, заполните поле
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit"><?php echo $button; ?></button>
                </form>
            </div>
        </div>
    </div>
    </div>

<?php include __DIR__ . '/footer.html';
